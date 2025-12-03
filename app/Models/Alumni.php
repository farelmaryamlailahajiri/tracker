<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    // Tetap pertahankan kedua opsi tabel
    protected $table = 'alumni'; // Untuk kompatibilitas dengan kode lama
    protected $newTable = 'tracer_study_jti_alumni'; // Untuk tabel baru

    protected $fillable = ['nama', 'nim', 'program_studi_id', 'tanggal_lulus', 'token', 'no_tlpn'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('database.use_new') ? $this->newTable : $this->table;
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id'); 
    }

    public function tracer()
    {
        return $this->hasOne(Tracer::class);
    }
}