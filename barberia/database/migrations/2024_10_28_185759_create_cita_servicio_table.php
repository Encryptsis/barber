<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cita_servicio')) {
            Schema::create('cita_servicio', function (Blueprint $table) {
                $table->unsignedBigInteger('id_cita');
                $table->foreign('id_cita')->references('id_cita')->on('cita')->onDelete('cascade')->onUpdate('cascade');
                
                $table->unsignedBigInteger('id_servicio');
                $table->foreign('id_servicio')->references('id_servicio')->on('servicio')->onDelete('restrict')->onUpdate('cascade');
                
                $table->integer('cantidad')->default(1);
                $table->decimal('costo', 10, 2);
                $table->integer('duracion');
                $table->primary(['id_cita', 'id_servicio']); // Clave primaria compuesta
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cita_servicio');
    }
};
