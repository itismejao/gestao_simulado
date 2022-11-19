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
        Schema::create('planilha', function (Blueprint $table) {
            $table->id($column = 'planilha_id');
            $table->string('nome_original');
            $table->string('extensao');
            $table->string('caminho');
            $table->integer('qtd_linhas');
            $table->boolean('success');
            $table->foreignId('prova_id')->references('prova_id')->on('prova');
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
        Schema::dropIfExists('planilha');
    }
};
