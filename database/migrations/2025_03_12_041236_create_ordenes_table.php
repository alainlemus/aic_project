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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id(); // 'id' como integer auto_increment PRIMARY KEY
            $table->string('nombre', 255);
            $table->enum('status', ['RECIBIDO', 'CUMPLIDO', 'INFORMADO', 'CANCELADO', 'PENDIENTE']);
            $table->foreignId('tipo_orden_id')->constrained('tipos_ordenes'); // FK corregida
            $table->foreignId('elemento_id')->constrained('elementos'); // FK corregida
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
