<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    use HasFactory;

    // Tetap pertahankan kedua opsi tabel
    protected $table = 'profesi'; // Untuk kompatibilitas dengan kode lama
    protected $newTable = 'tracer_study_jti_profesi'; // Untuk tabel baru

    protected $fillable = ['nama_profesi', 'kategori'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.use_new') ? $this->newTable : $this->table;
    }

    public function tracers()
    {
        return $this->hasMany(Tracer::class);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Tambahan untuk kompatibilitas
    public function getNamaAttribute()
    {
        return $this->nama_profesi;
    }
}