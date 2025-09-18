<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbeiro_filial_comissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barbeiro_id');
            $table->unsignedBigInteger('filial_id');
            $table->enum('tipo_comissao', ['percentual', 'valor_fixo'])->default('percentual');
            $table->decimal('valor_comissao', 8, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            $table->foreign('barbeiro_id')
                ->references('id')
                ->on('barbeiros')
                ->onDelete('cascade');

            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais')
                ->onDelete('cascade');

            $table->unique(['barbeiro_id', 'filial_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbeiro_filial_comissoes');
    }
};
