<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\ReportCuti;
use App\Models\Employee;
use App\Models\Lembur;
use App\Models\Departement;
use App\Models\ShiftSchedule;
use App\Models\Schedule;
use App\Models\NonshiftSchedule;
use App\Models\MstNonshiftSchedules;
use Illuminate\Http\Request;
use App\Exports\LemburExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use DB;

class ReportLemburController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    
    public function indexReportLembur() {
		$nik = '';
		$nama_karyawan = '';
		$bulan = date('m');
		$tahun = date('Y');
		$action = '1';
		$data_karyawan = DB::select('SELECT A.*, B.*
										FROM employees A 
										LEFT JOIN departements B ON A.DEPT_ID = B.ID');
		$data_lembur = Lembur::orderBy('tgl_pengajuan_lembur', 'DESC')->get();	
		$departements = Departement::orderBy('id', 'ASC')->get();	
		
        return view('admin.lembur.indexReportLembur', compact('data_karyawan', 'data_lembur', 'bulan', 'tahun', 
																'action', 'nama_karyawan', 'nik', 'departements'
													));
    }
	
	public function getTable(Request $request){
		$nik = $request->input('nik');
		$nama_karyawan = $request->input('nama_karyawan');
		$kd_divisi = $request->input('dept_id');
		$bulan = $request->input('bulan');
		$tahun = $request->input('tahun');

		if($nik == ''){
			if($kd_divisi == ''){
				$filter1 = "nik != ''";
				$filter2 = "a.nik != ''";
			}else{
				$filter1 = "dept_id = '".$kd_divisi."' ";
				$filter2 = "a.kd_divisi = '".$kd_divisi."' ";
			}
		}else{
			$filter1 = "nik = '".$nik."' ";
			$filter2 = "a.nik = '".$nik."' ";
		}

		if($bulan != ''){
			$filterbulan = "and substring(a.tgl_lembur_awal, 6, 2) = '".$bulan."'";
		}else{
			$filterbulan = "and substring(a.tgl_lembur_awal, 6, 2) != ''";
		}

		if($tahun != ''){
			$filtertahun = "and substring(a.tgl_lembur_awal, 1, 4) = '".$tahun."'";
		}else{
			$filtertahun = "and substring(a.tgl_lembur_awal, 1, 4) != ''";
		}
		
	/*	\Log::debug('filternik1 '.$filternik1);
		\Log::debug('filterdiv1 '.$filterdiv1);
		\Log::debug('filternik2 '.$filternik2);
		\Log::debug('filterdiv2 '.$filterdiv2);
		\Log::debug('bulan '.$bulan);
		\Log::debug('tahun '.$tahun);	*/
	/*	 $data_lembur = DB::select("SELECT 
		 							(CASE
		 							WHEN c.level = 'Non Staff' 
									 	THEN 
										 	(SELECT time_schedule_awal 
											 	FROM shift_schedules a 
												LEFT JOIN schedules b ON a.dept = b.dept_id 
												WHERE a.dept = a.kd_divisi )
		 							ELSE

		 							(SELECT CONCAT(wjm, ':00') 
									 	FROM absensi 
											WHERE ".$filter1." AND date = SUBSTRING(a.tgl_lembur_awal, 1, 11))

		 							END) AS mulai_shift,
		 							(CASE
										WHEN c.level = 'Non Staff' 
											THEN 
												(SELECT time_schedule_akhir 
													FROM shift_schedules a 
													LEFT JOIN schedules b ON a.dept = b.dept_id 
													WHERE a.dept = a.kd_divisi )
										ELSE
										(SELECT CONCAT(wjk, ':00') 
											FROM absensi 
											WHERE ".$filter1." AND date = SUBSTRING(a.tgl_lembur_awal, 1, 11))
		 							END) AS selesai_shift,
		 							a.tgl_lembur_awal, a.tgl_lembur_akhir,
		 							(SELECT CONCAT(wjm, ':00') FROM absensi WHERE ".$filter1." AND date = SUBSTRING(a.tgl_lembur_awal, 1, 11)) AS wjm,
		 							(SELECT CONCAT(wjk, ':00') FROM absensi WHERE ".$filter1." AND date = SUBSTRING(a.tgl_lembur_awal, 1, 11)) AS wjk,

		 							a.*, c.*
		 							FROM tbl_pengajuan_lembur a
		 							LEFT JOIN employees c
		 							ON c.nik = a.nik
		 							WHERE ".$filter2."
		 							AND SUBSTRING(a.tgl_lembur_awal, 6, 2) = '".$bulan."'
									 AND SUBSTRING(a.tgl_lembur_awal, 1, 4) = '".$tahun."'");	*/


		$data_lembur = DB::select("
								select 
									a.nama_karyawan,a.nik,c.unit,a.kd_divisi,a.jenis_lembur,a.batas_lembur,
									a.tgl_lembur_awal,a.tgl_lembur_akhir,b.wjm,b.wjk,a.lama_lembur,
									a.keterangan_lembur,a.app1,a.app2,d.shifting 
								from tbl_pengajuan_lembur a 
								left join absensi b on a.nik=b.nik 
								left join departements c ON a.kd_divisi = c.id 
								left join employees d ON d.nik = a.nik
								where ".$filter2."
									AND SUBSTRING(a.tgl_lembur_awal, 6, 2) = '".$bulan."' 
									AND SUBSTRING(a.tgl_lembur_awal, 1, 4) = '".$tahun."' 
									AND SUBSTRING(b.date, 9,2) = SUBSTRING(a.tgl_lembur_awal, 9, 2) 
									AND SUBSTRING(b.date, 6,2) = SUBSTRING(a.tgl_lembur_awal, 6, 2) 
									AND SUBSTRING(b.date, 1,4) = SUBSTRING(a.tgl_lembur_awal, 1, 4)");
		
		$no = 0;
		foreach($data_lembur as $data){
			$no = $no + 1;
			if($data->batas_lembur == 'Bawah'){
				if(Carbon::parse($data->tgl_lembur_awal)->format('H:i:s') > $data->wjm){
					$valid1 = Carbon::parse($data->tgl_lembur_awal)->format('H:i:s');
				}else{
					$valid1 =  $data->wjm;
				}
			}else{
				$valid1 =  $data->wjm;
			}

			if ($data->shifting == 'Y') {
			 	$jadwalshift = ShiftSchedule::where('date',Carbon::parse($data->tgl_lembur_awal)->format('Y-m-d'))->where('nik',$data->nik)->first();
			 	$mstjadwal = Schedule::where('dept_id',$jadwalshift->dept)
			 					->where('code',$jadwalshift->schedule_code)->first();
			 	$time_awal = Carbon::parse($mstjadwal->time_schedule_awal)->format('H:i');
			 	$time_akhir = Carbon::parse($mstjadwal->time_schedule_akhir)->format('H:i');
			 	$jadwal = $jadwalshift->schedule_code." - (".$time_awal."-".$time_akhir.")";
			}else{
				$jadwalnonshift = NonshiftSchedule::where('date',Carbon::parse($data->tgl_lembur_awal)->format('Y-m-d'))->where('nik',$data->nik)->first();
				$jadwalnonshift = MstNonshiftSchedules::where('id',$jadwalnonshift->schedule_code)->first();
				$time_awal = Carbon::parse($jadwalnonshift->time_schedule_awal)
								->format('H:i');
			 	$time_akhir = Carbon::parse($jadwalnonshift->time_schedule_akhir)
			 					->format('H:i');
			 	$jadwal = $jadwalnonshift->schedule_code." - (".$time_awal."-".$time_akhir.")";
			}

			if($data->batas_lembur == 'Bawah'){
				if(Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s') > $data->wjk){
					$valid2 =  $data->wjk;
				}else{
					$valid2 = Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s');
				}
			}else{
				$valid2 = Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s');
			}

			for($i = 0; $i < count($data_lembur); $i++){
				$hasil = "<tr>                       
							<td rowspan='1'>".$no."</td>
							<td>".$data->nama_karyawan."</td>
							<td>".$data->nik."</td>
							<td>".$data->unit."</td>
							<td>".Carbon::parse($data->tgl_lembur_awal)->format('d-m-Y')."</td>
							<td>".$jadwal."</td>
							<td>".$data->jenis_lembur."</td>
							<td>".Carbon::parse($data->tgl_lembur_awal)->format('H:i:s')."</td>
							<td>".Carbon::parse($data->tgl_lembur_akhir)->format('H:i:s')."</td>
							<td>".$data->wjm."</td>
							<td>".$data->wjk."</td>
							<td>".$valid1."</td>
							<td>".$valid2."</td>
							<td>".$data->lama_lembur."</td>
							<td>".$data->keterangan_lembur."</td>
							<td>".$data->app1."</td>
							<td>".$data->app2."</td>
						</tr>";	

			}
			$jumlahlemburkerja = Lembur::where('jenis_lembur','K')
										->where('nik', $data->nik)
										->where(DB::raw('substr(tgl_lembur_awal, 6, 2)'), '=' , $bulan)
										->where(DB::raw('substr(tgl_lembur_awal, 1, 4)'), '=' , $tahun)->count();
										
			$jamlemburkerja = DB::table('tbl_pengajuan_lembur')
										->select(DB::raw('sum(lama_lembur) as lama'))
										->where('nik', $data->nik)
										->where('jenis_lembur','K')
										->where(DB::raw('substr(tgl_lembur_awal, 6, 2)'), '=' , $bulan)
										->where(DB::raw('substr(tgl_lembur_awal, 1, 4)'), '=' , $tahun)
										->groupBy('lama_lembur')
										->get();
			
			if(count($jamlemburkerja) > 0){
				foreach($jamlemburkerja as $jamlemburk){
					$jamlk = $jamlemburk->lama;
				}
			}else{
				$jamlk = 0;
			}	

			$jumlahlemburlibur = Lembur::where('jenis_lembur','L')
										->where('nik', $data->nik)
										->where(DB::raw('substr(tgl_lembur_awal, 6, 2)'), '=' , $bulan)
										->where(DB::raw('substr(tgl_lembur_awal, 1, 4)'), '=' , $tahun)->count();
			$jamlemburlibur = DB::table('tbl_pengajuan_lembur')
										->select(DB::raw('sum(lama_lembur) as lama'))
										->where('nik', $data->nik)
										->where('jenis_lembur','L')
										->where(DB::raw('substr(tgl_lembur_awal, 6, 2)'), '=' , $bulan)
										->where(DB::raw('substr(tgl_lembur_awal, 1, 4)'), '=' , $tahun)
										->groupBy('lama_lembur')
										->get();
			if(count($jamlemburlibur) > 0){
				foreach($jamlemburlibur as $jamlemburl){
					$jamll = $jamlemburl->lama;
				}
			}else{
				$jamll = 0;
			}					
			
			$jumlahlembur = "<tr>           
								<th colspan='7' rowspan='2'>Total Lembur Hari Kerja</th>
								<th rowspan='1'>Hari</th>
								<th rowspan='1'>Jam</th>
 
								<th colspan='6' rowspan='2'>Total Lembur Hari Libur</th>
								<th rowspan='1'>Hari</th>
								<th rowspan='1'>Jam</th>
							</tr>
							<tr>                       
								<td rowspan='1'>".$jumlahlemburkerja."</td>
								<td rowspan='1'>".$jamlk."</td>
								<td rowspan='1'>".$jumlahlemburlibur."</td>
								<td rowspan='1'>".$jamll."</td>
							</tr>
							<tr>                       
								<td colspan='18'></td>
							</tr>";	
			echo $hasil;
		}
		
		if(count($data_lembur) > 0){
			echo $jumlahlembur;
		}
		
	}
	
	public function getExport(Request $request){
		$nama_karyawan = $request->input('get_nama_karyawan');
		$kd_divisi = $request->input('get_div');
		$nik = $request->input('get_nik');
		$bulan = $request->input('get_bulan');
		$tahun = $request->input('get_tahun');
		$download = $bulan.'_'.$tahun;
		return Excel::download(new LemburExport($nik, $nama_karyawan, $kd_divisi, $bulan, $tahun), 'datalembur_'.$download.'.xlsx');
	}
	
	

}
