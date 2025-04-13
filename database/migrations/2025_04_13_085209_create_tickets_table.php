<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_solicitante');
            $table->string('telefono');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tickets');
    }
};
