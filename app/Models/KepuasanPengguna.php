<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepuasanPengguna extends Model
{
    use HasFactory;

    // Tetap pertahankan kedua opsi tabel
    protected $table = 'kepuasan_pengguna'; // Untuk kompatibilitas dengan kode lama
    protected $newTable = 'tracer_study_jti_kepuasan_pengguna'; // Untuk tabel baru

    protected $fillable = [
        'tracer_id', 'pengguna_id', 'kerjasama_tim', 'keahlian_ti',
        'bahasa_asing', 'komunikasi', 'pengembangan_diri', 'kepemimpinan',
        'etos_kerja', 'kompetensi_yang_belum_dipenuhi', 'saran'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.use_new') ? $this->newTable : $this->table;
    }

    public function tracer()
    {
        return $this->belongsTo(Tracer::class);
    }

    public function penggunaLulusan()
    {
        return $this->belongsTo(PenggunaLulusan::class, 'pengguna_id');
    }
}