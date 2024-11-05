<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cita')) {
            Schema::create('cita', function (Blueprint $table) {
                $table->id('id_cita');
                $table->unsignedBigInteger('id_usuario_cliente');
                $table->foreign('id_usuario_cliente')->references('id_usuario')->on('usuario')->onDelete('cascade')->onUpdate('cascade');
                
                $table->date('fecha');
                $table->timestampTz('hora_reserva');
                $table->timestampTz('hora_termino')->nullable();
                $table->enum('metodo_pago', ['Tarjeta de crédito', 'Efectivo', 'Transferencia', 'Otro'])->nullable();
                $table->decimal('costo_total', 10, 2)->default(0.00);

                $table->unsignedBigInteger('id_usuario_barbero')->nullable();
                $table->foreign('id_usuario_barbero')->references('id_usuario')->on('usuario')->onDelete('set null')->onUpdate('cascade');
                
                $table->decimal('anticipo', 10, 2)->default(0.00);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
