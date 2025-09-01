<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('chave')->unique();
            $table->longText('valor');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        // Inserir configuração padrão
        DB::table('configuracoes')->insert([
            'chave' => 'duracao_servico_padrao',
            'valor' => '60',
            'descricao' => 'Duração padrão dos serviços em minutos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('configuracoes');
    }
};
