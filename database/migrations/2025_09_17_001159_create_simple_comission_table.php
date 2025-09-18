<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbeiro_comissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barbeiro_id');
            $table->unsignedBigInteger('filial_id');
            $table->enum('tipo_comissao_filial', ['percentual', 'valor_fixo'])->default('percentual');
            $table->decimal('valor_comissao_filial', 8, 2)->default(0);
            $table->timestamps();
             $table->foreign('barbeiro_id')
                ->references('id')
                ->on('barbeiros')
                ->onDelete('cascade');

            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais')
                ->onDelete('cascade');
            $table->unique(['barbeiro_id', 'filial_id'], 'uniq_barbeiro_filial');
        });

        Schema::create('barbeiro_servico_comissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barbeiro_id');
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('produto_id');
            $table->enum('tipo_comissao', ['percentual', 'valor_fixo'])->default('percentual');
            $table->decimal('valor_comissao', 8, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('barbeiro_id')
                ->references('id')
                ->on('barbeiros')
                ->onDelete('cascade');

            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais')
                ->onDelete('cascade');

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->onDelete('cascade');
            $table->unique(['barbeiro_id', 'filial_id', 'produto_id'], 'uniq_barbeiro_filial_produto');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbeiro_servico_comissoes');
        Schema::dropIfExists('barbeiro_comissoes');
    }
};
