<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('barbero_servicio')) {
            Schema::create('barbero_servicio', function (Blueprint $table) {
                $table->unsignedBigInteger('id_usuario_barbero');
                $table->foreign('id_usuario_barbero')->references('id_usuario')->on('usuario')->onDelete('cascade')->onUpdate('cascade');
                
                $table->unsignedBigInteger('id_servicio');
                $table->foreign('id_servicio')->references('id_servicio')->on('servicio')->onDelete('cascade')->onUpdate('cascade');
                
                $table->primary(['id_usuario_barbero', 'id_servicio']); // Clave primaria compuesta
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('barbero_servicio');
    }
};
