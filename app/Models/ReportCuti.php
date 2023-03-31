<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCuti extends Model
{
    protected $table = 'tbl_pengajuan_cuti';
    protected $fillable = ['hour','sequence_no','created_at','updated_at'];
}
