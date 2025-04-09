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
        Schema::table('unidades', function (Blueprint $table) {
            $table->string('observaciones', 255)->nullable(); // Nueva columna para observaciones
            $table->integer('estado_de_fuerza')->default(0)->after('municipio_id'); // Nueva columna para estado de fuerza
            $table->integer('vehiculos')->default(0)->after('estado_de_fuerza'); // Nueva columna para vehículos
            $table->foreignId('encargado_id')->nullable()->constrained('elementos')->onDelete('set null')->after('vehiculos'); // Relación con elementos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidades', function (Blueprint $table) {
            $table->dropColumn('estado_de_fuerza');
            $table->dropColumn('vehiculos');
            $table->dropForeign(['encargado_id']);
            $table->dropColumn('encargado_id');
        });
    }
};