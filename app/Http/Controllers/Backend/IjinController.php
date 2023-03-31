<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Ijin;
use App\Models\HPcuti;
use App\Models\Employee;
use App\Models\Datahakcuti;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Mail\IjinVerifikasi;
use App\Mail\IjinVerifikasiPemohon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\helpers;

class IjinController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

    
    public function indexIjin() {
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
					'jabatan' => $datakaryawan_cek->level,
					'level' => $datakaryawan_cek->level
				);
			}
			$getuser = '<div class="form-group">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="'.$parameter['nama_karyawan'].'" required readonly/>
						</div>';
		}
		return view('admin.ijin.indexIjin', compact('data_karyawan', 'parameter', 'departements', 'getuser', 'datamngrspv'));
    }
	
	
    public function storeIjin(Request $request){
        $nama_karyawan = $request->input('nama_karyawan');
        $nik = $request->input('nik');
        $kd_divisi = $request->input('kd_divisi');
		$jabatan = $request->input('jabatan');
        $tgl_ijin_awal = Carbon::parse($request->input('tgl_ijin_awal'))->format('Y-m-d');
        $jam_ijin_awal = $request->input('jam_ijin_awal');
		$jam_ijin_awal2 = $jam_ijin_awal.":00";
		$tgl_jam_ijin_awal = $tgl_ijin_awal.' '.$jam_ijin_awal2;
        $tgl_ijin_akhir = Carbon::parse($request->input('tgl_ijin_akhir'))->format('Y-m-d');
        $jam_ijin_akhir = $request->input('jam_ijin_akhir');
		$jam_ijin_akhir2 = $jam_ijin_akhir.":00";
		$tgl_jam_ijin_akhir = $tgl_ijin_akhir.' '.$jam_ijin_akhir2;
        $tgl_pengajuan_ijin = date('Y-m-d H:i:s');
        $tindak_lanjut = $request->input('tindak_lanjut');
		$keterangan_ijin = $request->input('keterangan_ijin');
		$app1 = '';
		$app2 = '';
		$app3 = '';
		
		$diff = abs(strtotime($jam_ijin_awal2) - strtotime($jam_ijin_akhir2));
		$years   = floor($diff / (365*60*60*24)); 
		$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
		$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
		$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
		$selisih = $hours.":".$minuts;
		
		$tahun_ini = date('Y');
		
		$ijin = new Ijin;
		$ijin->nama_karyawan = $nama_karyawan;
        $ijin->nik = $nik;
        $ijin->kd_divisi = $kd_divisi;
		$ijin->jabatan = $jabatan;
        $ijin->tgl_ijin_awal = $tgl_ijin_awal." ".$jam_ijin_awal2;
        $ijin->tgl_ijin_akhir = $tgl_ijin_akhir." ".$jam_ijin_akhir2;
        $ijin->tgl_pengajuan_ijin = $tgl_pengajuan_ijin;
		$ijin->tindak_lanjut = $tindak_lanjut;
        $ijin->keterangan_ijin = $keterangan_ijin;
        $ijin->app1 = $app1;
        $ijin->app2 = $app2;
        $ijin->app3 = $app3;
		$ijin->save();

		$departements = Departement::where('id', $kd_divisi)->get();
		foreach($departements as $dept){
			$department = $dept->department;
			$unit = $dept->unit;
		}	
		$divisi = $department.' / '.$unit;

		$emailpemohon = Employee::where('nik', $nik)->get();
		foreach($emailpemohon as $emailpemohons){
			$email_pemohon = $emailpemohons->email;
			$direct_supervisor = $emailpemohons->direct_supervisor;
		}

		$atasan = $direct_supervisor;
		$email_to = Employee::where('nama', $atasan)->get();
		foreach($email_to as $emailto){
			$email = $emailto->email;
		}

		$dataijinid = Ijin::where('nik', $nik)
							->where('tgl_ijin_awal', $tgl_jam_ijin_awal)
							->where('tgl_ijin_akhir', $tgl_jam_ijin_akhir)
                            ->get();
		foreach($dataijinid as $data_ijinid){
			$id = $data_ijinid->id;
		}

		$ijin_data = Ijin::where('id', $id)->get();
	
	//	$emails_send = ['wudcrafterz@gmail.com', 'farrosashiddiq@gmail.com'];
		if($email_pemohon != ''){
			Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $atasan, $id, $ijin_data));
		}

		Mail::to($email)->send(new IjinVerifikasi($subject = 'Approval Ijin', $atasan, $id, $ijin_data));
		
		
		return Redirect()->back();
    }
	
	public function dataijin(){
		$departements = Departement::orderBy('id', 'ASC')->get();
		return view('admin.ijin.TableApproveIjin', compact('departements'));
	}

	public function getdataijin(Request $request){
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
			$filterdate = 'and tgl_ijin_awal >= "'.$start_date.'" and tgl_ijin_akhir <= "'.$end_date.'" order by tgl_pengajuan_ijin desc';
		}else{
			if($start_date == ''){
				$filterdate = 'and tgl_ijin_akhir <= "'.$end_date.'" order by tgl_pengajuan_ijin desc';
			}else if($end_date == ''){
				$filterdate = 'and tgl_ijin_awal >= "'.$start_date.'" order by tgl_pengajuan_ijin desc';
			}else  if($start_date == '' and $end_date == ''){
				$filterdate = 'order by tgl_pengajuan_ijin desc';
			}else{
				$filterdate = 'order by tgl_pengajuan_ijin desc';
			}
		}

		$dataijin = DB::select('select * from 
								tbl_pengajuan_ijin 
								where '.$filter.' '.$filterdate.' ');
		
		$no = 0;
		foreach($dataijin as $data){
			$departements = Departement::where('id', $data->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;

			$status = statusapprove($app1 = $data->app1, $app2 = $data->app2, $app3 = $data->app3);
			$no  = $no+1;
			for($i = 0; $i < count($dataijin); $i++){
				if($data->app2 == ''){
					if($data->app1 == 'Y'){
						$btnapp = "<span class='btn btn-success' onclick='approve(3, ".$data->id.")'><i class='icon-ok'></i></span>";
					}else{
						$btnapp = "";
					}
				}else{
					$btnapp = "";
				}
				$hasil = "	<tr>
								<td>".$no."</td>
								<td width='12%'>
									".$btnapp."
									<span class='btn btn-danger' onclick='edit(3, ".$data->id.")'><i class='icon-eye-open'></i></span>
								</td>
								<td>".$status."</td>
								<td>".$data->nik."</td>
								<td>".$data->nama_karyawan."</td>
								<td>".$divisi."</td>
								<td>".$data->tgl_ijin_awal."</td>
								<td>".$data->tgl_ijin_akhir."</td>
								<td>".$data->keterangan_ijin."</td>
							</tr>";
			}
			echo $hasil;
		}
	}

	public function geteditIjin($id){
		$user = Auth::user();
		
		$data_ijin = Ijin::where('id', $id)->get();
		foreach($data_ijin as $dataijin){
			$nama_karyawan = $dataijin->nama_karyawan;
			$nik = $dataijin->nik;
			$jabatan = $dataijin->jabatan;
			$departements = Departement::where('id', $dataijin->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_ijin_awal = $dataijin->tgl_ijin_awal;
			$tgl_ijin_akhir = $dataijin->tgl_ijin_akhir;
			$keterangan_ijin = $dataijin->keterangan_ijin;
			$tindak_lanjut = $dataijin->tindak_lanjut;
			
			$app1 = $dataijin->app1;
			$app2 = $dataijin->app2;
			$app3 = $dataijin->app3;

			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$level = $datakaryawan->level;
			}
			$tombol = 'aktif';
			
		}
		if($user = Auth::user()){
				return view('admin.ijin.editIjin', compact('id', 'data_ijin', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_ijin_awal', 
																'tgl_ijin_akhir', 'keterangan_ijin', 'tindak_lanjut', 'tombol'));
		
		}else{
			return redirect('/login');
		}
	}

	public function editijin(Request $request){
		$id = $request->input('id');
		$tgl_ijin_awal = Carbon::parse($request->input('tgl_ijin_awal'))->format('Y-m-d');
		$tgl_ijin_akhir = Carbon::parse($request->input('tgl_ijin_akhir'))->format('Y-m-d');
		$jam_ijin_awal = $request->input('jam_ijin_awal');
		$jam_ijin_akhir = $request->input('jam_ijin_akhir');
		$keterangan_ijin = $request->input('keterangan');
		$tindak_lanjut = $request->input('tindak_lanjut');

		$diff = abs(strtotime($tgl_ijin_akhir.' '.$jam_ijin_akhir) - strtotime($tgl_ijin_awal.' '.$jam_ijin_awal));
				
		$years   = floor($diff / (365*60*60*24)); 
		$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
		$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		
		$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
		$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

		$getdataijin = Ijin::where('id', $id)->get();
		foreach($getdataijin as $data){
			$nik = $data->nik;
			$tgl_ijin_awal1 = Carbon::parse($data->tgl_ijin_awal)->format('Y-m-d').' 00:00:00';
			$tgl_ijin_akhir1 = Carbon::parse($data->tgl_ijin_akhir)->format('Y-m-d').' 00:00:00';
		}

		$getdatakaryawan = Employee::where('nik', $nik)->get();
		foreach($getdatakaryawan as $data){
			$userid = $data->userid;
		}

		$getdatahpcuti = HPcuti::where('mulai', '2019-03-07')
								->where('akhir', '2019-03-07')
								->where('isUser', '321')
								->where('istype', '1')
								->get();
		foreach($getdatahpcuti as $data){
			$cutiid = $data->cutiID;
			$jumlah1 = $data->Jumlah;
		}
		if($hours > 3){
			$jumlah2 = '0.5';
			editjumlahcuti($userid, $istype = '1', $tglcutiawal1 = $tgl_ijin_awal1, $tglcutiakhir1 = $tgl_ijin_akhir1, $jumlah1, $tglcutiawal2 = $tgl_ijin_awal, $tglcutiakhir2 = $tgl_ijin_akhir, $jumlah2);
		}else{
			$hapushpcuti = DB::select('delete from hpcuti where cutiID = "'.$cutiid.'" ');
		}

		

		$update = Ijin::where('id',$id)->first();
		$update->tgl_ijin_awal = $tgl_ijin_awal.' '.$jam_ijin_awal;
		$update->tgl_ijin_akhir = $tgl_ijin_akhir.' '.$jam_ijin_akhir;
		$update->keterangan_ijin = $keterangan_ijin;
		$update->tindak_lanjut = $tindak_lanjut;
		$update->update();
	}

	
	public function getapproveIjin($id){
		$user = Auth::user();
		$data_ijin = Ijin::where('id', $id)->get();
		foreach($data_ijin as $dataijin){
			$nama_karyawan = $dataijin->nama_karyawan;
			$nik = $dataijin->nik;
			$jabatan = $dataijin->jabatan;
			$departements = Departement::where('id', $dataijin->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_ijin_awal = $dataijin->tgl_ijin_awal;
			$tgl_ijin_akhir = $dataijin->tgl_ijin_akhir;
			$keterangan_ijin = $dataijin->keterangan_ijin;
			$tindak_lanjut = $dataijin->tindak_lanjut;
			$app1 = $dataijin->app1;
			$app2 = $dataijin->app2;
			$app3 = $dataijin->app3;
		}

		$karyawan = Employee::where('nik', $nik)->get();
		foreach($karyawan as $datakaryawan){
			$direct_supervisor = $datakaryawan->direct_supervisor;
			$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
			$level = $datakaryawan->level;
		}

		$tombol = tombolapprove($level, $direct_supervisor, $next_higher_supervisor, $app1, $app2, $app3);
		if($user = Auth::user()){
			return view('admin.ijin.approveIjin', compact('id', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_ijin_awal', 
															'tgl_ijin_akhir', 'keterangan_ijin', 'tindak_lanjut', 'tombol'));
		}else{
			return redirect('/login');
		}
		
	}
	
	
	public function approveIjin(Request $request){
        $id = $request->input('id');
		$approve = $request->input('action');
	//	$jabatan = $request->input('jabatan');
		$approve_time = date('Y-m-d H:i:s');
		$user = Auth::user();
		$tahun_ini = date('Y');

		$ijin_data = Ijin::where('id', $id)->get();
		
		$data_ijin = Ijin::where('id', $id)->get();
		foreach($data_ijin as $dataijin){
			$app1 = $dataijin->app1;
			$app2 = $dataijin->app2;
			$app3 = $dataijin->app3;
			$nik = $dataijin->nik;
			$nama_karyawan = $dataijin->nama_karyawan;
			$tgl_ijin_awal = $dataijin->tgl_ijin_awal;
			$jam_ijin_awal = Carbon::parse($tgl_ijin_awal)->format('H:i:s');
			$tgl_ijin_akhir = $dataijin->tgl_ijin_akhir;
			$jam_ijin_akhir = Carbon::parse($tgl_ijin_akhir)->format('H:i:s');
			$tindak_lanjut = $dataijin->tindak_lanjut;
			$tgl_jam_ijin_awal = $tgl_ijin_awal;
			$tgl_jam_ijin_akhir = $tgl_ijin_akhir;
			$tgl_pengajuan_ijin = $dataijin->tgl_pengajuan_ijin;
			$keterangan_ijin = $dataijin->keterangan_ijin;

			$diff = abs(strtotime($jam_ijin_akhir) - strtotime($jam_ijin_awal));
			$years   = floor($diff / (365*60*60*24)); 
			$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
			$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
			$selisih = $hours.":".$minuts;
			
			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$jenis_karyawan = $datakaryawan->level;
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$userid = $datakaryawan->userid;
				$jabatan = $datakaryawan->jabatan;
				$kd_divisi = $datakaryawan->dept_id;
				$email_pemohon = $datakaryawan->email;

				$departements = Departement::where('id', $kd_divisi)->get();
				foreach($departements as $dept){
					$department = $dept->department;
					$unit = $dept->unit;
				}	
				$divisi = $department.' / '.$unit;

				if($direct_supervisor == $next_higher_supervisor){
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff' || $jenis_karyawan == 'Supervisor'){
						if ($user->hasRole('Manager')) {
							if($app1 == ''){
								$approve_name = 'Manager';
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}
							
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																					$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																					$keterangan_ijin, $atasan = $nama_karyawan, $id));	
							}
						
							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
										$istype = '1';
										$keterangan = 'Cuti 0.5'; 
										$mulai = $tgl_jam_ijin_awal;
										$akhir = $tgl_jam_ijin_akhir;
										$jumlah_diambil = '0.5';
										updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
									}
								}else{
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}
								}
								
							}
						}else if ($user->hasRole('Super Admin')) {
							if($app1 == ''){
								$approve_name = 'Super Admin';
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																					$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																					$keterangan_ijin, $atasan = $nama_karyawan, $id));	
							}
							if($approve == 'Y'){
						
								if($tindak_lanjut == 'POTONG CUTI'){
									if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
										$istype = '1';
										$keterangan = 'Cuti 0.5'; 
										$mulai = $tgl_jam_ijin_awal;
										$akhir = $tgl_jam_ijin_akhir;
										$jumlah_diambil = '0.5';
										updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
									}
								}else{
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}
								}
							}
								
						}else{

						}
					} else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							if($app1 == ''){
								$approve_name = 'Manager';
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}
							
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																					$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																					$keterangan_ijin, $atasan = $nama_karyawan, $id));
							}
							
							if($approve == 'Y'){
								
								if($tindak_lanjut == 'POTONG CUTI'){
									if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
										$istype = '1';
										$keterangan = 'Cuti 0.5'; 
										$mulai = $tgl_jam_ijin_awal;
										$akhir = $tgl_jam_ijin_akhir;
										$jumlah_diambil = '0.5';
										updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
									}
								}else{
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}
								}
							}
						}else if ($user->hasRole('Super Admin')) {
							$approve_name = 'Super Admin';
							if($app1 == ''){
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																					$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																					$keterangan_ijin, $atasan = $nama_karyawan, $id));
							}
							if($approve == 'Y'){
								
								if($tindak_lanjut == 'POTONG CUTI'){
									if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
										$istype = '1';
										$keterangan = 'Cuti 0.5'; 
										$mulai = $tgl_jam_ijin_awal;
										$akhir = $tgl_jam_ijin_akhir;
										$jumlah_diambil = '0.5';
										updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
									}
								}else{
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}
								}

							}
						}else{

						}
					}else{
						
					}
				}else{
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff'){
						if ($user->hasRole('Supervisor')) {
							$approve_name = 'Supervisor';
							$update = Ijin::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->update();
							

							$atasan = $next_higher_supervisor;
							$email_to = Employee::where('nama', $atasan)->get();
							foreach($email_to as $emailto){
								$email = $emailto->email;
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																		$keterangan_ijin, $atasan = $nama_karyawan, $id));
							}
							
							Mail::to($email)->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																		$keterangan_ijin, $atasan, $id));
						}else if ($user->hasRole('Manager')) {
							if($app1 == 'Y'){
								$approve_name = 'Manager';
								$update = Ijin::where('id',$id)->first();
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																		$keterangan_ijin, $atasan = $nama_karyawan, $id));
							}
							
							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
										$istype = '1';
										$keterangan = 'Cuti 0.5'; 
										$mulai = $tgl_jam_ijin_awal;
										$akhir = $tgl_jam_ijin_akhir;
										$jumlah_diambil = '0.5';
										updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
									}
								}else{
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}
								}
							}
							
						}else if ($user->hasRole('Super Admin')) {
							if($app1 == ''){
								$approve_name = 'Super Admin';
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->update();

								if($email_pemohon != ''){
									Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																			$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																			$keterangan_ijin, $atasan = $nama_karyawan, $id));
								}
								Mail::to($email)->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																		$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																		$keterangan_ijin, $atasan, $id));
							}else{
								if($app1 == 'Y'){
									$approve_name = 'Super Admin';
									$update = Ijin::where('id',$id)->first();
									$update->app2 = $approve;
									$update->app_name2 = $approve_name;
									$update->app_time2 = $approve_time;
									$update->update();
								}

								if($email_pemohon != ''){
									Mail::to($email_pemohon)->send(new IjinVerifikasiPemohon($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																			$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																			$keterangan_ijin, $atasan = $nama_karyawan, $id));
								}
								if($approve == 'Y'){
									if($tindak_lanjut == 'POTONG CUTI'){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$istype = '1';
											$keterangan = 'Cuti 0.5'; 
											$mulai = $tgl_jam_ijin_awal;
											$akhir = $tgl_jam_ijin_akhir;
											$jumlah_diambil = '0.5';
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
									}else{
										if($hours >= 3){
											if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
												$istype = '1';
												$keterangan = 'Cuti 0.5'; 
												$mulai = $tgl_jam_ijin_awal;
												$akhir = $tgl_jam_ijin_akhir;
												$jumlah_diambil = '0.5';
												updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
											}
										}
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
