<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informes', function (Blueprint $table) {
            $table->string('plantilla_imagen_path')->nullable()->after('portada_path');
        });
    }

    public function down(): void
    {
        Schema::table('informes', function (Blueprint $table) {
            $table->dropColumn('plantilla_imagen_path');
        });
    }
};