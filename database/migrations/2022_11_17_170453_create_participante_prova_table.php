<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participante_prova', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prova_id')->references('prova_id')->on('prova');
            $table->foreignId('participante_id')->references('participante_id')->on('participante');
            $table->foreignId('sala_id')->nullable()->references('sala_id')->on('sala');
            $table->string('posicao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participante_prova');
    }
};
