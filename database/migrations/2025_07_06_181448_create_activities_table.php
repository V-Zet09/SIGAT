<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('actividades', function (Blueprint $table) {
     $table->id('id_actividad');
        $table->string('titulo', 150);
        $table->date('fecha'); // fecha de creación
        $table->text('resumen')->nullable();
        $table->text('contenido')->nullable();
        $table->decimal('presupuesto', 10, 2)->nullable();
        $table->enum('tipo_presupuesto', ['federal', 'estatal', 'municipal'])->nullable();
        $table->enum('estado', ['en revision', 'aprobada'])->default('en revision');
        $table->unsignedBigInteger('id_usuario');
       $table->timestamps();

        // Llave foránea
        $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
