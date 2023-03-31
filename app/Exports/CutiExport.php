<?php

namespace App\Exports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class CutiExport implements FromCollection
{
	public function __construct($kd_divisi, $startdate, $enddate)
    {
        $this->kd_divisi = $kd_divisi;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
    }
	
	public function collection()
    {
		return Cuti::where('kd_divisi', $this->kd_divisi)
					->whereBetween('tgl_pengajuan_cuti', [$this->startdate, $this->enddate])->get();
    }
	
}
