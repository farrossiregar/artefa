<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
	protected $table = 'tbl_pengajuan_cuti';
    protected $fillable = ['tgl_pengajuan_cuti', 'tgl_cuti_awal', 'tgl_cuti_akhir', 'jumlah_hari', 
							'jenis_cuti', 'jenis_cuti_detail', 'penjelasan_cuti', 
							'sisa_cuti_tahunan', 'sisa_cuti_besar', 'nama_karyawan', 
							'nik', 'kd_divisi', 'alamat', 'petugas_pengganti', 'app1', 'app2',  'app3', 
							'created_at','updated_at'];
}
