<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Agendamento;
use App\Models\Barbeiro;
use App\Models\FormaPagamento;
use App\Models\MovimentacaoFinanceira;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use PhpParser\Node\Stmt\Echo_;

class RelatorioController extends Controller
{
    public function index()
    {
        $barbeiros = Barbeiro::where('ativo', 1)->orderBy('nome')->get();
        $formaPagamento = FormaPagamento::orderBy('nome')->get();
        $clientes = Cliente::where('ativo', 1)->orderBy('nome')->limit(100)->get(); // Limitando para performance
        
        return view('admin.relatorios.index', compact('barbeiros', 'clientes', 'formaPagamento'));
    }

    public function faturamentoMensal(Request $request)
    {
        try{
            $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'filial_id' => 'nullable|exists:filiais,id'
            ]);
    
            $dataInicio = $request->data_inicio;
            $dataFim = $request->data_fim;
            $filialId = $request->filial_id;
            $formaPagamento = $request->forma_pagamento;
    
            // Consulta base para faturamento
            $query = MovimentacaoFinanceira::whereBetween('data_pagamento', [$dataInicio, $dataFim])
                ->where('tipo', 'entrada')
                ->where('situacao', 'pago');
    
            if ($filialId) {
                $query->where('filial_id', $filialId);
            }

            if ($formaPagamento) {
                $query->where('forma_pagamento_id', $filialId);
            }
    
            // Dados do relatório
            $faturamento = $query->get();
            
            $totalFaturamento = $faturamento->sum('valor_pago');
            $totalTransacoes = $faturamento->count();
            
            // Faturamento por dia
            $faturamentoPorDia = $faturamento->groupBy(function($item) {
                return Carbon::parse($item->data_pagamento)->format('Y-m-d');
            })->map(function($group) {
                return [
                    'data' => Carbon::parse($group->first()->data_pagamento)->format('d/m/Y'),
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
    
            $pdf = Pdf::loadView('admin.relatorios.pdf.faturamento-mensal', compact('data'));
            return $pdf->download('faturamento-mensal-' . date('Y-m-d') . '.pdf');

        } catch(Exception $e){
            return view('admin.relatorios.index')->with(['message' => 'Erro ao carregar relatório', 'type' => 'error']);

        }
        

        
    }

    public function despesas(Request $request)
    {
        try {
            $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'categoria_id' => 'nullable|exists:categorias_financeiras,id',
                'forma_pagamento_id' => 'nullable|exists:formas_pagamento,id',
                'situacao' => 'nullable|in:pago,em_aberto,cancelado',
            ]);

            $dataInicio = $request->data_inicio;
            $dataFim = $request->data_fim;
            $categoriaId = $request->categoria_id;
            $formaPagamentoId = $request->forma_pagamento_id;
            $situacao = $request->situacao;

            // Consulta base para despesas
            $query = MovimentacaoFinanceira::whereBetween('data_pagamento', [$dataInicio, $dataFim])
                ->where('tipo', 'saida');

            if ($categoriaId) {
                $query->where('categoria_financeira_id', $categoriaId);
            }

            if ($formaPagamentoId) {
                $query->where('forma_pagamento_id', $formaPagamentoId);
            }

            if ($situacao) {
                $query->where('situacao', $situacao);
            }

            $despesas = $query->with(['categoriaFinanceira', 'formaPagamento', 'filial'])->get();
            
            $totalDespesas = $despesas->sum(function($d) {
                return $d->valor_pago ?? $d->valor;
            });
            $totalTransacoes = $despesas->count();
            
            // Despesas por situação
            $despesasPagas = $despesas->where('situacao', 'pago')->sum(function($d) {
                return $d->valor_pago ?? $d->valor;
            });
            $transacoesPagas = $despesas->where('situacao', 'pago')->count();
            
            $despesasPendentes = $despesas->where('situacao', 'em_aberto')->sum(function($d) {
                return $d->valor_pago ?? $d->valor;
            });
            $transacoesPendentes = $despesas->where('situacao', 'em_aberto')->count();
            
            // Despesas por dia
            $despesasPorDia = $despesas->groupBy(function($item) {
                return Carbon::parse($item->data_pagamento)->format('Y-m-d');
            })->map(function($group) {
                return [
                    'data' => Carbon::parse($group->first()->data_pagamento)->format('d/m/Y'),
                    'valor' => $group->sum(function($d) {
                        return $d->valor_pago ?? $d->valor;
                    }),
                    'transacoes' => $group->count()
                ];
            })->sortBy('data');

            // Despesas por categoria
            $despesasPorCategoria = $despesas->groupBy('categoria_financeira_id')
                ->map(function($group) {
                    return [
                        'categoria' => $group->first()->categoriaFinanceira->nome ?? 'Sem categoria',
                        'valor' => $group->sum(function($d) {
                            return $d->valor_pago ?? $d->valor;
                        }),
                        'transacoes' => $group->count()
                    ];
                })->sortByDesc('valor');

            // Despesas por forma de pagamento
            $despesasPorFormaPagamento = $despesas->groupBy('forma_pagamento_id')
                ->map(function($group) {
                    return [
                        'forma_pagamento' => $group->first()->formaPagamento->nome ?? 'Não informado',
                        'valor' => $group->sum(function($d) {
                            return $d->valor_pago ?? $d->valor;
                        }),
                        'transacoes' => $group->count()
                    ];
                });

            $despesasPorFilial = $despesas->groupBy('filial_id')
                ->map(function($group) {
                    return [
                        'filial' => $group->first()->filial->nome ?? 'Sem filial',
                        'valor' => $group->sum(function($d) {
                            return $d->valor_pago ?? $d->valor;
                        }),
                        'transacoes' => $group->count(),
                        'pagas' => $group->where('situacao', 'pago')->count(),
                        'pendentes' => $group->where('situacao', 'em_aberto')->count()
                    ];
                })->sortByDesc('valor');

            // Calcular média por dia
            $diasPeriodo = Carbon::parse($dataInicio)->diffInDays(Carbon::parse($dataFim)) + 1;
            $mediaPorDia = $diasPeriodo > 0 ? $totalDespesas / $diasPeriodo : 0;

            $data = [
                'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
                'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
                'categoria_id' => $categoriaId,
                'categoria_nome' => $categoriaId ? \App\Models\CategoriaFinanceira::find($categoriaId)->nome : null,
                'total_despesas' => $totalDespesas,
                'total_transacoes' => $totalTransacoes,
                'despesas_pagas' => $despesasPagas,
                'transacoes_pagas' => $transacoesPagas,
                'despesas_pendentes' => $despesasPendentes,
                'transacoes_pendentes' => $transacoesPendentes,
                'despesas_por_dia' => $despesasPorDia,
                'despesas_por_categoria' => $despesasPorCategoria,
                'despesas_por_forma_pagamento' => $despesasPorFormaPagamento,
                'despesas_por_filial' => $despesasPorFilial, // Adicionando dados por filial
                'movimentacoes' => $despesas,
                'dias_periodo' => $diasPeriodo,
                'media_por_dia' => $mediaPorDia
            ];

            $pdf = Pdf::loadView('admin.relatorios.pdf.despesas', compact('data'));
            return $pdf->download('despesas-' . date('Y-m-d') . '.pdf');
            
        } catch(Exception $e) {
            dd($e->getMessage());
        }
    }

    public function analiseClientes(Request $request)
    {
        $request->validate([
            'formato' => 'required|in:pdf,excel'
        ]);

        // Total de clientes
        $totalClientes = Cliente::count();
        $clientesAtivos = Cliente::where('ativo', 1)->count();
        $clientesInativos = Cliente::where('ativo', 0)->count();
        
        // Distribuição por gênero
        $clientesMasculinos = Cliente::where('sexo', 'M')->count();
        $clientesFemininos = Cliente::where('sexo', 'F')->count();
        
        $clientesSemDataNascimento = Cliente::whereNull('data_nascimento')->count();
        
        // Distribuição por faixa etária
        $clientes = Cliente::whereNotNull('data_nascimento')->get();
        $faixasEtarias = $clientes->map(function($cliente) {
            $idade = Carbon::parse($cliente->data_nascimento)->age;
            if ($idade < 18) return '< 18 anos';
            if ($idade < 25) return '18-24 anos';
            if ($idade < 35) return '25-34 anos';
            if ($idade < 45) return '35-44 anos';
            if ($idade < 55) return '45-54 anos';
            return '55+ anos';
        })->countBy()->map(function($count, $faixa) use ($totalClientes) {
            return [
                'faixa' => $faixa,
                'quantidade' => $count,
                'percentual' => $totalClientes > 0 ? ($count / $totalClientes) * 100 : 0
            ];
        })->sortBy('faixa')->values();
        
        // Top 10 clientes mais frequentes
        $topClientes = DB::table('clientes')
            ->leftJoin('agendamentos', 'clientes.id', '=', 'agendamentos.cliente_id')
            ->leftJoin('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->select(
                'clientes.id',
                'clientes.nome',
                'clientes.telefone1',
                DB::raw('COUNT(DISTINCT agendamentos.id) as total_agendamentos'),
                DB::raw('COALESCE(SUM(agendamento_produto.quantidade * agendamento_produto.valor_unitario), 0) as valor_total_gasto'),
                DB::raw('MAX(agendamentos.data_agendamento) as ultimo_agendamento')
            )
            ->where('clientes.ativo', 1)
            ->groupBy('clientes.id', 'clientes.nome', 'clientes.telefone1')
            ->orderBy('total_agendamentos', 'desc')
            ->limit(10)
            ->get();
        
        // Ticket médio por cliente
        $ticketMedio = DB::table('clientes')
            ->join('agendamentos', 'clientes.id', '=', 'agendamentos.cliente_id')
            ->join('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->where('agendamentos.status', 'concluido')
            ->select(DB::raw('AVG(agendamento_produto.quantidade * agendamento_produto.valor_unitario) as ticket_medio'))
            ->value('ticket_medio') ?? 0;
        
        // Distribuição por filial
        $clientesPorFilial = DB::table('clientes')
            ->leftJoin('agendamentos', 'clientes.id', '=', 'agendamentos.cliente_id')
            ->leftJoin('filiais', 'agendamentos.filial_id', '=', 'filiais.id')
            ->select(
                'filiais.id as filial_id',
                'filiais.nome as filial_nome',
                DB::raw('COUNT(DISTINCT clientes.id) as total_clientes'),
                DB::raw('COUNT(DISTINCT agendamentos.id) as total_agendamentos')
            )
            ->whereNotNull('filiais.nome')
            ->groupBy('filiais.id', 'filiais.nome')
            ->orderBy('total_clientes', 'desc')
            ->get();
        
        // Crescimento de clientes (últimos 6 meses)
        $crescimento = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $quantidade = Cliente::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $crescimento[] = [
                'mes' => $mes->translatedFormat('M/Y'),
                'quantidade' => $quantidade
            ];
        }
        
        // Serviços mais procurados
        $servicosPreferidos = DB::table('produtos')
            ->join('agendamento_produto', 'produtos.id', '=', 'agendamento_produto.produto_id')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->where('produtos.tipo', 'servico')
            ->where('agendamentos.status', 'concluido')
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
        
        $servicosPorFilial = DB::table('filiais')
            ->join('agendamentos', 'filiais.id', '=', 'agendamentos.filial_id')
            ->join('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->where('produtos.tipo', 'servico')
            ->where('agendamentos.status', 'concluido')
            ->select(
                'filiais.nome as filial_nome',
                'produtos.nome as servico_nome',
                DB::raw('COUNT(DISTINCT agendamentos.cliente_id) as clientes_unicos'),
                DB::raw('SUM(agendamento_produto.quantidade) as total_utilizacoes'),
                DB::raw('AVG(agendamento_produto.valor_unitario) as valor_medio')
            )
            ->groupBy('filiais.id', 'filiais.nome', 'produtos.id', 'produtos.nome')
            ->orderBy('filiais.nome')
            ->orderBy('clientes_unicos', 'desc')
            ->get()
            ->groupBy('filial_nome')
            ->map(function($servicos) {
                return $servicos->take(5); // Top 5 por filial
            });
        
        // Horários preferidos
        $horariosPreferidos = DB::table('agendamentos')
            ->select(
                DB::raw('HOUR(hora_inicio) as hora'),
                DB::raw('COUNT(*) as quantidade')
            )
            ->where('status', 'concluido')
            ->groupBy('hora')
            ->orderBy('quantidade', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'horario' => sprintf('%02d:00 - %02d:59', $item->hora, $item->hora),
                    'quantidade' => $item->quantidade
                ];
            });
        
        $data = [
            'data_geracao' => Carbon::now()->format('d/m/Y H:i'),
            'total_clientes' => $totalClientes,
            'clientes_ativos' => $clientesAtivos,
            'clientes_inativos' => $clientesInativos,
            'clientes_masculinos' => $clientesMasculinos,
            'clientes_femininos' => $clientesFemininos,
            'clientes_sem_data_nascimento' => $clientesSemDataNascimento,
            'faixas_etarias' => $faixasEtarias,
            'top_clientes' => $topClientes,
            'ticket_medio' => $ticketMedio,
            'clientes_por_filial' => $clientesPorFilial,
            'crescimento' => $crescimento,
            'servicos_preferidos' => $servicosPreferidos,
            'servicos_por_filial' => $servicosPorFilial, // Adicionando serviços por filial
            'horarios_preferidos' => $horariosPreferidos
        ];

        $pdf = Pdf::loadView('admin.relatorios.pdf.analise-clientes', compact('data'));
        return $pdf->download('analise-clientes-' . date('Y-m-d') . '.pdf');
        

    }

    public function aniversariantes(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'sexo' => 'nullable|in:M,F',
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

        $pdf = Pdf::loadView('admin.relatorios.pdf.aniversariantes', compact('data'));
        return $pdf->download('aniversariantes-' . $data['mes_nome'] . '.pdf');
        

    }

    public function produtosMaisVendidos(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'filial_id' => 'nullable|exists:filiais,id',
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        $filialId = $request->filial_id;

        $query = DB::table('movimentacao_produto')
            ->join('movimentacoes_financeiras', 'movimentacao_produto.movimentacao_financeira_id', '=', 'movimentacoes_financeiras.id')
            ->join('produtos', 'movimentacao_produto.produto_id', '=', 'produtos.id')
            ->leftJoin('filiais', 'movimentacoes_financeiras.filial_id', '=', 'filiais.id')
            ->whereBetween('movimentacoes_financeiras.data', [$dataInicio, $dataFim])
            ->where('movimentacoes_financeiras.tipo', 'entrada')
            ->where('movimentacoes_financeiras.situacao', 'pago')
            ->where('produtos.tipo', 'produto'); // Filtrando apenas produtos

        if ($filialId) {
            $query->where('movimentacoes_financeiras.filial_id', $filialId);
        }

        // Produtos mais vendidos (geral)
        $produtosVendidos = $query->select(
            'produtos.id',
            'produtos.nome',
            'produtos.tipo',
            DB::raw('SUM(movimentacao_produto.quantidade) as total_quantidade'),
            DB::raw('SUM(movimentacao_produto.quantidade * movimentacao_produto.valor_unitario) as total_valor'),
            DB::raw('AVG(movimentacao_produto.valor_unitario) as valor_medio'),
            DB::raw('COUNT(DISTINCT movimentacoes_financeiras.id) as total_vendas')
        )
        ->groupBy('produtos.id', 'produtos.nome', 'produtos.tipo')
        ->orderBy('total_quantidade', 'desc')
        ->get();

        // Produtos mais vendidos por filial (se não filtrou filial específica)
        $produtosPorFilial = collect();
        if (!$filialId) {
            $produtosPorFilial = DB::table('movimentacao_produto')
                ->join('movimentacoes_financeiras', 'movimentacao_produto.movimentacao_financeira_id', '=', 'movimentacoes_financeiras.id')
                ->join('produtos', 'movimentacao_produto.produto_id', '=', 'produtos.id')
                ->join('filiais', 'movimentacoes_financeiras.filial_id', '=', 'filiais.id')
                ->whereBetween('movimentacoes_financeiras.data', [$dataInicio, $dataFim])
                ->where('movimentacoes_financeiras.tipo', 'saida')
                ->where('movimentacoes_financeiras.situacao', 'pago')
                ->where('produtos.tipo', 'produto') // Filtrando apenas produtos
                ->select(
                    'filiais.id as filial_id',
                    'filiais.nome as filial_nome',
                    'produtos.id as produto_id',
                    'produtos.nome as produto_nome',
                    'produtos.tipo',
                    DB::raw('SUM(movimentacao_produto.quantidade) as total_quantidade'),
                    DB::raw('SUM(movimentacao_produto.quantidade * movimentacao_produto.valor_unitario) as total_valor'),
                    DB::raw('COUNT(DISTINCT movimentacoes_financeiras.id) as total_vendas')
                )
                ->groupBy('filiais.id', 'filiais.nome', 'produtos.id', 'produtos.nome', 'produtos.tipo')
                ->orderBy('filiais.nome')
                ->orderBy('total_quantidade', 'desc')
                ->get()
                ->groupBy('filial_nome')
                ->map(function($produtos) {
                    return $produtos->take(10); // Top 10 por filial
                });
        }

        // Estatísticas gerais
        $totalQuantidade = $produtosVendidos->sum('total_quantidade');
        $totalValor = $produtosVendidos->sum('total_valor');
        $totalVendas = $produtosVendidos->sum('total_vendas');
        $ticketMedio = $totalVendas > 0 ? $totalValor / $totalVendas : 0;

        // Produtos por tipo
        $produtosPorTipo = $produtosVendidos->groupBy('tipo')->map(function($grupo) {
            return [
                'quantidade' => $grupo->sum('total_quantidade'),
                'valor' => $grupo->sum('total_valor'),
                'vendas' => $grupo->sum('total_vendas')
            ];
        });

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'filial_id' => $filialId,
            'filial_nome' => $filialId ? \App\Models\Filial::find($filialId)->nome : null,
            'produtos_vendidos' => $produtosVendidos,
            'produtos_por_filial' => $produtosPorFilial,
            'total_quantidade' => $totalQuantidade,
            'total_valor' => $totalValor,
            'total_vendas' => $totalVendas,
            'ticket_medio' => $ticketMedio,
            'produtos_por_tipo' => $produtosPorTipo
        ];

        $pdf = Pdf::loadView('admin.relatorios.pdf.produtos-mais-vendidos', compact('data'));
        return $pdf->download('produtos-mais-vendidos-' . date('Y-m-d') . '.pdf');
        

    }

    public function servicosRealizados(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;

        $query = DB::table('agendamentos')
            ->join('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->join('filiais', 'agendamentos.filial_id', '=', 'filiais.id')
            ->leftJoin('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
            ->leftJoin('clientes', 'agendamentos.cliente_id', '=', 'clientes.id')
            ->whereBetween('agendamentos.data_agendamento', [$dataInicio, $dataFim])
            ->where('agendamentos.status', 'concluido')
            ->where('produtos.tipo', 'servico');

        $servicosRealizados = $query->select(
            'filiais.id as filial_id',
            'filiais.nome as filial_nome',
            'produtos.id as servico_id',
            'produtos.nome as servico_nome',
            'agendamento_produto.quantidade',
            'agendamento_produto.valor_unitario',
            DB::raw('(agendamento_produto.quantidade * agendamento_produto.valor_unitario) as valor_total'),
            'agendamentos.data_agendamento',
            'barbeiros.nome as barbeiro_nome',
            'clientes.nome as cliente_nome'
        )->get();

        // Resumo geral
        $totalServicos = $servicosRealizados->sum('quantidade');
        $totalValor = $servicosRealizados->sum('valor_total');
        $totalAtendimentos = $servicosRealizados->count();
        $clientesUnicos = $servicosRealizados->pluck('cliente_nome')->unique()->count();

        // Serviços por filial
        $servicosPorFilial = $servicosRealizados->groupBy('filial_id')->map(function($group) {
            return [
                'filial_nome' => $group->first()->filial_nome,
                'total_servicos' => $group->sum('quantidade'),
                'total_valor' => $group->sum('valor_total'),
                'total_atendimentos' => $group->count(),
                'clientes_unicos' => $group->pluck('cliente_nome')->unique()->count(),
                'ticket_medio' => $group->count() > 0 ? $group->sum('valor_total') / $group->count() : 0
            ];
        })->sortByDesc('total_valor');

        // Top 10 serviços mais realizados (geral)
        $topServicos = $servicosRealizados->groupBy('servico_id')->map(function($group) {
            return [
                'servico_nome' => $group->first()->servico_nome,
                'quantidade' => $group->sum('quantidade'),
                'valor_total' => $group->sum('valor_total'),
                'atendimentos' => $group->count(),
                'valor_medio' => $group->avg('valor_unitario')
            ];
        })->sortByDesc('quantidade')->take(10);

        // Serviços por filial detalhado
        $servicosDetalhadosPorFilial = $servicosRealizados->groupBy('filial_nome')->map(function($filialGroup) {
            return $filialGroup->groupBy('servico_id')->map(function($servicoGroup) {
                return [
                    'servico_nome' => $servicoGroup->first()->servico_nome,
                    'quantidade' => $servicoGroup->sum('quantidade'),
                    'valor_total' => $servicoGroup->sum('valor_total'),
                    'atendimentos' => $servicoGroup->count(),
                    'valor_medio' => $servicoGroup->avg('valor_unitario')
                ];
            })->sortByDesc('quantidade')->take(5)->values();
        });

        // Serviços por dia da semana
        $servicosPorDiaSemana = $servicosRealizados->groupBy(function($item) {
            return Carbon::parse($item->data_agendamento)->dayOfWeek;
        })->map(function($group, $diaSemana) {
            $nomesDias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
            return [
                'dia_semana' => $nomesDias[$diaSemana],
                'quantidade' => $group->sum('quantidade'),
                'valor' => $group->sum('valor_total'),
                'atendimentos' => $group->count()
            ];
        })->sortKeys();

        // Barbeiros mais produtivos
        $barbeirosProdutivos = $servicosRealizados->groupBy('barbeiro_nome')->map(function($group) {
            return [
                'barbeiro_nome' => $group->first()->barbeiro_nome ?? 'Não informado',
                'total_servicos' => $group->sum('quantidade'),
                'total_valor' => $group->sum('valor_total'),
                'atendimentos' => $group->count(),
                'clientes_unicos' => $group->pluck('cliente_nome')->unique()->count()
            ];
        })->sortByDesc('total_servicos')->take(10);

        $data = [
            'periodo_inicio' => Carbon::parse($dataInicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($dataFim)->format('d/m/Y'),
            'total_servicos' => $totalServicos,
            'total_valor' => $totalValor,
            'total_atendimentos' => $totalAtendimentos,
            'clientes_unicos' => $clientesUnicos,
            'ticket_medio' => $totalAtendimentos > 0 ? $totalValor / $totalAtendimentos : 0,
            'servicos_por_filial' => $servicosPorFilial,
            'top_servicos' => $topServicos,
            'servicos_detalhados_por_filial' => $servicosDetalhadosPorFilial,
            'servicos_por_dia_semana' => $servicosPorDiaSemana,
            'barbeiros_produtivos' => $barbeirosProdutivos
        ];

        $pdf = Pdf::loadView('admin.relatorios.pdf.servicos-realizados', compact('data'));
        return $pdf->download('servicos-realizados-' . date('Y-m-d') . '.pdf');
        

    }

}
