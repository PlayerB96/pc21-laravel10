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
        Schema::create('respuesta_induccion', function (Blueprint $table) {
            $table->id('id_respuesta');
            $table->unsignedBigInteger('id_pregunta');
            $table->string('desc_respuesta', 255);
            $table->integer('correcto');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->unsignedBigInteger('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->unsignedBigInteger('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->unsignedBigInteger('user_eli')->nullable();

            $table->foreign('id_pregunta')->references('id')->on('preguntas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_induccion');
    }
};
