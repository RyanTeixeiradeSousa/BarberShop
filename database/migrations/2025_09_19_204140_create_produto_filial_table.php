<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produto_filial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->foreignId('filial_id')->constrained('filiais')->onDelete('cascade');
            $table->integer('estoque_filial')->default(0);
            $table->decimal('preco_filial', 10, 2)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            $table->unique(['produto_id', 'filial_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_filial');
    }
};
