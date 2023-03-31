<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalShift extends Model
{
    protected $table = 'jadwal_shift';
    protected $fillable = ['nama_karyawan', 'nik', 'dept_id', 'tgl_shift', 'kode_schedule', 'jam_shift_awal', 'jam_shift_akhir', 
							'created_at', 'updated_at'];
}
