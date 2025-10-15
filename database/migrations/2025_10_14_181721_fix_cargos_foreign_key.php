<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cargos', function (Blueprint $table) {
            // Primero eliminar la foreign key si existe
            try {
                $table->dropForeign(['id_superior']);
            } catch (\Exception $e) {
                // No existe, continuar
            }
            
            // Eliminar la columna si existe
            if (Schema::hasColumn('cargos', 'id_superior')) {
                $table->dropColumn('id_superior');
            }
        });

        // Ahora recrear correctamente
        Schema::table('cargos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_superior')->nullable()->after('id');
        });

        // Agregar la foreign key
        Schema::table('cargos', function (Blueprint $table) {
            $table->foreign('id_superior')
                  ->references('id')
                  ->on('cargos')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropForeign(['id_superior']);
            $table->dropColumn('id_superior');
        });
    }
};