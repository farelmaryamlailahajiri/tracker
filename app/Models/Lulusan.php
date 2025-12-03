<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lulusan extends Model
{
    use HasFactory;
    
    protected $table = 'pengguna_lulusan';

    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'telepon',
        'instansi_id',
    ];
}
