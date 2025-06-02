<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaLulusan extends Model
{
    use HasFactory;

    protected $table = 'pengguna_lulusan';
    protected $fillable = ['alumni_id','nama', 'jabatan', 'email', 'telepon', 'instansi_id'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function kepuasanPengguna()
    {
        return $this->hasMany(KepuasanPengguna::class, 'pengguna_id');
    }
}