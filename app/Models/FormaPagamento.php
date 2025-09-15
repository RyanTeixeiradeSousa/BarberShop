<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $table = 'formas_pagamento';

    protected $fillable = [
        'nome',
        'descricao',
        'ativo',
        'user_created'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoFinanceira::class);
    }
}
