<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['dept_id','nama','nik','userid','email','tgl_lahir','level','jabatan','direct_supervisor','next_higher_supervisor','shifting','ut','um','tgl_join','tgl_resign','status','remark','created_at','updated_at'];
    public function departement(){
    	return $this->belongsTo('App\Models\Departement','dept_id');
    }
}
