<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens';

    protected $fillable = [
        'nama',
        'no_telp',
        'email',
        'password'
    ];
}

