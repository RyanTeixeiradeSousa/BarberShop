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
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('barbeiro_id')->after('id')->nullable();
    
            $table->foreign('barbeiro_id')
                  ->references('id')
                  ->on('barbeiros');
                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            // Remove a foreign key
            $table->dropForeign('agendamentos_barbeiro_id_foreign');
    
            // Remove a coluna
            $table->dropColumn('barbeiro_id');
        });
    }
};
