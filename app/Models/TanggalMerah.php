<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalMerah extends Model
{
	protected $table = 'tanggal_merah';
	protected $fillable = ['date','description','keterangan','created_at','updated_at'];
}
