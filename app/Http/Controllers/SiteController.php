<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $servicos = Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'servico')
            ->get();

        return view('site.agendamento', compact('configuracoes', 'servicos'));
    }

    public function salvarAgendamento(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'data_agendamento' => 'required|date',
            'hora_inicio' => 'required',
            'servicos' => 'required|array|min:1',
            'servicos.*' => 'exists:produtos,id',
            'produtos_sugeridos' => 'nullable|array',
            'produtos_sugeridos.*' => 'exists:produtos,id',
            'criar_movimento_financeiro' => 'nullable|boolean'
        ]);

        // Criar ou encontrar cliente
        $cliente = Cliente::firstOrCreate(
            ['telefone' => $request->telefone],
            [
                'nome' => $request->nome,
                'email' => $request->email,
                'sexo' => 'masculino',
                'ativo' => true
            ]
        );

        // Calcular duração total dos serviços
        $servicos = Produto::whereIn('id', $request->servicos)->get();
        $duracaoTotal = $servicos->sum('duracao') ?: 60; // fallback para 60 minutos

        $horaFim = Carbon::parse($request->data_agendamento . ' ' . $request->hora_inicio)
            ->addMinutes($duracaoTotal)
            ->format('H:i');

        // Criar agendamento
        $agendamento = Agendamento::create([
            'cliente_id' => $cliente->id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim,
            'status' => 'agendado',
            'observacoes' => $request->observacoes,
            'ativo' => true
        ]);

        // Associar serviços
        $valorTotal = 0;
        foreach ($request->servicos as $servicoId) {
            $servico = $servicos->find($servicoId);
            $agendamento->produtos()->attach($servicoId, [
                'quantidade' => 1,
                'valor_unitario' => $servico->preco
            ]);
            $valorTotal += $servico->preco;
        }

        if ($request->criar_movimento_financeiro) {
            \App\Models\MovimentacaoFinanceira::create([
                'agendamento_id' => $agendamento->id,
                'tipo' => 'entrada',
                'categoria_id' => 1, // Categoria padrão de serviços
                'descricao' => 'Agendamento - ' . $cliente->nome,
                'valor' => $valorTotal,
                'data_vencimento' => $request->data_agendamento,
                'situacao' => 'em_aberto',
                'ativo' => true
            ]);
        }

        $produtosSugeridos = \App\Models\Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'produto')
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso!',
            'agendamento_id' => $agendamento->id,
            'produtos_sugeridos' => $produtosSugeridos
        ]);
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
}
