<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $guarded = [];

    protected $casts = [
        'config' => 'array',
        'es_activo' => 'boolean'
    ];
}
