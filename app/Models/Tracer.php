<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracer extends Model
{
    use HasFactory;

    // Tetap pertahankan kedua opsi tabel
    protected $table = 'tracer'; // Untuk kompatibilitas dengan kode lama
    protected $newTable = 'tracer_study_jti_tracer'; // Untuk tabel baru

    protected $fillable = [
        'alumni_id', 'instansi_id', 'profesi_id', 'pengguna_id', 'email', 'no_hp', 'tahun_lulus',
        'tanggal_pertama_kerja', 'tanggal_mulai_kerja_saat_ini', 
        'lokasi_kerja', 'waktu_tunggu'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.use_new') ? $this->newTable : $this->table;
    }

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

    public function pengguna()
    {
        return $this->belongsTo(PenggunaLulusan::class, 'pengguna_id');
    }

}