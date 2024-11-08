<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si el tipo ya existe
        if (!DB::select("SELECT 1 FROM pg_type WHERE typname = 'metodo_pago_enum'")) {
            DB::statement("CREATE TYPE metodo_pago_enum AS ENUM ('Tarjeta de crédito', 'Efectivo', 'Transferencia', 'Otro')");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar el tipo enumerado metodo_pago_enum en PostgreSQL
        DB::statement("DROP TYPE IF EXISTS metodo_pago_enum");
    }
};
