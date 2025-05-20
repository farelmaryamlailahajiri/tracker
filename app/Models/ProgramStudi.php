<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    protected $fillable = ['nama']; // Pastikan kolom ini ada

    public function alumnis()
    {
        return $this->hasMany(Alumni::class, 'program_studi_id');
    }
}
