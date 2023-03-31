<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datahakcuti extends Model
{
	protected $table = 'data_hak_cuti';
	protected $fillable = ['tahun', 'nama_karyawan', 'nik', 'sisa_cuti_tahunan', 'sisa_cuti_khusus', 'sisa_cuti_besar','created_at','updated_at'];
}
