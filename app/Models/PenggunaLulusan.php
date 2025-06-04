<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaLulusan extends Model
{
    use HasFactory;

    protected $table = 'pengguna_lulusan';
    protected $fillable = ['nama', 'jabatan', 'email', 'telepon', 'instansi_id', 'link_form'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    public function kepuasanPengguna()
    {
        return $this->hasOne(KepuasanPengguna::class, 'pengguna_id');
    }
    
    public function tracer()
    {
        return $this->hasOne(Tracer::class, 'pengguna_id');
    }

    
}