<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ijin extends Model
{
    protected $table = 'tbl_pengajuan_ijin';
    protected $fillable = ['nama_karyawan', 'nik', 'kd_divisi', 'jabatan', 'tgl_ijin_awal', 'tgl_ijin_akhir', 'keterangan_ijin',
							'tindak_lanjut', 'tgl_pengajuan_ijin'];
}
