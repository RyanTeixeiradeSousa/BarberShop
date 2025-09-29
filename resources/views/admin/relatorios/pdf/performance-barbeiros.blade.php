<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Agendamento;
use App\Models\Barbeiro;
use App\Models\MovimentacaoFinanceira;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('admin.relatorios.index');
    }

    public function faturamentoMensal(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'filial_id' => 'nullable|exists:filiais,id',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $filialId = $request->filial_id;

        // Consulta base para faturamento
        $query = MovimentacaoFinanceira::whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->where('tipo', 'receita')
            ->where('situacao', 'pago');

        if ($filialId) {
            $query->where('filial_id', $filialId);
        }

        // Dados do relatório
        $faturamento = $query->get();
        
        $totalFaturamento = $faturamento->sum('valor');
        $totalTransacoes = $faturamento->count();
        
        // Faturamento por dia
        $faturamentoPorDia = $faturamento->groupBy(function($item) {
            return Carbon::parse($item->data_vencimento)->format('Y-m-d');
        })->map(function($group) {
            return [
                'data' => Carbon::parse($group->first()->data_vencimento)->format('d/m/Y'),
                'valor' => $group->sum('valor'),
                'transacoes' => $group->count()
            ];
        })->sortBy('data');

        // Faturamento por forma de pagamento
        $faturamentoPorFormaPagamento = $faturamento->groupBy('forma_pagamento_id')
            ->map(function($group) {
                return [
                    'forma_pagamento' => $group->first()->formaPagamento->nome ?? 'Não informado',
                    'valor' => $group->sum('valor'),
                    'transacoes' => $group->count()
                ];
            });

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'filial_id' => $filialId,
            'total_faturamento' => $totalFaturamento,
            'total_transacoes' => $totalTransacoes,
            'faturamento_por_dia' => $faturamentoPorDia,
            'faturamento_por_forma_pagamento' => $faturamentoPorFormaPagamento,
            'movimentacoes' => $faturamento
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.faturamento-mensal', $data);
            return $pdf->download('faturamento-mensal-' . date('Y-m-d') . '.pdf');
        }

        // TODO: Implementar exportação para Excel
        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function comissoesBarbeiros(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'barbeiro_id' => 'nullable|exists:barbeiros,id',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $barbeiroId = $request->barbeiro_id;

        // Consulta para comissões
        $query = DB::table('agendamentos')
            ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
            ->join('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->whereBetween('agendamentos.data_agendamento', [$dataInicio, $dataFim])
            ->where('agendamentos.status', 'concluido');

        if ($barbeiroId) {
            $query->where('agendamentos.barbeiro_id', $barbeiroId);
        }

        $comissoes = $query->select(
            'barbeiros.id as barbeiro_id',
            'barbeiros.nome as barbeiro_nome',
            'produtos.nome as produto_nome',
            'produtos.tipo as produto_tipo',
            'agendamento_produto.quantidade',
            'agendamento_produto.valor_unitario',
            DB::raw('(agendamento_produto.quantidade * agendamento_produto.valor_unitario) as valor_total'),
            DB::raw('(agendamento_produto.quantidade * agendamento_produto.valor_unitario * barbeiros.percentual_comissao / 100) as valor_comissao'),
            'agendamentos.data_agendamento'
        )->get();

        // Resumo por barbeiro
        $resumoPorBarbeiro = $comissoes->groupBy('barbeiro_id')->map(function($group) {
            return [
                'barbeiro_nome' => $group->first()->barbeiro_nome,
                'total_vendas' => $group->sum('valor_total'),
                'total_comissoes' => $group->sum('valor_comissao'),
                'total_servicos' => $group->count()
            ];
        });

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'barbeiro_id' => $barbeiroId,
            'comissoes' => $comissoes,
            'resumo_por_barbeiro' => $resumoPorBarbeiro,
            'total_geral_vendas' => $comissoes->sum('valor_total'),
            'total_geral_comissoes' => $comissoes->sum('valor_comissao')
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.comissoes-barbeiros', $data);
            return $pdf->download('comissoes-barbeiros-' . date('Y-m-d') . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function novosClientes(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'sexo' => 'nullable|in:M,F',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $sexo = $request->sexo;

        $query = Cliente::whereBetween('created_at', [$dataInicio, $dataFim]);

        if ($sexo) {
            $query->where('sexo', $sexo);
        }

        $novosClientes = $query->orderBy('created_at', 'desc')->get();

        // Estatísticas
        $totalNovosClientes = $novosClientes->count();
        $clientesMasculinos = $novosClientes->where('sexo', 'M')->count();
        $clientesFemininos = $novosClientes->where('sexo', 'F')->count();

        // Clientes por dia
        $clientesPorDia = $novosClientes->groupBy(function($cliente) {
            return Carbon::parse($cliente->created_at)->format('Y-m-d');
        })->map(function($group, $data) {
            return [
                'data' => Carbon::parse($data)->format('d/m/Y'),
                'quantidade' => $group->count(),
                'masculino' => $group->where('sexo', 'M')->count(),
                'feminino' => $group->where('sexo', 'F')->count()
            ];
        })->sortBy('data');

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'sexo' => $sexo,
            'novos_clientes' => $novosClientes,
            'total_novos_clientes' => $totalNovosClientes,
            'clientes_masculinos' => $clientesMasculinos,
            'clientes_femininos' => $clientesFemininos,
            'clientes_por_dia' => $clientesPorDia
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.novos-clientes', $data);
            return $pdf->download('novos-clientes-' . date('Y-m-d') . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function aniversariantes(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'sexo' => 'nullable|in:M,F',
            'formato' => 'required|in:pdf,excel'
        ]);

        $mes = $request->mes;
        $sexo = $request->sexo;

        $query = Cliente::whereRaw('MONTH(data_nascimento) = ?', [$mes])
            ->where('ativo', 1)
            ->whereNotNull('data_nascimento');

        if ($sexo) {
            $query->where('sexo', $sexo);
        }

        $aniversariantes = $query->orderByRaw('DAY(data_nascimento)')
            ->get()
            ->map(function($cliente) {
                $cliente->idade = Carbon::parse($cliente->data_nascimento)->age;
                $cliente->dia_aniversario = Carbon::parse($cliente->data_nascimento)->day;
                return $cliente;
            });

        $data = [
            'mes' => $mes,
            'mes_nome' => Carbon::create()->month($mes)->translatedFormat('F'),
            'sexo' => $sexo,
            'aniversariantes' => $aniversariantes,
            'total_aniversariantes' => $aniversariantes->count(),
            'masculino' => $aniversariantes->where('sexo', 'M')->count(),
            'feminino' => $aniversariantes->where('sexo', 'F')->count()
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.aniversariantes', $data);
            return $pdf->download('aniversariantes-' . $data['mes_nome'] . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function taxaOcupacao(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'barbeiro_id' => 'nullable|exists:barbeiros,id',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $barbeiroId = $request->barbeiro_id;

        // Consulta para agendamentos no período
        $query = Agendamento::whereBetween('data_agendamento', [$dataInicio, $dataFim]);

        if ($barbeiroId) {
            $query->where('barbeiro_id', $barbeiroId);
        }

        $agendamentos = $query->with(['barbeiro', 'filial'])->get();

        // Cálculo da taxa de ocupação por barbeiro
        $ocupacaoPorBarbeiro = $agendamentos->groupBy('barbeiro_id')->map(function($group) {
            $barbeiro = $group->first()->barbeiro;
            $totalAgendamentos = $group->count();
            $agendamentosRealizados = $group->where('status', 'concluido')->count();
            $agendamentosCancelados = $group->where('status', 'cancelado')->count();
            
            return [
                'barbeiro_nome' => $barbeiro->nome,
                'total_agendamentos' => $totalAgendamentos,
                'realizados' => $agendamentosRealizados,
                'cancelados' => $agendamentosCancelados,
                'taxa_realizacao' => $totalAgendamentos > 0 ? ($agendamentosRealizados / $totalAgendamentos) * 100 : 0,
                'taxa_cancelamento' => $totalAgendamentos > 0 ? ($agendamentosCancelados / $totalAgendamentos) * 100 : 0
            ];
        });

        // Ocupação por dia da semana
        $ocupacaoPorDiaSemana = $agendamentos->groupBy(function($agendamento) {
            return Carbon::parse($agendamento->data_agendamento)->dayOfWeek;
        })->map(function($group, $diaSemana) {
            $nomesDias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
            return [
                'dia_semana' => $nomesDias[$diaSemana],
                'total_agendamentos' => $group->count(),
                'realizados' => $group->where('status', 'concluido')->count(),
                'cancelados' => $group->where('status', 'cancelado')->count()
            ];
        })->sortKeys();

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'barbeiro_id' => $barbeiroId,
            'ocupacao_por_barbeiro' => $ocupacaoPorBarbeiro,
            'ocupacao_por_dia_semana' => $ocupacaoPorDiaSemana,
            'total_agendamentos' => $agendamentos->count(),
            'total_realizados' => $agendamentos->where('status', 'concluido')->count(),
            'total_cancelados' => $agendamentos->where('status', 'cancelado')->count()
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.taxa-ocupacao', $data);
            return $pdf->download('taxa-ocupacao-' . date('Y-m-d') . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function performanceBarbeiros(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'barbeiro_id' => 'nullable|exists:barbeiros,id',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $barbeiroId = $request->barbeiro_id;

        // Performance dos barbeiros
        $query = DB::table('agendamentos')
            ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
            ->leftJoin('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->whereBetween('agendamentos.data_agendamento', [$dataInicio, $dataFim])
            ->where('agendamentos.status', 'concluido');

        if ($barbeiroId) {
            $query->where('agendamentos.barbeiro_id', $barbeiroId);
        }

        $performance = $query->select(
            'barbeiros.id',
            'barbeiros.nome',
            DB::raw('COUNT(DISTINCT agendamentos.id) as total_atendimentos'),
            DB::raw('COUNT(DISTINCT agendamentos.cliente_id) as clientes_unicos'),
            DB::raw('SUM(agendamento_produto.quantidade * agendamento_produto.valor_unitario) as faturamento_total'),
            DB::raw('AVG(agendamento_produto.valor_unitario) as ticket_medio')
        )
        ->groupBy('barbeiros.id', 'barbeiros.nome')
        ->orderBy('faturamento_total', 'desc')
        ->get();

        // Ranking de barbeiros
        $ranking = $performance->map(function($barbeiro, $index) {
            return [
                'posicao' => $index + 1,
                'nome' => $barbeiro->nome,
                'total_atendimentos' => $barbeiro->total_atendimentos,
                'clientes_unicos' => $barbeiro->clientes_unicos,
                'faturamento_total' => $barbeiro->faturamento_total,
                'ticket_medio' => $barbeiro->ticket_medio
            ];
        });

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'barbeiro_id' => $barbeiroId,
            'performance' => $performance,
            'ranking' => $ranking,
            'total_faturamento' => $performance->sum('faturamento_total'),
            'total_atendimentos' => $performance->sum('total_atendimentos')
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.performance-barbeiros', $data);
            return $pdf->download('performance-barbeiros-' . date('Y-m-d') . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }

    public function perfilClientes(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'sexo' => 'nullable|in:M,F',
            'faixa_etaria' => 'nullable|string',
            'status' => 'nullable|in:0,1',
            'formato' => 'required|in:pdf,excel'
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $sexo = $request->sexo;
        $faixaEtaria = $request->faixa_etaria;
        $status = $request->status;

        // Consulta base para clientes
        $query = Cliente::whereBetween('created_at', [$dataInicio, $dataFim]);

        if ($sexo) {
            $query->where('sexo', $sexo);
        }

        if ($status !== null) {
            $query->where('ativo', $status);
        }

        $clientes = $query->get();

        // Estatísticas gerais
        $estatisticas = [
            'total_clientes' => $clientes->count(),
            'clientes_ativos' => $clientes->where('ativo', 1)->count(),
            'masculino' => $clientes->where('sexo', 'M')->count(),
            'feminino' => $clientes->where('sexo', 'F')->count()
        ];

        // Análise por faixa etária
        $faixasEtarias = $clientes->filter(function($cliente) {
            return $cliente->data_nascimento;
        })->map(function($cliente) {
            $idade = Carbon::parse($cliente->data_nascimento)->age;
            if ($idade < 18) return '< 18 anos';
            if ($idade < 25) return '18-24 anos';
            if ($idade < 35) return '25-34 anos';
            if ($idade < 45) return '35-44 anos';
            if ($idade < 55) return '45-54 anos';
            return '55+ anos';
        })->countBy()->map(function($count, $faixa) use ($clientes) {
            $total = $clientes->count();
            return [
                'faixa_etaria' => $faixa,
                'quantidade' => $count,
                'percentual' => $total > 0 ? ($count / $total) * 100 : 0,
                'masculino' => 0, // TODO: Implementar contagem por sexo
                'feminino' => 0
            ];
        })->values();

        // Clientes por frequência de agendamentos
        $clientesFrequencia = DB::table('clientes')
            ->leftJoin('agendamentos', 'clientes.id', '=', 'agendamentos.cliente_id')
            ->leftJoin('movimentacao_financeiras', 'clientes.id', '=', 'movimentacao_financeiras.cliente_id')
            ->whereBetween('clientes.created_at', [$dataInicio, $dataFim])
            ->select(
                'clientes.*',
                DB::raw('COUNT(agendamentos.id) as total_agendamentos'),
                DB::raw('COALESCE(SUM(movimentacao_financeiras.valor), 0) as valor_total_gasto'),
                DB::raw('MAX(agendamentos.data_agendamento) as ultimo_agendamento')
            )
            ->groupBy('clientes.id')
            ->orderBy('total_agendamentos', 'desc')
            ->limit(50)
            ->get();

        // Serviços mais procurados
        $servicosPreferidos = DB::table('produtos')
            ->join('agendamento_produto', 'produtos.id', '=', 'agendamento_produto.produto_id')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->join('clientes', 'agendamentos.cliente_id', '=', 'clientes.id')
            ->whereBetween('clientes.created_at', [$dataInicio, $dataFim])
            ->where('produtos.tipo', 'servico')
            ->select(
                'produtos.nome',
                DB::raw('COUNT(DISTINCT agendamentos.cliente_id) as clientes_unicos'),
                DB::raw('SUM(agendamento_produto.quantidade) as total_utilizacoes'),
                DB::raw('AVG(agendamento_produto.valor_unitario) as valor_medio')
            )
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderBy('clientes_unicos', 'desc')
            ->limit(10)
            ->get();

        // Horários preferidos
        $horariosPreferidos = DB::table('agendamentos')
            ->join('clientes', 'agendamentos.cliente_id', '=', 'clientes.id')
            ->whereBetween('clientes.created_at', [$dataInicio, $dataFim])
            ->select(
                DB::raw('HOUR(agendamentos.hora_inicio) as hora'),
                DB::raw('COUNT(*) as quantidade')
            )
            ->groupBy('hora')
            ->orderBy('quantidade', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'horario' => sprintf('%02d:00 - %02d:59', $item->hora, $item->hora),
                    'quantidade' => $item->quantidade,
                    'percentual' => 0 // TODO: Calcular percentual
                ];
            });

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'sexo' => $sexo,
            'faixa_etaria' => $faixaEtaria,
            'status' => $status,
            'estatisticas' => $estatisticas,
            'faixas_etarias' => $faixasEtarias,
            'clientes_frequencia' => $clientesFrequencia,
            'servicos_preferidos' => $servicosPreferidos,
            'horarios_preferidos' => $horariosPreferidos
        ];

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('admin.relatorios.pdf.perfil-clientes', $data);
            return $pdf->download('perfil-clientes-' . date('Y-m-d') . '.pdf');
        }

        return response()->json(['message' => 'Formato Excel em desenvolvimento']);
    }
}
