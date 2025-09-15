<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Db;
class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'estoque',
        'categoria_id',
        'ativo',
        'tipo',
        'imagem',
        'site'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'site' => 'boolean',
        'preco' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getTipoFormatadoAttribute()
    {
        return $this->tipo === 'produto' ? 'Produto' : 'Serviço';
    }

    public function verificarEstoque()
    {
        if ($this->tipo === 'servico') {
            return true; // Serviços não têm estoque
        }

        // Verifica a quantidade de produtos reservados em agendamentos futuros
        $quantidadeReservadaAgendamento = db::table('agendamento_produtos')
        ->join('produtos', 'agendamento_produtos.produto_id', '=', 'produtos.id')
        ->join('agendamentos', 'agendamento_produtos.agendamento_id', '=', 'agendamentos.id')
        ->where('agendamentos.status',  'agendado')
        ->where('agendamentos.status',  'em_andamento')
        ->where('produtos.id', $this->id)
        ->sum('agendamento_produtos.quantidade');

        // Verifica a quantidade de produtos reservados em movimentações financeiras futuras
        $quantidadeReservadaFinanceira = db::table('movimentacao_produtos')
        ->join('produtos', 'movimentacao_produtos.produto_id', '=', 'produtos.id')
        ->join('movimentacoes_financeiras', 'movimentacao_produtos.movimentacao_financeira_id', '=', 'movimentacoes_financeiras.id')
        ->where('produtos.id', $this->id)
        ->where('movimentacoes_financeiras.status', 'em_aberto')
        ->sum('movimentacao_produtos.quantidade');
            
        if($this->estoque < $quantidadeReservadaAgendamento + $quantidadeReservadaFinanceira){
            return false; // Estoque insuficiente
        }

        return true; // Estoque suficiente
    }

    public function atualizarEstoque($quantidade, $operacao = 'diminuir')
    {
        if ($this->tipo === 'servico') {
            return; // Serviços não têm estoque
        }

        if ($operacao === 'diminuir') {
            $this->estoque -= $quantidade;
        } elseif ($operacao === 'aumentar') {
            $this->estoque += $quantidade;
        }

        $this->save();
    }
}
