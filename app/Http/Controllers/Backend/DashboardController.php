<?php

namespace App\Http\Controllers\Backend;

use DB;
use Auth;
use Mail;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Employee;
use App\Models\Departement;
use App\Models\Ijin;
use App\Models\Lembur;
use App\Models\Absensi;
use App\Models\TanggalMerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function checkAuth(){
    	return redirect('/'); // change to here;
    }

    public function index(Request $request) {
    //	return redirect('/backend/jadwal/nonshift'); //jika sudah kelar hapus ini
		$user = Auth::user();
		$nama = $user->name;
		if($user->hasRole('Super Admin') ){
			if(empty($request->input('date'))){
				$dateFrom = Carbon::now()->format('Y-m')."-01";
	        	$dateTo = date("Y-m-t", strtotime($dateFrom));
	        	$datemin7 = date('Y-m-d', strtotime('-7 days', strtotime($dateTo)));
			}else{
				$dateFrom = Carbon::parse($request->input('date'))->format('Y-m')."-01";
				$dateTo = date("Y-m-t", strtotime($dateFrom));
	        	$datemin7 = date('Y-m-d', strtotime('-7 days', strtotime($dateTo)));
			}

			/*CHART LINE DAY*/
			if(!empty($request->input('dept_id'))){
				$dept_ids = $request->input('dept_id');
			}else{
				$dept_ids=1;
			}
			$dept_id = Departement::where('id',$dept_ids)->first();
			$employees = Employee::where('dept_id',$dept_id->id)->where('status',1)->get();
			$empslabel=[];
			$empsval=[];
			$p=0;
			$q=0;
			for ($e=0; $e < count($employees); $e++) { 
				$cekAbsene = Absensi::where('nik',$employees[$e]->nik)
				                              ->whereBetween('date',[$dateFrom,$dateTo])
				                              ->where('mlate','!=',0)->get();
				$empslabel[$p] = $employees[$e]->nama;
				if(count($cekAbsene)>0){
					// $endperiodee = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
					// $starte = new DateTime($dateFrom);
					// $endperiodee = new DateTime($endperiodee);
					// $intervale = DateInterval::createFromDateString('1 days');
					// $periode   = new DatePeriod($starte, $intervale, $endperiodee);
					// $dayse=[];
					// $he=0;
					// foreach ($periode as $dte) {
					//     $list = $dte->format("Y m d-D");
					//     $day = substr($list, -3);
					//     if($day == 'Sun'){
					//        $dayse[$he] = $dte->format("Y-m-d");
					//        $dayse[$he++];
					// 	}
						
					// }
					// $getSunDayse = count($dayse);
					// $ende = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
					// $totalharie = $starte->diff($ende)->days+1;
					// $jumlahKare = Employee::where('dept_id',$dept_id->id)->where('status',1)->count();
					// $countTglMerahe = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
					// $jumlahharikerjae = $totalharie-$getSunDayse-$countTglMerahe;
					// $sakite = Absensi::where('nik',$employees[$e]->nik)->whereNull('wjm')->whereNull('wjk')
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->where('keterangan','Sakit')->get();
					// //Get Date Sakit
					// $dateSe=[];
					// $hee=0;                                              
					// if(count($sakite) > 0){
					//   	for($se=0; $se<count($sakite); $se++)
					//   	{
					//       	$dateSe[$hee] = $sakite[$se]->date;
					//       	$dateSe[$hee++];
					//   	}
					//   	$dateSakite = $dateSe;
					// }else{
					// 	$dateSakite = [0];
					// }
					// $sakitsetengahe = Absensi::where('nik',$employees[$e]->nik)->whereNull('wjm')->whereNull('wjk')
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->where('keterangan','Sakit 0.5')->get();
					// $telate = Absensi::where('nik',$employees[$e]->nik)->where('mlate','!=',0)
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->whereNull('keterangan')->count();
					// $ijine = Absensi::where('nik',$employees[$e]->nik)
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->where('keterangan','Ijin')->count();

					// $cutie = Absensi::where('nik',$employees[$e]->nik)->whereNull('wjm')->whereNull('wjk')
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->where('keterangan','Cuti')->count();
					// $cutiSetengahe = Absensi::where('nik',$employees[$e]->nik)
					//                               ->whereBetween('date',[$dateFrom,$dateTo])
					//                               ->where('keterangan','Cuti 0.5')->count();
					// $cekCutie = Cuti::where('kd_divisi',$dept_id->id)
					//                             ->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
					//                             ->get();
					// if(count($cekCutie) > 0){
					//   $cse = [];
					//   $ce=0;
					//   foreach ($cekCutie as $cutiiie) {
					//       if(in_array($cutiiie->tgl_cuti_awal, $dateSakite)){
					//         $cse[$ce++] = $cutiiie->tgl_cuti_awal;
					//       }
					//   }
					//   $sakitCutie = count($cse);
					// }else{
					//   $sakitCutie = 0;
					// }

					// $jumlahCutie = $cutie + ($cutiSetengahe/2);

					// $totalsakite = (count($sakite) + (count($sakitsetengahe)/2))-$sakitCutie;
					// $totalstie = $telate+$ijine+$totalsakite;
					// $totalcutie = $jumlahCutie + $sakitCutie;
					// $totalketidakhadirane = $totalstie+$totalcutie;
					// $totalharikerjae=$jumlahKare*$jumlahharikerjae;
					// $persentidakHadire = round(($totalketidakhadirane / $totalharikerjae) * 100,2);
					// $persenhadire = round(100-$persentidakHadire,2);
					$empsval[$q]=count($cekAbsene);
				}else{
					$empsval[$q] = 0;
				}
				$empslabel[$p++];
				$empsval[$q++];
				
			}
			// dd($empsval);
			
			/*END CHART LINE DAY*/



			/*CHART BAR MONTH*/
			$dept = Departement::all();
			$label=[];
			$val=[];
			$i=0;
			$z=0;
			for ($k=0; $k < count($dept); $k++) { 
				$cekAbsen = Absensi::where('dept_id',$dept[$k]->id)
											  ->whereBetween('date',[$dateFrom,$dateTo])->get();
											  
				$label[$z] = $dept[$k]->unit;
				if(count($cekAbsen)>0){
					$endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
					$start = new DateTime($dateFrom);
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
					$end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
					$totalhari = $start->diff($end)->days+1;
					$jumlahKar = Employee::where('dept_id',$dept[$k]->id)->where('status',1)->get();
					$countTglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
					$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
					$totalharikerja=count($jumlahKar)*$jumlahharikerja;
					$sakit = Absensi::where('dept_id',$dept[$k]->id)->whereNull('wjm')->whereNull('wjk')
					                              ->whereBetween('date',[$dateFrom,$dateTo])
												  ->where('keterangan','Sakit')->get();
					//Get Date Sakit
					$dateS=[];
					$h=0;      
					                                     
					if(count($sakit) > 0){
					  for($s=0; $s<count($sakit); $s++)
					  {
					      $dateS[$h] = $sakit[$s]->date;
					      $dateS[$h++];
					  }
					  $dateSakit = $dateS;
					}else{
						$dateSakit = [0];
					}  
					$sakitsetengah = Absensi::where('dept_id',$dept[$k]->id)->whereNull('wjm')->whereNull('wjk')
					                              ->whereBetween('date',[$dateFrom,$dateTo])
					                              ->where('keterangan','Sakit 0.5')->get();
					$telat = Absensi::where('dept_id',$dept[$k]->id)->where('mlate','!=',0)
					                              ->whereBetween('date',[$dateFrom,$dateTo])
					                              ->whereNull('keterangan')->count();
					$ijin = Absensi::where('dept_id',$dept[$k]->id)
					                              ->whereBetween('date',[$dateFrom,$dateTo])
					                              ->where('keterangan','Ijin')->count();

					$cuti = Absensi::where('dept_id',$dept[$k]->id)->whereNull('wjm')->whereNull('wjk')
					                              ->whereBetween('date',[$dateFrom,$dateTo])
					                              ->where('keterangan','Cuti')->count();
					$cutiSetengah = Absensi::where('dept_id',$dept[$k]->id)
					                              ->whereBetween('date',[$dateFrom,$dateTo])
					                              ->where('keterangan','Cuti 0.5')->count();
					$cekCuti = Cuti::where('kd_divisi',$dept[$k]->id)
					                            ->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
					                            ->get();
					if(count($cekCuti) > 0){
					  $cs = [];
					  $c=0;
					  foreach ($cekCuti as $cutiii) {
					      if(in_array($cutiii->tgl_cuti_awal, $dateSakit)){
					        $cs[$c++] = $cutiii->tgl_cuti_awal;
					      }
					  }
					  $sakitCuti = count($cs);
					}else{
					  $sakitCuti = 0;
					}

					$jumlahCuti = $cuti + ($cutiSetengah/2);
					$totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
					$totalsti = $telat+$ijin+$totalsakit;
					$totalcuti = $jumlahCuti + $sakitCuti;
					$totalketidakhadiran = $totalsti+$totalcuti;
					$totalharikerja=count($jumlahKar)*$jumlahharikerja;
					$persentidakHadir = round(($totalketidakhadiran / $totalharikerja) * 100,2);
					$persenhadir = round(100-$persentidakHadir,2);
					$val[$i]=$persenhadir;
				}else{
					$val[$i] = 0;
				}
				$label[$z++];
				$val[$i++];
			}
			$label=$label;
			$val=$val;
			/*END CHART BAR MONTH*/



			// KARYAWAN AKTIF NON AKTIF //
			$valuestatus = DB::table('employees')
								->select('status', DB::raw('count(*) as status_karyawan'))
								->groupBy('status')
								->get();
			
			$j = 0;
			for($i = 0; $i < count($valuestatus); $i++){
				$valuestatuskaryawan[$j] = $valuestatus[$i]->status_karyawan;
				$labelstatuskaryawan[$j] = $valuestatus[$i]->status;
				$labelstatus = DB::table('employees')
									->where('status', '0')
									->get();
				$valuestatuskaryawan[$j++];
			}
			// KARYAWAN AKTIF NON AKTIF //


			// PERSENTASE CUTI PER HARI //	
				$endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
				$start = new DateTime($datemin7);
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
				$end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
				$totalhari = $start->diff($end)->days+1;
				$jumlahKar = Employee::where('dept_id',$dept_ids)->get();
				$countTglMerah = TanggalMerah::whereBetween('date',[$datemin7,$dateTo])->count();
				$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
				$totalharikerja = $jumlahharikerja * count($jumlahKar);
				
				$sakit = Absensi::where('dept_id',$dept_ids)->whereNull('wjm')->whereNull('wjk')
												->whereBetween('date',[$datemin7,$dateTo])
											  ->where('keterangan','Sakit')->get();
				//Get Date Sakit
				
				$dateS=[];
				$h=0;      
											 
				if(count($sakit) > 0){
				  for($s=0; $s<count($sakit); $s++)
				  {
					  $dateS[$h] = $sakit[$s]->date;
					  $dateS[$h++];
				  }
				  $dateSakit = $dateS;
				}else{
					$dateSakit = [0];
				} 

				$sakitsetengah = Absensi::where('dept_id',$dept_ids)->whereNull('wjm')->whereNull('wjk')
											  ->whereBetween('date',[$datemin7,$dateTo])
											  ->where('keterangan','Sakit 0.5')->get();
				$telat = Absensi::where('dept_id',$dept_ids)->where('mlate','!=',0)
											  ->whereBetween('date',[$datemin7,$dateTo])
											  ->whereNull('keterangan')->count();
				$ijin = Absensi::where('dept_id',$dept_ids)
											  ->whereBetween('date',[$datemin7,$dateTo])
											  ->where('keterangan','Ijin')->count();

				$cuti = Absensi::where('dept_id','7')->whereNull('wjm')->whereNull('wjk')
												  ->whereBetween('date',[$datemin7,$dateTo])
												  ->where('keterangan','Cuti')->count();
				$cutiSetengah = Absensi::where('dept_id',$dept_ids)
											  ->whereBetween('date',[$datemin7,$dateTo])
											  ->where('keterangan','Cuti 0.5')->count();
				$cekCuti = Cuti::where('kd_divisi',$dept_ids)
											->whereBetween('tgl_cuti_awal',[$datemin7,$dateTo])
											->get();
				if(count($cekCuti) > 0){
				  $cs = [];
				  $c=0;
				  foreach ($cekCuti as $cutiii) {
					  if(in_array($cutiii->tgl_cuti_awal, $dateSakit)){
						$cs[$c++] = $cutiii->tgl_cuti_awal;
					  }
				  }
				  $sakitCuti = count($cs);
				}else{
				  $sakitCuti = 0;
				}

				$jumlahCuti = $cuti + ($cutiSetengah/2);
				$totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
				$totalsti = $telat+$ijin+$totalsakit;
				$totalcuti = $jumlahCuti + $sakitCuti;

				$tidakhadiselaincuti = $totalharikerja - $totalsti;
				$persencutihari = round(($totalcuti / $tidakhadiselaincuti) * 100,2);
				$persentidakcutihari = 100 - $persencutihari;	
			// PERSENTASE CUTI PER HARI //


			// PERSENTASE CUTI PER BULAN //	
				$endperiod = (new DateTime($dateTo))->modify('+1 day')->format('Y-m-d');
				$start = new DateTime($dateFrom);
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
				$end = new DateTime((new DateTime($dateTo))->format('Y-m-d'));
				$totalhari = $start->diff($end)->days+1;
				$jumlahKar = Employee::where('dept_id',$dept_ids)->get();
				$countTglMerah = TanggalMerah::whereBetween('date',[$dateFrom,$dateTo])->count();
				$jumlahharikerja = $totalhari-$getSunDays-$countTglMerah;
				
				$sakit = Absensi::where('dept_id',$dept_ids)->whereNull('wjm')->whereNull('wjk')
					                              ->whereBetween('date',[$dateFrom,$dateTo])
												  ->where('keterangan','Sakit')->get();
				//Get Date Sakit
				$dateS=[];
				$h=0;      
				if(count($sakit) > 0){
					for($s=0; $s<count($sakit); $s++)
					{
						$dateS[$h] = $sakit[$s]->date;
						$dateS[$h++];
					}
					$dateSakit = $dateS;
				}else{
					$dateSakit = [0];
				} 
				
				$sakitsetengah = Absensi::where('dept_id',$dept_ids)->whereNull('wjm')->whereNull('wjk')
												->whereBetween('date',[$dateFrom,$dateTo])
												->where('keterangan','Sakit 0.5')->get();
				$telat = Absensi::where('dept_id',$dept_ids)->where('mlate','!=',0)
												->whereBetween('date',[$dateFrom,$dateTo])
												->whereNull('keterangan')->count();
				$ijin = Absensi::where('dept_id',$dept_ids)
												->whereBetween('date',[$dateFrom,$dateTo])
												->where('keterangan','Ijin')->count();
				$cuti = Absensi::where('dept_id',$dept_ids)->whereNull('wjm')->whereNull('wjk')
													->whereBetween('date',[$dateFrom,$dateTo])
													->where('keterangan','Cuti')->count();
				$cutiSetengah = Absensi::where('dept_id',$dept_ids)
												->whereBetween('date',[$dateFrom,$dateTo])
												->where('keterangan','Cuti 0.5')->count();
				$cekCuti = Cuti::where('kd_divisi',$dept_ids)
											->whereBetween('tgl_cuti_awal',[$dateFrom,$dateTo])
											->get();
											
				if(count($cekCuti) > 0){
					$cs = [];
					$c=0;
					foreach ($cekCuti as $cutiii) {
						if(in_array($cutiii->tgl_cuti_awal, $dateSakit)){
						$cs[$c++] = $cutiii->tgl_cuti_awal;
						}
					}
					$sakitCuti = count($cs);
				}else{
					$sakitCuti = 0;
				}

				$jumlahCuti = $cuti + ($cutiSetengah/2);

				$totalsakit = (count($sakit) + (count($sakitsetengah)/2))-$sakitCuti;
				$totalsti = $telat+$ijin+$totalsakit;
				$totalcuti = $jumlahCuti + $sakitCuti;
				$totalharikerja=$jumlahharikerja;

				$tidakhadiselaincuti = $totalharikerja - $totalsti;
				$persencutibulan = round(($totalcuti / $tidakhadiselaincuti) * 100,2);
				$persentidakcutibulan = 100 - $persencutibulan;

			/*	$persentidakcutibulanan = Absensi::where('dept_id', '7')
																					->where('keterangan', '')
																					->whereBetween('date',[$dateFrom,$dateTo])->count();
				if($persentidakcutibulanan == 0){
					$persentidakcutibulan2 = 100;
				}else{
					$persentidakcutibulan2 = $persentidakcutibulanan;
				}
				
				$persencutibulanan = Absensi::where('dept_id', '7')
																			->whereIn('keterangan', ['Cuti', '- Cuti 0.5'])
																			->whereBetween('date',[$dateFrom,$dateTo])->count();
				if($persencutibulanan == 0){
					$persencutibulan2 = 100 - $persentidakcutibulan2;
				}else{
					$persencutibulan2 = $persencutibulanan;
				}
				
				if($persencutibulan2 == 0){
					$persentidakcutibulan = ($persentidakcutibulan2 * 100) / 100;
				}else{
					$persentidakcutibulan = ($persentidakcutibulan2 / $persencutibulan2) * 100;
				}
			
				$persencutibulan = 100 - $persentidakcutibulan;	*/

			// PERSENTASE CUTI PER BULAN //


			//	START RANK CUTI PER HARI //
				
				$cekkaryawan = DB::table('employees')
							->select('level', DB::raw('count(*) as lvl'))
							->where('dept_id', $dept_ids)
							->groupBy('level')
							->get();
				$y=0;
				for ($x=0; $x < count($cekkaryawan); $x++) { 	
					$level[$y] = $cekkaryawan[$x]->level;
					$jumlahkaryawanperlevel[$y] = $cekkaryawan[$x]->lvl;
					$level[$y++];
				}
				$labelcutiharian = $level;
				$valuecutiharian = $jumlahkaryawanperlevel;
			//	END RANK CUTI PER HARI //



			//	START SUMMARY KARYAWAN PER MASA KERJA //
				$datakaryawanpermasa = DB::select("SELECT 
									(CASE 
										WHEN tahun.Totaltahun <= 2 THEN '<= 2 TAHUN'
										WHEN tahun.Totaltahun BETWEEN 3 and 5 THEN '<= 5 TAHUN'
										WHEN tahun.Totaltahun BETWEEN 6 and 10 THEN '<= 10 TAHUN'
										ELSE '>10 Tahun'  
									END) as masakerja , COUNT(*) as jumlah
									FROM
										(Select 
										nik
										,tgl_join
										,CURDATE() as today
										,DateDiff (tgl_join, CURDATE()) as Totalhari
										,(DateDiff (tgl_join, CURDATE())/365) as Totaltahun 
										from 
										employees) as tahun
									GROUP BY 
									(CASE 
										WHEN tahun.Totaltahun <= 2 THEN '<= 2 TAHUN'
										WHEN tahun.Totaltahun BETWEEN 3 and 5 THEN '<= 5 TAHUN'
										WHEN tahun.Totaltahun BETWEEN 6 and 10 THEN '<= 10 TAHUN'
										ELSE '>10 Tahun'  
									END)");	
				$j = 0;
				for($i = 0; $i < count($datakaryawanpermasa); $i++){
					$masakerja[$j] = $datakaryawanpermasa[$i]->masakerja;
					$jumlah[$j] = $datakaryawanpermasa[$i]->jumlah;

					$masakerja[$j++];
				}
				$labelcutibulanan = $masakerja;
				
				$valuecutibulanan = $jumlah;
			//	END SUMMARY KARYAWAN PER MASA KERJA //

			if(request()->ajax()){
				$data['label'] = $label;
				$data['val'] = $val;
				$data['empslabel'] = $empslabel;
				$data['empsval'] = $empsval;
				$data['valuestatuskaryawan'] = $valuestatuskaryawan;
				$data['labelstatuskaryawan'] = $labelstatuskaryawan;
				$data['labelcutibulanan'] = $labelcutibulanan;
				$data['valuecutibulanan'] = $valuecutibulanan;
				$data['labelcutiharian'] = $labelcutiharian;
				$data['valuecutiharian'] = $valuecutiharian;
				$data['persencutihari'] = $persencutihari;
				$data['persentidakcutihari'] = $persentidakcutihari;
				$data['persencutibulan'] = $persencutibulan;
				$data['persentidakcutibulan'] = $persentidakcutibulan;
				return response()->json($data);
			}
			$filter = "b.id != ''";
	
			$data_cuti = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_cuti, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_cuti b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_cuti, b.app1, b.app2, b.app3 
									order by b.id desc");
			$data_lembur = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_lembur, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_lembur b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_lembur, b.app1, b.app2, b.app3 
									order by b.id desc");
			$data_ijin = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_ijin, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_ijin b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_ijin, b.app1, b.app2, b.app3 
									order by b.id desc");
			
			if($user->hasRole('Super Admin') || $user->hasRole('Management') || $user->hasRole('Manager') || $user->hasRole('Supervisor')){
				$cuti_url = "http://127.0.0.1:8000/backend/cuti/approve_cuti";
				$ijin_url = "http://127.0.0.1:8000/backend/ijin/approve_ijin";
				$lembur_url = "http://127.0.0.1:8000/backend/lembur/approve_lembur";
				$post = "post";
			}else{
				$cuti_url = "";
				$ijin_url = "";
				$lembur_url = "";
				$post = "";
			}
			
			return view('admin.dashboard',compact('val','label','dept','empsval','empslabel',
													'data_cuti', 'data_ijin', 'data_lembur', 
													'cuti_url', 'ijin_url', 'lembur_url', 'post',
													'labelstatuskaryawan', 'valuestatuskaryawan', 
													'valuecutiharian', 'labelcutiharian', 
													'labelcutibulanan', 'valuecutibulanan', 
													'persencutihari', 'persentidakcutihari', 
													'persencutibulan', 'persentidakcutibulan'));
		}else{
			if($user->hasRole('Staff') || $user->hasRole('Non Staff')){
				$filter = "b.nama_karyawan = '".$nama."' and b.app2 = 'Y' ";
			}else if($user->hasRole('Supervisor')){
				$filter = "(case 
								when b.nama_karyawan != '".$nama."' 
									then a.direct_supervisor = '".$nama."' 
										and a.direct_supervisor != a.next_higher_supervisor
								else
								 	b.id != ''
							end)";
			}else if($user->hasRole('Manager')){
				$filter = "(case 
							when b.nama_karyawan != '".$nama."' 
								then a.next_higher_supervisor = '".$nama."' 
									and
									(case
										when a.direct_supervisor = a.next_higher_supervisor
											then b.app2 = '' and b.app1 = ''
										else b.app2 = '' and b.app1 = 'Y'
									end) 
							else 
								b.id != ''
						end)";
			}else if($user->hasRole('Management')){
				$filter = "b.id != '' ";
			}else if($user->hasRole('Super Admin')){
				$filter = "b.id != ''";
			}else{
				$filter = "b.app1 = 'HHHHH'";
			}
	
			
			$data_cuti = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_cuti, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_cuti b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_cuti, b.app1, b.app2, b.app3 
									order by b.id desc");			
			$data_lembur = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_lembur, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_lembur b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_lembur, b.app1, b.app2, b.app3 
									order by b.id desc");
			$data_ijin = DB::select("select b.nama_karyawan, b.id, b.tgl_pengajuan_ijin, b.app1, b.app2, b.app3 
									from employees a 
									left join tbl_pengajuan_ijin b 
									on b.nama_karyawan = a.nama 
									where ".$filter." 
									group by b.nama_karyawan, b.id, b.tgl_pengajuan_ijin, b.app1, b.app2, b.app3 
									order by b.id desc");
			
			if($user->hasRole('Super Admin') || $user->hasRole('Management') || $user->hasRole('Manager') || $user->hasRole('Supervisor')){
				$cuti_url = "http://127.0.0.1:8000/backend/cuti/approve_cuti";
				$ijin_url = "http://127.0.0.1:8000/backend/ijin/approve_ijin";
				$lembur_url = "http://127.0.0.1:8000/backend/lembur/approve_lembur";
				$post = "post";
			}else{
				$cuti_url = "";
				$ijin_url = "";
				$lembur_url = "";
				$post = "";
			}

			return view('admin.dashboard',compact('data_cuti', 'data_ijin', 'data_lembur', 
													'cuti_url', 'ijin_url', 'lembur_url', 'post'));
	
		}
	}

	public function getChart() {
		$karyawanaktif = DB::table('employees')->where('status', '1')->count();
		$karyawannonaktif = DB::table('employees')->where('status', '0')->count();
		
		$result = array(
			'aktif'=>$karyawanaktif,
			'nonaktif'=>$karyawannonaktif
		);
		
		return response()->json($result);
		
	}
	public function sendMail(){
		$contactemail = 'abdrozak20@gmail.com';
		$user = 'aaaaaa';
		Mail::send('emails.testmail', compact('user'), function ($message) use ($contactemail) {
		     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_ADDRESS'));
		     $message->subject('Reschedule Interview');
		     $message->to($contactemail);
		 });
		flash()->success('success');
		return redirect()->back();
	}

	public function userprofile($id,Request $request){
		$user = User::find($id)->first();
		$user->password = Hash::make($request->input('password'));
		$user->update();
		flash()->success('Password Berhasil Dirubah');
		return redirect()->back();
	}
}
