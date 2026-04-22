<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $guarded = [];

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
