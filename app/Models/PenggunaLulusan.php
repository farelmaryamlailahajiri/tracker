<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaLulusan extends Model
{
    protected $table = 'pengguna_lulusan';
    protected $fillable = ['nama', 'jabatan', 'email', 'telepon', 'instansi_id'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function kepuasanPengguna()
    {
        return $this->hasMany(KepuasanPengguna::class);
    }
}
