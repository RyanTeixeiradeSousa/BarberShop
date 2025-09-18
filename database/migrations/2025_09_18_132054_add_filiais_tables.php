<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['agendamentos', 'movimentacoes_financeiras']; // coloque aqui as tabelas que quiser

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->unsignedBigInteger('filial_id')->after('id')->nullable();

                // foreign key explícita
                $table->foreign('filial_id')
                      ->references('id')
                      ->on('filiais');
            });
        }
    }

    public function down(): void
    {
        $tables = ['agendamentos', 'movimentacoes_financeiras'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropForeign($tableName.'_filial_id_foreign'); // nome correto
                $table->dropColumn('filial_id');
            });
        }
    }
};
