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
