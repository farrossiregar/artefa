<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hpcuti extends Model
{
    protected $table = 'hpcuti';
    protected $fillable = ['cutiID', 'isUser', 'mulai', 'akhir', 'istype', 'jumlah', 'keterangan', 
							'sebelum', 'sesudah', 'audit'];
}
