<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HPcutibesar extends Model
{
    protected $table = 'hpcutibesar';
    protected $fillable = ['cutiIDB', 'isUserB', 'mulaiB', 'akhirB', 'istypeB', 'JumlahB', 'keteranganB', 
							'sebelumB', 'sesudahB', 'auditB'];
}
