<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Lembur;
use App\Models\Departement;

class LemburVerifikasiPemohon extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($subject, $atasan, $id, $lembur_data)
    {
        $this->subject = $subject;
        $this->atasan = $atasan;
        $this->id = $id;
        $this->lembur_data = $lembur_data;
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
        $lembur_data = $this->lembur_data;
        foreach($lembur_data as $lemburdata){
            $nama_karyawan = $lemburdata->nama_karyawan;
            $nik = $lemburdata->nik;
            $kd_divisi = $lemburdata->kd_divisi;
            $jabatan = $lemburdata->jabatan;
            $tgl_pengajuan_lembur = $lemburdata->tgl_pengajuan_lembur;
            $tgl_lembur_awal = $lemburdata->tgl_lembur_awal;
            $tgl_lembur_akhir = $lemburdata->tgl_lembur_akhir;
            $lama_lembur = $lemburdata->lama_lembur;
            $keterangan_lembur = $lemburdata->keterangan_lembur;
            $app1 = $lemburdata->app1;
            $app2 = $lemburdata->app2;
            $app3 = $lemburdata->app3;
        }

        $departements = Departement::where('id', $kd_divisi)->get();
		foreach($departements as $dept){
			$department = $dept->department;
			$unit = $dept->unit;
        }	
        $divisi = $department.' / '.$unit;

        $link = "http://127.0.0.1:8000/";
        
        return $this->view('emails.lemburverifikasipemohon', compact('subject', 'atasan', 'id', 'lembur_data',
                                                                'nama_karyawan', 'nik', 'divisi', 
                                                                'jabatan', 'tgl_pengajuan_lembur','tgl_lembur_awal',
                                                                'tgl_lembur_akhir', 'lama_lembur', 'keterangan_lembur',
                                                                'app1', 'app2', 'app3'
                                                        ));

    /*    return $this->from('farros.jackson@gmail.com', 'Farros Shier')
                    ->view('emails.verifikasi2')
                    ->with([
                            'name' => 'Joe Doe',
                            'link' => 'http://www.bryceandy.com'
                      ])
                      ->attach(public_path('/images').'/demo.jpg', [
                              'as' => 'demo.jpg',
                              'mime' => 'image/jpeg',
                      ]);   */

    }


}
