<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('usuario', 20)->unique();
            $table->string('clave');
            $table->string('nombre_completo', 100);
            $table->string('telefono', 15)->unique();
            $table->string('foto_perfil', 100)->nullable();
            $table->boolean('activo')->default(true);

            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id_rol')->on('rol')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
    
};
