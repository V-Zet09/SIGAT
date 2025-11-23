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
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Identificación
            $table->string('slug')->unique();
            $table->string('portada_imagen_path')->nullable();
            $table->string('plantilla_imagen_path')->nullable();
            
            // Comuna
            $table->string('presidente_nombre')->nullable()->default('N/D');
            $table->string('presidente_cargo')->nullable()->default('N/D');
            $table->string('sindicato_nombre')->nullable()->default('N/D');
            $table->string('sindicato_cargo')->nullable()->default('N/D');
            $table->string('secretario_nombre')->nullable()->default('N/D');
            $table->string('secretario_cargo')->nullable()->default('N/D');
            $table->string('comuna_imagen_path')->nullable();

            // Regidores (JSON)
            $table->json('regidores')->nullable();
            
            // Municipio
            $table->string('municipio_nombre')->nullable()->default('N/D');
            $table->longText('municipio_descripcion')->nullable();
            $table->string('municipio_imagen_path')->nullable();
            
            // Introducciones
            $table->longText('introduccion')->nullable();
            $table->string('introduccion_imagen_path')->nullable();
            $table->longText('gobierno_introduccion')->nullable();
            $table->string('gobierno_imagen_path')->nullable();
            
            // Filtros de actividades
            $table->date('actividades_fecha_inicio');
            $table->date('actividades_fecha_fin');
            $table->json('dependencias_seleccionadas')->nullable();
            
            // PDF generado
            $table->string('pdf_path')->nullable();
            $table->integer('descargas')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
