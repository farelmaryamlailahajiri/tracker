<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
    ];

    protected $hidden = [
        'password',
    ];
}