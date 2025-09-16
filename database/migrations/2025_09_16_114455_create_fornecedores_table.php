<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_fantasia')->nullable();
            $table->string('cpf_cnpj', 18);
            $table->text('endereco');
            $table->boolean('ativo')->default(true);
            $table->enum('pessoa_fisica_juridica', ['F', 'J'])->default('J');
            $table->integer('user_created');
            $table->timestamps();

            $table->index(['ativo', 'pessoa_fisica_juridica']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
};
