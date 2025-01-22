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
        Schema::create('pregunta_induccion', function (Blueprint $table) {
            $table->id('id_pregunta');
            $table->string('pregunta', 200);
            $table->integer('orden');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->unsignedBigInteger('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->unsignedBigInteger('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->unsignedBigInteger('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta_induccion');
    }
};
