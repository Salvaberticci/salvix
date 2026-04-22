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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesa_id')->nullable()->constrained('mesas')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado', ['pendiente', 'cocina', 'listo', 'entregado', 'pagado', 'cancelado'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->decimal('total_usd', 10, 2)->default(0);
            $table->decimal('total_bs', 10, 2)->default(0);
            $table->decimal('tasa_bcv', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
