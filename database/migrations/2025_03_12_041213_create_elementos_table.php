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
        Schema::create('elementos', function (Blueprint $table) {
            $table->id(); // 'id' como integer auto_increment PRIMARY KEY
            $table->string('no_empleado', 255);
            $table->string('cargo', 255);
            $table->string('apellido_paterno', 255);
            $table->string('apellido_materno', 255);
            $table->string('nombre', 255);
            $table->foreignId('id_unidad')->nullable()->constrained('unidades')->onDelete('cascade');
            $table->string('observaciones', 255)->nullable();
            $table->enum('status', ['ACTIVO', 'INACTIVO']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos');
    }
};
