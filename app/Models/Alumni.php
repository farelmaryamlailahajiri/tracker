<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    // Jika kolom timestamp tidak digunakan
    public $timestamps = false;

    // Jika kamu ingin mengatur kolom yang bisa diisi
    protected $fillable = ['id', 'nama', 'nim', 'program_studi_id', 'tahun_lulus']; // sesuaikan dengan tabelmu

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
