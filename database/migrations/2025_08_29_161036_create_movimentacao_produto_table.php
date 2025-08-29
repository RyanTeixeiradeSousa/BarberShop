<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimentacao_produto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movimentacao_financeira_id')->constrained('movimentacoes_financeiras')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('quantidade')->default(1);
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->timestamps();
            
            // $table->unique(['movimentacao_financeira_id', 'produto_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentacao_produto');
    }
};
