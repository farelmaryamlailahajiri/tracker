<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lulusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_lulus',
        'jumlah_lulusan',
        'jumlah_lulusan_teracak',
        'rata_rata_waktu_tunggu',
    ];
}