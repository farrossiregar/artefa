<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\ReportCuti;
use App\Models\Cuti;
use App\Models\Departement;
use Illuminate\Http\Request;
//use App\Exports\CutiExport;
use App\Exports\CutiExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use DB;

class ReportCutiController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
    public function indexReportCuti() {
		$action = '1';
		$startdate = '';
		$enddate = '';
		$kd_divisi = '';
		$departements = Departement::orderBy('id', 'ASC')->get();
        return view('admin.report.indexReportCuti', compact('startdate', 'enddate', 'kd_divisi', 'action', 'departements'));
    }
	
    public function getTable(Request $request){
		$nama_karyawan = $request->input('nama_karyawan');
		$kd_divisi = $request->input('kd_divisi');
		$startdate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
		$enddate = Carbon::parse($request->input('end_date'))->format('Y-m-d');

		if($nama_karyawan == ''){
			if($kd_divisi == ''){
			//	$filter = "a.nama_karyawan != ''";
				$filter = "nama_karyawan != ''";
			}else{
			//	$filter = "a.kd_divisi = '".$kd_divisi."' ";
				$filter = "kd_divisi = '".$kd_divisi."' ";
			}
		}else{
		//	$filter = "a.nama_karyawan = '".$nama_karyawan."' ";
			$filter = "nama_karyawan = '".$nama_karyawan."' ";
		}

		if($startdate != '' and $enddate != ''){
			$filterdate = ' and tgl_cuti_awal >= "'.$startdate.'" and tgl_cuti_akhir <= "'.$enddate.'" ';
		}else{
			if($startdate == '' or $enddate == ''){
				if($start_date == ''){
					$filterdate = 'and tgl_cuti_awal >= "'.date('Y-m-d').'" and tgl_cuti_akhir <= "'.$enddate.'" ';
				}else{
					$filterdate = 'and tgl_cuti_awal >= "'.$startdate.'" and tgl_cuti_akhir <= "'.date('Y-m-d').'"';
				}
			}else{
				$filterdate = '';
			}
		}

	
	/*	$data_cuti = DB::select('SELECT a.nik, 
										a.nama_karyawan,
										b.sisa_cuti_tahunan, 
										b.sisa_cuti_khusus, 
										b.sisa_cuti_besar,
										c.department, 
										c.unit, 
										GROUP_CONCAT(CONCAT(DATE_FORMAT(a.tgl_cuti_awal, "%d-%m-%Y")," s/d ", 
										DATE_FORMAT(a.tgl_cuti_akhir, "%d-%m-%Y")) ORDER BY a.tgl_pengajuan_cuti) AS tglcutidiambil
								FROM tbl_pengajuan_cuti a
									LEFT JOIN data_hak_cuti b ON a.nik = b.nik 
									LEFT JOIN departements c ON a.kd_divisi = c.id 
								WHERE '.$filter.' and a.app2 = "Y" '.$filterdate.'
								GROUP BY 	a.nik, 
											a.nama_karyawan, 
											b.sisa_cuti_tahunan, 
											b.sisa_cuti_khusus, 
											b.sisa_cuti_besar,
											c.department, 
											c.unit
								ORDER BY b.id, a.tgl_pengajuan_cuti, a.nik');	*/

			$data_cuti = DB::select('select * from tbl_pengajuan_cuti 
																where '.$filter.' 
																and app2 = "Y"
																'.$filterdate.'
																ORDER BY tgl_pengajuan_cuti');
		$no = 0;
		foreach($data_cuti as $data){
			$departements = Departement::where('id', $data->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}
			$kd_divisi = $department.' / '.$unit;
			$no = $no + 1;
			for($i = 0; $i < count($data_cuti); $i++){
				$hasil = '<tr >
							<td >'.$no.'</td>
							<td class=" ">'.$data->nik.'</td>
							<td class=" ">'.$data->nama_karyawan.'</td>
							<td class="center ">'.$kd_divisi.'</td>
							<td class="center ">'.$data->sisa_cuti_tahunan.'</td>
							<td class="center ">'.$data->sisa_cuti_besar.'</td>
							<td class="center ">'.$data->tgl_cuti_awal.'</td>
							<td class="center ">'.$data->tgl_cuti_akhir.'</td>
							<td class="center ">'.$data->penjelasan_cuti.'</td>
						</tr>';
			}
			echo $hasil;
		}
  }
	
	
	public function getExport(Request $request){
		$tgl_download =  Carbon::parse($request->input('tgl1'))->format('Ymd').'sd'. Carbon::parse($request->input('tgl2'))->format('Ymd');
		$nama_karyawan = $request->input('get_nama');
		$kd_divisi = $request->input('get_kd_divisi');
		$startdate = Carbon::parse($request->input('tgl1'))->format('Y-m-d');
		$enddate = Carbon::parse($request->input('tgl2'))->format('Y-m-d');
		return (new CutiExports($nama_karyawan, $kd_divisi, $startdate, $enddate))->download('datacuti_'.$tgl_download.'.xlsx');
	}

}
