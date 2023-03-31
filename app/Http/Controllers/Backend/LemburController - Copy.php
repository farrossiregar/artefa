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
use Illuminate\Support\Facades\Mail;

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
	
    public function storeLembur(Request $request){

        $nama_karyawan = $request->input('nama_karyawan');
		$nik = $request->input('nik');
		
		$id_lembur = DB::select("SELECT id FROM TBL_PENGAJUAN_LEMBUR
		 							ORDER BY ID DESC
									LIMIT 1");
		foreach($id_lembur as $idlemburs){
			$idd = $idlemburs->id;
			$ids = $idd + 1;
		}

        $kd_divisi = $request->input('kd_divisi');
		$jabatan = $request->input('jabatan');
		$banyak_lembur = $request->input('banyak_lembur');

        $tgl_pengajuan_lembur = date('Y-m-d H:i:s');
		$app1 = '';
		$app2 = '';
		$app3 = '';

	/*	$tgl_lembur_awal1 = $_POST['tgl_lembur_awal'];
		$jam_lembur_awal1 = $_POST['jam_lembur_awal'];
		$jam_lembur_akhir1 = $_POST['jam_lembur_akhir'];
		$keterangan_lembur1 = $_POST['keterangan_lembur'];
		
		foreach (array_combine($tgl_lembur_awal1, $jam_lembur_awal1) as $tgl_lembur_awal2 => $jam_lembur_awal2 ) {
			$tgl_lembur_awal = Carbon::parse($tgl_lembur_awal2)->format('Y-m-d');
			$getharilembur = strtotime($tgl_lembur_awal);
			$hari_lembur = date('D', $getharilembur);
			$jam_lembur_awal = $jam_lembur_awal2;
			$tgl_jam_lembur_awal = $tgl_lembur_awal.' '.$jam_lembur_awal;
			$jam_lembur_akhir = $jam_lembur_akhir2;
			$tgl_lembur_akhir = $tgl_lembur_awal;
			$tgl_jam_lembur_akhir = $tgl_lembur_akhir.' '.$jam_lembur_akhir;
			$keterangan_lembur = $request->input('keterangan_lembur'.$i);
			echo $tgl_lembur_awal.' - '.$hari_lembur;
		}	*/
		
		if(isset($_POST["tgl_lembur_awal"])){
			$lmbr=$_POST["tgl_lembur_awal"];
			reset($lmbr);
		//	while (list($key, $value) = each($lmbr)){
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
				
				if($hours > 4){
					$setjam = $hours - 1;
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
					
					$email_pemohon = $shiftkaryawan->email;
					if($level == 'Non Staff'){
						$jenis_karyawan = 'Shifting';
						$cek_jadwal_shift = DB::table('shift_schedules')->where('nik', $nik)->where('date', $tgl_lembur_awal)->count();
					//	$cek_jadwal_shift = JadwalShift::where('nik', $nik)->where('tgl_shift', $tgl_lembur_awal)->count();	
						if($cek_jadwal_shift > 0){
							$jenis_hari = 'Masuk';
							$data_shift = DB::table('shift_schedules')->where('nik', $nik)->where('date', $tgl_lembur_awal)->get();
						//	$data_shift = JadwalShift::where('nik', $nik)->where('tgl_shift', $tgl_lembur_awal)->get();		
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

		//	$emails_send = [$email_pemohon, $email];
		//	$emails_send = ['wudcrafterz@gmail.com', 'farrosashiddiq@gmail.com', 'arbitentur.fahmi@gmail.com'];
			Mail::to('wudcrafterz@gmail.com')->send(new LemburVerifikasi($subject = 'Pengajuan Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_lembur, $tgl_jam_lembur_awal, $tgl_jam_lembur_akhir,
																		$lama_lembur, $keterangan_lembur, $atasan, $id, $lembur_data));

			Mail::to('farrosashiddiq@gmail.com')->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_lembur, $tgl_jam_lembur_awal, $tgl_jam_lembur_akhir,
																		$lama_lembur, $keterangan_lembur, $atasan, $id, $lembur_data));
			
		}  
		

		return redirect()->back()->with('success', 'Berhasil Menambah Data!!! Refresh Halaman Untuk Membuat Pengajuan Baru...'); 
	}
	

	
	
	public function getapproveLembur($id){
		$user = Auth::user();
		
		$data_lembur = Lembur::where('id', $id)->get();
		foreach($data_lembur as $datalembur){
			$nama_karyawan = $datalembur->nama_karyawan;
			$nik = $datalembur->nik;
			$jabatan = $datalembur->jabatan;
			$kd_divisi = $datalembur->kd_divisi;
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

			if($user->hasRole('Supervisor')){
				if($level == 'Supervisor'){
					$tombol = 'nonaktif';
				}else{
					if($app1 == ''){
						$tombol = 'aktif';
					}else{
						$tombol = 'nonaktif';
					}
				}
			}else if($user->hasRole('Manager')){
				if($level == 'Manager'){
					if($app1 == ''){
						$tombol = 'aktif';
					}else{
						$tombol = 'nonaktif';
					}
				}else{
					if($direct_supervisor == $next_higher_supervisor){
						if($app1 == ''){
							$tombol = 'aktif';
						}else{
							$tombol = 'nonaktif';
						}
					}else{
						if($app1 == 'Y'){
							if($app2 == ''){
								$tombol = 'aktif';
							}else{
								$tombol = 'nonaktif';
							}
						}else{
							$tombol = 'nonaktif';
						}
					}
				}
			}else if($user->hasRole('Management')){
				if($level == 'Management'){
					if($app1 == ''){
						$tombol = 'aktif';
					}else{
						$tombol = 'nonaktif';
					}
				}else{
					$tombol = 'aktif';
				}
			}else if($user->hasRole('Super Admin')){
				if($app3 == ''){
					$tombol = 'aktif';
				}else{
					$tombol = 'nonaktif';
				}
			}else if($user->hasRole('Staff') || $user->hasRole('Non Staff')){
				$tombol = 'nonaktif';
			}else{
				$tombol = 'nonaktif';
			}
			
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
			$kd_divisi = $datalembur->kd_divisi;
			$jabatan = $datalembur->jabatan;
			$tgl_pengajuan_lembur = $datalembur->tgl_pengajuan_lembur;
			$tgl_lembur_awal = $datalembur->tgl_lembur_awal;
			$tgl_lembur_akhir = $datalembur->tgl_lembur_akhir;
			$lama_lembur = $datalembur->lama_lembur;
			$keterangan_lembur = $datalembur->keterangan_lembur;
			$app1 = $datalembur->app1;
			$app2 = $datalembur->app2;
			$app3 = $datalembur->app3;
			
			$departements = Departement::where('id', $kd_divisi)->get();
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
							$atasan = 'Divisi HRD';
							$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app1 = "'.$approve.'",
												app_name1 = "'.$approve_name.'", 
												app_time1 = "'.$approve_time.'",
												app2 = "'.$approve.'",
												app_name2 = "'.$approve_name.'", 
												app_time2 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								
								Mail::to('abdrozak20@gmail.com')->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
												$tgl_pengajuan_lembur, $tgl_lembur_awal, $tgl_lembur_akhir,
												$lama_lembur, $keterangan_lembur, $atasan = 'HRD', $id, $lembur_data));
							}
						}else{
							if($app2 == 'Y'){
								$approve_name = 'Super Admin';
								$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app3 = "'.$approve.'",
												app_name3 = "'.$approve_name.'", 
												app_time3 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							}
							
						}
					} else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$update = DB::select('UPDATE tbl_pengajuan_lembur
											SET app1 = "'.$approve.'",
											app_name1 = "'.$approve_name.'", 
											app_time1 = "'.$approve_time.'",
											app2 = "'.$approve.'",
											app_name2 = "'.$approve_name.'", 
											app_time2 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
											$tgl_pengajuan_lembur, $tgl_lembur_awal, $tgl_lembur_akhir,
											$lama_lembur, $keterangan_lembur, $atasan = 'HRD', $id, $lembur_data));
							}
						}else if($user->hasRole('Management')){
							if($app1 == 'Y'){
								$approve_name = 'Management';
								$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app3 = "'.$approve.'",
												app_name3 = "'.$approve_name.'", 
												app_time3 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							}
						}else{
							if($app2 == 'Y'){
								$approve_name = 'Super Admin';
								$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app3 = "'.$approve.'",
												app_name3 = "'.$approve_name.'", 
												app_time3 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							}
						}
						
					}else{
						if ($user->hasRole('Management')) {
							$approve_name = 'Management';
							$update = DB::select('UPDATE tbl_pengajuan_lembur
											SET app1 = "'.$approve.'",
											app_name1 = "'.$approve_name.'", 
											app_time1 = "'.$approve_time.'",
											app2 = "'.$approve.'",
											app_name2 = "'.$approve_name.'", 
											app_time2 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
											$tgl_pengajuan_lembur, $tgl_lembur_awal, $tgl_lembur_akhir,
											$lama_lembur, $keterangan_lembur, $atasan = 'HRD', $id, $lembur_data));

							}
							
						}else{
							if($app2 == 'Y'){
								$approve_name = 'Super Admin';
								$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app3 = "'.$approve.'",
												app_name3 = "'.$approve_name.'", 
												app_time3 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							}
						}
					}
				}else{
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff'){
						if ($user->hasRole('Supervisor')) {
							$approve_name = 'Supervisor';
							$pos = 1;
							$atasan = $next_higher_supervisor;

							if($approve == 'Y'){
								$email_to = Employee::where('nama', $next_higher_supervisor)->get();
								foreach($email_to as $emailto){
									$email = $emailto->email;
								}
								Mail::to($email)->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
																	$tgl_pengajuan_lembur, $tgl_lembur_awal, $tgl_lembur_akhir,
																	$lama_lembur, $keterangan_lembur, $atasan, $id, $lembur_data));

								
							}
						}else if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$pos = 2;
						//	$atasan = 'Divisi HRD';
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new LemburVerifikasi($subject = 'Approval Lembur', $nama_karyawan, $nik, $divisi, $jabatan,
																	$tgl_pengajuan_lembur, $tgl_lembur_awal, $tgl_lembur_akhir,
																	$lama_lembur, $keterangan_lembur, $atasan = 'HRD', $id, $lembur_data));
		
							}
							
						}else {
							$approve_name = 'Super Admin';
							$pos = 3;
						}

						$update = DB::select('UPDATE tbl_pengajuan_lembur
												SET app'.$pos.' = "'.$approve.'",
												app_name'.$pos.' = "'.$approve_name.'", 
												app_time'.$pos.' = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
						
					}else{

					}
				}

				//	=====	APPROVAL SUPER ADMIN	=====	//
				if ($user->hasRole('Super Admin') || $user->hasRole('Management')) {
					if($user->hasRole('Super Admin')){
						$approve_name = 'Super Admin';
					}else{
						$approve_name = 'Management';
					}
					
					if($app3 == ''){
						if($app2 == ''){
							if($app1 == ''){
								$update = DB::select('UPDATE tbl_pengajuan_lembur
									SET app1 = "'.$approve.'",
									app_name1 = "'.$approve_name.'", 
									app_time1 = "'.$approve_time.'",
									app2 = "'.$approve.'",
									app_name2 = "'.$approve_name.'", 
									app_time2 = "'.$approve_time.'",
									app3 = "'.$approve.'",
									app_name3 = "'.$approve_name.'", 
									app_time3 = "'.$approve_time.'"
									WHERE id = "'.$id.'"');
							}else{
								if($app1 == 'Y'){
									$update = DB::select('UPDATE tbl_pengajuan_lembur
													SET app2 = "'.$approve.'",
													app_name2 = "'.$approve_name.'", 
													app_time2 = "'.$approve_time.'",
													app3 = "'.$approve.'",
													app_name3 = "'.$approve_name.'", 
													app_time3 = "'.$approve_time.'"
													WHERE id = "'.$id.'"');
								}else{

								}
							}
						}else{
							if($app2 == 'Y'){
								$update = DB::select('UPDATE tbl_pengajuan_lembur
									SET app3 = "'.$approve.'",
									app_name3 = "'.$approve_name.'", 
									app_time3 = "'.$approve_time.'"
									WHERE id = "'.$id.'"');
							}else{

							}
						}
					}else{

					}
				}
			}
		}
		
		

		return redirect('');
	}
}
