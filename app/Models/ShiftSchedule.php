<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    protected $table = 'shift_schedules';
    protected $fillable = ['nik','dept','date','schedule_code','created_at','updated_at'];
}
