<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\FormaPagamento;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Exception;
class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with(['cliente', 'produtos']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->whereHas('cliente', function($subQ) use ($busca) {
                    $subQ->where('nome', 'like', "%{$busca}%");
                })->orWhereHas('produtos', function($subQ) use ($busca) {
                    $subQ->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->where('data_agendamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data_agendamento', '<=', $request->data_fim);
        }

        $agendamentos = $query->orderBy('data_agendamento', 'desc')
                             ->orderBy('hora_inicio', 'asc')
                             ->paginate($request->get('per_page', 10));

        $total = Agendamento::count();
        $disponiveis = Agendamento::where('status', 'disponivel')->count();
        $agendados = Agendamento::where('status', 'agendado')->count();
        $concluidos = Agendamento::where('status', 'concluido')->count();
        $cancelados = Agendamento::where('status', 'cancelado')->count();

        $clientes = Cliente::where('ativo', true)->get();
        $produtos = Produto::where('ativo', true)->where('tipo', 'servico')->get();
        $formasPagamento = FormaPagamento::where('ativo', 1)->get();
        return view('admin.agendamentos.index', compact(
            'agendamentos', 'total', 'disponiveis', 'agendados', 'concluidos', 'cancelados', 'clientes', 'produtos', 'formasPagamento'
        ));
    }

    public function criarSlot(Request $request)
    {
        $request->validate([
            'data_agendamento' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
        ]);
    
        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento = Agendamento::create([
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'status' => 'disponivel'
        ]);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Slot criado com sucesso!');
    }

    public function associarSlot(Request $request, Agendamento $id)
    {
        try{
            $agendamento = $id;
            $validator = Validator::make($request->all(), [
                'cliente_id' => 'required|exists:clientes,id',
                'servicos' => 'required|array|min:1',
                'servicos.*.produto_id' => 'required|exists:produtos,id',
                'servicos.*.quantidade' => 'required|integer|min:1',
                'observacoes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Erro ao tentar associar cliente a slot.' . $validator->errors()->first()]);

            }
    
            // Verificar se o slot está disponível
            if ($agendamento->status !== 'disponivel') {
                return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Este slot não está mais disponível!']);
            }
            $agendamento->update([
                'cliente_id' => $request->cliente_id,
                'status' => 'agendado',
                'observacoes' => $request->observacoes
            ]);
    
            $servicos = [];
            foreach ($request->servicos as $servico) {
                $produto = Produto::find($servico['produto_id']);
                $servicos[$servico['produto_id']] = [
                    'quantidade' => $servico['quantidade'],
                    'valor_unitario' => $produto->preco ?? 0
                ];
            }
            
            $agendamento->produtos()->sync($servicos);
            return redirect()->route('agendamentos.index')->with(['type' => 'success', 'message' => 'Cliente associado ao slot.']);

        } catch(Exception $e){
            return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Erro ao tentar associar cliente a slot.' . $e->getMessage()]);
        }

        
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'servicos' => 'nullable|array',
            'servicos.*.produto_id' => 'required_with:servicos|exists:produtos,id',
            'servicos.*.quantidade' => 'required_with:servicos|integer|min:1',
            'data_agendamento' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento = Agendamento::create([
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'observacoes' => $request->observacoes,
            'status' => 'disponivel'
        ]);

        // Se tem cliente e serviços, associar
        if ($request->filled('cliente_id') && $request->filled('servicos')) {
            $agendamento->associarClienteServicos(
                $request->cliente_id,
                $request->servicos,
                $request->observacoes
            );
        }

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicos' => 'required|array|min:1',
            'servicos.*.produto_id' => 'required|exists:produtos,id',
            'servicos.*.quantidade' => 'required|integer|min:1',
            'data_agendamento' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'status' => 'required|in:agendado,confirmado,em_andamento,concluido,cancelado',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        // Recalcular hora fim se necessário
        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento->update([
            'cliente_id' => $request->cliente_id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'status' => $request->status,
            'observacoes' => $request->observacoes
        ]);

        // Atualizar serviços
        $agendamento->associarClienteServicos(
            $request->cliente_id,
            $request->servicos,
            $request->observacoes
        );

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento)
    {
        try{
            $agendamento->delete();
            return redirect()->route('agendamentos.index')->with(['type' => 'success', 'message' =>  'Agendamento excluído com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' =>  'Erro ao excluir o agendamento. ' . $e->getMessage()]);
        }

    }

    public function gerarEmLote(Request $request)
    {
        try {
            $request->validate([
                'data_inicio' => 'required|date|after_or_equal:today',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
                'dias' => 'required|array|min:1',
                'dias.*' => 'in:0,1,2,3,4,5,6', // 0=domingo, 1=segunda, etc.
                'intervalo_minutos' => 'nullable|integer|min:30|max:480'
            ]);
            

            $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
            $intervalo = $request->intervalo_minutos ?? $duracaoPadrao;

            $dataAtual = Carbon::parse($request->data_inicio);
            $dataFim = Carbon::parse($request->data_fim);
            $slotsGerados = 0;

            if ($dataAtual->diffInYears($dataFim) > 3) {
                return redirect()->route('agendamentos.index')
                ->with(['type' => 'error','message' => "Erro ao tentar gerar lote de agendamentos. O intervalo entre as datas não pode ser superior a 3 anos."]);
            }

            while ($dataAtual->lte($dataFim)) {
                if (in_array($dataAtual->dayOfWeek, $request->dias)) {
                    
                    $horaAtual = Carbon::createFromFormat('H:i', $request->hora_inicio);
                    $horaFimDia = Carbon::createFromFormat('H:i', $request->hora_fim);

                    while ($horaAtual->lt($horaFimDia)) {
                        $horaFimSlot = $horaAtual->copy()->addMinutes($duracaoPadrao);

                        // Verificar se já existe agendamento neste horário
                        $existeAgendamento = Agendamento::where('data_agendamento', $dataAtual->format('Y-m-d'))
                            ->where('hora_inicio', $horaAtual->format('H:i'))
                            ->exists();

                        if (!$existeAgendamento) {
                            Agendamento::create([
                                'data_agendamento' => $dataAtual->format('Y-m-d'),
                                'hora_inicio' => $horaAtual->format('H:i'),
                                'hora_fim' => $horaFimSlot->format('H:i'),
                                'status' => 'disponivel'
                            ]);

                            $slotsGerados++;
                        }

                        $horaAtual->addMinutes($intervalo);
                    }
                }

                $dataAtual->addDay();
            }

            return redirect()->route('agendamentos.index')
                ->with(['type' => 'success','message' => "Gerados {$slotsGerados} slots de agendamento com sucesso!"]);

        } catch(Exception $e) {
            return redirect()->route('agendamentos.index')
                ->with(['type' => 'error','message' => "Erro ao tentar gerar lote de agendamentos. " . $e->getMessage()]);
        }

    }

    public function show(Agendamento $agendamento)
    {
        $agendamento->load(['cliente', 'produtos']);
        
        // Calcular valor total dos serviços
        $valorTotal = $agendamento->produtos->sum(function($produto) {
            return $produto->pivot->quantidade * $produto->pivot->valor_unitario;
        });

        // Definir cor e label do status
        $statusColors = [
            'disponivel' => 'secondary',
            'agendado' => 'primary',
            'em_andamento' => 'warning',
            'concluido' => 'success',
            'cancelado' => 'danger'
        ];

        $statusLabels = [
            'disponivel' => 'Disponível',
            'agendado' => 'Agendado',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado'
        ];

        return response()->json([
            'id' => $agendamento->id,
            'cliente' => $agendamento->cliente,
            'produtos' => $agendamento->produtos,
            'data_agendamento' => $agendamento->data_agendamento,
            'hora_inicio' => $agendamento->hora_inicio,
            'hora_fim' => $agendamento->hora_fim,
            'status' => $agendamento->status,
            'status_color' => $statusColors[$agendamento->status] ?? 'secondary',
            'status_label' => $statusLabels[$agendamento->status] ?? 'Desconhecido',
            'observacoes' => $agendamento->observacoes,
            'valor_total' => $valorTotal
        ]);
    }

    public function cancelarAtendimento(Agendamento $agendamento)
    {
        if ($agendamento->status !== 'agendado') {
            return response()->json([
                'success' => false,
                'message' => 'Apenas agendamentos com status "agendado" podem ser cancelados.'
            ]);
        }

        // Desassociar cliente e serviços
        $agendamento->update([
            'cliente_id' => null,
            'status' => 'disponivel',
            'observacoes' => null
        ]);

        // Remover serviços associados
        $agendamento->produtos()->detach();

        return response()->json([
            'success' => true,
            'message' => 'Atendimento cancelado com sucesso!'
        ]);
    }

    public function iniciarAtendimento(Agendamento $agendamento)
    {
        if ($agendamento->status === 'agendado') {
             $agendamento->update([
                'status' => 'em_andamento',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Atendimento iniciado!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Atendimento precisa estar agendado.'
        ]); 
    }

    public function mudarStatus(Agendamento $agendamento)
    {
        if ($agendamento->status === 'agendado') {
            $agendamento->update(['status' => 'em_andamento']);
            
            return response()->json([
                'success' => true,
                'message' => 'Atendimento iniciado com sucesso!',
                'novo_status' => 'em_andamento'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Status não pode ser alterado.'
        ]);
    }

    public function finalizarAtendimento(Request $request, Agendamento $agendamento)
    {
        $validator = Validator::make($request->all(), [
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'valor_pago_decimal' => 'required|numeric|min:0',
            'desconto_decimal' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('agendamentos.index')->with([
                'type' => 'error',
                'message' => 'Campos inválidos na requisição',
                'errors' => $validator->errors()
            ]);
        }

        if ($agendamento->status !== 'em_andamento') {
            return redirect()->route('agendamentos.index')->with([
                'type' => 'error',
                'message' => 'Apenas atendimentos em andamento podem ser finalizados.'
            ]);
        }

        // Atualizar status do agendamento
        $agendamento->update(['status' => 'concluido']);

        // Criar movimentação financeira
        $movimentacao = \App\Models\MovimentacaoFinanceira::create([
            'tipo' => 'entrada',
            'descricao' => 'Atendimento - ' . $agendamento->cliente->nome,
            'valor' => $request->valor_pago_decimal,
            'data' => now()->format('Y-m-d'),
            'data_vencimento' => now()->format('Y-m-d'),
            'cliente_id' => $agendamento->cliente_id,
            'agendamento_id' => $agendamento->id,
            'situacao' => 'pago',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'data_pagamento' => now()->format('Y-m-d'),
            'desconto' => $request->desconto_decimal ?? 0,
            'valor_pago' => $request->valor_pago_decimal,
            'ativo' => true
        ]);

        // Associar produtos à movimentação financeira
        $produtos = [];
        foreach ($agendamento->produtos as $produto) {
            $produtos[$produto->id] = [
                'quantidade' => $produto->pivot->quantidade,
                'valor_unitario' => $produto->pivot->valor_unitario
            ];
        }
        $movimentacao->produtos()->sync($produtos);

        return redirect()->route('agendamentos.index')->with([
            'type' => 'success',
            'message' => 'Atendimento finalizado com sucesso!'
        ]);
    }
}
