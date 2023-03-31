<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Ijin;
use App\Models\Employee;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Mail\IjinVerifikasi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

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
	//	echo $email_pemohon;
		$emails_send = [$email_pemohon, $email];
	//	$emails_send = ['wudcrafterz@gmail.com', 'farrosashiddiq@gmail.com'];
		Mail::to($email_pemohon)->send(new IjinVerifikasi($subject = 'Pengajuan Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
														$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
														$keterangan_ijin, $atasan, $id));

		Mail::to($email)->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
														$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
														$keterangan_ijin, $atasan, $id));
		
		
		return Redirect()->back();
    }
	
	
	public function getapproveIjin($id){
		$user = Auth::user();
		$data_ijin = Ijin::where('id', $id)->get();
		foreach($data_ijin as $dataijin){
			$nama_karyawan = $dataijin->nama_karyawan;
			$nik = $dataijin->nik;
			$jabatan = $dataijin->jabatan;
			$kd_divisi = $dataijin->kd_divisi;
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

		if($user = Auth::user()){
			return view('admin.ijin.approveijin', compact('id', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_ijin_awal', 
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

				$departements = Departement::where('id', $kd_divisi)->get();
				foreach($departements as $dept){
					$department = $dept->department;
					$unit = $dept->unit;
				}	
				$divisi = $department.' / '.$unit;

				if($direct_supervisor == $next_higher_supervisor){
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff' || $jenis_karyawan == 'Supervisor'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
								// $update = DB::select('UPDATE tbl_pengajuan_ijin
								// 				SET app1 = "'.$approve.'",
								// 				app_name1 = "'.$approve_name.'", 
								// 				app_time1 = "'.$approve_time.'",
								// 				app2 = "'.$approve.'",
								// 				app_name2 = "'.$approve_name.'", 
								// 				app_time2 = "'.$approve_time.'"
								// 				WHERE id = "'.$id.'"');
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();

							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																						$keterangan_ijin, $atasan = 'HRD', $id));	
							
							}
						}else{
							if($app2 == 'Y'){
								$approve_name = 'Super Admin';
								// $update = DB::select('UPDATE tbl_pengajuan_ijin
								// 				SET app3 = "'.$approve.'",
								// 				app_name3 = "'.$approve_name.'", 
								// 				app_time3 = "'.$approve_time.'"
								// 				WHERE id = "'.$id.'"');
								$update = Ijin::where('id',$id)->first();
								$update->app3 = $approve;
								$update->app_name3 = $approve_name;
								$update->app_time3 = $approve_time;
								$update->update();
							}
							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$cek_sisa_cuti = DB::select('SELECT * FROM data_hak_cuti 
																		WHERE nik = "'.$nik.'" 
																		AND tahun = "'.$tahun_ini.'"');
											foreach($cek_sisa_cuti as $ceksisacuti){
												$sisa_cuti_tahunan = $ceksisacuti->sisa_cuti_tahunan;
												if($sisa_cuti_tahunan > 0){
													$update_sisa_cuti = DB::select('UPDATE data_hak_cuti 
																					SET sisa_cuti_tahunan = (SELECT (sisa_cuti_tahunan - 0.5) As hr) 
																					WHERE nik = "'.$nik.'" 
																					AND tahun = "'.$tahun_ini.'"');
												}
											}
	
	
											$istype = '1';
											$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
											$jumlah = $cek_hpcuti;
											if($jumlah > 0){
												$hp_cuti = HPcuti::where('istype', $istype)
																->where('isuser', $userid)->orderBy('cutiid', 'DESC')
																->get();
												foreach($hp_cuti as $hpcuti){
													$sebelum = $hpcuti->sebelum;
													$sesudah = $hpcuti->sesudah;
													$audit = $hpcuti->audit;
													$audit2 = $audit + 1;
												}
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_akhir;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = $sesudah;
												$inserthpcuti->sesudah = $sesudah - 0.5;
												$inserthpcuti->audit = $audit2;
										
												$inserthpcuti->save();
											}else{
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_awal;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = 0;
												$inserthpcuti->sesudah = 0 - 0.5;
												$inserthpcuti->audit = '1';
										
												$inserthpcuti->save();
											}
										}
									}else{
										
									}
								}
							}
						}
					} else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							// $update = DB::select('UPDATE tbl_pengajuan_ijin
							// 				SET app1 = "'.$approve.'",
							// 				app_name1 = "'.$approve_name.'", 
							// 				app_time1 = "'.$approve_time.'"
							// 				WHERE id = "'.$id.'"');
							$update = Ijin::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->update();
							if($approve == 'Y'){
								$atasan = $next_higher_supervisor;
								$email_to = Employee::where('nama', $atasan)->get();
								foreach($email_to as $emailto){
									$email = $emailto->email;
								}
								Mail::to($email)->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																						$keterangan_ijin, $atasan = 'HRD', $id));
							
							}
							
						}else if($user->hasRole('Management')){
							$approve_name = 'Management';
							// $update = DB::select('UPDATE tbl_pengajuan_ijin
							// 				SET app2 = "'.$approve.'",
							// 				app_name2 = "'.$approve_name.'", 
							// 				app_time2 = "'.$approve_time.'"
							// 				WHERE id = "'.$id.'"');
							$update = Ijin::where('id',$id)->first();
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																						$keterangan_ijin, $atasan = 'HRD', $id));
							}
						}else{
							$approve_name = 'Super Admin';
							// $update = DB::select('UPDATE tbl_pengajuan_ijin
							// 				SET app3 = "'.$approve.'",
							// 				app_name3 = "'.$approve_name.'", 
							// 				app_time3 = "'.$approve_time.'"
							// 				WHERE id = "'.$id.'"');
							$update = Ijin::where('id',$id)->first();
							$update->app3 = $approve;
							$update->app_name3 = $approve_name;
							$update->app_time3 = $approve_time;
							$update->update();
							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$cek_sisa_cuti = DB::select('SELECT * FROM data_hak_cuti 
																		WHERE nik = "'.$nik.'" 
																		AND tahun = "'.$tahun_ini.'"');
											foreach($cek_sisa_cuti as $ceksisacuti){
												$sisa_cuti_tahunan = $ceksisacuti->sisa_cuti_tahunan;
												if($sisa_cuti_tahunan > 0){
													$update_sisa_cuti = DB::select('UPDATE data_hak_cuti 
																					SET sisa_cuti_tahunan = (SELECT (sisa_cuti_tahunan - 0.5) As hr) 
																					WHERE nik = "'.$nik.'" 
																					AND tahun = "'.$tahun_ini.'"');
												}
											}
	
											$istype = '1';
											$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
											$jumlah = $cek_hpcuti;
											if($jumlah > 0){
												$hp_cuti = HPcuti::where('istype', $istype)
																->where('isuser', $userid)->orderBy('cutiid', 'DESC')
																->get();
												foreach($hp_cuti as $hpcuti){
													$sebelum = $hpcuti->sebelum;
													$sesudah = $hpcuti->sesudah;
													$audit = $hpcuti->audit;
													$audit2 = $audit + 1;
												}
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_akhir;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = $sesudah;
												$inserthpcuti->sesudah = $sesudah - 0.5;
												$inserthpcuti->audit = $audit2;
										
												$inserthpcuti->save();
											}else{
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_awal;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = 0;
												$inserthpcuti->sesudah = 0 - 0.5;
												$inserthpcuti->audit = '1';
										
												$inserthpcuti->save();
											}
										}
									}else{
										
									}
								}
							}
						}
					}else{
						if ($user->hasRole('Management')) {
							$approve_name = 'Management';
							// $update = DB::select('UPDATE tbl_pengajuan_ijin
							// 				SET app1 = "'.$approve.'",
							// 				app_name1 = "'.$approve_name.'", 
							// 				app_time1 = "'.$approve_time.'",
							// 				app2 = "'.$approve.'",
							// 				app_name2 = "'.$approve_name.'", 
							// 				app_time2 = "'.$approve_time.'"
							// 				WHERE id = "'.$id.'"');
							$update = Ijin::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();

							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																						$keterangan_ijin, $atasan = 'HRD', $id));
							
							}
								
						}else{
							if($app2 == 'Y'){
								$approve_name = 'Super Admin';
								// $update = DB::select('UPDATE tbl_pengajuan_ijin
								// 				SET app3 = "'.$approve.'",
								// 				app_name3 = "'.$approve_name.'", 
								// 				app_time3 = "'.$approve_time.'"
								// 				WHERE id = "'.$id.'"');
								$update = Ijin::where('id',$id)->first();
								$update->app3 = $approve;
								$update->app_name3 = $approve_name;
								$update->app_time3 = $approve_time;
								$update->update();
							}
							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$cek_sisa_cuti = DB::select('SELECT * FROM data_hak_cuti 
																		WHERE nik = "'.$nik.'" 
																		AND tahun = "'.$tahun_ini.'"');
											foreach($cek_sisa_cuti as $ceksisacuti){
												$sisa_cuti_tahunan = $ceksisacuti->sisa_cuti_tahunan;
												if($sisa_cuti_tahunan > 0){
													$update_sisa_cuti = DB::select('UPDATE data_hak_cuti 
																					SET sisa_cuti_tahunan = (SELECT (sisa_cuti_tahunan - 0.5) As hr) 
																					WHERE nik = "'.$nik.'" 
																					AND tahun = "'.$tahun_ini.'"');
												}
											}
		
											$istype = '1';
											$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
											$jumlah = $cek_hpcuti;
											if($jumlah > 0){
												$hp_cuti = HPcuti::where('istype', $istype)
																->where('isuser', $userid)->orderBy('cutiid', 'DESC')
																->get();
												foreach($hp_cuti as $hpcuti){
													$sebelum = $hpcuti->sebelum;
													$sesudah = $hpcuti->sesudah;
													$audit = $hpcuti->audit;
													$audit2 = $audit + 1;
												}
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_akhir;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = $sesudah;
												$inserthpcuti->sesudah = $sesudah - 0.5;
												$inserthpcuti->audit = $audit2;
										
												$inserthpcuti->save();
											}else{
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_awal;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = 0;
												$inserthpcuti->sesudah = 0 - 0.5;
												$inserthpcuti->audit = '1';
										
												$inserthpcuti->save();
											}
										}
										
									}else{
										
									}
								}
							}
						}
					}
				}else{
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff'){
						if ($user->hasRole('Supervisor')) {
							$approve_name = 'Supervisor';
							$pos = 1;

							$atasan = $next_higher_supervisor;
							$email_to = Employee::where('nama', $atasan)->get();
							foreach($email_to as $emailto){
								$email = $emailto->email;
							}

							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																			$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																			$keterangan_ijin, $atasan, $id));
							}
						}else if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$pos = 2;

							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new IjinVerifikasi($subject = 'Approval Ijin', $nama_karyawan, $nik, $divisi, $jabatan,
																			$tgl_pengajuan_ijin, $tgl_jam_ijin_awal, $tgl_jam_ijin_akhir,
																			$keterangan_ijin, $atasan = 'HRD', $id));
								
							}
							
						}else {
							$approve_name = 'Super Admin';
							$pos = 3;

							if($approve == 'Y'){
								if($tindak_lanjut == 'POTONG CUTI'){
									if($hours >= 3){
										if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
											$cek_sisa_cuti = DB::select('SELECT * FROM data_hak_cuti 
																		WHERE nik = "'.$nik.'" 
																		AND tahun = "'.$tahun_ini.'"');
											foreach($cek_sisa_cuti as $ceksisacuti){
												$sisa_cuti_tahunan = $ceksisacuti->sisa_cuti_tahunan;
												if($sisa_cuti_tahunan > 0){
													$update_sisa_cuti = DB::select('UPDATE data_hak_cuti 
																					SET sisa_cuti_tahunan = (SELECT (sisa_cuti_tahunan - 0.5) As hr) 
																					WHERE nik = "'.$nik.'" 
																					AND tahun = "'.$tahun_ini.'"');
												}
											}
			
											$istype = '1';
											$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
											$jumlah = $cek_hpcuti;
											if($jumlah > 0){
												$hp_cuti = HPcuti::where('istype', $istype)
																->where('isuser', $userid)->orderBy('cutiid', 'DESC')
																->get();
												foreach($hp_cuti as $hpcuti){
													$sebelum = $hpcuti->sebelum;
													$sesudah = $hpcuti->sesudah;
													$audit = $hpcuti->audit;
													$audit2 = $audit + 1;
												}
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_akhir;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = $sesudah;
												$inserthpcuti->sesudah = $sesudah - 0.5;
												$inserthpcuti->audit = $audit2;
										
												$inserthpcuti->save();
											}else{
												$inserthpcuti = new HPcuti;
												$inserthpcuti->isuser = $userid;
												$inserthpcuti->mulai = $tgl_cuti_awal;
												$inserthpcuti->akhir = $tgl_cuti_awal;
												$inserthpcuti->istype = $istype;
												$inserthpcuti->jumlah = 0.5;
												$inserthpcuti->keterangan = 'Cuti 0.5';
												$inserthpcuti->sebelum = 0;
												$inserthpcuti->sesudah = 0 - 0.5;
												$inserthpcuti->audit = '1';
										
												$inserthpcuti->save();
											}
										}
									}else{
										
									}
								}
							}
						}

						$update = DB::select('UPDATE tbl_pengajuan_ijin
												SET app'.$pos.' = "'.$approve.'",
												app_name'.$pos.' = "'.$approve_name.'", 
												app_time'.$pos.' = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
						// $update = Ijin::where('id',$id)->first();
						// $update->app1 = $approve;
						// $update->app_''name1'' = $approve_name;
						// $update->app_time1 = $approve_time;
						// $update->app2 = $approve;
						// $update->app_name2 = $approve_name;
						// $update->app_time2 = $approve_time;
						// $update->app3 = $approve;
						// $update->app_name3 = $approve_name;
						// $update->app_time3 = $approve_time;
						// $update->update();
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
					
					$pos = 3;

					if($app3 == ''){
						if($app2 == ''){
							if($app1 == ''){
								// $update = DB::select('UPDATE tbl_pengajuan_ijin
								// 	SET app1 = "'.$approve.'",
								// 	app_name1 = "'.$approve_name.'", 
								// 	app_time1 = "'.$approve_time.'",
								// 	app2 = "'.$approve.'",
								// 	app_name2 = "'.$approve_name.'", 
								// 	app_time2 = "'.$approve_time.'",
								// 	app3 = "'.$approve.'",
								// 	app_name3 = "'.$approve_name.'", 
								// 	app_time3 = "'.$approve_time.'"
								// 	WHERE id = "'.$id.'"');
								$update = Ijin::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->app3 = $approve;
								$update->app_name3 = $approve_name;
								$update->app_time3 = $approve_time;
								$update->update();
							}else{
								if($app1 == 'Y'){
									// $update = DB::select('UPDATE tbl_pengajuan_ijin
									// 			SET app2 = "'.$approve.'",
									// 			app_name2 = "'.$approve_name.'", 
									// 			app_time2 = "'.$approve_time.'"
									// 			app3 = "'.$approve.'",
									// 			app_name3 = "'.$approve_name.'", 
									// 			app_time3 = "'.$approve_time.'"
									// 			WHERE id = "'.$id.'"');
									$update = Ijin::where('id',$id)->first();
									$update->app2 = $approve;
									$update->app_name2 = $approve_name;
									$update->app_time2 = $approve_time;
									$update->app3 = $approve;
									$update->app_name3 = $approve_name;
									$update->app_time3 = $approve_time;
									$update->update();
								}else{
									
								}
							}
						}else{
							if($app2 == 'Y'){
								// $update = DB::select('UPDATE tbl_pengajuan_ijin
								// 	SET app3 = "'.$approve.'",
								// 	app_name3 = "'.$approve_name.'", 
								// 	app_time3 = "'.$approve_time.'"
								// 	WHERE id = "'.$id.'"');
								$update = Ijin::where('id',$id)->first();
								$update->app3 = $approve;
								$update->app_name3 = $approve_name;
								$update->app_time3 = $approve_time;
								$update->update();
							}else{
								
							}
						}
					}else{

					}

					if($approve == 'Y'){
						if($tindak_lanjut == 'POTONG CUTI'){
							if($hours >= 3){
								if($jabatan != 'Sales & Marketing Manager' || $jabatan != 'Sales Consultant' || $jabatan != 'Sales Supervisor' || $jabatan != 'Sales Counter'){
									$cek_sisa_cuti = DB::select('SELECT * FROM data_hak_cuti 
																WHERE nik = "'.$nik.'" 
																AND tahun = "'.$tahun_ini.'"');
									foreach($cek_sisa_cuti as $ceksisacuti){
										$sisa_cuti_tahunan = $ceksisacuti->sisa_cuti_tahunan;
										if($sisa_cuti_tahunan > 0){
											$update_sisa_cuti = DB::select('UPDATE data_hak_cuti 
																			SET sisa_cuti_tahunan = (SELECT (sisa_cuti_tahunan - 0.5) As hr) 
																			WHERE nik = "'.$nik.'" 
																			AND tahun = "'.$tahun_ini.'"');
										}
									}
	
									$istype = '1';
									$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
									$jumlah = $cek_hpcuti;
									if($jumlah > 0){
										$hp_cuti = HPcuti::where('istype', $istype)
														->where('isuser', $userid)->orderBy('cutiid', 'DESC')
														->get();
										foreach($hp_cuti as $hpcuti){
											$sebelum = $hpcuti->sebelum;
											$sesudah = $hpcuti->sesudah;
											$audit = $hpcuti->audit;
											$audit2 = $audit + 1;
										}
										$inserthpcuti = new HPcuti;
										$inserthpcuti->isuser = $userid;
										$inserthpcuti->mulai = $tgl_cuti_awal;
										$inserthpcuti->akhir = $tgl_cuti_akhir;
										$inserthpcuti->istype = $istype;
										$inserthpcuti->jumlah = 0.5;
										$inserthpcuti->keterangan = 'Cuti 0.5';
										$inserthpcuti->sebelum = $sesudah;
										$inserthpcuti->sesudah = $sesudah - 0.5;
										$inserthpcuti->audit = $audit2;
								
										$inserthpcuti->save();
									}else{
										$inserthpcuti = new HPcuti;
										$inserthpcuti->isuser = $userid;
										$inserthpcuti->mulai = $tgl_cuti_awal;
										$inserthpcuti->akhir = $tgl_cuti_awal;
										$inserthpcuti->istype = $istype;
										$inserthpcuti->jumlah = 0.5;
										$inserthpcuti->keterangan = 'Cuti 0.5';
										$inserthpcuti->sebelum = 0;
										$inserthpcuti->sesudah = 0 - 0.5;
										$inserthpcuti->audit = '1';
								
										$inserthpcuti->save();
									}
								}
							}else{
								
							}
						}
					}
				}
			}
		}
		
		return redirect('');
	}
}
