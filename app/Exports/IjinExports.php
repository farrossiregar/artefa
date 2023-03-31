<?php

namespace App\Exports;

use App\Models\Ijin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class IjinExports implements FromView
{
	use Exportable;
	
	public function __construct($nama_karyawan, $kd_divisi, $startdate, $enddate)
    {
        $this->nama_karyawan = $nama_karyawan;
        $this->kd_divisi = $kd_divisi;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
    }
	
	public function view(): View
    {
    	if($this->nama_karyawan == ''){
			$nama = "a.nama_karyawan != '' ";
			if($this->kd_divisi == ''){
				$div = "and a.kd_divisi != '' ";
			}else{
				$div = "and a.kd_divisi = '".$this->kd_divisi."'";
			}
		}else{
			$nama = "a.nama_karyawan = '".$this->nama_karyawan."' ";
			$div = "";
		}

		if($this->startdate != '' and $this->enddate != ''){
			$filterdate = 'and tgl_ijin_awal >= "'.$this->startdate.'" and tgl_ijin_akhir <= "'.$this->enddate.'" order by tgl_pengajuan_ijin desc';
		}else{
			if($this->startdate == ''){
				$filterdate = 'and tgl_ijin_akhir <= "'.$this->enddate.'" order by tgl_pengajuan_ijin desc';
			}else if($this->enddate == ''){
				$filterdate = 'and tgl_ijin_awal >= "'.$start_date.'" order by tgl_pengajuan_ijin desc';
			}else  if($this->startdate == '' and $this->enddate == ''){
				$filterdate = 'order by tgl_pengajuan_ijin desc';
			}else{
				$filterdate = 'order by tgl_pengajuan_ijin desc';
			}
		}
        
        return view('admin.ijin.reportijintemplate', [
			'ijin' => Ijin::orderBy('id', 'DESC')->get()
        ]);
    }
	
}