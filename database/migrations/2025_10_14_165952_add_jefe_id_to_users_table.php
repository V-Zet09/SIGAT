<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('jefe_id')->nullable()->after('cargo');
            $table->string('telefono')->nullable()->after('email');
            $table->integer('orden')->default(0)->after('jefe_id');
            
            $table->foreign('jefe_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jefe_id']);
            $table->dropColumn(['jefe_id', 'telefono', 'orden']);
        });
    }
};