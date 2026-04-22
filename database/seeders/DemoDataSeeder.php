<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Pago;
use App\Models\MovimientoInventario;
use App\Models\CuentaBancaria;
use App\Models\Ingrediente;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categorías Editoriales
        $catPizza = Categoria::create(['nombre' => 'Pizzas de Autor', 'orden' => 4, 'descripcion' => 'Masa madurada 48h con ingredientes DOP.']);
        $catPostre = Categoria::create(['nombre' => 'Dolci & Postres', 'orden' => 5, 'descripcion' => 'Finales dulces con el toque de la Nonna.']);
        $catVino = Categoria::create(['nombre' => 'Bodega & Vinos', 'orden' => 6, 'descripcion' => 'Selección exclusiva de viñedos italianos.']);

        // 2. Ingredientes para Inventario
        $ing1 = Ingrediente::create(['nombre' => 'Harina 00', 'unidad' => 'kg', 'stock_actual' => 50, 'stock_minimo' => 10, 'costo_usd' => 1.20]);
        $ing2 = Ingrediente::create(['nombre' => 'Queso Mozzarella', 'unidad' => 'kg', 'stock_actual' => 20, 'stock_minimo' => 5, 'costo_usd' => 8.50]);
        $ing3 = Ingrediente::create(['nombre' => 'Tomate San Marzano', 'unidad' => 'kg', 'stock_actual' => 30, 'stock_minimo' => 10, 'costo_usd' => 3.00]);

        // 3. Movimientos de Inventario
        MovimientoInventario::create(['ingrediente_id' => $ing1->id, 'cantidad' => 50, 'tipo' => 'entrada', 'motivo' => 'Carga inicial de demo']);
        MovimientoInventario::create(['ingrediente_id' => $ing2->id, 'cantidad' => 20, 'tipo' => 'entrada', 'motivo' => 'Carga inicial de demo']);
        MovimientoInventario::create(['ingrediente_id' => $ing3->id, 'cantidad' => 30, 'tipo' => 'entrada', 'motivo' => 'Carga inicial de demo']);

        // 4. Productos Premium
        $p1 = Producto::create([
            'categoria_id' => $catPizza->id,
            'nombre' => 'Pizza Margherita DOP',
            'descripcion' => 'Pomodoro San Marzano, Mozzarella di Bufala, Albahaca fresca y AOVE.',
            'precio_usd' => 14.00,
            'orden' => 1
        ]);
        
        $p2 = Producto::create([
            'categoria_id' => $catPizza->id,
            'nombre' => 'Pizza Tartufo',
            'descripcion' => 'Crema de trufa negra, champiñones, huevo de codorniz y pecorino.',
            'precio_usd' => 18.50,
            'orden' => 2
        ]);

        Producto::create([
            'categoria_id' => $catPostre->id,
            'nombre' => 'Tiramisu Classico',
            'descripcion' => 'Capas de mascarpone, savoiardi bañados en espresso y cacao puro.',
            'precio_usd' => 7.50,
            'orden' => 1
        ]);

        Producto::create([
            'categoria_id' => $catVino->id,
            'nombre' => 'Chianti Classico Riserva',
            'descripcion' => 'Copa de vino tinto con notas de frutos rojos y roble.',
            'precio_usd' => 9.00,
            'orden' => 1
        ]);

        // 5. Pedidos y Pagos (Simular flujo)
        $tasa = 48.12; 

        // Pedido 1: Entregado y Pagado
        $ped1 = Pedido::create([
            'estado' => 'entregado',
            'total_usd' => 21.50,
            'total_bs' => 21.50 * $tasa,
            'tasa_bcv' => $tasa,
            'created_at' => now()->subHours(5)
        ]);
        DetallePedido::create(['pedido_id' => $ped1->id, 'producto_id' => $p1->id, 'cantidad' => 1, 'precio_usd' => 14.00, 'subtotal_usd' => 14.00]);
        
        $cuenta = CuentaBancaria::first();
        Pago::create([
            'pedido_id' => $ped1->id,
            'cuenta_bancaria_id' => $cuenta ? $cuenta->id : null,
            'metodo' => 'Pago Móvil',
            'monto_usd' => 21.50,
            'monto_bs' => 21.50 * $tasa,
            'tasa_bcv' => $tasa,
            'referencia' => 'REF0019283',
            'estado' => 'confirmado'
        ]);

        // Pedido 2: En Cocina
        $ped2 = Pedido::create([
            'estado' => 'cocina',
            'total_usd' => 18.50,
            'total_bs' => 18.50 * $tasa,
            'tasa_bcv' => $tasa,
            'created_at' => now()->subHours(2)
        ]);
        DetallePedido::create(['pedido_id' => $ped2->id, 'producto_id' => $p2->id, 'cantidad' => 1, 'precio_usd' => 18.50, 'subtotal_usd' => 18.50]);

        // Pedido 3: Pendiente
        $ped3 = Pedido::create([
            'estado' => 'pendiente',
            'total_usd' => 14.00,
            'total_bs' => 14.00 * $tasa,
            'tasa_bcv' => $tasa,
            'created_at' => now()->subMinutes(30)
        ]);
        DetallePedido::create(['pedido_id' => $ped3->id, 'producto_id' => $p1->id, 'cantidad' => 1, 'precio_usd' => 14.00, 'subtotal_usd' => 14.00]);
    }
}
