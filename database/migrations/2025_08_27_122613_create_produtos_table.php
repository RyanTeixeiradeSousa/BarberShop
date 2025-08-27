<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->boolean('ativo')->default(true);
            $table->enum('tipo', ['produto', 'servico']);
            $table->longText('imagem')->nullable(); // base64
            $table->boolean('site')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
