<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Ijin;
use App\Models\Departement;

class IjinVerifikasiPemohon extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($subject, $atasan, $id, $ijin_data)
    {
        $this->subject = $subject;
        $this->atasan = $atasan;
        $this->id = $id;
        $this->ijin_data = $ijin_data;
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
        $ijin_data = $this->ijin_data;
        foreach($ijin_data as $data){
            $nama_karyawan = $data->nama_karyawan;
            $nik = $data->nik;
            $kd_divisi = $data->kd_divisi;
            $jabatan = $data->jabatan;
            $tgl_pengajuan_ijin = $data->tgl_pengajuan_ijin;
            $tgl_jam_ijin_awal = $data->tgl_ijin_awal;
            $tgl_jam_ijin_akhir = $data->tgl_ijin_akhir;
            $keterangan_ijin = $data->keterangan_ijin;
            $app1 = $data->app1;
            $app2 = $data->app2;
            $app3 = $data->app3;
        }

        $departements = Departement::where('id', $kd_divisi)->get();
		foreach($departements as $dept){
			$department = $dept->department;
			$unit = $dept->unit;
		}	
		$divisi = $department.' / '.$unit;

        $link = "http://127.0.0.1:8000/";
        
        return $this->view('emails.ijinverifikasipemohon', compact('subject', 'nama_karyawan', 'nik', 'divisi', 
                                                        'jabatan', 'tgl_pengajuan_ijin','tgl_jam_ijin_awal',
                                                        'tgl_jam_ijin_akhir', 'keterangan_ijin', 'app1', 'app2', 'app3',
                                                        'atasan', 'id'));

    }


}
