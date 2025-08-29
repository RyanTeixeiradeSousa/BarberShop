<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
                             ->orderBy('hora_inicio', 'desc')
                             ->paginate($request->get('per_page', 10));

        $total = Agendamento::count();
        $disponiveis = Agendamento::where('status', 'disponivel')->count();
        $agendados = Agendamento::where('status', 'agendado')->count();
        $concluidos = Agendamento::where('status', 'concluido')->count();
        $cancelados = Agendamento::where('status', 'cancelado')->count();

        $clientes = Cliente::where('ativo', true)->get();
        $produtos = Produto::where('ativo', true)->where('tipo', 'servico')->get();

        return view('admin.agendamentos.index', compact(
            'agendamentos', 'total', 'disponiveis', 'agendados', 'concluidos', 'cancelados', 'clientes', 'produtos'
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

    public function associarSlot(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicos' => 'required|array|min:1',
            'servicos.*.produto_id' => 'required|exists:produtos,id',
            'servicos.*.quantidade' => 'required|integer|min:1',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        $agendamento->associarClienteServicos(
            $request->cliente_id,
            $request->servicos,
            $request->observacoes
        );

        return redirect()->route('agendamentos.index')
            ->with('success', 'Cliente e serviços associados ao slot com sucesso!');
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
        $agendamento->delete();

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}
