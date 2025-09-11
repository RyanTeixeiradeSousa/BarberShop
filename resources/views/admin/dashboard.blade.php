@extends('layouts.app')

@section('title', 'Dashboard - BarberShop Pro')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do sistema')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-tachometer-alt me-2" style="color: var(--primary);"></i>
                Dashboard
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Visão geral do sistema</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i>
                Atualizar
            </button>
        </div>
    </div>

    <!-- Menu de Navegação -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom">
                <div class="card-body p-0">
                    <nav class="nav nav-pills nav-fill dashboard-nav">
                        <a class="nav-link active" href="#" data-tab="principal">
                            <i class="fas fa-home me-2"></i>Principal
                        </a>
                        <a class="nav-link" href="#" data-tab="financeiro">
                            <i class="fas fa-dollar-sign me-2"></i>Financeiro
                        </a>
                        <a class="nav-link" href="#" data-tab="atendimentos">
                            <i class="fas fa-calendar-check me-2"></i>Atendimentos
                        </a>
                        <a class="nav-link" href="#" data-tab="produtos">
                            <i class="fas fa-cut me-2"></i>Produtos
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Principal -->
    <div class="tab-content" id="principal-tab">
        <!-- Cards de estatísticas gerais -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado data-bs-toggle e data-bs-title para tooltip informativo -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Número total de clientes cadastrados no sistema">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['total_clientes'] }}</h4>
                            <p class="text-muted mb-0">Total de Clientes</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para agendamentos de hoje -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Quantidade de agendamentos marcados para o dia de hoje">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['agendamentos_hoje'] }}</h4>
                            <p class="text-muted mb-0">Agendamentos Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para faturamento de hoje -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Valor total faturado no dia de hoje com serviços concluídos">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($stats['faturamento_hoje'], 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Faturamento Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para serviços concluídos -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Número de serviços finalizados e concluídos hoje">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['servicos_concluidos'] }}</h4>
                            <p class="text-muted mb-0">Serviços Concluídos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos da Aba Principal -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-line me-2" style="color: var(--primary);"></i>Faturamento dos Últimos 7 Dias
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="faturamentoChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-pie me-2" style="color: var(--primary);"></i>Status dos Agendamentos
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acesso Rápido e Próximos Agendamentos -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>Próximos Agendamentos
                        </h6>
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Agenda Completa
                        </a>
                    </div>
                    <div class="card-body">
                        @if($proximosAgendamentos->count() > 0)
                            <div class="timeline">
                                @foreach($proximosAgendamentos as $agendamento)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $agendamento->status === 'concluido' ? 'success' : ($agendamento->status === 'em_andamento' ? 'warning' : 'primary') }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $agendamento->hora_inicio }} - {{ $agendamento->cliente->nome ?? 'Slot Disponível' }}</h6>
                                        <p class="mb-0 text-muted">
                                            @if($agendamento->produtos->count() > 0)
                                                {{ $agendamento->produtos->pluck('nome')->join(', ') }}
                                            @else
                                                Sem serviços definidos
                                            @endif
                                            - <span class="badge bg-{{ $agendamento->status_color }}">{{ $agendamento->status_label }}</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum agendamento para hoje</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-bolt me-2" style="color: var(--primary);"></i>Acesso Rápido
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <a href="{{ route('agendamentos.index') }}" class="quick-access-card">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Novo Agendamento</span>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('clientes.index') }}" class="quick-access-card">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Novo Cliente</span>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('financeiro.index') }}" class="quick-access-card">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nova Movimentação</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Financeiro -->
    <div class="tab-content d-none" id="financeiro-tab">
        <!-- Cards de estatísticas financeiras -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para receitas de hoje -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Total de receitas (entradas) registradas no dia de hoje">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($financeiro['receitas_hoje'], 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Receitas Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para despesas de hoje -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Total de despesas (saídas) registradas no dia de hoje">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($financeiro['despesas_hoje'], 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Despesas Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para lucro líquido -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Diferença entre receitas e despesas (lucro líquido do mês)">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($financeiro['lucro_liquido'], 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Lucro Líquido</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para faturamento mensal -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Valor total faturado no mês atual com todos os serviços">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($financeiro['faturamento_mensal'], 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Faturamento Mensal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos da Aba Financeiro -->
        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-area me-2" style="color: var(--primary);"></i>Receitas vs Despesas (Últimos 30 dias)
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="receitasDespesasChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-bar me-2" style="color: var(--primary);"></i>Movimentações Recentes
                        </h6>
                        <a href="{{ route('financeiro.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todas
                        </a>
                    </div>
                    <div class="card-body">
                        @if($movimentacoesRecentes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Descrição</th>
                                            <th>Cliente</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($movimentacoesRecentes as $movimentacao)
                                        <tr>
                                            <td><span class="badge bg-{{ $movimentacao->tipo === 'entrada' ? 'success' : 'danger' }}">{{ ucfirst($movimentacao->tipo) }}</span></td>
                                            <td>{{ $movimentacao->descricao }}</td>
                                            <td>{{ $movimentacao->cliente->nome ?? '-' }}</td>
                                            <td class="text-{{ $movimentacao->tipo === 'entrada' ? 'success' : 'danger' }}">R$ {{ number_format($movimentacao->valor - $movimentacao->desconto ?? 0, 2, ',', '.') }}</td>
                                            <td><span class="badge bg-{{ $movimentacao->situacao_cor }}">{{ $movimentacao->situacao_texto }}</span></td>
                                            <td>{{ $movimentacao->data->format('d/m/Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma movimentação encontrada</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Atendimentos -->
    <div class="tab-content d-none" id="atendimentos-tab">
        <!-- Cards de estatísticas de atendimentos -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para agendamentos de hoje -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Total de agendamentos marcados para hoje (todos os status)">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $agendamentos['hoje_total'] }}</h4>
                            <p class="text-muted mb-0">Agendamentos Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para serviços concluídos -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Agendamentos que já foram finalizados e concluídos hoje">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $agendamentos['hoje_concluidos'] }}</h4>
                            <p class="text-muted mb-0">Concluídos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para serviços em andamento -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Agendamentos que estão sendo executados no momento">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $agendamentos['hoje_em_andamento'] }}</h4>
                            <p class="text-muted mb-0">Em Andamento</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para agendamentos pendentes -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Agendamentos confirmados que ainda não foram iniciados">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $agendamentos['hoje_agendados'] }}</h4>
                            <p class="text-muted mb-0">Agendados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>Agenda do Dia
                        </h6>
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Agenda Completa
                        </a>
                    </div>
                    <div class="card-body">
                        @if($agendamentosHoje->count() > 0)
                            <div class="timeline">
                                @foreach($agendamentosHoje as $agendamento)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $agendamento->status === 'concluido' ? 'success' : ($agendamento->status === 'em_andamento' ? 'warning' : ($agendamento->status === 'cancelado' ? 'danger' : 'primary')) }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $agendamento->hora_inicio }} - {{ $agendamento->cliente->nome ?? 'Slot Disponível' }}</h6>
                                        <p class="mb-0 text-muted">
                                            @if($agendamento->produtos->count() > 0)
                                                {{ $agendamento->produtos->pluck('nome')->join(', ') }}
                                            @else
                                                Sem serviços definidos
                                            @endif
                                            - <span class="badge bg-{{ $agendamento->status_color }}">{{ $agendamento->status_label }}</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum agendamento para hoje</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-pie me-2" style="color: var(--primary);"></i>Serviços Mais Solicitados
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($servicosMaisSolicitados->count() > 0)
                            @foreach($servicosMaisSolicitados as $servico)
                            <div class="service-stat">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $servico->nome }}</span>
                                    <span class="fw-bold">{{ $servico->percentual }}%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $servico->percentual }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum dado disponível</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Produtos -->
    <div class="tab-content d-none" id="produtos-tab">
        <!-- Cards de estatísticas de produtos -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para total de produtos -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Quantidade total de produtos cadastrados no sistema">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $produtos['total_produtos'] }}</h4>
                            <p class="text-muted mb-0">Total de Produtos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para estoque baixo -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Produtos com estoque abaixo do limite mínimo (necessita reposição)">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $produtos['estoque_baixo'] }}</h4>
                            <p class="text-muted mb-0">Estoque Baixo</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para serviços ativos -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Quantidade de serviços disponíveis e ativos para agendamento">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $produtos['total_servicos'] }}</h4>
                            <p class="text-muted mb-0">Serviços Ativos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <!-- Adicionado tooltip explicativo para produtos mais utilizados -->
                <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" 
                     data-bs-title="Produtos e serviços com maior número de utilizações/vendas">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $produtos['mais_vendidos'] }}</h4>
                            <p class="text-muted mb-0">Mais Utilizados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico da Aba Produtos -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-bar me-2" style="color: var(--primary);"></i>Produtos Mais Utilizados (Este Mês)
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="produtosUtilizadosChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-pie me-2" style="color: var(--primary);"></i>Serviços vs Produtos
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="servicosProdutosChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-chart-bar me-2" style="color: var(--primary);"></i>Produtos Mais Utilizados
                        </h6>
                        <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todos
                        </a>
                    </div>
                    <div class="card-body">
                        @if($produtosMaisUtilizados->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Produto/Serviço</th>
                                            <th>Tipo</th>
                                            <th>Preço</th>
                                            <th>Utilizações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produtosMaisUtilizados as $produto)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="product-avatar me-3" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                        <i class="fas fa-{{ $produto->tipo === 'servico' ? 'cut' : 'box' }}"></i>
                                                    </div>
                                                    <span>{{ $produto->nome }}</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-{{ $produto->tipo === 'servico' ? 'primary' : 'warning' }}">{{ ucfirst($produto->tipo) }}</span></td>
                                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                            <td><span class="badge bg-success">{{ $produto->total_utilizacoes }}x</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum produto utilizado este mês</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-bg); border-bottom: 1px solid var(--border);">
                        <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                            <i class="fas fa-exclamation-circle me-2" style="color: var(--primary);"></i>Alertas de Estoque
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($produtosEstoqueBaixo->count() > 0)
                            @foreach($produtosEstoqueBaixo as $produto)
                            <div class="alert-item">
                                <div class="alert-icon bg-{{ $produto->estoque <= 2 ? 'danger' : ($produto->estoque <= 5 ? 'warning' : 'info') }}">
                                    <i class="fas fa-{{ $produto->estoque <= 2 ? 'exclamation' : ($produto->estoque <= 5 ? 'exclamation-triangle' : 'info') }}"></i>
                                </div>
                                <div class="alert-content">
                                    <p class="mb-0">{{ $produto->nome }}</p>
                                    <small class="text-muted">Estoque: {{ $produto->estoque }} unidades</small>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <p class="text-muted">Todos os estoques estão normais</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background: var(--background);
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    .card-custom {
        background: var(--card-bg);
        border: 2px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.15s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: var(--primary);
    }

    .btn-primary-custom {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        border: none;
        color: var(--primary-foreground);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(45deg, #2563eb, #3b82f6);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: var(--primary-foreground);
    }

    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: var(--primary);
        color: var(--primary);
    }

    .product-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
        backdrop-filter: blur(10px);
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        border-color: var(--primary);
    }

    .product-avatar {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .table {
        background: transparent;
        color: var(--text-primary);
    }

    .table th {
        border-bottom: 2px solid var(--border);
        font-weight: 600;
        padding: 1rem 0.75rem;
        color: var(--text-primary);
    }

    .table td {
        border-bottom: 1px solid var(--border);
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: var(--text-primary);
    }

    .table tbody tr:hover {
        background: var(--muted);
    }

    .progress {
        background: var(--muted);
        border-radius: 4px;
    }

    /* Adicionando estilos para o sistema de navegação por abas */
    .dashboard-nav {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 0.5rem;
    }

    .dashboard-nav .nav-link {
        color: var(--text-muted);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .dashboard-nav .nav-link:hover {
        background: var(--muted);
        color: var(--primary);
    }

    .dashboard-nav .nav-link.active {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: var(--primary-foreground);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .quick-access-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        background: var(--muted);
        border: 2px solid var(--border);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
        min-height: 100px;
    }

    .quick-access-card:hover {
        background: var(--accent);
        border-color: var(--primary);
        transform: translateY(-2px);
        color: var(--primary);
        text-decoration: none;
    }

    .quick-access-card i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }

    .log-item, .alert-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border);
    }

    .log-item:last-child, .alert-item:last-child {
        border-bottom: none;
    }

    .log-icon, .alert-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 0.8rem;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 1.5rem;
        width: 2px;
        height: calc(100% - 1rem);
        background: var(--border);
    }

    .timeline-marker {
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid var(--card-bg);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .service-stat .progress {
        background: var(--muted);
    }

    .text-muted {
        color: var(--text-muted) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

    const navLinks = document.querySelectorAll('.dashboard-nav .nav-link');
    const tabContents = document.querySelectorAll('.tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('d-none'));
            
            // Show selected tab content
            const tabId = this.getAttribute('data-tab') + '-tab';
            const targetTab = document.getElementById(tabId);
            if (targetTab) {
                targetTab.classList.remove('d-none');
            }
        });
    });

    // Configuração global dos gráficos
    Chart.defaults.color = getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim() || '#ffffff';
    Chart.defaults.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--border').trim() || '#334155';
    Chart.defaults.backgroundColor = 'rgba(59, 130, 246, 0.1)';

    const faturamentoCtx = document.getElementById('faturamentoChart').getContext('2d');
    const faturamentoData = @json($chartData['faturamento_semanal'] ?? []);
    new Chart(faturamentoCtx, {
        type: 'line',
        data: {
            labels: faturamentoData.map(item => item.dia),
            datasets: [{
                label: 'Faturamento (R$)',
                data: faturamentoData.map(item => item.valor),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Status dos Agendamentos
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Concluídos', 'Em Andamento', 'Agendados', 'Cancelados'],
            datasets: [{
                data: [
                    {{ $agendamentos['hoje_concluidos'] ?? 0 }},
                    {{ $agendamentos['hoje_em_andamento'] ?? 0 }},
                    {{ $agendamentos['hoje_agendados'] ?? 0 }},
                    {{ $agendamentos['hoje_cancelados'] ?? 0 }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const receitasDespesasCtx = document.getElementById('receitasDespesasChart').getContext('2d');
    const receitasDespesasData = @json($chartData['receitas_despesas'] ?? []);
    new Chart(receitasDespesasCtx, {
        type: 'bar',
        data: {
            labels: receitasDespesasData.map(item => item.dia),
            datasets: [{
                label: 'Receitas',
                data: receitasDespesasData.map(item => item.receitas),
                backgroundColor: '#10b981'
            }, {
                label: 'Despesas',
                data: receitasDespesasData.map(item => item.despesas),
                backgroundColor: '#ef4444'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });

    

    const produtosUtilizadosCtx = document.getElementById('produtosUtilizadosChart').getContext('2d');
    const produtosData = @json($chartData['produtos_utilizados'] ?? []);
    new Chart(produtosUtilizadosCtx, {
        type: 'bar',
        data: {
            labels: produtosData.map(item => item.nome),
            datasets: [{
                label: 'Utilizações',
                data: produtosData.map(item => item.total_utilizacoes),
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4']
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Serviços vs Produtos
    const servicosProdutosCtx = document.getElementById('servicosProdutosChart').getContext('2d');
    new Chart(servicosProdutosCtx, {
        type: 'doughnut',
        data: {
            labels: ['Serviços', 'Produtos'],
            datasets: [{
                data: [
                    {{ $produtos['total_servicos'] ?? 0 }},
                    {{ $produtos['total_produtos'] ?? 0 }}
                ],
                backgroundColor: ['#3b82f6', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
@endsection
