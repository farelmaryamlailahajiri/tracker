<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = ['nama_instansi', 'jenis_instansi', 'skala', 'lokasi'];

    public function tracers()
    {
        return $this->hasMany(Tracer::class);
    }

    public function penggunaLulusan()
    {
        return $this->hasMany(PenggunaLulusan::class);
    }
}
