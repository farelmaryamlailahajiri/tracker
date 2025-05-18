<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracer extends Model
{
   protected $table = 'tracer';
   protected $fillable = [
        'alumni_id', 'profesi_id', 'instansi_id', 'email', 'no_hp', 'tahun_lulus',
        'tanggal_pertama_kerja', 'tanggal_mulai_kerja_saat_ini', 
        'lokasi_kerja', 'waktu_tunggu'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function profesi()
    {
        return $this->belongsTo(Profesi::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function kepuasanPengguna()
    {
        return $this->hasMany(KepuasanPengguna::class);
    }
}
