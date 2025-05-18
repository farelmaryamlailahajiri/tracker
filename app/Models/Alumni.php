<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    // Jika kamu ingin mengatur kolom yang bisa diisi
    protected $fillable = ['nama', 'nim', 'program_studi_id', 'tahun_lulus']; // sesuaikan dengan tabelmu

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tracer()
    {
        return $this->hasOne(Tracer::class);
    }
}
