<?php

namespace App\Http\Controllers\Backend;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\ReportCuti;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\HPcuti;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanggalMerah;
use DB;
use Auth;
use App\Mail\CutiVerifikasi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

class CutiController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function filterkaryawan(Request $request) {
		$dept_id = $request->input('dept_id');

		if($dept_id != ''){
			$datamngrspv = Employee::where('dept_id', $dept_id)->get();
		}else{
			$datamngrspv = Employee::orderBy('dept_id','ASC')->get();
		}

		foreach($datamngrspv as $data_mngr_spv){
			$nama = $data_mngr_spv->nama;
			$nik = $data_mngr_spv->nik;
			
			for($i = 0; $i < count($datamngrspv); $i++){
				$hasil = "<tr class='gradeA odd'>
								<td onclick='post();'>".$nama."</td>
								<td onclick='post();'>".$nik."</td>
							</tr>";
			}
			echo $hasil;
		}
	}

	public function getUser(Request $request) {
		$nik = $request->input('nik');
	
		$datakaryawan = DB::select("SELECT a.*, b.* , 
									(select sum(jumlah) 
										from hpcuti 
										where istype in ('1', '2', '3', '4') 
										and isuser = b.isuser 
									group by isuser) as cutitahunan, 
									(select sum(jumlah) 
										from hpcuti 
										where istype = '5' 
										and isuser = b.isuser 
									group by isuser) as cutikhusus

									FROM employees a 
									LEFT JOIN hpcuti b 
									ON b.isuser = a.userid 
									WHERE a.nik = '".$nik."'
									ORDER BY b.audit DESC
									LIMIT 1");
		
        return response()->json($datakaryawan);
	}

	public function lamacuti(Request $request) {
		$cuti_awal = Carbon::parse($request->input('tgl_cuti_awal'))->format('Y-m-d');
		$cuti_akhir = Carbon::parse($request->input('tgl_cuti_akhir'))->format('Y-m-d');
		$tgl_cuti_awal = $cuti_awal.' 00:00:00';
		$tgl_cuti_akhir = $cuti_akhir.' 00:00:00';
		if($tgl_cuti_awal != '' && $tgl_cuti_akhir != ''){
			$endperiod = (new DateTime($tgl_cuti_akhir))->modify('+1 day')->format('Y-m-d');
			$start = new DateTime($tgl_cuti_awal);
			$endperiod = new DateTime($endperiod);
			$interval = DateInterval::createFromDateString('1 days');
			$period   = new DatePeriod($start, $interval, $endperiod);
			$days=[];
			$h=0;
			foreach ($period as $dt) {
				$list = $dt->format("Y m d-D");
				
				$day = substr($list, -3);
				if($day == 'Sun'){
					$days[$h] = $dt->format("Y-m-d");
					$days[$h++];
				}
			}
			
			$getSunDays = count($days);
			$end = new DateTime((new DateTime($tgl_cuti_akhir))->format('Y-m-d'));
			$totalhari = $start->diff($end)->days+1;
			$countTglMerah = TanggalMerah::whereBetween('date',[$tgl_cuti_awal,$tgl_cuti_akhir])->count();
			$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;

			return response()->json($jumlahharikerja);
		}else{
			$jumlahharikerja = '0';
			return response()->json($jumlahharikerja);
		}
	}


	public function cekCutiBesar(Request $request){
		$nik = $request->input('nik');
		$tahun = date('Y');
		$data_cuti_besar = Employee::where('nik', $nik)->get();
		foreach($data_cuti_besar as $datacutibesar){
			$tgl_masuk_karyawan = $datacutibesar->tgl_join;

			$diff = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($tgl_masuk_karyawan.' 00:00:00'));
			
			$years   = floor($diff / (365*60*60*24));
		}
		return response()->json($years);
	}
	
    public function indexCuti(Request $request) {
		$datamngrspv = Employee::orderBy('dept_id','ASC')->get();
		$departements = Departement::orderBy('id', 'ASC')->get();
		$user = Auth::user();
		if($user->hasRole('Super Admin')){
			$getuser = '<div class="form-group input-group" onclick = "filterkaryawan();">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan"  required readonly/>
							<span id="openmodal" class="input-group-addon" data-toggle="modal" data-target="#formModal"><i class="icon-search"></i></span>
						</div>';
			$parameter = array(
				'nama_karyawan' =>'',
				'nik' => '',
				'jabatan' => '',
				'dept_id' => '',
				'level' => '',	
				'tmk' => '',
				'sisa_cuti_tahunan' => '',
				'sisa_cuti_tahunan_diambil' => '',
				'sisa_cuti_khusus' => '',
				'sisa_cuti_khusus_diambil' => ''
			);
			$data_karyawan = Employee::orderBy('dept_id', 'ASC')->get();
		}else{
			
			$nama = $user->name;			
			$datakaryawan = DB::select("SELECT a.*, b.* , 
										(select sum(jumlah) 
											from hpcuti 
											where istype in ('1', '2', '3', '4') 
											and isuser = b.isuser 
										group by isuser) as cutitahunan, 
										(select sum(jumlah) 
											from hpcuti 
											where istype = '5' 
											and isuser = b.isuser 
										group by isuser) as cutikhusus

										FROM employees a 
										LEFT JOIN hpcuti b 
										ON b.isuser = a.userid 
										WHERE a.nama = '".$nama."'
                                        ORDER BY b.audit DESC
										LIMIT 1 ");	
			
			$cuti_tahunan = 12;
			$cuti_khusus = 54;
			foreach($datakaryawan as $datakaryawan_cek){
				$parameter = array(
					'nama_karyawan' => $datakaryawan_cek->nama,
					'nik' => $datakaryawan_cek->nik,
					'jabatan' => $datakaryawan_cek->level,
					'dept_id' => $datakaryawan_cek->dept_id,
					'level' => $datakaryawan_cek->level,	
					'tmk' => $datakaryawan_cek->tgl_join,
					'sisa_cuti_tahunan' => $datakaryawan_cek->sesudah,
					'sisa_cuti_tahunan_diambil' => $datakaryawan_cek->cutitahunan,
					'sisa_cuti_khusus' => $datakaryawan_cek->sesudah,
					'sisa_cuti_khusus_diambil' => $datakaryawan_cek->cutikhusus
				);
			}
			$dep = $parameter['dept_id'];
			$lvl = $parameter['level'];
			$data_karyawan = Employee::where('dept_id', $dep)->where('level', $lvl)->get();
			
			$getuser = '<div class="form-group">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="'.$parameter['nama_karyawan'].'" required readonly/>
						</div>';
		}
        return view('admin.cuti.indexCuti', compact('data_karyawan', 'dep', 'parameter', 'departements', 'getuser', 'datamngrspv'));
    }

    public function storeCuti(Request $request){
        $nama_karyawan = $request->input('nama_karyawan');
        $nik = $request->input('nik');
		$kd_divisi = $request->input('kd_divisi');
		$jabatan = $request->input('jabatan');
        $tanggal_pengajuan = date('Y-m-d H:i:s');
        $tgl_cuti_awal = Carbon::parse($request->input('tgl_cuti_awal'))->format('Y-m-d');
        $tgl_cuti_akhir = Carbon::parse($request->input('tgl_cuti_akhir'))->format('Y-m-d');
        $jumlah_hari = $request->input('jumlah_hari');
		$tmk = $request->input('tmk');
		$alamat = $request->input('alamat');
		$jenis_cuti = $request->input('jenis_cuti');
		$kode_cuti = $request->input('kode_cuti');
		$app1 = '';
		$app2 = '';
		$app3 = '';
		
		if($kode_cuti == 'C1'){
			$jenis_cuti_detail = 'Cuti Tahunan';
			$keterangan_cuti = '';
		}else if($kode_cuti == 'C2'){
			$jenis_cuti_detail = 'Sakit Tanpa Surat Dokter';
			$keterangan_cuti = '';
		}else if($kode_cuti == 'C3'){
			$jenis_cuti_detail = 'Ijin';
			$keterangan_cuti = '';
		}else if($kode_cuti == 'C4'){
			$jenis_cuti_detail = 'Cuti Besar';
			$keterangan_cuti = '';
		}else if($kode_cuti == 'C5'){
			$keterangan_cuti = $request->input('keterangan_cuti');
			if($keterangan_cuti == '5'){
				$jenis_cuti_detail2 = 'Cuti Pernikahan';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '3';
			}else if($keterangan_cuti == '6'){
				$jenis_cuti_detail2 = 'Cuti Pernikahan Anak';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '7'){
				$jenis_cuti_detail2 = 'Istri Melahirkan / Keguguran';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '8'){
				$jenis_cuti_detail2 = 'Kematian Istri / Suami / Anak';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '9'){
				$jenis_cuti_detail2 = 'Kematian Orangtua / Mertua';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '10'){
				$jenis_cuti_detail2 = 'Khitanan / Pembaptisan Anak';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '11'){
				$jenis_cuti_detail2 = 'Keluarga 1 Rumah Meninggal';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '1';
			}else if($keterangan_cuti == '12'){
				$jenis_cuti_detail2 = 'Ibadah Haji';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '40';
			}else if($keterangan_cuti == '13'){
				$jenis_cuti_detail2 = 'Melahirkan';
				$keterangan_cuti_detail = '90';
				$keterangan_cuti_jumlah_hari = '2';
			}else if($keterangan_cuti == '14'){
				$jenis_cuti_detail2 = 'Keguguran';
				$keterangan_cuti_detail = '45';
				$keterangan_cuti_jumlah_hari = '2';
			}else{
				$jenis_cuti_detail2 = '';
				$keterangan_cuti_detail = '';
				$keterangan_cuti_jumlah_hari = '1';
			}
			$jenis_cuti_detail = $jenis_cuti_detail2;
		}else{
			$jenis_cuti_detail = '';
			$keterangan_cuti = '';
		}
        $penjelasan_cuti = $request->input('penjelasan_cuti');
        $petugas_pengganti = $request->input('petugas_pengganti');
		
		$tahun_ini = date('Y');
		
        $cuti = new Cuti;
			$cuti->nama_karyawan = $nama_karyawan;
			$cuti->nik = $nik;
			$cuti->kd_divisi = $kd_divisi;
			$cuti->jabatan = $jabatan;
			$cuti->alamat = $alamat;
			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
			$cuti->tgl_cuti_awal = $tgl_cuti_awal;
			$cuti->tgl_cuti_akhir = $tgl_cuti_akhir;
			$cuti->jumlah_hari = $jumlah_hari;
			$cuti->jenis_cuti = $kode_cuti;
			$cuti->jenis_cuti_detail = $jenis_cuti_detail;
			$cuti->penjelasan_cuti = $penjelasan_cuti;
			$cuti->petugas_pengganti = $petugas_pengganti;
			$cuti->app1 = $app1;
			$cuti->app2 = $app2;
			$cuti->app3 = $app3;

			$cuti->save();
		
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

			$datacutiid = Cuti::where('nik', $nik)
                            ->where('tgl_cuti_awal', $tgl_cuti_awal)
                            ->where('tgl_cuti_akhir', $tgl_cuti_akhir)
                            ->get();
			foreach($datacutiid as $data_cutiid){
				$id = $data_cutiid->id;
			}

		//	$emails_send = [$email_pemohon, $email];
		//	$emails_send = ['wudcrafterz@gmail.com', 'farrosashiddiq@gmail.com'];
			//PEMOHON
			Mail::to($email_pemohon)->send(new CutiVerifikasi($subject = 'Pengajuan Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
																	$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
																	$jumlah_hari, $penjelasan_cuti, $atasan, $id));

			//ATASAN
			Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
																	$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
																	$jumlah_hari, $penjelasan_cuti, $atasan, $id));
			
			

		return redirect()->back();
    }
	
	
	public function getapproveCuti($id){
		$user = Auth::user();
		$data_cuti = Cuti::where('id', $id)->get();
		
		foreach($data_cuti as $datacuti){
			$nama_karyawan = $datacuti->nama_karyawan;
			$nik = $datacuti->nik;
			$jabatan = $datacuti->jabatan;
			$alamat = $datacuti->alamat;
			$kd_divisi = $datacuti->kd_divisi;
			$tgl_cuti_awal = $datacuti->tgl_cuti_awal;
			$tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;
			$tgl_pengajuan_cuti = $datacuti->tgl_pengajuan_cuti;
			$jumlah_hari = $datacuti->jumlah_hari;
			$penjelasan_cuti = $datacuti->penjelasan_cuti;
			$keterangan_cuti = $datacuti->keterangan_cuti;
			$tindak_lanjut = $datacuti->tindak_lanjut;
		//	$jenis_cuti = $datacuti->jenis_cuti;
			if($datacuti->jenis_cuti == 'C1'){
				$jenis_cuti = 'Cuti Tahunan';
			}else if($datacuti->jenis_cuti == 'C2'){
				$jenis_cuti = 'Sakit';
			}else if($datacuti->jenis_cuti == 'C3'){
				$jenis_cuti = 'Ijin';
			}else if($datacuti->jenis_cuti == 'C4'){
				$jenis_cuti = 'Cuti Besar';
			}else{
				$jenis_cuti = 'Cuti Khusus';
			}

			$petugas_pengganti = $datacuti->petugas_pengganti;
			$app1 = $datacuti->app1;
			$app2 = $datacuti->app2;
			$app3 = $datacuti->app3;
			
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
		$datakaryawan = DB::select("SELECT a.*, b.* , 
									(select sum(jumlah) 
										from hpcuti 
										where istype in ('1', '2', '3', '4') 
										and isuser = b.isuser 
									group by isuser) as cutitahunan, 
									(select sum(jumlah) 
										from hpcuti 
										where istype = '5' 
										and isuser = b.isuser 
									group by isuser) as cutikhusus

									FROM employees a 
									LEFT JOIN hpcuti b 
									ON b.isuser = a.userid 
									WHERE a.nik = '".$nik."'
									ORDER BY b.audit DESC
									LIMIT 1 ");
	
		foreach($datakaryawan as $datakaryawan_cek){
			$sisa_cuti_tahunan = $datakaryawan_cek->sesudah;
			$sisa_cuti_tahunan_sudah_diambil = $datakaryawan_cek->cutitahunan;
			$sisa_cuti_tahunan_diambil = $datakaryawan_cek->sesudah;
			$sisa_cuti_khusus = $datakaryawan_cek->sesudah;
			$sisa_cuti_khusus_sudah_diambil = $datakaryawan_cek->cutikhusus;
			$sisa_cuti_khusus_diambil = $datakaryawan_cek->sesudah;
			$tgl_masuk_karyawan = $datakaryawan_cek->tgl_join;
		}
		
		if($user = Auth::user()){
			return view('admin.cuti.approveCuti', compact('id', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_cuti_awal', 
																	'tgl_cuti_akhir', 'penjelasan_cuti', 'jumlah_hari', 'tgl_pengajuan_cuti', 
																	'keterangan_cuti', 'tindak_lanjut', 'jenis_cuti', 'petugas_pengganti', 'tombol',
																	'sisa_cuti_tahunan', 'sisa_cuti_tahunan_sudah_diambil', 'sisa_cuti_tahunan_diambil', 
																	'sisa_cuti_khusus', 'sisa_cuti_khusus_sudah_diambil', 'sisa_cuti_khusus_diambil',
																	'tgl_masuk_karyawan' 
																	));
		}else{
			return redirect('/login');
		}
	}
	
	
	public function approveCuti(Request $request){
		$user = Auth::user();
		$tahun_ini = date('Y');
		$id = $request->input('id');
		$approve = $request->input('action');
		$approve_time = date('Y-m-d H:i:s');
        $sisa_cuti_tahunan = $request->input('sisa_cuti_tahunan');
        $jabatan = $request->input('jabatan');
		$sisa_cuti_khusus = $request->input('sisa_cuti');
		
		$data_cuti = Cuti::where('id', $id)->get();
		foreach($data_cuti as $datacuti){
			$app1 = $datacuti->app1;
			$app2 = $datacuti->app1;
			$app3 = $datacuti->app1;
			$jenis_cuti = $datacuti->jenis_cuti;
			$jumlah_cuti_diambil = $datacuti->jumlah_hari;
			$jumlah_hari = $datacuti->jumlah_hari;
			$nik = $datacuti->nik;
			$nama_karyawan = $datacuti->nama_karyawan;
			$kd_divisi = $datacuti->kd_divisi;
			$jabatan = $datacuti->jabatan;
			$penjelasan_cuti = $datacuti->penjelasan_cuti;
			$tgl_cuti_awal = $datacuti->tgl_cuti_awal;
			$tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;  
			$tanggal_pengajuan = $datacuti->tgl_pengajuan_cuti;

			$departements = Departement::where('id', $kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;


			if($jenis_cuti == 'C1' || $jenis_cuti == 'C2' || $jenis_cuti == 'C3'){
				$pengurangan_cuti = 'sisa_cuti_tahunan = (sisa_cuti_tahunan - "'.$jumlah_cuti_diambil.'")';
			}else if($jenis_cuti == 'C4'){
				$pengurangan_cuti = 'sisa_cuti_besar = (sisa_cuti_besar - "'.$jumlah_cuti_diambil.'")';
			}else{
				$pengurangan_cuti = 'sisa_cuti_khusus = (sisa_cuti_khusus - "'.$jumlah_cuti_diambil.'")';
			}
			
			$karyawan = Employee::where('nik', $nik)->get();
			foreach($karyawan as $datakaryawan){
				$jenis_karyawan = $datakaryawan->level;
				$direct_supervisor = $datakaryawan->direct_supervisor;
				$next_higher_supervisor = $datakaryawan->next_higher_supervisor;
				$userid = $datakaryawan->userid;

				if($direct_supervisor == $next_higher_supervisor){
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff' || $jenis_karyawan == 'Supervisor'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
								$update = DB::select('UPDATE tbl_pengajuan_cuti
												SET app1 = "'.$approve.'",
												app_name1 = "'.$approve_name.'", 
												app_time1 = "'.$approve_time.'",
												app2 = "'.$approve.'",
												app_name2 = "'.$approve_name.'", 
												app_time2 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
																						$jumlah_hari, $penjelasan_cuti, $atasan = 'HRD', $id));

							}
							
						}else{
							$approve_name = 'Super Admin';
								$update = DB::select('UPDATE tbl_pengajuan_cuti
												SET app3 = "'.$approve.'",
												app_name3 = "'.$approve_name.'", 
												app_time3 = "'.$approve_time.'"
												WHERE id = "'.$id.'"');

								if($approve == 'Y'){
									if($jenis_cuti != 'C4'){
										$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
																SET ".$pengurangan_cuti."
																WHERE nik = '".$nik."' 
																AND tahun = '".$tahun_ini."'");
									}else{
										$data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
																			WHERE NIK = '".$nik."' 
																			AND TAHUN = '".$tahun_ini."' ");
										foreach($data_cuti_karyawan as $datacutikaryawan){
											$sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
											$sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
										}
										if($sisa_cuti_tahunan > 0){
											$habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
											$sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
											if($habisin_cuti_tahunan < 0){
												$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET sisa_cuti_tahunan = '0', 
															sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
											}else{
												$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
											}
											
										}
									}
								
									$istype = substr($jenis_cuti, 1, 1);
									$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
									$jumlah = $cek_hpcuti;
									if($istype == '1'){
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
											$inserthpcuti->jumlah = $jumlah_cuti_diambil;
											$inserthpcuti->keterangan = $penjelasan_cuti;
											$inserthpcuti->sebelum = $sesudah;
											if($istype == '1'){
												$inserthpcuti->sesudah = $sesudah - $jumlah_cuti_diambil;
											}else{
												$inserthpcuti->sesudah = $sesudah;
											}
											$inserthpcuti->audit = $audit2;
									
											$inserthpcuti->save();
										}else{
											$inserthpcuti = new HPcuti;
											$inserthpcuti->isuser = $userid;
											$inserthpcuti->mulai = $tgl_cuti_awal;
											$inserthpcuti->akhir = $tgl_cuti_awal;
											$inserthpcuti->istype = $istype;
											$inserthpcuti->jumlah = $jumlah_cuti_diambil;
											$inserthpcuti->keterangan = $penjelasan_cuti;
											$inserthpcuti->sebelum = 0;
											if($istype == '1'){
												$inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
											}else{
												$inserthpcuti->sesudah = 0;
											}
											$inserthpcuti->audit = '1';
									
											$inserthpcuti->save();
										}
									}
								}
							
						}
					}else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$update = DB::select('UPDATE tbl_pengajuan_cuti
											SET app1 = "'.$approve.'",
											app_name1 = "'.$approve_name.'", 
											app_time1 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								$atasan = $next_higher_supervisor;
								$email_to = Employee::where('nama', $atasan)->get();
								foreach($email_to as $emailto){
									$email = $emailto->email;
								}
								Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
												$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
												$jumlah_hari, $penjelasan_cuti, $atasan = 'HRD', $id));

							}
						}else if($user->hasRole('Management')) {
							$approve_name = 'Management';
							$update = DB::select('UPDATE tbl_pengajuan_cuti
											SET app2 = "'.$approve.'",
											app_name2 = "'.$approve_name.'", 
											app_time2 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
												$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
												$jumlah_hari, $penjelasan_cuti, $atasan = 'HRD', $id));

							}
						}else{
							$approve_name = 'Super Admin';
							$update = DB::select('UPDATE tbl_pengajuan_cuti
											SET app3 = "'.$approve.'",
											app_name3 = "'.$approve_name.'", 
											app_time3 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');

							if($approve == 'Y'){
								if($jenis_cuti != 'C4'){
									$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET ".$pengurangan_cuti."
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
								}else{
									$data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
																		WHERE NIK = '".$nik."' 
																		AND TAHUN = '".$tahun_ini."' ");
									foreach($data_cuti_karyawan as $datacutikaryawan){
										$sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
										$sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
									}
									if($sisa_cuti_tahunan > 0){
										$habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
										$sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
										if($habisin_cuti_tahunan < 0){
											$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
														SET sisa_cuti_tahunan = '0', 
														sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
														WHERE nik = '".$nik."' 
														AND tahun = '".$tahun_ini."'");
										}else{
											$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
														SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
														WHERE nik = '".$nik."' 
														AND tahun = '".$tahun_ini."'");
										}
									}
								}
							
								$istype = substr($jenis_cuti, 1, 1);
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
									$inserthpcuti->jumlah = $jumlah_cuti_diambil;
									$inserthpcuti->keterangan = $penjelasan_cuti;
									$inserthpcuti->sebelum = $sesudah;
									if($istype == '1'){
										$inserthpcuti->sesudah = $sesudah - $jumlah_cuti_diambil;
									}else{
										$inserthpcuti->sesudah = $sesudah;
									}
									$inserthpcuti->audit = $audit2;
							
									$inserthpcuti->save();
								}else{
									$inserthpcuti = new HPcuti;
									$inserthpcuti->isuser = $userid;
									$inserthpcuti->mulai = $tgl_cuti_awal;
									$inserthpcuti->akhir = $tgl_cuti_awal;
									$inserthpcuti->istype = $istype;
									$inserthpcuti->jumlah = $jumlah_cuti_diambil;
									$inserthpcuti->keterangan = $penjelasan_cuti;
									$inserthpcuti->sebelum = 0;
									if($istype == '1'){
										$inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
									}else{
										$inserthpcuti->sesudah = 0;
									}
									$inserthpcuti->audit = '1';
							
									$inserthpcuti->save();
								}
							}
						}
					}else{
						if ($user->hasRole('Management')) {
							$approve_name = 'Management';
							$update = DB::select('UPDATE tbl_pengajuan_cuti
											SET app1 = "'.$approve.'",
											app_name1 = "'.$approve_name.'", 
											app_time1 = "'.$approve_time.'",
											app2 = "'.$approve.'",
											app_name2 = "'.$approve_name.'", 
											app_time2 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');
							if($approve == 'Y'){
								Mail::to('abdrozak20@gmail.com')->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
											$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
											$jumlah_hari, $penjelasan_cuti, $atasan = 'HRD', $id));
							}
							
						}else{
							$approve_name = 'Super Admin';
							$update = DB::select('UPDATE tbl_pengajuan_cuti
											SET app3 = "'.$approve.'",
											app_name3 = "'.$approve_name.'", 
											app_time3 = "'.$approve_time.'"
											WHERE id = "'.$id.'"');

							if($approve == 'Y'){
								if($jenis_cuti != 'C4'){
									$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET ".$pengurangan_cuti."
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
								}else{
									$data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
																		WHERE NIK = '".$nik."' 
																		AND TAHUN = '".$tahun_ini."' ");
									foreach($data_cuti_karyawan as $datacutikaryawan){
										$sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
										$sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
									}
									if($sisa_cuti_tahunan > 0){
										$habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
										$sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
										if($habisin_cuti_tahunan < 0){
											$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
														SET sisa_cuti_tahunan = '0', 
														sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
														WHERE nik = '".$nik."' 
														AND tahun = '".$tahun_ini."'");
										}else{
											$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
														SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
														WHERE nik = '".$nik."' 
														AND tahun = '".$tahun_ini."'");
										}
										
									}
								}
							
								$istype = substr($jenis_cuti, 1, 1);
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
									$inserthpcuti->jumlah = $jumlah_cuti_diambil;
									$inserthpcuti->keterangan = $penjelasan_cuti;
									$inserthpcuti->sebelum = $sesudah;
									if($istype == '1'){
										$inserthpcuti->sesudah = $sesudah - $jumlah_cuti_diambil;
									}else{
										$inserthpcuti->sesudah = $sesudah;
									}
									$inserthpcuti->audit = $audit2;
							
									$inserthpcuti->save();
								}else{
									$inserthpcuti = new HPcuti;
									$inserthpcuti->isuser = $userid;
									$inserthpcuti->mulai = $tgl_cuti_awal;
									$inserthpcuti->akhir = $tgl_cuti_awal;
									$inserthpcuti->istype = $istype;
									$inserthpcuti->jumlah = $jumlah_cuti_diambil;
									$inserthpcuti->keterangan = $penjelasan_cuti;
									$inserthpcuti->sebelum = 0;
									$inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
									$inserthpcuti->audit = '1';
							
									$inserthpcuti->save();
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
									Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
																								$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
																								$jumlah_hari, $penjelasan_cuti, $atasan, $id));

							}
						
						}else if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$pos = 2;

							if($approve == 'Y'){
								Mail::to('farrosashiddiq@gmail.com')->send(new CutiVerifikasi($subject = 'Approval Cuti', $nama_karyawan, $nik, $divisi, $jabatan,
																						$tanggal_pengajuan, $tgl_cuti_awal, $tgl_cuti_akhir,
																						$jumlah_hari, $penjelasan_cuti, $atasan = 'HRD', $id));
						
							}
						}else {
							$approve_name = 'Super Admin';
							$pos = 3;

							if($app2 == 'Y'){
								if($approve == 'Y'){
									if($jenis_cuti != 'C4'){
										$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
																SET ".$pengurangan_cuti."
																WHERE nik = '".$nik."' 
																AND tahun = '".$tahun_ini."'");
									}else{
										$data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
																			WHERE NIK = '".$nik."' 
																			AND TAHUN = '".$tahun_ini."' ");
										foreach($data_cuti_karyawan as $datacutikaryawan){
											$sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
											$sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
										}
										if($sisa_cuti_tahunan > 0){
											$habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
											$sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
											if($habisin_cuti_tahunan < 0){
												$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET sisa_cuti_tahunan = '0', 
															sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
											}else{
												$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
															SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
															WHERE nik = '".$nik."' 
															AND tahun = '".$tahun_ini."'");
											}
											
										}
									}
								
									$istype = substr($jenis_cuti, 1, 1);
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
										$inserthpcuti->jumlah = $jumlah_cuti_diambil;
										$inserthpcuti->keterangan = $penjelasan_cuti;
										$inserthpcuti->sebelum = $sesudah;
										if($istype == '1'){
											$inserthpcuti->sesudah = $sebelum - $jumlah_cuti_diambil;
										}else{
											$inserthpcuti->sesudah = $sebelum;
										}
										$inserthpcuti->audit = $audit2;
								
										$inserthpcuti->save();
									}else{
										$inserthpcuti = new HPcuti;
										$inserthpcuti->isuser = $userid;
										$inserthpcuti->mulai = $tgl_cuti_awal;
										$inserthpcuti->akhir = $tgl_cuti_awal;
										$inserthpcuti->istype = $istype;
										$inserthpcuti->jumlah = $jumlah_cuti_diambil;
										$inserthpcuti->keterangan = $penjelasan_cuti;
										$inserthpcuti->sebelum = 0;
										if($istype == '1'){
											$inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
										}else{
											$inserthpcuti->sesudah = 0;
										}
										$inserthpcuti->audit = '1';
								
										$inserthpcuti->save();
									}
									
								}
							}
							
						}

						$update = DB::select('UPDATE tbl_pengajuan_cuti
												SET app'.$pos.' = "'.$approve.'",
												app_name'.$pos.' = "'.$approve_name.'", 
												app_time'.$pos.' = "'.$approve_time.'"
												WHERE id = "'.$id.'"');
					}else{

					}
				}

				//	=====	APPROVAL SUPER ADMIN	=====	//
				if ($user->hasRole('Super Admin') || $user->hasRole('Management') ) {
					if($user->hasRole('Super Admin') ){
						$approve_name = 'Super Admin';
					}else{
						$approve_name = 'Management';
					}
					if($app3 == ''){
						if($app2 == ''){
							if($app1 == ''){
								$update = DB::select('UPDATE tbl_pengajuan_cuti
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
									$update = DB::select('UPDATE tbl_pengajuan_cuti
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
								$update = DB::select('UPDATE tbl_pengajuan_cuti
									SET app3 = "'.$approve.'",
									app_name3 = "'.$approve_name.'", 
									app_time3 = "'.$approve_time.'"
									WHERE id = "'.$id.'"');
							}else{
								
							}
						}
					}

					if($approve == 'Y'){
						if($jenis_cuti != 'C4'){
							$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
													SET ".$pengurangan_cuti."
													WHERE nik = '".$nik."' 
													AND tahun = '".$tahun_ini."'");
						}else{
							$data_cuti_karyawan = DB::select("SELECT * FROM DATA_HAK_CUTI 
																WHERE NIK = '".$nik."' 
																AND TAHUN = '".$tahun_ini."' ");
							foreach($data_cuti_karyawan as $datacutikaryawan){
								$sisa_cuti_tahunan = $datacutikaryawan->sisa_cuti_tahunan;
								$sisa_cuti_besar = $datacutikaryawan->sisa_cuti_besar;
							}
							if($sisa_cuti_tahunan > 0){
								$habisin_cuti_tahunan = $sisa_cuti_tahunan - $jumlah_cuti_diambil;
								$sisa_cuti_besar_setelah_pengurangan = $sisa_cuti_besar - abs($habisin_cuti_tahunan);
								if($habisin_cuti_tahunan < 0){
									$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
												SET sisa_cuti_tahunan = '0', 
												sisa_cuti_besar = '".$sisa_cuti_besar_setelah_pengurangan."'
												WHERE nik = '".$nik."' 
												AND tahun = '".$tahun_ini."'");
								}else{
									$update_hak_cuti = DB::select("UPDATE data_hak_cuti 
												SET sisa_cuti_tahunan = '".$habisin_cuti_tahunan."'
												WHERE nik = '".$nik."' 
												AND tahun = '".$tahun_ini."'");
								}
								
							}
						}
					
						$istype = substr($jenis_cuti, 1, 1);
						$cek_hpcuti = HPcuti::where('istype', $istype)->where('isuser', $userid)->count();
						$jumlah = $cek_hpcuti;
						if($istype == '1'){
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
								$inserthpcuti->jumlah = $jumlah_cuti_diambil;
								$inserthpcuti->keterangan = $penjelasan_cuti;
								$inserthpcuti->sebelum = $sesudah;
								if($istype == '1'){
									$inserthpcuti->sesudah = $sesudah - $jumlah_cuti_diambil;
								}else{
									$inserthpcuti->sesudah = $sesudah;
								}
								$inserthpcuti->audit = $audit2;
						
								$inserthpcuti->save();
							}else{
								$inserthpcuti = new HPcuti;
								$inserthpcuti->isuser = $userid;
								$inserthpcuti->mulai = $tgl_cuti_awal;
								$inserthpcuti->akhir = $tgl_cuti_awal;
								$inserthpcuti->istype = $istype;
								$inserthpcuti->jumlah = $jumlah_cuti_diambil;
								$inserthpcuti->keterangan = $penjelasan_cuti;
								$inserthpcuti->sebelum = 0;
								if($istype == '1'){
									$inserthpcuti->sesudah = 0 - $jumlah_cuti_diambil;
								}else{
									$inserthpcuti->sesudah = 0;
								}
								$inserthpcuti->audit = '1';
						
								$inserthpcuti->save();
							}
						}
					}
				}
				
							
			}						
		}
		return redirect('');
	}

}
