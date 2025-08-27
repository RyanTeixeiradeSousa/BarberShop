<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimentacoes_financeiras', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'saida']);
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            $table->enum('situacao', ['em_aberto', 'cancelado', 'pago'])->default('em_aberto');
            $table->date('data_vencimento')->nullable();
            $table->foreignId('forma_pagamento_id')->nullable()->constrained('formas_pagamento')->onDelete('set null');
            $table->date('data_pagamento')->nullable();
            $table->decimal('desconto', 10, 2)->nullable()->default(0);
            $table->decimal('valor_pago', 10, 2)->nullable();
            $table->foreignId('categoria_financeira_id')->nullable()->constrained('categorias_financeiras')->onDelete('set null');
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentacoes_financeiras');
    }
};
