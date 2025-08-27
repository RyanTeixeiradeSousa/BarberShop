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
        $query = Agendamento::with(['cliente', 'produto']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->whereHas('cliente', function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%");
            })->orWhereHas('produto', function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%");
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

        // Estatísticas
        $total = Agendamento::count();
        $agendados = Agendamento::where('status', 'agendado')->count();
        $concluidos = Agendamento::where('status', 'concluido')->count();
        $cancelados = Agendamento::where('status', 'cancelado')->count();

        $clientes = Cliente::where('ativo', true)->get();
        $produtos = Produto::where('ativo', true)->where('tipo', 'servico')->get();

        return view('admin.agendamentos.index', compact(
            'agendamentos', 'total', 'agendados', 'concluidos', 'cancelados', 'clientes', 'produtos'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'data_agendamento' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        // Calcular hora fim baseada na configuração
        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        // Buscar o preço do produto/serviço
        $produto = Produto::find($request->produto_id);

        $agendamento = Agendamento::create([
            'cliente_id' => $request->cliente_id,
            'produto_id' => $request->produto_id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'observacoes' => $request->observacoes,
            'valor' => $produto->preco,
            'status' => 'agendado'
        ]);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
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
            'produto_id' => $request->produto_id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'status' => $request->status,
            'observacoes' => $request->observacoes
        ]);

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
