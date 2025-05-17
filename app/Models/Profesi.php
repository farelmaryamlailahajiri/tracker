<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika nama model sesuai konvensi)
    protected $table = 'profesi';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_profesi',
        'kategori',
    ];

}
