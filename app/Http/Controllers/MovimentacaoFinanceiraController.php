<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoFinanceira;
use App\Models\Cliente;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentacaoFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimentacaoFinanceira::with(['cliente', 'categoriaFinanceira', 'formaPagamento']);

        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('descricao', 'like', '%' . $request->busca . '%')
                  ->orWhereHas('cliente', function($clienteQuery) use ($request) {
                      $clienteQuery->where('nome', 'like', '%' . $request->busca . '%');
                  })
                  ->orWhereHas('categoriaFinanceira', function($catQuery) use ($request) {
                      $catQuery->where('nome', 'like', '%' . $request->busca . '%');
                  });
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data', '<=', $request->data_fim);
        }

        $movimentacoes = $query->orderBy('data', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->paginate($request->get('per_page', 10));

        $totalEntradas = MovimentacaoFinanceira::where('tipo', 'entrada')
                                              ->where('situacao', 'pago')
                                              ->sum('valor_pago');
        $totalSaidas = MovimentacaoFinanceira::where('tipo', 'saida')
                                            ->where('situacao', 'pago')
                                            ->sum('valor_pago');
        $saldoAtual = $totalEntradas - $totalSaidas;
        $totalMovimentacoes = MovimentacaoFinanceira::count();
        $movimentacoesAbertas = MovimentacaoFinanceira::where('situacao', 'em_aberto')->count();

        $clientes = Cliente::where('ativo', true)->orderBy('nome')->get();
        $categorias = CategoriaFinanceira::where('ativo', true)->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::where('ativo', true)->orderBy('nome')->get();

        return view('admin.financeiro.index', compact(
            'movimentacoes', 
            'totalEntradas', 
            'totalSaidas', 
            'saldoAtual', 
            'totalMovimentacoes',
            'movimentacoesAbertas',
            'clientes',
            'categorias',
            'formasPagamento'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'cliente_id' => 'nullable|exists:clientes,id',
            'situacao' => 'required|in:em_aberto,cancelado,pago',
            'data_vencimento' => 'nullable|date',
            'forma_pagamento_id' => 'nullable|exists:formas_pagamento,id',
            'data_pagamento' => 'nullable|date',
            'desconto' => 'nullable|numeric|min:0',
            'valor_pago' => 'nullable|numeric|min:0',
            'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean'
        ]);

        $data = $request->all();
        
        foreach (['valor', 'desconto', 'valor_pago'] as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
            }
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        MovimentacaoFinanceira::create($data);

        return redirect()->route('financeiro.index')
                        ->with('success', 'Movimentação cadastrada com sucesso!');
    }

    public function update(Request $request, MovimentacaoFinanceira $movimentacao)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'cliente_id' => 'nullable|exists:clientes,id',
            'situacao' => 'required|in:em_aberto,cancelado,pago',
            'data_vencimento' => 'nullable|date',
            'forma_pagamento_id' => 'nullable|exists:formas_pagamento,id',
            'data_pagamento' => 'nullable|date',
            'desconto' => 'nullable|numeric|min:0',
            'valor_pago' => 'nullable|numeric|min:0',
            'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean'
        ]);

        $data = $request->all();
        
        foreach (['valor', 'desconto', 'valor_pago'] as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
            }
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        $movimentacao->update($data);

        return redirect()->route('financeiro.index')
                        ->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy(MovimentacaoFinanceira $movimentacao)
    {
        $movimentacao->delete();

        return redirect()->route('financeiro.index')
                        ->with('success', 'Movimentação excluída com sucesso!');
    }
}
