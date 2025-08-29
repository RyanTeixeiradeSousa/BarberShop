<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            // $table->foreignId('produto_id')->nullable()->constrained('produtos')->onDelete('set null');
            $table->date('data_agendamento');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->enum('status', ['disponivel', 'agendado', 'confirmado', 'em_andamento', 'concluido', 'cancelado'])->default('disponivel');
            $table->text('observacoes')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
};
