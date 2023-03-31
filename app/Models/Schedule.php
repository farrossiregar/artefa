<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['code','dept_id','time_schedule_awal','time_schedule_akhir','uang_makan','created_at','updated_at'];

    public function department(){
    	return $this->belongsTo('App\Models\Departement','dept_id');
    }
}
