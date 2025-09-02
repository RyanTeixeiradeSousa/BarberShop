<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Agendamento;
use App\Models\MovimentacaoFinanceira;
use App\Models\Produto;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();
        
        $stats = [
            'total_clientes' => Cliente::where('ativo', true)->count(),
            'agendamentos_hoje' => Agendamento::whereDate('data_agendamento', $hoje)
                ->whereIn('status', ['agendado', 'em_andamento', 'concluido'])
                ->count(),
            'faturamento_hoje' => MovimentacaoFinanceira::whereDate('created_at', $hoje)
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->sum('valor'),
            'servicos_concluidos' => Agendamento::whereDate('data_agendamento', $hoje)
                ->where('status', 'concluido')
                ->count()
        ];

        $ultimosAgendamentos = Agendamento::with(['cliente', 'produtos'])
            ->whereDate('data_agendamento', '>=', $hoje)
            ->orderBy('data_agendamento', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->limit(10)
            ->get();

        $receitasHoje = MovimentacaoFinanceira::whereDate('created_at', $hoje)
            ->where('tipo', 'entrada')
            ->where('situacao', 'pago')
            ->sum('valor');

        $despesasHoje = MovimentacaoFinanceira::whereDate('created_at', $hoje)
            ->where('tipo', 'saida')
            ->where('situacao', 'pago')
            ->sum('valor');

        $resumoFinanceiro = [
            'receitas_hoje' => $receitasHoje,
            'despesas_hoje' => $despesasHoje,
            'lucro_liquido' => $receitasHoje - $despesasHoje
        ];

        $proximosAgendamentos = Agendamento::with(['cliente', 'produtos'])
            ->whereDate('data_agendamento', $hoje)
            ->where('hora_inicio', '>', Carbon::now()->format('H:i:s'))
            ->whereIn('status', ['agendado', 'em_andamento'])
            ->orderBy('hora_inicio', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'ultimosAgendamentos', 
            'resumoFinanceiro', 
            'proximosAgendamentos'
        ));
    }
}
