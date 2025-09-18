<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barbeiro_filial', function (Blueprint $table) {
            $table->dropColumn(['tipo_comissao', 'valor_comissao']);
        });
    }

    public function down()
    {
        Schema::table('barbeiro_filial', function (Blueprint $table) {
            $table->enum('tipo_comissao', ['percentual', 'valor_fixo'])->default('percentual');
            $table->decimal('valor_comissao', 8, 2)->default(0);
        });
    }
};
