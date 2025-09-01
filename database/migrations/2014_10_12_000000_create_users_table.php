<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->boolean('ativo');
            $table->string('senha');
            $table->boolean('master');
            $table->datetime('last_acess')->nullable();
            $table->boolean('redefinir_senha_login')->default(0);
            $table->timestamps();
        });

        DB::table('users')->insert([
            'nome' => 'Master',
            'email' => 'masterbarbershop@gmail.com',
            'ativo' => 1,
            'senha' => env('PASSWORD_MASTERUSER') ?? Str::random(15),
            'master' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
