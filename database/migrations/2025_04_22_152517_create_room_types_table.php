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
        // CREAMOS LA TABLA PARA TIPOS DE HABITACIONES
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // ESTANDAR, JUNIOR, SUITE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
