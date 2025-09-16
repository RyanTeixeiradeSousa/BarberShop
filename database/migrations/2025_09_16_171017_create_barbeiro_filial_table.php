<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbeiro_filial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barbeiro_id')
            ->references('id')        // campo da tabela barbeiros
            ->on('barbeiros')         // tabela barbeiros
            ->onDelete('cascade');

            $table->foreignId('filial_id')
            ->references('id')        // campo da tabela filiais
            ->on('filiais')           // tabela filiais
            ->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['barbeiro_id', 'filial_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbeiro_filial');
    }
};
