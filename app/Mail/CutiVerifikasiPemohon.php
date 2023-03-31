<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Cuti;
use App\Models\Departement;

class CutiVerifikasiPemohon extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($subject, $atasan, $id, $cuti_data)
    {
        $this->subject = $subject;
        $this->atasan = $atasan;
        $this->id = $id;
        $this->cuti_data = $cuti_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->subject;
        $atasan = $this->atasan;
        $id = $this->id;
        $cuti_data = $this->cuti_data;
        foreach($cuti_data as $datacuti){
            $nama_karyawan = $datacuti->nama_karyawan;
            $nik = $datacuti->nik;
            $kd_divisi = $datacuti->kd_divisi;
            $jabatan = $datacuti->jabatan;
            $tgl_pengajuan_cuti = $datacuti->tgl_pengajuan_cuti;
            $tgl_cuti_awal = $datacuti->tgl_cuti_awal;
            $tgl_cuti_akhir = $datacuti->tgl_cuti_akhir;
            $jumlah_hari = $datacuti->jumlah_hari;
            $penjelasan_cuti = $datacuti->penjelasan_cuti;
            $app1 = $datacuti->app1;
            $app2 = $datacuti->app2;
            $app3 = $datacuti->app3;
        }

        $departements = Departement::where('id', $kd_divisi)->get();
		foreach($departements as $dept){
			$department = $dept->department;
			$unit = $dept->unit;
		}	
		$divisi = $department.' / '.$unit;

        $link = "http://127.0.0.1:8000/";
        
        return $this->view('emails.cutiverifikasipemohon', compact('subject', 'atasan', 'id', 'cuti_data', 
                                                            'nama_karyawan', 'nik', 'divisi', 
                                                            'jabatan', 'tgl_pengajuan_cuti','tgl_cuti_awal',
                                                            'tgl_cuti_akhir', 'jumlah_hari', 'penjelasan_cuti',
                                                            'app1', 'app2', 'app3'));


    }


}
