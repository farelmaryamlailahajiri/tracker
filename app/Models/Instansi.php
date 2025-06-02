<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    // Tetap pertahankan kedua opsi tabel
    protected $table = 'instansi'; // Untuk kompatibilitas dengan kode lama
    protected $newTable = 'tracer_study_jti_instansi'; // Untuk tabel baru

    protected $fillable = ['nama_instansi', 'jenis_instansi', 'skala', 'lokasi'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.use_new') ? $this->newTable : $this->table;
    }

    public function tracers()
    {
        return $this->hasMany(Tracer::class);
    }

    public function penggunaLulusan()
    {
        return $this->hasMany(PenggunaLulusan::class, 'instansi_id');
    }
}