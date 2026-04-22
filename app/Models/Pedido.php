<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $guarded = [];

    public function detalle()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
