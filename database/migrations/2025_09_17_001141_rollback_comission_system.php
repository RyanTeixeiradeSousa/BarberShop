<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barbeiros', function (Blueprint $table) {
            $table->dropColumn(['tipo_comissao_default', 'valor_comissao_default']);
        });

        Schema::dropIfExists('barbeiro_filial_comissoes');
        Schema::dropIfExists('barbeiro_servico_comissoes');
    }

    public function down()
    {
        // Reverter as mudanças se necessário
        Schema::table('barbeiros', function (Blueprint $table) {
            $table->enum('tipo_comissao_default', ['percentual', 'valor_fixo'])->default('percentual');
            $table->decimal('valor_comissao_default', 8, 2)->default(0);
        });
    }
};
