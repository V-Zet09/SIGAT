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
        // Elimina la columna legacy
        $table->dropColumn('foto');
        // Agrega la columna nueva de fotos múltiples tipo JSON
        $table->json('fotos')->nullable();
    });
}

public function down(): void
{
    Schema::table('actividades', function (Blueprint $table) {
        // Reversa los cambios por si necesitas hacer rollback
        $table->string('foto')->nullable();
        $table->dropColumn('fotos');
    });
}

};
