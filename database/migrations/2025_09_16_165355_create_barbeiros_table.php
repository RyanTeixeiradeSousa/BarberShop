<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbeiros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nascimento')->nullable();
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->nullable();
            $table->text('endereco')->nullable();
            $table->string('telefone', 15);
            $table->string('email')->unique();
            $table->integer('user_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->integer('user_created')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbeiros');
    }
};
