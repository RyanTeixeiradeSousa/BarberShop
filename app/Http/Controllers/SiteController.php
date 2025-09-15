<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        ', ['agendado', 'em_andamento',  'em_aberto'])
        ->get(); // Retira produtos comprometidos
        return view('site.index', compact('configuracoes', 'servicos', 'produtos'));
    }

    public function agendamento()
    {
        $configuracoes = $this->getConfiguracoes();

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
            
            $cliente = Cliente::query()
            ->when($telefone, fn($q) => $q->where('telefone1', $telefone))
            ->when($request->telefone, fn($q) => $q->orWhere('telefone1', $request->telefone))
            ->when($request->email, fn($q) => $q->orWhere('email', $request->email))
            ->first();

            if($cliente){
                $cliente->email = $request->email;
                $cliente->ativo = true;
                $cliente->save();
            }
            
            if (!$cliente) {
                $cliente = Cliente::create([
                    'nome' => $request->nome,
                    'telefone1' => $request->telefone,
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
