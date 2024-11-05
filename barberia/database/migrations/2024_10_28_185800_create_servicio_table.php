<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('servicio')) {
            Schema::create('servicio', function (Blueprint $table) {
                $table->id('id_servicio');
                $table->string('nombre_servicio', 50)->unique();
                $table->string('descripcion_servicio', 255);
                $table->decimal('precio', 10, 2);
                $table->integer('duracion')->default(30);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
