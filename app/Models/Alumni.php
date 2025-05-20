<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $fillable = ['nama', 'nim', 'program_studi_id', 'tanggal_lulus'];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id'); 
    }

    public function tracer()
    {
        return $this->hasOne(Tracer::class);
    }
}
