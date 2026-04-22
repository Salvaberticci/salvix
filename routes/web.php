<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('catalogo.index');
});

Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');

// Wizard Publico
Route::get('/pagar', [\App\Http\Controllers\PagoController::class, 'create'])->name('pagos.wizard');
Route::post('/pagar/procesar', [\App\Http\Controllers\PagoController::class, 'store'])->name('pagos.procesar');

// IA API
Route::post('/api/chat', [\App\Http\Controllers\Api\ChatApiController::class, 'sendMessage']);

// Background Sync API
Route::get('/api/tasa-sync', [\App\Http\Controllers\ConfiguracionController::class, 'syncBcv']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas protegidas genéricas
    Route::resource('pedidos', PedidoController::class);
    Route::resource('pagos', \App\Http\Controllers\PagoController::class);
    
    // Rutas protegidas solo Admin
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('inventario', InventarioController::class);
    Route::resource('cuentabancarias', \App\Http\Controllers\CuentaBancariaController::class);
    
    Route::get('/configuracion', [\App\Http\Controllers\ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::put('/configuracion', [\App\Http\Controllers\ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::post('/configuracion/sync-bcv', [\App\Http\Controllers\ConfiguracionController::class, 'syncBcv'])->name('configuracion.sync_bcv');
    
    Route::get('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'index'])->name('chatbot.index');
    Route::get('/chatbot/{id}', [\App\Http\Controllers\ChatbotController::class, 'show'])->name('chatbot.show');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
