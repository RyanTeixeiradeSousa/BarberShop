<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->text('endereco');
            $table->string('telefone', 15)->nullable();
            $table->string('email');
            $table->boolean('ativo')->default(true);
            $table->boolean('disponivel_site')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filiais');
    }
};
