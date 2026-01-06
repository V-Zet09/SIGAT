<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->uuid('id')->primary();


            $table->morphs('notifiable'); 

            $table->string('type'); // Tipo de notificación (clase PHP)
            
            // --- TUS CAMPOS PERSONALIZADOS (Los mantuve todos) ---
            $table->string('custom_type')->nullable(); 
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('blue');
            $table->string('link')->nullable();
            // -----------------------------------------------------

            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Laravel guarda aquí la info por defecto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
