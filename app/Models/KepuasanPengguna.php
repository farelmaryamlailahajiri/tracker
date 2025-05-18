<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepuasanPengguna extends Model
{
    protected $table = 'kepuasan_pengguna';
    protected $fillable = [
        'tracer_id', 'pengguna_id', 'kerjasama_tim', 'keahlian_ti',
        'bahasa_asing', 'komunikasi', 'pengembangan_diri', 'kepemimpinan',
        'etos_kerja', 'kompentensi_yang_belum_dipenuhi', 'saran'
    ];

    public function tracer()
    {
        return $this->belongsTo(Tracer::class);
    }

    public function penggunaLulusan()
    {
        return $this->belongsTo(PenggunaLulusan::class, 'pengguna_id');
    }
}
