<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // A quién va dirigida
            $table->string('type'); // Tipo: actividad, informe, sistema
            $table->string('title'); // Título corto
            $table->text('message'); // Mensaje completo
            $table->string('icon')->nullable(); // Icono remixicon
            $table->string('color')->default('blue'); // Color: blue, green, red, yellow
            $table->string('link')->nullable(); // URL a donde redirige
            $table->boolean('read')->default(false); // Leída o no
            $table->timestamp('read_at')->nullable(); // Cuándo se leyó
            $table->json('data')->nullable(); // Datos adicionales en JSON
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index('user_id');
            $table->index('read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};