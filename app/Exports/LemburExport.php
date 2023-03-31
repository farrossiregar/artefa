<?php


namespace App\Exports;

use App\Models\Lembur;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class LemburExport implements FromView
{
	use Exportable;
	
	public function __construct($nik, $nama_karyawan, $kd_divisi, $bulan, $tahun)
    {
		$this->nik = $nik;
		$this->nama_karyawan = $nama_karyawan;
		$this->kd_divisi = $kd_divisi;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }
	
	public function view(): View
    {

		if($this->nik == ''){
			if($this->kd_divisi == ''){
				$filter1 = "nik != ''";
				$filter2 = "a.nik != ''";
			}else{
				$filter1 = "dept_id = '".$this->kd_divisi."' ";
				$filter2 = "a.kd_divisi = '".$this->kd_divisi."' ";
			}
		}else{
			$filter1 = "nik = '".$this->nik."' ";
			$filter2 = "a.nik = '".$this->nik."' ";
		}

		if($this->bulan != ''){
			$filterbulan = "and substring(a.tgl_lembur_awal, 6, 2) = '".$this->bulan."'";
		}else{
			$filterbulan = "and substring(a.tgl_lembur_awal, 6, 2) != ''";
		}

		if($this->tahun != ''){
			$filtertahun = "and substring(a.tgl_lembur_awal, 1, 4) = '".$this->tahun."'";
		}else{
			$filtertahun = "and substring(a.tgl_lembur_awal, 1, 4) != ''";
		}

        return view('admin.lembur.reportlemburtemplate', [
		
									
		/*	'lembur' => DB::select("SELECT 
									(CASE
									WHEN C.LEVEL = 'Non Staff' THEN (SELECT TIME_SCHEDULE_AWAL FROM shift_schedules A LEFT JOIN schedules B ON A.DEPT = B.DEPT_ID WHERE A.DEPT = A.kd_divisi )
									ELSE
									(SELECT CONCAT(WJM, ':00') FROM absensi WHERE ".$filternik1." ".$filterdiv1." AND DATE = SUBSTRING(A.TGL_LEMBUR_AWAL, 1, 11))
									END) AS mulai_shift,
									(CASE
									WHEN C.LEVEL = 'Non Staff' THEN (SELECT TIME_SCHEDULE_AKHIR FROM shift_schedules A LEFT JOIN schedules B ON A.DEPT = B.DEPT_ID WHERE A.DEPT = A.kd_divisi )
									ELSE
									(SELECT CONCAT(WJK, ':00') FROM absensi WHERE ".$filternik1." ".$filterdiv1." AND DATE = SUBSTRING(A.TGL_LEMBUR_AWAL, 1, 11))
									END) AS selesai_shift,
									A.TGL_LEMBUR_AWAL, A.TGL_LEMBUR_AKHIR,
									(SELECT WJM FROM absensi WHERE ".$filternik1." ".$filterdiv1." AND DATE = SUBSTRING(A.TGL_LEMBUR_AWAL, 1, 11)) AS wjm,
									(SELECT WJK FROM absensi WHERE ".$filternik1." ".$filterdiv1." AND DATE = SUBSTRING(A.TGL_LEMBUR_AWAL, 1, 11)) AS wjk,

									A.*, C.*
									FROM tbl_pengajuan_lembur A
									LEFT JOIN employees C
									ON C.NIK = A.NIK
									WHERE ".$filternik2." ".$filterdiv2."
									AND SUBSTRING(A.TGL_PENGAJUAN_LEMBUR, 6, 2) = '".$this->bulan."'
									AND SUBSTRING(A.TGL_PENGAJUAN_LEMBUR, 1, 4) = '".$this->tahun."'
									")	*/
			'lembur' => DB::select("
									select 
										a.nama_karyawan,a.nik,c.unit,a.kd_divisi,a.jenis_lembur,a.batas_lembur,
										a.tgl_lembur_awal,a.tgl_lembur_akhir,b.wjm,b.wjk,a.lama_lembur,
										a.keterangan_lembur,a.app1,a.app2,d.shifting 
									from tbl_pengajuan_lembur a 
									left join absensi b on a.nik=b.nik 
									left join departements c ON a.kd_divisi = c.id 
									left join employees d ON d.nik = a.nik
									where ".$filter2."
										AND SUBSTRING(a.tgl_lembur_awal, 6, 2) = '".$this->bulan."' 
										AND SUBSTRING(a.tgl_lembur_awal, 1, 4) = '".$this->tahun."' 
										AND SUBSTRING(b.date, 9,2) = SUBSTRING(a.tgl_lembur_awal, 9, 2) 
										AND SUBSTRING(b.date, 6,2) = SUBSTRING(a.tgl_lembur_awal, 6, 2) 
										AND SUBSTRING(b.date, 1,4) = SUBSTRING(a.tgl_lembur_awal, 1, 4)")
        ]);
    }
	
}
