<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;

class CatalogoController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['productos' => function($q) {
            $q->where('disponible', true)->orderBy('orden');
        }])->where('activa', true)->orderBy('orden')->get();

        return view('catalogo.index', compact('categorias'));
    }
}
