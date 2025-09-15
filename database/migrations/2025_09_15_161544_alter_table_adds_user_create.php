<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tabelas = [
            'users',
            'produtos',
            'clientes',
            'categorias',
            'configuracoes',
            'agendamentos',
            'categorias_financeiras',
            'formas_pagamento',
            'movimentacoes_financeiras'
        ];
    
        foreach ($tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->string('user_created')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
