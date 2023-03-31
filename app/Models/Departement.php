<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';
    protected $fillable = ['department','unit','shift','created_at','updated_at'];
}
