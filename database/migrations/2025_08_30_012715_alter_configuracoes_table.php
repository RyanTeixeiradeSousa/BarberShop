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
        DB::table('configuracoes')->insert([
            [
                'chave' => 'site_nome',
                'valor' => 'BarberShop Premium',
                'descricao' => 'Nome da barbearia para o site',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_cnpj',
                'valor' => '12.345.678/0001-90',
                'descricao' => 'CNPJ da barbearia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_foto_principal',
                'valor' => '',
                'descricao' => 'Foto principal da barbearia em base64',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_logomarca',
                'valor' => '',
                'descricao' => 'Logomarca da barbearia em base64',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_cor_primaria',
                'valor' => '#1a1a1a',
                'descricao' => 'Cor primária do site',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_cor_secundaria',
                'valor' => '#d4af37',
                'descricao' => 'Cor secundária do site (dourado)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_historia',
                'valor' => 'Há mais de 20 anos oferecendo os melhores serviços de barbearia da cidade. Nossa equipe especializada garante um atendimento de qualidade premium com técnicas modernas e tradicionais.',
                'descricao' => 'História da barbearia para o site',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_endereco',
                'valor' => 'Rua das Flores, 123 - Centro',
                'descricao' => 'Endereço da barbearia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_telefone',
                'valor' => '(11) 99999-9999',
                'descricao' => 'Telefone da barbearia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'site_horario_funcionamento',
                'valor' => 'Segunda a Sexta: 8h às 18h | Sábado: 8h às 16h',
                'descricao' => 'Horário de funcionamento',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
