<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\ReportIjin;
use App\Models\Ijin;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Exports\IjinExports;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use DB;

class ReportIjinController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
    public function indexReportIjin() {
		$action = '1';
		$startdate = '';
		$enddate = '';
		$kd_divisi = '';
		$departements = Departement::orderBy('id', 'ASC')->get();
        return view('admin.report.indexReportIjin', compact('startdate', 'enddate', 'kd_divisi', 'action', 'departements'));
    }
	
    public function getTable(Request $request){
		
		$nama_karyawan = $request->input('nama_karyawan');
		$dept_id = $request->input('dept_id');
		$start_date = $request->input('start_date');
		$end_date = $request->input('end_date');

		if($nama_karyawan == ''){
			if($dept_id == ''){
				$dataijin = Ijin::orderBy('tgl_pengajuan_ijin', 'DESC')->get();
			}else{
				$dataijin = Ijin::where('kd_divisi', $dept_id)->orderBy('tgl_pengajuan_ijin', 'DESC')->get();
			}
		}else{
			$dataijin = Ijin::where('nama_karyawan', $nama_karyawan)->orderBy('tgl_pengajuan_ijin', 'DESC')->get();
		}

		foreach($dataijin as $data){
			$no = 0;
			$departements = Departement::where('id', $data->kd_divisi)->get();
			foreach($departements as $dept){
				$department = $dept->department;
				$unit = $dept->unit;
			}	
			$divisi = $department.' / '.$unit;
			if($data->app1 == ''){
				$status = 'Belum diproses';
			}else{
				if($data->app1 == 'Y'){
					if($data->app2 == ''){
						$status = 'Disetujui App1';
					}else{
						if($data->app2 == 'Y'){
							if($data->app3 == ''){
								$status = 'Disetujui App2';
							}else{
								if($data->app3 == 'Y'){
									$status = 'Disetujui App3';
								}else{
									$status = 'Tidak disetujui App3';
								}
							}
						}else{
							$status = 'Tidak disetujui App2';
						}
					}
				}else{
					$status = 'Tidak disetujui App1';
				}
			}
			$no = 0;
			for($i = 0; $i < count($dataijin); $i++){
				$no  = $no + 1;
				$hasil = "	<tr>
								<td>".$no."</td>
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
	
	
	public function getExport(Request $request){
		$tgl_download =  Carbon::parse($request->input('tgl1'))->format('Ymd').'sd'. Carbon::parse($request->input('tgl2'))->format('Ymd');
		$nama_karyawan = $request->input('get_nama');
		$kd_divisi = $request->input('get_kd_divisi');
		$startdate = Carbon::parse($request->input('tgl1'))->format('Y-m-d');
		$enddate = Carbon::parse($request->input('tgl2'))->format('Y-m-d');
		return (new IjinExports($nama_karyawan, $kd_divisi, $startdate, $enddate))->download('dataijin_'.$tgl_download.'.xlsx');
		
	}

}
