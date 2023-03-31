<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lembur extends Model
{
    protected $table = 'tbl_pengajuan_lembur';
    protected $fillable = ['id', 'nama_karyawan', 'nik', 'kd_divisi', 'jabatan', 'tgl_lembur_awal', 'tgl_lembur_akhir', 'lama_lembur', 
							'keterangan_lembur', 'jenis_lembur', 'uang_makan', 'batas_lembur', 
							'tgl_pengajuan_lembur', 'app1', 'app2', 'app3', 'activation_token'];
}
