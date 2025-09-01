<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('formas_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        DB::table('formas_pagamento')->insert([
            'nome' => 'PIX',
            'descricao' => '',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('formas_pagamento')->insert([
            'nome' => 'DINHEIRO',
            'descricao' => '',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('formas_pagamento')->insert([
            'nome' => 'CARTÃO DE CRÉDITO',
            'descricao' => '',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('formas_pagamento')->insert([
            'nome' => 'CARTÃO DE DÉBITO',
            'descricao' => '',
            'ativo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }

    public function down()
    {
        Schema::dropIfExists('formas_pagamento');
    }
};
