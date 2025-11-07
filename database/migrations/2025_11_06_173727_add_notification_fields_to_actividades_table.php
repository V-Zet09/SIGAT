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
        Schema::table('actividades', function (Blueprint $table) {
            // Usuario que creó la actividad
            $table->foreignId('creado_por_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            
            // Usuario responsable de la actividad
            $table->foreignId('responsable_id')->nullable()->after('creado_por_id')->constrained('users')->onDelete('set null');
            
            // Estado de la actividad
            $table->string('estado')->default('Pendiente')->after('responsable_id'); // Pendiente, Aprobada, Rechazada, En Proceso, Completada
            
            // Aprobación
            $table->foreignId('aprobada_por')->nullable()->after('estado')->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_aprobacion')->nullable()->after('aprobada_por');
            
            // Rechazo
            $table->foreignId('rechazada_por')->nullable()->after('fecha_aprobacion')->constrained('users')->onDelete('set null');
            $table->text('motivo_rechazo')->nullable()->after('rechazada_por');
            $table->timestamp('fecha_rechazo')->nullable()->after('motivo_rechazo');
            
            // Evidencias (archivos adjuntos en formato JSON)
            $table->json('evidencias')->nullable()->after('fecha_rechazo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            // Eliminar en orden inverso
            $table->dropColumn('evidencias');
            
            $table->dropForeign(['rechazada_por']);
            $table->dropColumn(['rechazada_por', 'motivo_rechazo', 'fecha_rechazo']);
            
            $table->dropForeign(['aprobada_por']);
            $table->dropColumn(['aprobada_por', 'fecha_aprobacion']);
            
            $table->dropColumn('estado');
            
            $table->dropForeign(['responsable_id']);
            $table->dropColumn('responsable_id');
            
            $table->dropForeign(['creado_por_id']);
            $table->dropColumn('creado_por_id');
        });
    }
};