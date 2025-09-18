<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbeiro_servico_comissoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barbeiro_id')->constrained('barbeiros')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->foreignId('filial_id')->constrained('filiais')->onDelete('cascade');
            $table->enum('tipo_comissao', ['percentual', 'valor_fixo']);
            $table->decimal('valor_comissao', 8, 2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            $table->unique(['barbeiro_id', 'produto_id', 'filial_id'], 'barbeiro_servico_filial_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbeiro_servico_comissoes');
    }
};
