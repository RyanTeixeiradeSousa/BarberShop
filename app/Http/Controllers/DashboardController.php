<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Agendamento;
use App\Models\MovimentacaoFinanceira;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();
        
        $stats = [
            'total_clientes' => Cliente::all()->count(),
            'agendamentos_hoje' => Agendamento::whereDate('data_agendamento', $hoje)
                ->whereIn('status', ['agendado', 'confirmado', 'em_andamento', 'concluido'])
                ->count(),
            'faturamento_hoje' => MovimentacaoFinanceira::whereDate('data', $hoje)
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total'),
            'servicos_concluidos' => Agendamento::whereDate('data_agendamento', $hoje)
                ->where('status', 'concluido')
                ->count()
        ];

        $financeiro = [
            'receitas_hoje' => MovimentacaoFinanceira::whereDate('data', $hoje)
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total'),
            'despesas_hoje' => MovimentacaoFinanceira::whereDate('data', $hoje)
                ->where('tipo', 'saida')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total'),
            'faturamento_mensal' => MovimentacaoFinanceira::whereBetween('data', [$inicioMes, $fimMes])
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total'),
            'contas_abertas' => MovimentacaoFinanceira::where('situacao', 'em_aberto')->count()
        ];
        
        $financeiro['lucro_liquido'] = $financeiro['receitas_hoje'] - $financeiro['despesas_hoje'];

        $agendamentos = [
            'hoje_total' => Agendamento::whereDate('data_agendamento', $hoje)->count(),
            'hoje_concluidos' => Agendamento::whereDate('data_agendamento', $hoje)
                ->where('status', 'concluido')->count(),
            'hoje_em_andamento' => Agendamento::whereDate('data_agendamento', $hoje)
                ->where('status', 'em_andamento')->count(),
            'hoje_agendados' => Agendamento::whereDate('data_agendamento', $hoje)
                ->whereIn('status', ['agendado', 'confirmado'])->count(),
            'hoje_cancelados' => Agendamento::whereDate('data_agendamento', $hoje)
                ->where('status', 'cancelado')->count()
        ];

        $produtos = [
            'total_produtos' => Produto::where('ativo', true)->where('tipo', 'produto')->count(),
            'total_servicos' => Produto::where('ativo', true)->where('tipo', 'servico')->count(),
            'estoque_baixo' => Produto::where('ativo', true)
                ->where('tipo', 'produto')
                ->where('estoque', '<=', 5)
                ->count(),
            'mais_vendidos' =>  DB::table('movimentacao_produto')
                ->join('movimentacoes_financeiras', 'movimentacao_produto.movimentacao_financeira_id', '=', 'movimentacoes_financeiras.id')
                ->whereBetween('movimentacoes_financeiras.data_pagamento', [$inicioMes, $fimMes])
                ->where('movimentacoes_financeiras.situacao', 'pago')
                ->distinct('movimentacao_produto.movimentacao_financeira_id')
                ->count()
        ];

        $agendamentosHoje = Agendamento::with(['cliente', 'produtos'])
            ->whereDate('data_agendamento', $hoje)
            ->orderBy('hora_inicio', 'asc')
            ->get();

        $proximosAgendamentos = Agendamento::with(['cliente', 'produtos'])
            ->whereDate('data_agendamento', $hoje)
            ->where('hora_inicio', '>', Carbon::now()->format('H:i:s'))
            ->whereIn('status', ['agendado', 'confirmado', 'em_andamento'])
            ->orderBy('hora_inicio', 'asc')
            ->limit(5)
            ->get();

        $movimentacoesRecentes = MovimentacaoFinanceira::with(['cliente', 'categoriaFinanceira'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $produtosMaisUtilizados = DB::table('movimentacao_produto')
            ->join('produtos', 'movimentacao_produto.produto_id', '=', 'produtos.id')
            ->join('movimentacoes_financeiras', 'movimentacao_produto.movimentacao_financeira_id', '=', 'movimentacoes_financeiras.id')
            ->whereBetween('movimentacoes_financeiras.data_pagamento', [$inicioMes, $fimMes])
            ->where('movimentacoes_financeiras.situacao', 'pago')
            ->select('produtos.nome', 'produtos.tipo', 'produtos.preco', 
                    DB::raw('SUM(movimentacao_produto.quantidade) as total_utilizacoes'))
            ->groupBy('produtos.id', 'produtos.nome', 'produtos.tipo', 'produtos.preco')
            ->orderBy('total_utilizacoes', 'desc')
            ->limit(5)
            ->get();

        $produtosEstoqueBaixo = Produto::where('ativo', true)
            ->where('tipo', 'produto')
            ->where('estoque', '<=', 10)
            ->orderBy('estoque', 'asc')
            ->limit(5)
            ->get();

        $totalServicos = DB::table('agendamento_produto')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->whereBetween('agendamentos.data_agendamento', [$inicioMes, $fimMes])
            ->where('agendamentos.status', 'concluido')
            ->sum('agendamento_produto.quantidade');

        $servicosMaisSolicitados = DB::table('agendamento_produto')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->whereBetween('agendamentos.data_agendamento', [$inicioMes, $fimMes])
            ->where('agendamentos.status', 'concluido')
            ->where('produtos.tipo', 'servico')
            ->select('produtos.nome', 
                    DB::raw('SUM(agendamento_produto.quantidade) as total'),
                    DB::raw('ROUND((SUM(agendamento_produto.quantidade) * 100.0 / ' . ($totalServicos ?: 1) . '), 1) as percentual'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $chartData = [
            'faturamento_semanal' => $this->getFaturamentoSemanal(),
            'receitas_despesas' => $this->getReceitasDespesas(),
            'agendamentos_semana' => $this->getAgendamentosSemana(),
            'produtos_utilizados' => $produtosMaisUtilizados->take(5)
        ];

        return view('admin.dashboard', compact(
            'stats', 
            'financeiro',
            'agendamentos',
            'produtos',
            'agendamentosHoje',
            'proximosAgendamentos',
            'movimentacoesRecentes',
            'produtosMaisUtilizados',
            'produtosEstoqueBaixo',
            'servicosMaisSolicitados',
            'chartData'
        ));
    }

    private function getFaturamentoSemanal()
    {
        $dados = [];
        for ($i = 6; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i);
            $faturamento = MovimentacaoFinanceira::whereDate('data', $data)
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total');
            
            $dados[] = [
                'dia' => $data->format('d/m'),
                'valor' => (float) $faturamento
            ];
        }
        return $dados;
    }

    private function getReceitasDespesas()
    {
        $dados = [];
        for ($i = 6; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i);
            
            $receitas = MovimentacaoFinanceira::whereDate('data', $data)
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total');
                
            $despesas = MovimentacaoFinanceira::whereDate('data', $data)
                ->where('tipo', 'saida')
                ->where('situacao', 'pago')
                ->selectRaw('SUM(valor_pago - desconto) as total')
                ->value('total');
            
            $dados[] = [
                'dia' => $data->format('d/m'),
                'receitas' => (float) $receitas,
                'despesas' => (float) $despesas
            ];
        }
        return $dados;
    }

    private function getAgendamentosSemana()
    {
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $dados = [];
        
        foreach ($diasSemana as $index => $dia) {
            $total = Agendamento::whereRaw('DAYOFWEEK(data_agendamento) = ?', [$index + 1])
                ->whereBetween('data_agendamento', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count();
                
            $dados[] = [
                'dia' => $dia,
                'total' => $total
            ];
        }
        return $dados;
    }
}
