<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstNonshiftSchedules extends Model
{
    protected $table = 'mst_nonshift_schedules';
    protected $fillable = ['code','days','time_schedule_awal','time_schedule_akhir','sabtu_masuk','created_at','updated_at'];
}
