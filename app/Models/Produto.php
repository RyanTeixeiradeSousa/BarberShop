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
        'categoria_id',
        'ativo',
        'tipo',
        'imagem',
        'site',
        'user_created'
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

    public function verificarEstoqueComprometido($filialId, $quantidadeDesejada)
    {
        if ($this->tipo === 'servico') {
            return true; // Serviços não têm estoque
        }

        // Verifica a quantidade de produtos reservados em agendamentos futuros
        $agendamento = DB::table('agendamento_produto as ap')
            ->join('agendamentos as a', 'ap.agendamento_id', '=', 'a.id')
            ->whereIn('a.status', ['agendado', 'em_andamento'])
            ->where('ap.produto_id', $this->id)
            ->where('a.filial_id', $filialId)
            ->sum('ap.quantidade');

        $movimentacao = DB::table('movimentacao_produto as mp')
            ->join('movimentacoes_financeiras as mf', 'mp.movimentacao_financeira_id', '=', 'mf.id')
            ->where('mf.situacao', 'em_aberto')
            ->where('mp.produto_id', $this->id)
            ->where('mf.filial_id', $filialId)
            ->sum('mp.quantidade');

        $comprometido = $agendamento + $movimentacao;
            
        $estoqueDisponivel = db::table('produto_filial')->where('produto_id', $this->id)->where('filial_id', $filialId)->value('estoque_filial') - $comprometido;

        return $quantidadeDesejada <= $estoqueDisponivel;
    }

    public function atualizarEstoque($filialId, $quantidade, $operacao = 'diminuir')
    {
        if ($this->tipo === 'servico') {
            return; // Serviços não têm estoque
        }

        if ($operacao === 'diminuir') {
            DB::table('produto_filial')
                ->where('produto_id', $this->id)
                ->where('filial_id', $filialId)
                ->update([
                    'estoque_filial' => DB::raw('estoque_filial - ' . (int) $quantidade)
                ]);
        } elseif ($operacao === 'aumentar') {
            DB::table('produto_filial')
                ->where('produto_id', $this->id)
                ->where('filial_id', $filialId)
                ->update([
                    'estoque_filial' => DB::raw('estoque_filial + ' . (int) $quantidade)
                ]);
        }

        $this->save();
    }

    public function filiais()
    {
        return $this->belongsToMany(Filial::class, 'produto_filial')
                    ->withPivot('estoque_filial', 'preco_filial', 'ativo')
                    ->withTimestamps();
    }

    public function getEstoqueTotalAttribute()
    {
        return $this->filiais()->sum('produto_filial.estoque_filial');
    }

    public function getDisponivelAttribute()
    {
        return $this->filiais()->wherePivot('ativo', true)->exists();
    }
}
