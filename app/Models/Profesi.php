<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    protected $table = 'profesi';
    protected $fillable = ['nama_profesi', 'kategori'];

    public function tracers()
    {
        return $this->hasMany(Tracer::class);
    }
}
