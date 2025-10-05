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
            $table->string('slug', 255)->unique();
            
            // === PORTADA ===
            $table->string('portada_path');
            
            // === INFORMACIÓN DE LA COMUNA ===
            $table->string('presidente_nombre');
            $table->string('presidente_cargo');
            $table->string('sindicato_nombre');
            $table->string('sindicato_cargo');
            $table->string('secretario_nombre');
            $table->string('secretario_cargo');
            $table->json('regidores'); // Array con los 6 regidores
            
            // === INFORMACIÓN DEL MUNICIPIO ===
            $table->string('municipio_nombre');
            $table->text('municipio_descripcion');
            $table->string('municipio_imagen_path');
            
            // === INTRODUCCIÓN ===
            $table->text('introduccion');
            $table->string('introduccion_imagen_path');
            
            // === GOBIERNO ===
            $table->text('gobierno_introduccion');
            $table->string('gobierno_imagen_path');
            
            // === ACTIVIDADES (FILTROS) ===
            $table->date('actividades_fecha_inicio');
            $table->date('actividades_fecha_fin');
            $table->json('dependencias_seleccionadas'); // Array de dependencias a incluir
            
            // === PDF GENERADO ===
            $table->string('pdf_path')->nullable(); // Ruta del PDF generado
            $table->integer('descargas')->default(0); // Contador de descargas
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejor performance
            $table->index('user_id');
            $table->index('slug');
            $table->index('created_at');
            $table->index(['actividades_fecha_inicio', 'actividades_fecha_fin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('informes');
    }
};