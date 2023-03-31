<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstJabatan extends Model
{
    protected $table = 'mst_jabatan';
    protected $fillable = ['name','created_at', 'updated_at'];
}
