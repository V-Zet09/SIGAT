<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gobierno', function (Blueprint $table) {
            $table->id();
            $table->string('periodo')->default('2024 - 2027');
            
            // Información del Presidente
            $table->string('presidente_nombre');
            $table->string('presidente_telefono')->nullable();
            $table->string('presidente_facebook')->nullable();
            $table->string('presidente_direccion')->nullable();
            $table->string('presidente_imagen')->nullable();
            
            // Imagen del cabildo
            $table->string('cabildo_imagen')->nullable();
            
            // Síndica
            $table->string('sindica_nombre')->nullable();
            
            // Secretario General
            $table->string('secretario_nombre')->nullable();
            
            // Regidores (almacenado como JSON)
            $table->json('regidores')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gobierno');
    }
};