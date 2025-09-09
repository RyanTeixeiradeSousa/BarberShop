<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $configuracoes = $this->getConfiguracoes();
        $servicos = Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'servico')
            ->get();

        $produtos = Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'produto')
            ->get();
        return view('site.index', compact('configuracoes', 'servicos', 'produtos'));
    }

    public function agendamento()
    {
        $configuracoes = $this->getConfiguracoes();

        $produtos = Produto::where('ativo', true)
            ->where('site', true)
            ->get();

    
        return view('site.agendamento', compact('configuracoes', 'produtos'));
    }

    public function getSlotsDisponiveis(Request $request)
    {
        $data = $request->get('data');
        
        if (!$data) {
            return response()->json(['horarios' => []]);
        }

        $slotsDisponiveis = Agendamento::where('data_agendamento', $data)
            ->where('status', 'disponivel')
            ->where('ativo', true)
            ->orderBy('hora_inicio')
            ->get(['hora_inicio', 'id']);

        return response()->json([
            'horarios' => $slotsDisponiveis->map(function($slot) {
                return [
                    'id' => $slot->id,
                    'hora' => \Carbon\Carbon::parse($slot->hora_inicio)->format('H:i')
                ];
            })
        ]);
    }

    private function getConfiguracoes()
    {
        return Configuracao::pluck('valor', 'chave')->toArray();
    }

    // public function criarAgendamento(Request $request)
    // {
       
    //     $validator = Validator::make($request->all(), [
    //         'slot_id' => 'required|exists:agendamentos,id',
    //         'nome' => 'required|string|max:255',
    //         'telefone' => 'required|string|max:20',
    //         'email' => 'nullable|email',
    //         'servicos' => 'required|array|min:1',
    //         'servicos.*' => 'exists:produtos,id',
    //         'observacoes' => 'nullable|string|max:500'
    //     ]);
        
    //     if ($validator->fails()) {
    //         // Retorna erros em JSON
    //        dd($validator->errors());
    //     }
    //     try {
            
    //         // Buscar ou criar cliente pelo telefone
    //         $telefone = preg_replace('/\D/', '', $request->telefone);
            
    //         $cliente = Cliente::where('telefone1', $telefone)
    //             ->orWhere('telefone1', $request->telefone)
    //             ->first();

    //         if (!$cliente) {
    //             $cliente = Cliente::create([
    //                 'nome' => $request->nome,
    //                 'telefone' => $telefone,
    //                 'email' => $request->email,
    //                 'sexo' => 'M',
    //                 'ativo' => true
    //             ]);
    //         } else {
    //             $cliente->update([
    //                 'nome' => $request->nome,
    //                 'email' => $request->email ?: $cliente->email
    //             ]);
    //         }

    //         // Buscar o slot disponível
    //         $agendamento = Agendamento::where('id', $request->slot_id)
    //             ->where('status', 'disponivel')
    //             ->where('ativo', true)
    //             ->first();

    //         if (!$agendamento) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Horário não está mais disponível.'
    //             ], 400);
    //         }

    //         // Associar cliente ao agendamento
    //         $agendamento->update([
    //             'cliente_id' => $cliente->id,
    //             'status' => 'agendado',
    //             'observacoes' => $request->observacoes
    //         ]);

    //         // Associar serviços selecionados
    //         $servicos = Produto::whereIn('id', $request->servicos)->get();
    //         $valorTotal = 0;

    //         foreach ($servicos as $servico) {
    //             $agendamento->produtos()->attach($servico->id, [
    //                 'quantidade' => 1,
    //                 'valor_unitario' => $servico->preco
    //             ]);
    //             $valorTotal += $servico->preco;
    //         }

    //         // Buscar produtos sugeridos
    //         $produtosSugeridos = Produto::where('ativo', true)
    //             ->where('site', true)
    //             ->where('tipo', 'produto')
    //             ->take(6)
    //             ->get();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Agendamento realizado com sucesso!',
    //             'agendamento' => [
    //                 'id' => $agendamento->id,
    //                 'data' => $agendamento->data_agendamento,
    //                 'hora' => $agendamento->hora_inicio,
    //                 'cliente' => $cliente->nome,
    //                 'servicos' => $servicos->pluck('nome')->toArray()
    //             ],
    //             'produtos_sugeridos' => $produtosSugeridos,
    //             'valor_total' => $valorTotal
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erro ao processar agendamento: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function adicionarProdutos(Request $request)
    // {
    //     $request->validate([
    //         'agendamento_id' => 'required|exists:agendamentos,id',
    //         'produtos' => 'nullable|array',
    //         'produtos.*' => 'exists:produtos,id',
    //         'criar_cobranca' => 'nullable|boolean'
    //     ]);

    //     try {
    //         $agendamento = Agendamento::findOrFail($request->agendamento_id);
            
    //         if (!empty($request->produtos)) {
    //             $produtos = Produto::whereIn('id', $request->produtos)->get();
    //             $valorProdutos = 0;
                
    //             // Associar produtos ao agendamento
    //             foreach ($produtos as $produto) {
    //                 $agendamento->produtos()->attach($produto->id, [
    //                     'quantidade' => 1,
    //                     'valor_unitario' => $produto->preco
    //                 ]);
    //                 $valorProdutos += $produto->preco;
    //             }

    //             if ($request->criar_cobranca && $valorProdutos > 0) {
    //                 \App\Models\MovimentacaoFinanceira::create([
    //                     'agendamento_id' => $agendamento->id,
    //                     'tipo' => 'entrada',
    //                     'categoria_id' => 2, // Categoria de produtos
    //                     'descricao' => 'Produtos - ' . $agendamento->cliente->nome,
    //                     'valor' => $valorProdutos,
    //                     'data_vencimento' => $agendamento->data_agendamento,
    //                     'situacao' => 'em_aberto',
    //                     'ativo' => true
    //                 ]);
    //             }
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Produtos processados com sucesso!',
    //             'valor_produtos' => $request->produtos ? $valorProdutos : 0
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erro ao processar produtos: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function finalizarAgendamentoCompleto(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:agendamentos,id',
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'observacoes' => 'nullable|string|max:500',
            'produtos' => 'nullable|array',
            'produtos.*' => 'exists:produtos,id',
            'criar_cobranca' => 'nullable|boolean'
        ]);

        try {
            // Buscar ou criar cliente pelo telefone
            $telefone = preg_replace('/\D/', '', $request->telefone);
            
            $cliente = Cliente::where('telefone1', $telefone)
                ->orWhere('telefone1', $request->telefone)
                ->orWhere('telefone2', $telefone)
                ->orWhere('telefone2', $request->telefone)
                ->orWhere('email', $request->email)
                ->first();
            
            if (!$cliente) {
                $cliente = Cliente::create([
                    'nome' => $request->nome,
                    'telefone' => $request->telefone,
                    'email' => $request->email,
                    'sexo' => 'M',
                    'ativo' => true
                ]);
            }

            // Buscar o slot disponível
            $agendamento = Agendamento::where('id', $request->slot_id)
                ->where('status', 'disponivel')
                ->where('ativo', true)
                ->first();

            if (!$agendamento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Horário não está mais disponível.'
                ], 400);
            }

            // Associar cliente ao agendamento
            $agendamento->update([
                'cliente_id' => $cliente->id,
                'status' => 'agendado',
                'observacoes' => $request->observacoes
            ]);

            $valorTotal = 0;

            // Associar produtos selecionados se houver
            if (!empty($request->produtos)) {
                $produtos = Produto::whereIn('id', $request->produtos)->get();
                
                foreach ($produtos as $produto) {
                    $agendamento->produtos()->attach($produto->id, [
                        'quantidade' => 1,
                        'valor_unitario' => $produto->preco
                    ]);
                    $valorTotal += $produto->preco;
                }

            }

            if (!empty($request->servicos)) {
                $servicos = Produto::whereIn('id', $request->servicos)->get();
                
                foreach ($servicos as $servico) {
                    $agendamento->produtos()->attach($servico->id, [
                        'quantidade' => 1,
                        'valor_unitario' => $servico->preco
                    ]);
                    $valorTotal += $servico->preco;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Agendamento finalizado com sucesso!',
                'agendamento' => [
                    'id' => $agendamento->id,
                    'data' => $agendamento->data_agendamento,
                    'hora' => $agendamento->hora_inicio,
                    'cliente' => $cliente->nome
                ],
                'valor_total' => $valorTotal,
                'cobranca_criada' => $request->criar_cobranca && $valorTotal > 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao finalizar agendamento: ' . $e->getMessage()
            ], 500);
        }
    }
}
