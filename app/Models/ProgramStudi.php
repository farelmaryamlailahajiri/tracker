<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    // Jika kolom timestamp tidak digunakan
    public $timestamps = false;

    protected $fillable = ['id', 'nama']; // sesuaikan dengan tabelmu

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'program_studi_id');
    }
}
