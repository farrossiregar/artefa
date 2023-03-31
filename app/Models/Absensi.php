<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['date','nik','dept_id','wjm','wjk','mrly','mlate','mleft','prly','plate','wkhr','keterangan','year','tahun','created_at','updated_at'];
}
