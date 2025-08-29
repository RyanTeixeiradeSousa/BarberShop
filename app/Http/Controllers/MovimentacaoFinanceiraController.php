<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoFinanceira;
use App\Models\Cliente;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use App\Models\Produto; // Adicionando model Produto
use App\Models\Agendamento; // Adicionando model Agendamento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentacaoFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimentacaoFinanceira::with(['cliente', 'categoriaFinanceira', 'formaPagamento', 'agendamento', 'produtos']);

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
        $produtos = Produto::where('ativo', true)->orderBy('nome')->get(); // Adicionando produtos
        $agendamentos = Agendamento::with('cliente')->orderBy('data_agendamento', 'desc')->get(); // Adicionando agendamentos

        return view('admin.financeiro.index', compact(
            'movimentacoes', 
            'totalEntradas', 
            'totalSaidas', 
            'saldoAtual', 
            'totalMovimentacoes',
            'movimentacoesAbertas',
            'clientes',
            'categorias',
            'formasPagamento',
            'produtos', // Passando produtos para view
            'agendamentos' // Passando agendamentos para view
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
            'agendamento_id' => 'nullable|exists:agendamentos,id', // Validação para agendamento
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
            'baixado' => 'boolean',
            'produtos' => 'nullable|array', // Validação para produtos
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|numeric|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0'
        ]);

        $data = $request->all();
        
        foreach (['valor', 'desconto', 'valor_pago'] as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
            }
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        if ($request->has('baixado') && $request->baixado) {
            $data['situacao'] = 'pago';
            $data['data_pagamento'] = $data['data_pagamento'] ?? now()->format('Y-m-d');
            if (!$data['valor_pago']) {
                $data['valor_pago'] = $data['valor'] - ($data['desconto'] ?? 0);
            }
        }

        unset($data['baixado'], $data['produtos']); // Removendo produtos dos dados principais

        DB::transaction(function () use ($data, $request) {
            $movimentacao = MovimentacaoFinanceira::create($data);

            // Associar produtos se fornecidos
            if ($request->has('produtos') && is_array($request->produtos)) {
                foreach ($request->produtos as $produto) {
                    $valorUnitario = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $produto['valor_unitario']);
                    $movimentacao->produtos()->attach($produto['id'], [
                        'quantidade' => $produto['quantidade'],
                        'valor_unitario' => $valorUnitario
                    ]);
                }
            }
        });

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
            'agendamento_id' => 'nullable|exists:agendamentos,id', // Validação para agendamento
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
            'baixado' => 'boolean',
            'produtos' => 'nullable|array', // Validação para produtos
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|numeric|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0'
        ]);

        $data = $request->all();
        
        foreach (['valor', 'desconto', 'valor_pago'] as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
            }
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        if ($request->has('baixado') && $request->baixado && $movimentacao->situacao == 'em_aberto') {
            $data['situacao'] = 'pago';
            $data['data_pagamento'] = $data['data_pagamento'] ?? now()->format('Y-m-d');
            if (!$data['valor_pago']) {
                $data['valor_pago'] = $data['valor'] - ($data['desconto'] ?? 0);
            }
        }

        unset($data['baixado'], $data['produtos']); // Removendo produtos dos dados principais

        DB::transaction(function () use ($data, $request, $movimentacao) {
            $movimentacao->update($data);

            // Remover produtos existentes e adicionar novos
            $movimentacao->produtos()->detach();
            
            if ($request->has('produtos') && is_array($request->produtos)) {
                foreach ($request->produtos as $produto) {
                    $valorUnitario = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $produto['valor_unitario']);
                    $movimentacao->produtos()->attach($produto['id'], [
                        'quantidade' => $produto['quantidade'],
                        'valor_unitario' => $valorUnitario
                    ]);
                }
            }
        });

        return redirect()->route('financeiro.index')
                        ->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy(MovimentacaoFinanceira $movimentacao)
    {
        $movimentacao->delete();

        return redirect()->route('financeiro.index')
                        ->with('success', 'Movimentação excluída com sucesso!');
    }

    public function show(MovimentacaoFinanceira $movimentacao)
    {
        $movimentacao->load(['cliente', 'categoriaFinanceira', 'formaPagamento', 'agendamento', 'produtos']);
        return response()->json($movimentacao);
    }
}
