<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuenta_bancarias')->onDelete('set null');
            $table->string('metodo');
            $table->decimal('monto_usd', 10, 2)->default(0);
            $table->decimal('monto_bs', 10, 2)->default(0);
            $table->decimal('tasa_bcv', 8, 2)->default(0);
            $table->string('referencia')->nullable();
            $table->string('comprobante_imagen')->nullable();
            $table->enum('estado', ['pendiente', 'confirmado', 'rechazado'])->default('pendiente');
            $table->text('notas_verificacion')->nullable();
            $table->foreignId('verificado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verificado_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
