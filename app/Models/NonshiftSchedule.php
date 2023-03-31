<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonshiftSchedule extends Model
{
    protected $table = 'nonshift_schedules';
    protected $fillable = ['nik','dept','date','schedule_code','remark','created_at','updated_at'];
}
