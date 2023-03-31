<?php

namespace App\Exports;

use App\Models\Cuti;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CutiExports implements FromView
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
			if($this->kd_divisi == ''){
				$filter = "nama_karyawan != ''";
			}else{
				$filter = "kd_divisi = '".$this->kd_divisi."' ";
			}
		}else{
			$filter = "nama_karyawan = '".$this->nama_karyawan."' ";
		}


		if($this->startdate != '' and $this->enddate != ''){
			$filterdate = ' and tgl_cuti_awal >= "'.$this->startdate.'" and tgl_cuti_akhir <= "'.$this->enddate.'" ';
		}else{
			if($startdate == '' or $enddate == ''){
				if($this->start_date == ''){
					$filterdate = 'and tgl_cuti_awal >= "'.date('Y-m-d').'" and tgl_cuti_akhir <= "'.$this->enddate.'" ';
				}else{
					$filterdate = 'and tgl_cuti_awal >= "'.$this->startdate.'" and tgl_cuti_akhir <= "'.date('Y-m-d').'"';
				}
			}else{
				$filterdate = '';
			}
        }
        
        
        return view('admin.cuti.reportcutitemplate', [
		/*	'cuti' => DB::select('SELECT a.nik, 
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
                                    WHERE '.$filter.' and a.app3 = "Y" '.$filterdate.'
                                    GROUP BY 	a.nik, 
                                                a.nama_karyawan, 
                                                b.sisa_cuti_tahunan, 
                                                b.sisa_cuti_khusus, 
                                                b.sisa_cuti_besar, 
                                                c.department, 
                                                c.unit
                                    ORDER BY b.id, a.tgl_pengajuan_cuti, a.nik')    */
            'cuti' => DB::select('select *, (select unit from departements where id = "'.$this->kd_divisi.'" ) as unit 
                                    from tbl_pengajuan_cuti 
                                    where '.$filter.' 
                                    and app2 = "Y"
                                    '.$filterdate.'
                                    ORDER BY tgl_pengajuan_cuti')
        ]);
    }
	
}