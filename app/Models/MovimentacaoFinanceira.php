<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoFinanceira extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes_financeiras';

    protected $fillable = [
        'tipo',
        'descricao',
        'valor',
        'data',
        'cliente_id',
        'situacao',
        'data_vencimento',
        'forma_pagamento_id',
        'data_pagamento',
        'desconto',
        'valor_pago',
        'categoria_financeira_id',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'data' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'valor' => 'decimal:2',
        'desconto' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function categoriaFinanceira()
    {
        return $this->belongsTo(CategoriaFinanceira::class);
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function getTipoCorAttribute()
    {
        return $this->tipo === 'entrada' ? 'success' : 'danger';
    }

    public function getTipoIconeAttribute()
    {
        return $this->tipo === 'entrada' ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
    }

    public function getValorFinalAttribute()
    {
        return $this->valor - ($this->desconto ?? 0);
    }

    public function getSituacaoCorAttribute()
    {
        return match($this->situacao) {
            'pago' => 'success',
            'em_aberto' => 'warning',
            'cancelado' => 'danger',
            default => 'secondary'
        };
    }

    public function getSituacaoTextoAttribute()
    {
        return match($this->situacao) {
            'em_aberto' => 'Em Aberto',
            'pago' => 'Pago',
            'cancelado' => 'Cancelado',
            default => $this->situacao
        };
    }
}
