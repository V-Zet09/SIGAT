<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            
            // Relación con el usuario creador
            $table->foreignId('user_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            // Información básica del informe
            $table->string('titulo', 255);
            $table->string('periodo', 100);
            
            // Sección de portada
            $table->string('portada_path');
            
            // Sección de información del municipio
            $table->string('municipio_nombre')->nullable();
            $table->text('municipio_descripcion')->nullable();
            $table->string('municipio_imagen_path')->nullable();
            
            // Sección de introducción
            $table->text('introduccion');
            $table->string('introduccion_imagen_path')->nullable();
            
            // Sección de gobierno
            $table->text('gobierno_introduccion');
            $table->string('gobierno_imagen_path')->nullable();
            
            // Sección de actividades
            $table->string('actividades_periodo');
            $table->json('actividades_areas')->nullable(); // Para guardar las áreas seleccionadas
            $table->text('actividades_descripcion');
            $table->json('actividades_imagenes_paths')->nullable(); // Para múltiples imágenes
            
            // URL amigable
            $table->string('slug', 255)->unique();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejor performance
            $table->index('user_id');
            $table->index('slug');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('informes');
    }
};