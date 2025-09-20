<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoFinanceira;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\CategoriaFinanceira;
use App\Models\FormaPagamento;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Filial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class MovimentacaoFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimentacaoFinanceira::with(['cliente', 'categoriaFinanceira', 'formaPagamento', 'agendamento', 'produtos', 'fornecedor', 'filial']);

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
        $fornecedores = Fornecedor::where('ativo', true)->orderBy('nome')->get();
        $categorias = CategoriaFinanceira::where('ativo', true)->orderBy('nome')->get();
        $formasPagamento = FormaPagamento::where('ativo', true)->orderBy('nome')->get();
        $filialSelect = (new Filial())->getFilials();
        $servicosAtivos = Produto::where('ativo', true)->where('tipo','servico')->where('site', true)->get();

        $produtosAtivosNaoComprometidos = Produto::where('ativo', true)
        ->where('site', true)
        ->where('tipo', 'produto')
        ->select('produtos.*')
        ->whereRaw('estoque > 
            (
                SELECT COALESCE(SUM(ap.quantidade), 0)
                FROM agendamento_produto ap
                JOIN agendamentos a ON ap.agendamento_id = a.id
                WHERE a.status IN (?, ?)
                    AND ap.produto_id = produtos.id
            ) +
            (
                SELECT COALESCE(SUM(mp.quantidade), 0)
                FROM movimentacao_produto mp
                JOIN movimentacoes_financeiras mf ON mp.movimentacao_financeira_id = mf.id
                WHERE mf.situacao = ?
                    AND mp.produto_id = produtos.id
            )
        ', ['agendado', 'em_andamento', 'em_aberto'])
        ->get();

        $produtos = $servicosAtivos->merge($produtosAtivosNaoComprometidos);

        $agendamentos = Agendamento::with('cliente')->orderBy('data_agendamento', 'desc')->get();

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
            'produtos', 
            'agendamentos',
            'fornecedores',
            'filialSelect'
        ));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'filial_id' => 'required|exists:filiais,id',
                'tipo' => 'required|in:entrada,saida',
                'descricao' => 'required|string|max:255',
                'valor' => 'required',
                'data' => 'required|date',
                'cliente_id' => 'nullable|exists:clientes,id',
                'situacao' => 'required|in:em_aberto,cancelado,pago',
                'data_vencimento' => 'nullable|date',
                'forma_pagamento_id' => 'nullable|exists:formas_pagamento,id',
                'data_pagamento' => 'nullable|date',
                'desconto' => 'nullable',
                'valor_pago' => 'nullable',
                'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
                'agendamento_id' => 'nullable|exists:agendamentos,id',
                'observacoes' => 'nullable|string',
                'produtos' => 'nullable|array',
                'produtos.*.id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|numeric|min:1',
                'produtos.*.valor_unitario' => 'required',
            ]);
        
            if ($validator->fails()) {
                return redirect()->route('financeiro.index') ->with(['type' => 'error', 'message' => 'Erro ao cadastrar movimentalção: ' . $validator->errors()->first()]);
            }

            if ($request->has('produtos') && is_array($request->produtos)) {
                foreach ($request->produtos as $produto) {
                    $p = Produto::find($produto['id']);
                    if(!$p->verificarEstoqueComprometido($request->filial_id, $produto['quantidade'])){
                        throw new Exception('O produto ' . $p->nome . ' não tem estoque suficiente ou está com saldo comprometido na filial.',1);
                    } 
                }
            }
    
           
            $data = $request->all();
            
            foreach (['valor', 'desconto', 'valor_pago'] as $campo) {
                if (isset($data[$campo])) {
                    $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
                }
            }
    
            $data['ativo'] = true;
            $data['user_created'] = Auth::user()->id;

            if($data['tipo'] == 'saida'){
                $data['cliente_id'] = null;
            }

            if($data['tipo'] == 'entrada'){
                $data['fornecedor_id'] = null;
            }
    
            unset($data['produtos']);
    
            DB::transaction(function () use ($data, $request) {
                $movimentacao = MovimentacaoFinanceira::create($data);
                
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
            
            return redirect()->route('financeiro.index') ->with(['type' => 'success', 'message' => 'Movimentação cadastrada com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('financeiro.index') ->with(['type' => 'error', 'message' => 'Erro ao cadastrar movimentação: ' . $e->getMessage()]);

        }
    }

    public function update(Request $request, MovimentacaoFinanceira $movimentacao)
    {
        try{
            $request->validate([
                'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
                'observacoes' => 'nullable|string',
            ]);
    
            $data = $request->only(['categoria_financeira_id', 'observacoes']);
            $data['ativo'] = true;
    
            $movimentacao->update($data);
    
            return redirect()->route('financeiro.index')
                                        ->with(['type' => 'success', 'message' => 'Movimentação atualizada com sucesso!' ]);

        } catch(Exception $e){
            return redirect()->route('financeiro.index')
                                        ->with(['type' => 'error', 'message' => 'Erro ao atualizar movimentação: ' . $e->getMessage() ]);
        }
    }

    public function destroy(MovimentacaoFinanceira $movimentacao)
    {

        try{
            $movimentacao->delete();
    
            return redirect()->route('financeiro.index')
                            ->with(['type' => 'success', 'message' => 'Movimentação excluída com sucesso!' ]);
        } catch(Exception $e){
            return redirect()->route('financeiro.index')
                                        ->with(['type' => 'error', 'message' => 'Erro ao excluir movimentação: ' . $e->getMessage() ]);
        }
    }

    public function show(MovimentacaoFinanceira $movimentacao)
    {
        $movimentacao->load(['cliente', 'categoriaFinanceira', 'formaPagamento', 'agendamento', 'produtos', 'filial']);
        return response()->json($movimentacao);
    }

    public function baixar(Request $request, MovimentacaoFinanceira $financeiro)
    {
        try{

            $movimentacao = $financeiro;
            $request->validate([
                'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
                'data_pagamento' => 'required|date',
                'desconto' => 'nullable',
                'valor_pago' => 'required',
            ]);
    
            $data = $request->all();
            
            foreach (['desconto', 'valor_pago'] as $campo) {
                if (isset($data[$campo])) {
                    $data[$campo] = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $data[$campo]);
                }
            }
    
            if($movimentacao->tipo == 'entrada'){
                $produtosAssociados = db::table('movimentacao_produto')->where('movimentacao_financeira_id',$financeiro->id)->get();
    
                foreach ($produtosAssociados as $key => $p) {
                    Produto::find($p->produto_id)->atualizarEstoque($movimentacao->filial_id,$p->quantidade, 'diminuir');
                }
            }

            $movimentacao->update([
                'situacao' => 'pago',
                'forma_pagamento_id' => $data['forma_pagamento_id'],
                'data_pagamento' => $data['data_pagamento'],
                'desconto' => $data['desconto'] ?? 0,
                'valor_pago' => $data['valor_pago'],
            ]);
    
            return redirect()->route('financeiro.index') ->with(['type' => 'success', 'message' => 'Movimentação baixada com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('financeiro.index') ->with(['type' => 'error', 'message' => 'Erro ao baixa movimentação: ' . $e->getMessage()]);

        }
    }

    public function cancelar(MovimentacaoFinanceira $financeiro)
    {
        try{
            $movimentacao = $financeiro;

            if($movimentacao->tipo == 'entrada' && $movimentacao->situacao != 'em_aberto'){
                $produtosAssociados = db::table('movimentacao_produto')->where('movimentacao_financeira_id',$financeiro->id)->get();
                foreach ($produtosAssociados as $key => $p) {
                    Produto::find($p->produto_id)->atualizarEstoque($movimentacao->filial_id, $p->quantidade, 'aumentar');
                }
            }

            $movimentacao->update([
                'situacao' => 'cancelado',
                'data_pagamento' => null,
                'forma_pagamento_id' => null,
                'data_pagamento' => null,
                'valor_pago' => null,
            ]);
            
            return redirect()->route('financeiro.index') ->with(['type' => 'success', 'message' => 'Movimentação cancelada com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('financeiro.index') ->with(['type' => 'success', 'message' => 'Erro ao cancelar movimentação: ' . $e->getMessage()]);
        }
                       
    }

    public function getProdutosByFilial($filialId)
    {
       $produtos = Produto::whereHas('filiais', function ($query) use ($filialId) {
        $query->where('filial_id', $filialId)
            ->where('produto_filial.ativo', true);
          
})
->where('produtos.ativo', true)
->orderBy('nome')
->get(['id', 'nome', 'preco']);



        return response()->json($produtos);
    }
}

