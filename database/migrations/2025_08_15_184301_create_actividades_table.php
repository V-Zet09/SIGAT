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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('autor')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo_area')->nullable();
            $table->text('resumen')->nullable();
            $table->longText('contenido')->nullable();
            $table->decimal('presupuesto', 10, 2)->nullable();
            $table->string('tipo_presupuesto')->nullable();
            $table->string('numero')->nullable();
            $table->string('fase')->nullable();
            $table->string('fotos')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};