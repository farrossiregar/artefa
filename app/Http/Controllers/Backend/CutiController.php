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
use App\Models\Datahakcuti;
use App\Models\NonshiftSchedule;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanggalMerah;
use DB;
use Auth;
use App\Mail\CutiVerifikasi;
use App\Mail\CutiVerifikasiPemohon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\helpers;

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
		$tahun_ini = date('Y');
		$nik = $request->input('nik');
		$datakaryawan = cutiexisting($nik);
        return response()->json($datakaryawan);
	}

	public function lamacuti(Request $request) {
		$cuti_awal = Carbon::parse($request->input('tgl_cuti_awal'))->format('Y-m-d');
		$cuti_akhir = Carbon::parse($request->input('tgl_cuti_akhir'))->format('Y-m-d');
		$tgl_cuti_awal = $cuti_awal.' 00:00:00';
		$tgl_cuti_akhir = $cuti_akhir.' 00:00:00';
		$nik = $request->input('nik');
		$karyawan = Employee::where('nik', $nik)->get();
		foreach($karyawan as $kry){
			$level = $kry->level;
			$shifting = $kry->shifting;
		}
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

				if($day == 'Sat'){
					$daysat[$h] = $dt->format("Y-m-d");
					$daysat[$h++];
				}else{
					$daysat[$h] = '';
				}
			}
			$getSunDays = count($days);
			$getSat = count($daysat);
			$getSatDays = ($getSat - 1) / 2;
			$end = new DateTime((new DateTime($tgl_cuti_akhir))->format('Y-m-d'));
			$totalhari = $start->diff($end)->days+1;
			$countTglMerah = TanggalMerah::whereBetween('date',[$tgl_cuti_awal,$tgl_cuti_akhir])->count();
		
			if($shifting == 'Y'){
				$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
			}else{
				$jadwalnonshift = NonshiftSchedule::where('nik', $nik)->whereIn('date', $daysat)->get();
				if(count($jadwalnonshift) > 0){
					$co = count($jadwalnonshift)/2;
					// return $totalhari-$getSunDays-$countTglMerah;
					$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah-$co;
					// $jumlahharikerja = $totalhari-$getSunDays-$getSatDays-$countTglMerah;
				}else{
					$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
				}
			}
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
			$userid = $datacutibesar->userid;
			$diff = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($tgl_masuk_karyawan.' 00:00:00'));
			$years   = floor($diff / (365*60*60*24));
			if($years > 6){
				$ceksisacutitahunan = DB::table('hpcuti')
										->select(\DB::raw('sum(Jumlah) as Jumlah'))
										->where('isUser', $userid)
										->where(\DB::raw('substr(mulai, 1, 4)'), '=' , $tahun)->get();
				foreach($ceksisacutitahunan as $ceksisacutitahun){
					$cuti_tahunan = $ceksisacutitahun->Jumlah;
					if($cuti_tahunan >= 12){
						$ceksisacutibesar = DB::table('hpcutibesar')
										->select(\DB::raw('sum(JumlahB) as JumlahB'))
										->where('isUserB', $userid)
										->where(\DB::raw('substr(mulaiB, 1, 4)'), '=' , $tahun)->get();
						foreach($ceksisacutibesar as $data){
							$cuti_besar = $data->JumlahB;
							if($cuti_besar < 12){
								$hasil = 1;
							}else{
								$hasil = 0;
							}
						}
					}else{
						$hasil = 0;
					}
				}
			}else{
				$hasil = 1;
			}
		}
		return response()->json($hasil);
	}
	
    public function indexCuti(Request $request) {
		$tahun_ini = date('Y');
		$datamngrspv = Employee::orderBy('dept_id','ASC')->get();
		$departements = Departement::orderBy('id', 'ASC')->get();
		$user = Auth::user();
		
		if($user->hasRole('Super Admin')){
			$getuser = '<div class="form-group input-group" onclick = "filterkaryawan();">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan"  required readonly/>
							<span id="openmodal" class="input-group-addon" data-toggle="modal" data-target="#formModal"><i class="icon-search"></i></span>
						</div>';
			$getdiv = '1';
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
				'sisa_cuti_khusus_diambil' => '',
				'sisa_cuti_besar' => '',
				'sisa_cuti_besar_diambil' => ''
			);
			$data_karyawan = Employee::orderBy('dept_id', 'ASC')->get();
		}else{
			$namakaryawan = Employee::where('nama', $user->name)->get();
			foreach($namakaryawan as $nam){
				$nik = $nam->nik;
			}
		
			$datakaryawan = cutiexisting($nik);
			
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
					'sisa_cuti_khusus_diambil' => $datakaryawan_cek->cutikhusus,
					'sisa_cuti_besar' => $datakaryawan_cek->sesudahB,
					'sisa_cuti_besar_diambil' => $datakaryawan_cek->cutibesar
				);
			}
			$dep = $parameter['dept_id'];
			$lvl = $parameter['level'];
			$data_karyawan = Employee::where('dept_id', $dep)->where('level', $lvl)->get();
			
			$getuser = '<div class="form-group">
							<input class="form-control" name="nama_karyawan" id="nama_karyawan" value="'.$parameter['nama_karyawan'].'" required readonly/>
						</div>';
			

			$getdiv = '2';
		}
        return view('admin.cuti.indexCuti', compact('data_karyawan', 'dep', 'parameter', 'departements', 'getuser', 'getdiv', 'datamngrspv'));
    }

    public function storeCuti(Request $request){
		$user = Auth::user();
		$id_cuti = Cuti::latest('id')->first();
		if(!empty($id_cuti)){
			$ids = $id_cuti->id+1;
		}else{
			$ids = 1;
		}

    	$nama_karyawan = $request->input('nama_karyawan');
        $nik = $request->input('nik');
		$kd_divisi = $request->input('kd_divisi');
		$jabatan = $request->input('jabatan');
        $tanggal_pengajuan = date('Y-m-d H:i:s');
		$tmk = $request->input('tmk');
		$alamat = $request->input('alamat');
		$tanpa_approve = $request->input('action');
		$penjelasan_cuti = $request->input('penjelasan_cuti');
		$sisa_cuti_tahunan = $request->input('cuti_tahunan_sudah_diambil');
		$sisa_cuti_besar = $request->input('cuti_besar_sudah_diambil');
        $petugas_pengganti = $request->input('petugas_pengganti');
		$tahun_ini = date('Y');

		$iduser = Employee::where('nik', $nik)->get();
		foreach($iduser as $data){
			$userid = $data->userid;
		}

		/*CUTI C1*/
		$tgl_cuti_awal_c1s = $request->input('tgl_cuti_awal_C1');
		$tgl_cuti_akhir_c1 = $request->input('tgl_cuti_akhir_C1');
		$jumlah_hari_c1 = $request->input('jumlah_hari_C1');
		if(!empty($tgl_cuti_awal_c1s)){
			foreach ($tgl_cuti_awal_c1s as $key => $tgl_cuti_awal) {
				if($user->hasRole('Super Admin')){
					if($tanpa_approve == 'Y'){
					//	if($jabatan == 'Manager' || $jabatan == 'Management'){
							$app1 = 'Y';
							$app2 = 'Y';
							$app3 = 'Y';

					/*	 }else{
						 	$app1 = '';
						 	$app2 = '';
						 	$app3 = '';
						 }	*/
					}else{
						$app1 = '';
						$app2 = '';
						$app3 = '';
					}	
				}else{
					$app1 = '';
					$app2 = '';
					$app3 = '';
				}
				
				$cuti = new Cuti;
				$cuti->nama_karyawan = $nama_karyawan;
				$cuti->id = $ids;
				$cuti->nik = $nik;
				$cuti->kd_divisi = $kd_divisi;
				$cuti->jabatan = $jabatan;
				$cuti->alamat = $alamat;
				$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
				$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
				$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c1[$key])->format('Y-m-d');
				$cuti->jumlah_hari = $jumlah_hari_c1[$key];
				$cuti->jenis_cuti = 'C1';
				$cuti->jenis_cuti_detail = 'Cuti Tahunan';
				$cuti->penjelasan_cuti = $penjelasan_cuti;
				$cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
				$cuti->sisa_cuti_besar = $sisa_cuti_besar;
				$cuti->petugas_pengganti = $petugas_pengganti;
				$cuti->app1 = $app1;
				$cuti->app2 = $app2;
				$cuti->app3 = $app3;

				$cuti->save();

				if($tanpa_approve == 'Y'){
					$istype = '1';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c1[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c1[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				}
			}
		}
	 	/*END CUTI C1*/
		 /*CUTI C2*/
		$tgl_cuti_awal_c2s = $request->input('tgl_cuti_awal_C2');
 		$tgl_cuti_akhir_c2 = $request->input('tgl_cuti_akhir_C2');
		 
 		$jumlah_hari_c2 = $request->input('jumlah_hari_C2');
 		if(!empty($tgl_cuti_awal_c2s)){
 			foreach ($tgl_cuti_awal_c2s as $key => $tgl_cuti_awal) {
	 			if($user->hasRole('Super Admin')){
	 				if($tanpa_approve == 'Y'){
	 					// if($jabatan == 'Manager' || $jabatan == 'Management'){
	 						$app1 = 'Y';
	 						$app2 = 'Y';
	 						$app3 = 'Y';
	 					// }else{
	 					// 	$app1 = '';
	 					// 	$app2 = '';
	 					// 	$app3 = '';
	 					// }
	 				}else{
	 					$app1 = '';
	 					$app2 = '';
	 					$app3 = '';
	 				}	
	 			}else{
	 				$app1 = '';
	 				$app2 = '';
	 				$app3 = '';
	 			}
				 $cuti = new Cuti;
				 $cuti->nama_karyawan = $nama_karyawan;
				 $cuti->id = $ids;
	 			$cuti->nik = $nik;
	 			$cuti->kd_divisi = $kd_divisi;
	 			$cuti->jabatan = $jabatan;
	 			$cuti->alamat = $alamat;
	 			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
	 			$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
	 			$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c2[$key])->format('Y-m-d');
	 			$cuti->jumlah_hari = $jumlah_hari_c2[$key];
	 			$cuti->jenis_cuti = 'C2';
	 			$cuti->jenis_cuti_detail = 'Sakit Tanpa Surat Dokter';
	 			$cuti->penjelasan_cuti = $penjelasan_cuti;
				$cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
				$cuti->sisa_cuti_besar = $sisa_cuti_besar;
	 			$cuti->petugas_pengganti = $petugas_pengganti;
	 			$cuti->app1 = $app1;
	 			$cuti->app2 = $app2;
	 			$cuti->app3 = $app3;

				 $cuti->save();

				if($tanpa_approve == 'Y'){
					$istype = '2';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c2[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c2[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				}
				
			}
 		}
 	 	/*END CUTI C2*/
		  /*CUTI C3*/
		$tgl_cuti_awal_c3s = $request->input('tgl_cuti_awal_C3');
		$tgl_cuti_akhir_c3 = $request->input('tgl_cuti_akhir_C3');
 		$jumlah_hari_c3 = $request->input('jumlah_hari_C3');
 		if(!empty($tgl_cuti_awal_c3s)){
 			foreach ($tgl_cuti_awal_c3s as $key => $tgl_cuti_awal) {
	 			if($user->hasRole('Super Admin')){
	 				if($tanpa_approve == 'Y'){
	 					// if($jabatan == 'Manager' || $jabatan == 'Management'){
	 						$app1 = 'Y';
	 						$app2 = 'Y';
	 						$app3 = 'Y';
	 					// }else{
	 					// 	$app1 = '';
	 					// 	$app2 = '';
	 					// 	$app3 = '';
	 					// }
	 				}else{
	 					$app1 = '';
	 					$app2 = '';
	 					$app3 = '';
	 				}	
	 			}else{
	 				$app1 = '';
	 				$app2 = '';
	 				$app3 = '';
	 			}
				 $cuti = new Cuti;
				 $cuti->nama_karyawan = $nama_karyawan;
				 $cuti->id = $ids;
	 			$cuti->nik = $nik;
	 			$cuti->kd_divisi = $kd_divisi;
	 			$cuti->jabatan = $jabatan;
	 			$cuti->alamat = $alamat;
	 			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
	 			$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
	 			$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c3[$key])->format('Y-m-d');
	 			$cuti->jumlah_hari = $jumlah_hari_c3[$key];
	 			$cuti->jenis_cuti = 'C3';
	 			$cuti->jenis_cuti_detail = 'Ijin';
				$cuti->penjelasan_cuti = $penjelasan_cuti;
				$cuti->sisa_cuti_tahunan = '1';
				$cuti->sisa_cuti_besar = '';
	 			$cuti->petugas_pengganti = $petugas_pengganti;
	 			$cuti->app1 = $app1;
	 			$cuti->app2 = $app2;
	 			$cuti->app3 = $app3;

				 $cuti->save();

				 if($tanpa_approve == 'Y'){
					$istype = '3';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c3[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c3[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				 }
	 		}
 		}
 	 	/*END CUTI C3*/
 	 	/*CUTI C4*/
		$tgl_cuti_awal_c4s = $request->input('tgl_cuti_awal_C4');
 		$tgl_cuti_akhir_c4 = $request->input('tgl_cuti_akhir_C4');
 		$jumlah_hari_c4 = $request->input('jumlah_hari_C4');
 		if(!empty($tgl_cuti_awal_c4s)){
 			foreach ($tgl_cuti_awal_c4s as $key => $tgl_cuti_awal) {
	 			if($user->hasRole('Super Admin')){
	 				if($tanpa_approve == 'Y'){
	 					// if($jabatan == 'Manager' || $jabatan == 'Management'){
	 						$app1 = 'Y';
	 						$app2 = 'Y';
	 						$app3 = 'Y';
	 					// }else{
	 					// 	$app1 = '';
	 					// 	$app2 = '';
	 					// 	$app3 = '';
	 					// }
	 				}else{
	 					$app1 = '';
	 					$app2 = '';
	 					$app3 = '';
	 				}	
	 			}else{
	 				$app1 = '';
	 				$app2 = '';
	 				$app3 = '';
	 			}
				$cuti = new Cuti;
				 $cuti->nama_karyawan = $nama_karyawan;
				 $cuti->id = $ids;
	 			$cuti->nik = $nik;
	 			$cuti->kd_divisi = $kd_divisi;
	 			$cuti->jabatan = $jabatan;
	 			$cuti->alamat = $alamat;
	 			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
	 			$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
	 			$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c4[$key])->format('Y-m-d');
	 			$cuti->jumlah_hari = $jumlah_hari_c4[$key];
	 			$cuti->jenis_cuti = 'C4';
	 			$cuti->jenis_cuti_detail = 'Cuti Besar';
	 			$cuti->penjelasan_cuti = $penjelasan_cuti;
				$cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
				$cuti->sisa_cuti_besar = $sisa_cuti_besar;
	 			$cuti->petugas_pengganti = $petugas_pengganti;
	 			$cuti->app1 = $app1;
	 			$cuti->app2 = $app2;
	 			$cuti->app3 = $app3;

				 $cuti->save();
				 
				 if($tanpa_approve == 'Y'){
					$istype = '4';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c4[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c4[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				 }
				
			
	 		}
 		}
 	 	/*END CUTI C4*/
 	 	/*CUTI C4*/
		$tgl_cuti_awal_c5s = $request->input('tgl_cuti_awal_C5');
 		$tgl_cuti_akhir_c5 = $request->input('tgl_cuti_akhir_C5');
 		$jumlah_hari_c5 = $request->input('jumlah_hari_C5');
 		if(!empty($tgl_cuti_awal_c5s)){
 			foreach ($tgl_cuti_awal_c5s as $key => $tgl_cuti_awal) {
	 			if($user->hasRole('Super Admin')){
	 				if($tanpa_approve == 'Y'){
	 					// if($jabatan == 'Manager' || $jabatan == 'Management'){
	 						$app1 = 'Y';
	 						$app2 = 'Y';
	 						$app3 = 'Y';
	 					// }else{
	 					// 	$app1 = '';
	 					// 	$app2 = '';
	 					// 	$app3 = '';
	 					// }
	 				}else{
	 					$app1 = '';
	 					$app2 = '';
	 					$app3 = '';
	 				}	
	 			}else{
	 				$app1 = '';
	 				$app2 = '';
	 				$app3 = '';
	 			}
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

				 $cuti = new Cuti;
				 $cuti->nama_karyawan = $nama_karyawan;
				 $cuti->id = $ids;
	 			$cuti->nik = $nik;
	 			$cuti->kd_divisi = $kd_divisi;
	 			$cuti->jabatan = $jabatan;
	 			$cuti->alamat = $alamat;
	 			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
	 			$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
	 			$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c5[$key])->format('Y-m-d');
	 			$cuti->jumlah_hari = $jumlah_hari_c5[$key];
	 			$cuti->jenis_cuti = 'C5';
	 			$cuti->jenis_cuti_detail = $jenis_cuti_detail;
	 			$cuti->penjelasan_cuti = $penjelasan_cuti;
				 $cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
				 $cuti->sisa_cuti_besar = $sisa_cuti_besar;
	 			$cuti->petugas_pengganti = $petugas_pengganti;
	 			$cuti->app1 = $app1;
	 			$cuti->app2 = $app2;
	 			$cuti->app3 = $app3;

				 $cuti->save();
				 
				 if($tanpa_approve == 'Y'){
					$istype = '5';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c5[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c5[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				 }
				 
	 		}
 		}
 	 	/*END CUTI C5*/
		  /*CUTI C17*/
		
		$tgl_cuti_awal_c17s = $request->input('tgl_cuti_awal_C17');
 		$tgl_cuti_akhir_c17 = $request->input('tgl_cuti_akhir_C17');
 		$jumlah_hari_c17 = $request->input('jumlah_hari_C17');
 		// dd($jumlah_hari_c17);
 		if(!empty($tgl_cuti_awal_c17s)){
 			foreach ($tgl_cuti_awal_c17s as $key => $tgl_cuti_awal) {
				$app1 = 'Y';
				$app2 = 'Y';
				$app3 = 'Y';

				$cuti = new Cuti;
				 $cuti->nama_karyawan = $nama_karyawan;
				 $cuti->id = $ids;
	 			$cuti->nik = $nik;
	 			$cuti->kd_divisi = $kd_divisi;
	 			$cuti->jabatan = $jabatan;
	 			$cuti->alamat = $alamat;
	 			$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
	 			$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
	 			$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c17[$key])->format('Y-m-d');
	 			$cuti->jumlah_hari = $jumlah_hari_c17[$key];
	 			$cuti->jenis_cuti = 'C17';
	 			$cuti->jenis_cuti_detail = 'Cuti Sakit dengan Surat Dokter';
	 			$cuti->penjelasan_cuti = $penjelasan_cuti;
				$cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
				$cuti->sisa_cuti_besar = $sisa_cuti_besar;
	 			$cuti->petugas_pengganti = $petugas_pengganti;
	 			$cuti->app1 = $app1;
	 			$cuti->app2 = $app2;
	 			$cuti->app3 = $app3;

				$cuti->save();
				
	 		}
		 }
		 
		 

		  /*END CUTI C17*/
		
		  /*CUTI C18*/
		
		$tgl_cuti_awal_c18s = $request->input('tgl_cuti_awal_C18');
		$tgl_cuti_akhir_c18 = $request->input('tgl_cuti_akhir_C18');
		$jumlah_hari_c18 = $request->input('jumlah_hari_C18');
		// dd($jumlah_hari_c18);
		if(!empty($tgl_cuti_awal_c18s)){
			foreach ($tgl_cuti_awal_c18s as $key => $tgl_cuti_awal) {
			   $app1 = 'Y';
			   $app2 = 'Y';
			   $app3 = 'Y';

			   $cuti = new Cuti;
				$cuti->nama_karyawan = $nama_karyawan;
				$cuti->id = $ids;
				$cuti->nik = $nik;
				$cuti->kd_divisi = $kd_divisi;
				$cuti->jabatan = $jabatan;
				$cuti->alamat = $alamat;
				$cuti->tgl_pengajuan_cuti = $tanggal_pengajuan;
				$cuti->tgl_cuti_awal = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
				$cuti->tgl_cuti_akhir = Carbon::parse($tgl_cuti_akhir_c18[$key])->format('Y-m-d');
				$cuti->jumlah_hari = $jumlah_hari_c18[$key];
				$cuti->jenis_cuti = 'C18';
				$cuti->jenis_cuti_detail = 'Cuti Setengah';
				$cuti->penjelasan_cuti = $penjelasan_cuti;
			   $cuti->sisa_cuti_tahunan = $sisa_cuti_tahunan;
			   $cuti->sisa_cuti_besar = $sisa_cuti_besar;
				$cuti->petugas_pengganti = $petugas_pengganti;
				$cuti->app1 = $app1;
				$cuti->app2 = $app2;
				$cuti->app3 = $app3;

			   $cuti->save();

				if($tanpa_approve == 'Y'){
					$istype = '1';
					$keterangan = $penjelasan_cuti; 
					$mulai = Carbon::parse($tgl_cuti_awal)->format('Y-m-d');
					$akhir = Carbon::parse($tgl_cuti_akhir_c18[$key])->format('Y-m-d');
					$jumlah_diambil = $jumlah_hari_c18[$key];
					updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
				}
			}
		}
		
		 /*END CUTI C18*/
	 
		  	
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

		  	$cuti_data = Cuti::where('penjelasan_cuti', $penjelasan_cuti)
							  ->where('nik', $nik)
							  ->where('petugas_pengganti', $petugas_pengganti)->get();
		  	if($tanpa_approve == 'Y'){

			}else{
				if($email_pemohon != ''){
					if($email_pemohon != ''){
						Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Pengajuan Cuti', $atasan, $ids, $cuti_data));
					}
				}

				if($jabatan != "Manager"){
					if($email != ''){
						Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $atasan, $ids, $cuti_data));
					}
				}else{
				
				}
			}
		  return redirect()->back()->with('success', 'Berhasil Menambah Data!!! Refresh Halaman Untuk Membuat Pengajuan Baru...'); 
	
    }

	
	
	public function datacuti(){
		$departements = Departement::orderBy('id', 'ASC')->get();
		return view('admin.cuti.TableApproveCuti', compact('departements'));
	}

	public function geteditCuti($id){
		$user = Auth::user();
		$data_cuti = Cuti::where('id', $id)->get();
		$data_karyawan = Employee::orderBy('dept_id', 'ASC')->get();
		
		foreach($data_cuti as $datacuti){
			$nama_karyawan = $datacuti->nama_karyawan;
			$nik = $datacuti->nik;
			$jabatan = $datacuti->jabatan;
			$alamat = $datacuti->alamat;
			$departements = Departement::where('id', $datacuti->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_cuti_awal = $datacuti->tgl_cuti_awal;
			$tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;
			$tgl_pengajuan_cuti = $datacuti->tgl_pengajuan_cuti;
			$jumlah_hari = $datacuti->jumlah_hari;
			$penjelasan_cuti = $datacuti->penjelasan_cuti;
			$alamat = $datacuti->alamat;
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
		}

		if($datacuti->jenis_cuti == 'C1' || $datacuti->jenis_cuti == 'C2' || $datacuti->jenis_cuti == 'C3' || $datacuti->jenis_cuti == 'C5'){
			$totalhari = DB::table('tbl_pengajuan_cuti')->select(DB::raw("sum(jumlah_hari) as jumlah"))->where('id', $id)->get();
			foreach($totalhari as $total){
				$totaljumlahhari = $total->jumlah;
			}
		}else{
			$totaljumlahhari = '';
		}

		if($datacuti->jenis_cuti == 'C4'){
			$totalhari = DB::table('tbl_pengajuan_cuti')->select(DB::raw("sum(jumlah_hari) as jumlah"))->where('id', $id)->get();
			foreach($totalhari as $total){
				$totaljumlahharibesar = $total->jumlah;
			}
		}else{
			$totaljumlahharibesar = '';
		}

		$datakaryawan = cutiexisting($nik);
	
		foreach($datakaryawan as $datakaryawan_cek){
			$sisa_cuti_tahunan = $datakaryawan_cek->sesudah;
			$sisa_cuti_tahunan_sudah_diambil = $datakaryawan_cek->cutitahunan;
			$sisa_cuti_tahunan_diambil = $datakaryawan_cek->sesudah;
			$sisa_cuti_besar = $datakaryawan_cek->sesudahB;
			$sisa_cuti_besar_sudah_diambil = $datakaryawan_cek->cutibesar;
			$sisa_cuti_besar_diambil = $datakaryawan_cek->sesudahB;
			$tgl_masuk_karyawan = $datakaryawan_cek->tgl_join;
		}
		
		if($user = Auth::user()){
			return view('admin.cuti.editCuti', compact('id', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_cuti_awal', 
																	'tgl_cuti_akhir', 'penjelasan_cuti', 'alamat', 'jumlah_hari', 'tgl_pengajuan_cuti', 
																	'keterangan_cuti', 'tindak_lanjut', 'jenis_cuti', 'petugas_pengganti', 'tombol',
																	'sisa_cuti_tahunan', 'sisa_cuti_tahunan_sudah_diambil', 'sisa_cuti_tahunan_diambil', 
																	'sisa_cuti_besar', 'sisa_cuti_besar_sudah_diambil', 'sisa_cuti_besar_diambil',
																	'tgl_masuk_karyawan', 'totaljumlahhari', 'totaljumlahharibesar', 'data_cuti', 'data_karyawan'
																	));
		}else{
			return redirect('/login');
		}
	}

	public function editcuti(Request $request){
		$id = $request->input('id');
		$jenis_cuti = $request->input('jenis_cuti');
		$tglcutiawal2 = Carbon::parse($request->input('tgl_cuti_awal'))->format('Y-m-d');
		$tglcutiakhir2 = Carbon::parse($request->input('tgl_cuti_akhir'))->format('Y-m-d');
		$jumlah2 = $request->input('jumlah_hari');

		$getdatakaryawan = Cuti::where('kd', $id)->get();
		foreach($getdatakaryawan as $datakaryawan){
			$nik = $datakaryawan->nik;
			$istype = substr($datakaryawan->jenis_cuti, 1, 2);
			$tglcutiawal1 = $datakaryawan->tgl_cuti_awal;
			$tglcutiakhir1 = $datakaryawan->tgl_cuti_akhir;
			$jumlah1 = $datakaryawan->jumlah_hari;

			$getuserid = Employee::where('nik', $nik)->get();
			foreach($getuserid as $getuser){
				$userid = $getuser->userid;
				editjumlahcuti($userid, $istype, $tglcutiawal1, $tglcutiakhir1, $jumlah1, $tglcutiawal2, $tglcutiakhir2, $jumlah2);
			}
		}

		if($jenis_cuti == ''){
			$update = DB::select("update tbl_pengajuan_cuti set
							tgl_cuti_awal = '".$tglcutiawal2."', 
							tgl_cuti_akhir = '".$tglcutiakhir2."',
							jumlah_hari = '".$jumlah2."'
							where kd = '".$id."'  ");
		}else{
			$update = DB::select("update tbl_pengajuan_cuti set
							jenis_cuti = '".$jenis_cuti."', 
							tgl_cuti_awal = '".$tgl_cuti_awal."', 
							tgl_cuti_akhir = '".$tgl_cuti_akhir."',
							jumlah_hari = '".$jumlah_hari."'
							where kd = '".$id."'  ");
		}
		
	}

	public function editcuti2(Request $request){
		$id = $request->input('id');
		$alamat = $request->input('alamat');
		$penjelasan_cuti2 = $request->input('penjelasan_cuti');
		$petugas_pengganti = $request->input('petugas_pengganti');

		$getdatakaryawan = DB::select('select * from tbl_pengajuan_cuti where id = "'.$id.'" limit 1');
		foreach($getdatakaryawan as $datakaryawan){
			$nik = $datakaryawan->nik;
			$istype = substr($datakaryawan->jenis_cuti, 1, 2);
			$penjelasancuti1 = $datakaryawan->penjelasan_cuti;
		}

		$getuserid = Employee::where('nik', $nik)->get();
		foreach($getuserid as $getuser){
			$userid = $getuser->userid;
			editcutilain($userid, $istype, $penjelasancuti1, $penjelasan_cuti2);
		}

		$update = Cuti::where('id', $id)->first();
		$update->alamat = $alamat;
		$update->penjelasan_cuti = $penjelasan_cuti2;
		$update->petugas_pengganti = $petugas_pengganti;
		$update->update();
	}

	public function getdatacuti(Request $request){
		$nama_karyawan = $request->input('nama_karyawan');
		$dept_id = $request->input('dept_id');
		$start_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
		$end_date =  Carbon::parse($request->input('end_date'))->format('Y-m-d');

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
			$filterdate = 'and tgl_cuti_awal >= "'.$start_date.'" and tgl_cuti_akhir <= "'.$end_date.'" ';
		}else{
			if($start_date == '' or $end_date == ''){
				if($start_date == ''){
					$filterdate = 'and tgl_cuti_awal >= "'.date('Y-m-d').'" and tgl_cuti_akhir <= "'.$end_date.'" ';
				}else{
					$filterdate = 'and tgl_cuti_awal >= "'.$start_date.'" and tgl_cuti_akhir <= "'.date('Y-m-d').'"';
				}
			}else{
				$filterdate = '';
			}
		}
		
		

		$datacuti = DB::select('select id, nik, nama_karyawan, kd_divisi, 
										penjelasan_cuti, app1, app2, app3,
										GROUP_CONCAT(jumlah_hari SEPARATOR "<br>") AS jumlah_hari,
										GROUP_CONCAT(tgl_cuti_awal SEPARATOR "<br>") AS tgl_cuti_awal, 
										GROUP_CONCAT(tgl_cuti_akhir SEPARATOR "<br>") AS tgl_cuti_akhir 
										from tbl_pengajuan_cuti 
										where '.$filter.' '.$filterdate.'
										group by id, nik, nama_karyawan, kd_divisi, 
										penjelasan_cuti, app1, app2, app3  
										order by tgl_pengajuan_cuti desc');

		$no = 0;
		foreach($datacuti as $data){
			$departements = Departement::where('id', $data->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;
		
			$status = statusapprove($app1 = $data->app1, $app2 = $data->app2, $app3 = $data->app3);
			
			$no  = $no+1;
			for($i = 0; $i < count($datacuti); $i++){
				if($data->app2 == ''){
					$btnapp = "<span class='btn btn-success' onclick='approve(1, ".$data->id.")'><i class='icon-ok'></i></span>";
				}else{
					$btnapp = "";
				}
				$hasil = "	<tr>
								<td>".$no."</td>
								<td width='12%'>
									".$btnapp."	
									<span class='btn btn-danger' onclick='edit(1, ".$data->id.")'><i class='icon-eye-open'></i></span>
								</td>
								<td>".$status."</td>
								<td>".$data->nik."</td>
								<td>".$data->nama_karyawan."</td>
								<td>".$divisi."</td>
								<td width='10%'>".$data->tgl_cuti_awal."</td>
								<td width='10%'>".$data->tgl_cuti_akhir."</td>
								<td>".$data->jumlah_hari."</td>
								<td>".$data->penjelasan_cuti."</td>
							</tr>";
			}
			echo $hasil;
		}
	}


	public function getapproveCuti($id){
		$user = Auth::user();
		$data_cuti = Cuti::where('id', $id)->where('jenis_cuti', '!=', 'C17')->get();
		
		foreach($data_cuti as $datacuti){
			$nama_karyawan = $datacuti->nama_karyawan;
			$nik = $datacuti->nik;
			$jabatan = $datacuti->jabatan;
			$alamat = $datacuti->alamat;
			$departements = Departement::where('id', $datacuti->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$kd_divisi = $department.' / '.$unit;
			$tgl_cuti_awal = $datacuti->tgl_cuti_awal;
			$tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;
			$tgl_pengajuan_cuti = $datacuti->tgl_pengajuan_cuti;
			$jumlah_hari = $datacuti->jumlah_hari;
			$penjelasan_cuti = $datacuti->penjelasan_cuti;
			$alamat = $datacuti->alamat;
			$keterangan_cuti = $datacuti->keterangan_cuti;
			$tindak_lanjut = $datacuti->tindak_lanjut;
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

			$tombol = tombolapprove($level, $direct_supervisor, $next_higher_supervisor, $app1, $app2, $app3);
		}

		if($datacuti->jenis_cuti == 'C1' || $datacuti->jenis_cuti == 'C2' || $datacuti->jenis_cuti == 'C3' || $datacuti->jenis_cuti == 'C5'){
			$totalhari = DB::table('tbl_pengajuan_cuti')->select(DB::raw("sum(jumlah_hari) as jumlah"))->where('id', $id)->where('jenis_cuti', '!=', 'C17')->get();
			foreach($totalhari as $total){
				$totaljumlahhari = $total->jumlah;
			}
		}else{
			$totaljumlahhari = '';
		}

		if($datacuti->jenis_cuti == 'C4'){
			$totalhari = DB::table('tbl_pengajuan_cuti')->select(DB::raw("sum(jumlah_hari) as jumlah"))->where('id', $id)->get();
			foreach($totalhari as $total){
				$totaljumlahharibesar = $total->jumlah;
			}
		}else{
			$totaljumlahharibesar = '';
		}
		
		$datakaryawan = cutiexisting($nik);
	
		foreach($datakaryawan as $datakaryawan_cek){
			$sisa_cuti_tahunan = $datakaryawan_cek->sesudah;
			$sisa_cuti_tahunan_sudah_diambil = $datakaryawan_cek->cutitahunan;
			$sisa_cuti_tahunan_diambil = $datakaryawan_cek->sesudah;
			$sisa_cuti_besar = $datakaryawan_cek->sesudahB;
			$sisa_cuti_besar_sudah_diambil = $datakaryawan_cek->cutibesar;
			$sisa_cuti_besar_diambil = $datakaryawan_cek->sesudahB;
			$tgl_masuk_karyawan = $datakaryawan_cek->tgl_join;
		}
		
		if($user = Auth::user()){
			return view('admin.cuti.approveCuti', compact('id', 'nama_karyawan', 'nik', 'jabatan', 'kd_divisi', 'tgl_cuti_awal', 
																	'tgl_cuti_akhir', 'penjelasan_cuti', 'alamat', 'jumlah_hari', 'tgl_pengajuan_cuti', 
																	'keterangan_cuti', 'tindak_lanjut', 'jenis_cuti', 'petugas_pengganti', 'tombol',
																	'sisa_cuti_tahunan', 'sisa_cuti_tahunan_sudah_diambil', 'sisa_cuti_tahunan_diambil', 
																	'sisa_cuti_besar', 'sisa_cuti_besar_sudah_diambil', 'sisa_cuti_besar_diambil',
																	'tgl_masuk_karyawan', 'totaljumlahhari', 'totaljumlahharibesar', 'data_cuti', 
																	'app1', 'app2', 'app3' 
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
			$app2 = $datacuti->app2;
			$app3 = $datacuti->app3;
			$jenis_cuti = $datacuti->jenis_cuti;
			$jumlah_cuti_diambil = $datacuti->jumlah_hari;
			$jumlah_hari = $datacuti->jumlah_hari;
			$nik = $datacuti->nik;
			$nama_karyawan = $datacuti->nama_karyawan;
			$kd_divisi = $datacuti->kd_divisi;
			$jabatan = $datacuti->jabatan;
			$penjelasan_cuti = $datacuti->penjelasan_cuti;
			$petugas_pengganti = $datacuti->petugas_pengganti;
			$tgl_cuti_awal = $datacuti->tgl_cuti_awal;
			$tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;  
			$tanggal_pengajuan = $datacuti->tgl_pengajuan_cuti;

			$cuti_data = Cuti::where('nik', $nik)
								->where('penjelasan_cuti', $penjelasan_cuti)
								->where('petugas_pengganti', $petugas_pengganti)->get();
			

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
				$userid = $datakaryawan->userid;
				$email_pemohon = $datakaryawan->email;

				if($direct_supervisor == $next_higher_supervisor){
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff' || $jenis_karyawan == 'Supervisor'){
						if ($user->hasRole('Manager')) {
							$approve_name = 'Manager';
							$update = Cuti::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();

							//email pemohon
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
							}
						
							if($approve == 'Y'){
								$istype = substr($jenis_cuti, 1, 1);
								$keterangan = $penjelasan_cuti; 
								$mulai = $tgl_cuti_awal;
								$akhir = $tgl_cuti_akhir;
								$jumlah_diambil = $jumlah_cuti_diambil;
								updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
							}
						}else if ($user->hasRole('Super Admin')) {
							$approve_name = 'Super Admin';
							$update = Cuti::where('id',$id)->first();
							$update->app1 = $approve;
							$update->app_name1 = $approve_name;
							$update->app_time1 = $approve_time;
							$update->app2 = $approve;
							$update->app_name2 = $approve_name;
							$update->app_time2 = $approve_time;
							$update->update();

							//email pemohon
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
							}

							if($approve == 'Y'){
								$istype = substr($jenis_cuti, 1, 1);
								$keterangan = $penjelasan_cuti; 
								$mulai = $tgl_cuti_awal;
								$akhir = $tgl_cuti_akhir;
								$jumlah_diambil = $jumlah_cuti_diambil;
								updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
							}
						}else{
							
						}
					}else if($jenis_karyawan == 'Manager'){
						if ($user->hasRole('Manager')) {
							if($app1 == ''){
								$approve_name = 'Manager';
								$update = Cuti::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							//email pemohon
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
							}
							
							if($approve == 'Y'){
								$istype = substr($jenis_cuti, 1, 1);
								$keterangan = $penjelasan_cuti; 
								$mulai = $tgl_cuti_awal;
								$akhir = $tgl_cuti_akhir;
								$jumlah_diambil = $jumlah_cuti_diambil;
								updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
							}
						}else{
							
						}
					}else{

					}
				}else{
					if($jenis_karyawan == 'Staff' || $jenis_karyawan == 'Non Staff'){
						if ($user->hasRole('Supervisor')) {
							if($app1 == ''){
								$approve_name = 'Supervisor';
								$update = Cuti::where('id',$id)->first();
								$update->app1 = $approve;
								$update->app_name1 = $approve_name;
								$update->app_time1 = $approve_time;
								$update->update();
							}
							$atasan = $next_higher_supervisor;
							$email_to = Employee::where('nama', $atasan)->get();
							foreach($email_to as $emailto){
								$email = $emailto->email;
							}
							//email pemohon
							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
							}
							//atasan	
							if($email != ''){															
								Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $atasan, $id, $cuti_data));
							}
						}else if($user->hasRole('Manager')) {
							if($app2 == ''){
								$approve_name = 'Manager';
								$update = Cuti::where('id',$id)->first();
								$update->app2 = $approve;
								$update->app_name2 = $approve_name;
								$update->app_time2 = $approve_time;
								$update->update();
							}

							if($email_pemohon != ''){
								Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Pengajuan Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
							}
						
							
							if($approve == 'Y'){
								$istype = substr($jenis_cuti, 1, 1);
								$keterangan = $penjelasan_cuti; 
								$mulai = $tgl_cuti_awal;
								$akhir = $tgl_cuti_akhir;
								$jumlah_diambil = $jumlah_cuti_diambil;
								updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
							}
						}else if($user->hasRole('Super Admin')){
							if($app1 == ''){
								$approve_name = 'Super Admin';
								$update = Cuti::where('id',$id)->first();
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
									Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
								}
								if($email != ''){
									Mail::to($email)->send(new CutiVerifikasi($subject = 'Approval Cuti', $atasan = 'HRD', $id, $cuti_data));
								}
							}else{
								if($app2 == ''){
									if($jenis_cuti != 'C17'){
										$approve_name = 'Super Admin';
										$update = Cuti::where('id',$id)->first();
										$update->app2 = $approve;
										$update->app_name2 = $approve_name;
										$update->app_time2 = $approve_time;
										$update->update();
									}

									if($email_pemohon != ''){
										Mail::to($email_pemohon)->send(new CutiVerifikasiPemohon($subject = 'Approval Cuti', $atasan = $nama_karyawan, $id, $cuti_data));
									}
			
									if($approve == 'Y'){
										if($jenis_cuti != 'C17'){
											$istype = substr($jenis_cuti, 1, 2);
											$keterangan = $penjelasan_cuti; 
											$mulai = $tgl_cuti_awal;
											$akhir = $tgl_cuti_akhir;
											$jumlah_diambil = $jumlah_cuti_diambil;
											updatecuti($userid, $istype, $keterangan, $mulai, $akhir, $jumlah_diambil);
										}
										
									}
								}
							}
						}else{

						}
					}else{

					}
				}
			}						
		}
		return redirect('');
	}

}
