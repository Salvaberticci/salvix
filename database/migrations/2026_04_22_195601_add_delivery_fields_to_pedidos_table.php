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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('cliente_nombre')->nullable()->after('user_id');
            $table->string('cliente_telefono')->nullable()->after('cliente_nombre');
            $table->string('direccion')->nullable()->after('cliente_telefono');
            $table->string('tipo_entrega')->default('delivery')->after('direccion'); // delivery, retiro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['cliente_nombre', 'cliente_telefono', 'direccion', 'tipo_entrega']);
        });
    }
};
