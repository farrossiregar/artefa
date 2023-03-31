<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Lembur;
use App\Models\Employee;
use App\Models\JadwalShift;
use App\Models\Departement;
use App\Models\TanggalMerah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Mail\LemburVerifikasi;
use App\Mail\LemburVerifikasiPemohon;
use Illuminate\Support\Facades\Mail;
use App\helpers;

class LemburController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    
    public function indexLembur() {
		$datamngrspv = Employee::orderBy('dept_id','ASC')->get();
		$departements = Departement::orderBy('id', 'ASC')->get();	
		$user = Auth::user();
		
		if($user->hasRole('Super Admin')){
			$parameter = array(
				'nama_karyawan' => '',
				'nik' => '',
				'jabatan' => '',
				'level' => ''
			);
			$getuser = '<div class="form-group input-group" onclick="filterkaryawan();">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan" required readonly/>
							<span class="input-group-addon" data-toggle="modal" data-target="#formModal"><i class="icon-search"></i></span>
						</div>';
		}else{
			$nama = $user->name;
			$datakaryawan = Employee::where('nama', $nama)->get();
			foreach($datakaryawan as $datakaryawan_cek){
				$parameter = array(
					'nama_karyawan' => $datakaryawan_cek->nama,
					'nik' => $datakaryawan_cek->nik,
					'jabatan' => $datakaryawan_cek->jabatan,
					'level' => $datakaryawan_cek->level
				);
			}
			$getuser = '<div class="form-group">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="'.$parameter['nama_karyawan'].'" required readonly/>
						</div>';
		}
        return view('admin.lembur.indexLembur', compact('parameter', 'departements', 'getuser', 'datamngrspv'));
    }
	

	public function cektgllembur(Request $request){
		$nik = $request->input('nik');
		$tgl_lembur = Carbon::parse($request->input('tgl_lembur'))->format('Y-m-d');
		$jam_lembur_awal = $request->input('jam_lembur_awal').':00';
		$jam_lembur_akhir = $request->input('jam_lembur_akhir').':00';

		$tgl_lembur_awal = $tgl_lembur.' '.$jam_lembur_awal;
		$tgl_lembur_akhir = $tgl_lembur.' '.$jam_lembur_akhir;

		$datalembur = Lembur::where('nik', $nik)
								->where('tgl_lembur_awal', $tgl_lembur_awal)
								->where('tgl_lembur_akhir', $tgl_lembur_akhir)->count();
		if($datalembur > 0){
			$status = 1;
		}else{
			$status = 0;
		}

		return response()->json($status);
	}


    public function storeLembur(Request $request){

        $nama_karyawan = $request->input('nama_karyawan');
		$nik = $request->input('nik');
		
		$id_lembur = Lembur::latest('id')->first();
		if(!empty($id_lembur)){
			$ids = $id_lembur->id+1;
		}else{
			$ids = 1;
		}

        $kd_divisi = $request->input('kd_divisi');
		$jabatan = $request->input('jabatan');
		$banyak_lembur = $request->input('banyak_lembur');

        $tgl_pengajuan_lembur = date('Y-m-d H:i:s');
		$app1 = '';
		$app2 = '';
		$app3 = '';
		
		if(isset($_POST["tgl_lembur_awal"])){
			$lmbr=$_POST["tgl_lembur_awal"];
			reset($lmbr);
			foreach ($lmbr as $key => $value){
				$tgl_lembur_awal   = Carbon::parse($_POST["tgl_lembur_awal"][$key])->format('Y-m-d');
				$getharilembur = strtotime($tgl_lembur_awal);
				$hari_lembur = date('D', $getharilembur);
				$tgl_lembur_akhir   = $tgl_lembur_awal;
				$jam_lembur_awal   =$_POST["jam_lembur_awal"][$key];
				$jam_lembur_akhir   =$_POST["jam_lembur_akhir"][$key]; 
				$keterangan_lembur   =$_POST["keterangan_lembur"][$key];  
				$tgl_jam_lembur_awal = $tgl_lembur_awal.' '.$jam_lembur_awal;
				$tgl_jam_lembur_akhir = $tgl_lembur_akhir.' '.$jam_lembur_akhir;

				$diff = abs(strtotime($tgl_jam_lembur_akhir) - strtotime($tgl_jam_lembur_awal));
				$years   = floor($diff / (365*60*60*24)); 
				$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
				$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
				$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
				
				if($hours >= 3){
					$uang_makan = 'Y';
				}else{
					$uang_makan = 'N';
				}
				
				if($hours >= 4){
					if($hours == 4){
						if($minuts <= '30'){
							$setjam = $hours;
						}else{
							$setjam = $hours - 1;
						}
					}else{
						$setjam = $hours - 1;
					}
				}else{
					$setjam = $hours;
				}
				
				$tgl_merah = TanggalMerah::where('date', $tgl_lembur_awal)->count();
				if($tgl_merah > 0){
					$jenis_lembur = 'L';
					$roundmenit = $minuts;
				}else{
					$jenis_lembur = 'K';
					
					if($minuts <= '59' && $minuts >= '30'){
						$roundmenit = '30';
					}else if($minuts < '30'){
						$roundmenit = '00';
					}else{
						$roundmenit = '00';
					}
				}
				
				$lama_lembur = $setjam.":".$roundmenit;
				
				$shift_karyawan = Employee::where('nik', $nik)->get();	
				foreach($shift_karyawan as $shiftkaryawan){
					$direct_supervisor = $shiftkaryawan->direct_supervisor;
					
					$next_higher_supervisor = $shiftkaryawan->next_higher_supervisor;
					$dept_id = $shiftkaryawan->dept_id;
					$level = $shiftkaryawan->level;
					$shifting = $shiftkaryawan->shifting;
					
					$email_pemohon = $shiftkaryawan->email;
					if($shifting == 'Y'){
						$jenis_karyawan = 'Shifting';
						$cek_jadwal_shift = DB::table('shift_schedules')->where('nik', $nik)->where('date', $tgl_lembur_awal)->count();
						
						if($cek_jadwal_shift > 0){
							$jenis_hari = 'Masuk';
							$data_shift = DB::table('shift_schedules')->where('nik', $nik)->where('date', $tgl_lembur_awal)->get();
							
							foreach($data_shift as $datashift){
								$code_shift = $datashift->schedule_code;
								$dept_shift = $datashift->dept;
								$data_jam_shift = DB::table('schedules')->where('code', $code_shift)->where('dept_id', $dept_shift)->get();
								foreach($data_jam_shift as $datajamshift){
									$jam_shift_awal = $datajamshift->time_schedule_awal;
									$jam_shift_akhir = $datajamshift->time_schedule_akhir;
									if($jam_lembur_awal < $jam_shift_awal){
										$batas_lembur = 'Bawah';
									}else{
										$batas_lembur = 'Atas';
									}
								}
							}
						}else{
							$jenis_hari = 'Libur';
							$batas_lembur = '';
						}
					}else{
						if($jenis_lembur == 'K'){
							$jam_shift_awal = '08:00:00';
							if($hari_lembur == 'Sat'){
								$hari = 'Sabtu';
								$jam_shift_akhir = '12:00:00';
							}else{
								$hari = 'Senin';
								$jam_shift_akhir = '16:30:00';
							}
							
							if($jam_lembur_awal < substr($jam_shift_awal, 0, 11)){
								$batas_lembur = 'Bawah';
							}else{
								$batas_lembur = 'Atas';
							}
						}else{
							$batas_lembur = '';
						}
						$jenis_karyawan = 'Non-Shifting';
						$jenis_hari = '';
					}
				}
				
				$lembur = new Lembur;
				$lembur->id = $ids;
				$lembur->nama_karyawan = $nama_karyawan;
				$lembur->nik = $nik;
				$lembur->kd_divisi = $kd_divisi;
				$lembur->jabatan = $jabatan;
				$lembur->tgl_pengajuan_lembur = $tgl_pengajuan_lembur;

				$lembur->tgl_lembur_awal = $tgl_jam_lembur_awal;
				$lembur->tgl_lembur_akhir = $tgl_jam_lembur_akhir;
				$lembur->lama_lembur = $lama_lembur;
				$lembur->keterangan_lembur = $keterangan_lembur;
				$lembur->jenis_lembur = $jenis_lembur;
				$lembur->uang_makan = $uang_makan;
				$lembur->batas_lembur = $batas_lembur;
			
				$lembur->app1 = $app1;
				$lembur->app2 = $app2;
				$lembur->app3 = $app3;
				$lembur->activation_token = '';
				$lembur->save();
			}

			$departements = Departement::where('id', $kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;

			$atasan = $direct_supervisor;
			$email_to = Employee::where('nama', $atasan)->get();
			foreach($email_to as $emailto){
				$email = $emailto->email;
			}

			$datalemburid = Lembur::where('nik', $nik)
								->where('tgl_lembur_awal', $tgl_jam_lembur_awal)
								->where('tgl_lembur_akhir', $tgl_jam_lembur_akhir)
								->get();
			foreach($datalemburid as $data_lemburid){
				$id = $data_lemburid->id;
			}
			$id = $ids;
			$lembur_data = Lembur::where('id', $id)->get();

		//	$emails_send = ['wudcrafterz@gmail.com', 'farrosashiddiq@gmail.com', 'arbitentur.fahmi@gmail.com', 'abdrozak20@gmail.com'];
			
			if($email_pemohon != ''){
				if($email_pemohon != ''){
					Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Pengajuan Lembur', $atasan, $id, $lembur_data));
				}
			}

			if($jabatan != "Manager"){
				if($email != ''){
					Mail::to($email)->send(new LemburVerifikasi($subject = 'Approval Lembur', $atasan, $id, $lembur_data));
				}
			}else{
				
			}
		}  
		return redirect()->back()->with('success', 'Berhasil Menambah Data!!! Refresh Halaman Untuk Membuat Pengajuan Baru...'); 
	}
	
	public function datalembur(){
		$departements = Departement::orderBy('id', 'ASC')->get();
		return view('admin.lembur.TableApproveLembur', compact('departements'));
	}

	public function getdatalembur(Request $request){
		$nama_karyawan = $request->input('nama_karyawan');
		$dept_id = $request->input('dept_id');
		$start_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
		$end_date = Carbon::parse($request->input('end_date'))->format('Y-m-d');

		if($nama_karyawan == ''){
			if($dept_id == ''){
				$filter = "nama_karyawan != ''";
			}else{
				$filter = "kd_divisi = '".$dept_id."' ";
			}
		}else{
			$filter = "nama_karyawan = '".$nama_karyawan."' ";
		}

		
		if($start_date != '' and $end_date != ''){
			$filterdate = 'and tgl_lembur_awal >= "'.$start_date.'" and tgl_lembur_akhir <= "'.$end_date.'" ';
		}else{
			if($start_date == '' or $end_date == ''){
				if($start_date == ''){
					$filterdate = 'and tgl_lembur_awal >= "'.date('Y-m-d').'" and tgl_lembur_akhir <= "'.$end_date.'" ';
				}else{
					$filterdate = 'and tgl_lembur_awal >= "'.$start_date.'" and tgl_lembur_akhir <= "'.date('Y-m-d').'"';
				}
			}else{
				$filterdate = '';
			}
		}

	/*	$datalembur = DB::select('select  * from tbl_pengajuan_lembur 
									where '.$filter.' '.$filterdate.' 
									order by tgl_pengajuan_lembur desc');	*/
		
		$datalembur = DB::select('select id, nik, nama_karyawan, kd_divisi, 
									keterangan_lembur, app1, app2, app3,
									GROUP_CONCAT(tgl_lembur_awal SEPARATOR "<br>") AS tgl_lembur_awal, 
									GROUP_CONCAT(tgl_lembur_akhir SEPARATOR "<br>") AS tgl_lembur_akhir 
									from tbl_pengajuan_lembur 
									where '.$filter.' '.$filterdate.'
									group by id, nik, nama_karyawan, kd_divisi, 
									keterangan_lembur, app1, app2, app3  
									order by tgl_pengajuan_lembur desc');
		$no = 0;
		foreach($datalembur as $data){
			
			$departements = Departement::where('id', $data->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;

			$status = statusapprove($app1 = $data->app1, $app2 = $data->app2, $app3 = $data->app3);

			$no  = $no+1;
			for($i = 0; $i < count($datalembur); $i++){
				if($data->app2 == ''){
					$btnapp = "<span class='btn btn-success' onclick='approve(2, ".$data->id.")'><i class='icon-ok'></i></span>";
				}else{
					$btnapp = "";
				}
				
				$hasil = "	<tr>
								<td>".$no."</td>
								<td width='12%'>
									".$btnapp."
									<span class='btn btn-danger' onclick='edit(2, ".$data->id.")'><i class='icon-eye-open'></i></span>
								</td>
								<td>".$status."</td>
								<td>".$data->nik."</td>
								<td>".$data->nama_karyawan."</td>
								<td>".$divisi."</td>
								<td>".$data->tgl_lembur_awal."</td>
								<td>".$data->tgl_lembur_akhir."</td>
								<td>".$data->keterangan_lembur."</td>
							</tr>";
			}
			echo $hasil;
		}
	}
	
	
	public function geteditLembur($id){
		$user = Auth::user();
		
		$data_lembur = Lembur::where('id', $id)->get();
		foreach($data_lembur as $datalembur){
			$nama_karyawan = $datalembur->nama_karyawan;
			$nik = $datalembur->nik;
			$jabatan = $datalembur->jabatan;
			$departements = Departement::where('id', $datalembur->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_lembur_awal = $datalembur->tgl_lembur_awal;
			$tgl_lembur_akhir = $datalembur->tgl_lembur_akhir;
			$keterangan_lembur = $datalembur->keterangan_lembur;
			$jenis_lembur = $datalembur->jenis_lembur;
			
			$app1 = $datalembur->app1;
			$app2 = $datalembur->app2;
			$app3 = $datalembur->app3;

			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$level = $datakaryawan->level;
			}
			$tombol = 'aktif';
			
		}
		if($user = Auth::user()){
				return view('admin.lembur.editLembur', compact('id', 'data_lembur', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_lembur_awal', 
																'tgl_lembur_akhir', 'keterangan_lembur', 'jenis_lembur', 'tombol'));
		
		}else{
			return redirect('/login');
		}
	}

	public function editLembur(Request $request){
		$id = $request->input('id');
		$tgl_lembur_awal = Carbon::parse($request->input('tgl_lembur_awal'))->format('Y-m-d');
		$tgl_lembur_akhir = Carbon::parse($request->input('tgl_lembur_akhir'))->format('Y-m-d');
		$jam_lembur_awal = $request->input('jam_lembur_awal');
		$jam_lembur_akhir = $request->input('jam_lembur_akhir');
		$keterangan = $request->input('keterangan');

	/*	$update = Lembur::where('kd',$id)->get();
		$update->tgl_lembur_awal = $tgl_lembur_awal.' '.$jam_lembur_awal;
		$update->tgl_lembur_akhir = $tgl_lembur_akhir.' '.$jam_lembur_akhir;
		$update->keterangan_lembur = $keterangan;
		$update->update();	*/

		$update =DB::select('update tbl_pengajuan_lembur set
							tgl_lembur_awal = "'.$tgl_lembur_awal.' '.$jam_lembur_awal.'",
							tgl_lembur_akhir = "'.$tgl_lembur_akhir.' '.$jam_lembur_akhir.'",
							keterangan_lembur = "'.$keterangan.'"
							where kd = "'.$id.'" ');
	}

	public function getapproveLembur($id){
		$user = Auth::user();
		
		$data_lembur = Lembur::where('id', $id)->get();
		foreach($data_lembur as $datalembur){
			$nama_karyawan = $datalembur->nama_karyawan;
			$nik = $datalembur->nik;
			$jabatan = $datalembur->jabatan;
			$departements = Departement::where('id', $datalembur->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_lembur_awal = $datalembur->tgl_lembur_awal;
			$tgl_lembur_akhir = $datalembur->tgl_lembur_akhir;
			$keterangan_lembur = $datalembur->keterangan_lembur;
			$jenis_lembur = $datalembur->jenis_lembur;
			
			$app1 = $datalembur->app1;
			$app2 = $datalembur->app2;
			$app3 = $datalembur->app3;

			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$level = $datakaryawan->level;
			}

			$tombol = tombolapprove($level, $direct_supervisor, $next_higher_supervisor, $app1, $app2, $app3);
			
		}
		if($user = Auth::user()){
				return view('admin.lembur.approveLembur', compact('id', 'data_lembur', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_lembur_awal', 
																'tgl_lembur_akhir', 'keterangan_lembur', 'jenis_lembur', 'tombol'));
		
		}else{
			return redirect('/login');
		}
	}
	
	
	public function approveLembur(Request $request){
		$user = Auth::user();
		$id = $request->input('id');
		$lembur_data = Lembur::where('id', $id)->get();
		$approve = $request->input('action');
		$jabatan = $request->input('jabatan');
		$approve_time = date('Y-m-d H:i:s');
		$data_lembur = Lembur::where('id', $id)->get();
		foreach($data_lembur as $datalembur){
			$nama_karyawan = $datalembur->nama_karyawan;
			$nik = $datalembur->nik;
			$jabatan = $datalembur->jabatan;
			$tgl_pengajuan_lembur = $datalembur->tgl_pengajuan_lembur;
			$tgl_lembur_awal = $datalembur->tgl_lembur_awal;
			$tgl_lembur_akhir = $datalembur->tgl_lembur_akhir;
			$lama_lembur = $datalembur->lama_lembur;
			$keterangan_lembur = $datalembur->keterangan_lembur;
			$app1 = $datalembur->app1;
			$app2 = $datalembur->app2;
			$app3 = $datalembur->app3;
			
			$departements = Departement::where('id', $datalembur->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;

			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$jenis_karyawan = $datakaryawan->level;
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$email_pemohon = $datakaryawan->email;

				if($direct_supervisor == $next_higher_supervisor){
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff' || $jenis_karyawan == 'Supervisor'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$atasan = 'HRD';

							$update = Lembur::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();
							
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
						

						}else if ($user->hasRole('Super Admin')) {
							$approve_name = 'Super Admin';
							if($app1 == ''){
								$update = Lembur::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
						}else{
							
						}
					} else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$update = Lembur::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();
							
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval Lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
						
						
						}else if ($user->hasRole('Super Admin')) {
							$approve_name = 'Super Admin';
							if($app1 == ''){
								$update = Lembur::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval Lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
						}else{
							
						}
					}else{
						
					}
				}else{
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff'){
						if ($user->hasRole('Supervisor')) {
							$approve_name = 'Supervisor';
							$update = Lembur::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->update();

							$atasan = $next_higher_supervisor;
							$email_to = Employee::where('nama', $next_higher_supervisor)->get();
							foreach($email_to as $emailto){
								$email = $emailto->email;
							}
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval Lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
							Mail::to($email)->send(new LemburVerifikasi($subject = 'Approval Lembur', $atasan, $id, $lembur_data));
						
						}else if ($user->hasRole('Manager')) {
							$update = Lembur::where('id',$id)->first();
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();
							$atasan = 'HRD';
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Pengajuan Lembur', $atasan = $nama_karyawan, $id, $lembur_data));
							}
						
							
						}else if ($user->hasRole('Super Admin')) {
							$approve_name = 'Super Admin';
							if($app1 == ''){
								$update = Lembur::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->update();

								$atasan = $direct_supervisor;
								$email_to = Employee::where('nama', $next_higher_supervisor)->get();
								foreach($email_to as $emailto){
									$email = $emailto->email;
								}

								if($email_pemohon != ''){
									Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval Lembur', $atasan, $id, $lembur_data));
								}
								Mail::to($email)->send(new LemburVerifikasi($subject = 'Approval Lembur', $atasan, $id, $lembur_data));
							}else{
								if($app1 == 'Y'){
									$update = Lembur::where('id',$id)->first();
									$update->app2 = $approve;
									$update->app_name2 = $approve_name;
									$update->app_time2 = $approve_time;
									$update->update();

									if($email_pemohon != ''){
										Mail::to($email_pemohon)->send(new LemburVerifikasiPemohon($subject = 'Approval Lembur', $atasan = $nama_karyawan, $id, $lembur_data));
									}
								
								}
							}
						}else {
							
						}
					}else{

					}
				}
			}
		}
		
		return redirect('');
	}
}
