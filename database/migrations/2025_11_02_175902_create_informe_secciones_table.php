
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('informe_secciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informe_id')->constrained('informes')->onDelete('cascade');
            $table->string('titulo');
            $table->text('contenido')->nullable();
            $table->integer('nivel'); // 1, 2, 3 para h2, h3, h4
            $table->integer('orden');
            $table->integer('pagina')->nullable();
            $table->boolean('mostrar_indice')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informe_secciones');
    }
};
