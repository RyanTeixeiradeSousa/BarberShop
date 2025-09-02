@extends('layouts.app')

@section('title', 'Dashboard - BarberShop Pro')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do sistema')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-tachometer-alt me-2" style="color: #60a5fa;"></i>
                Dashboard
            </h2>
            <p class="mb-0" style="color: #6b7280;">Visão geral do sistema</p>
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
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['total_clientes'] ?? 150 }}</h4>
                            <p class="text-muted mb-0">Total de Clientes</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['agendamentos_hoje'] ?? 12 }}</h4>
                            <p class="text-muted mb-0">Agendamentos Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ {{ number_format($stats['faturamento_hoje'] ?? 2450, 2, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Faturamento Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $stats['servicos_concluidos'] ?? 8 }}</h4>
                            <p class="text-muted mb-0">Serviços Concluídos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acesso Rápido e Logs -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-bolt me-2" style="color: #60a5fa;"></i>Acesso Rápido
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('agendamentos.index') }}" class="quick-access-card">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Novo Agendamento</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('clientes.index') }}" class="quick-access-card">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Novo Cliente</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('financeiro.index') }}" class="quick-access-card">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nova Movimentação</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-history me-2" style="color: #60a5fa;"></i>Logs do Sistema
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="log-item">
                            <div class="log-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="log-content">
                                <p class="mb-0">Agendamento concluído</p>
                                <small class="text-muted">João Silva - há 5 min</small>
                            </div>
                        </div>
                        <div class="log-item">
                            <div class="log-icon bg-primary">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="log-content">
                                <p class="mb-0">Novo cliente cadastrado</p>
                                <small class="text-muted">Pedro Santos - há 15 min</small>
                            </div>
                        </div>
                        <div class="log-item">
                            <div class="log-icon bg-warning">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="log-content">
                                <p class="mb-0">Pagamento recebido</p>
                                <small class="text-muted">R$ 45,00 - há 20 min</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Financeiro -->
    <div class="tab-content d-none" id="financeiro-tab">
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ 2.450,00</h4>
                            <p class="text-muted mb-0">Receitas Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ 320,00</h4>
                            <p class="text-muted mb-0">Despesas Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ 2.130,00</h4>
                            <p class="text-muted mb-0">Lucro Líquido</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">R$ 18.500,00</h4>
                            <p class="text-muted mb-0">Faturamento Mensal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-chart-bar me-2" style="color: #60a5fa;"></i>Movimentações Recentes
                        </h6>
                        <a href="{{ route('financeiro.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todas
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th>Categoria</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-success">Entrada</span></td>
                                        <td>Serviço - Corte + Barba</td>
                                        <td>Serviços</td>
                                        <td class="text-success">R$ 45,00</td>
                                        <td><span class="badge bg-success">Pago</span></td>
                                        <td>Hoje 14:30</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">Saída</span></td>
                                        <td>Compra de produtos</td>
                                        <td>Materiais</td>
                                        <td class="text-danger">R$ 120,00</td>
                                        <td><span class="badge bg-warning">Pendente</span></td>
                                        <td>Hoje 10:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Atendimentos -->
    <div class="tab-content d-none" id="atendimentos-tab">
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">12</h4>
                            <p class="text-muted mb-0">Agendamentos Hoje</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">8</h4>
                            <p class="text-muted mb-0">Concluídos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">2</h4>
                            <p class="text-muted mb-0">Em Andamento</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">2</h4>
                            <p class="text-muted mb-0">Agendados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-calendar-alt me-2" style="color: #60a5fa;"></i>Agenda do Dia
                        </h6>
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Agenda Completa
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">14:30 - João Silva</h6>
                                    <p class="mb-0 text-muted">Corte + Barba - <span class="badge bg-success">Concluído</span></p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">15:00 - Pedro Santos</h6>
                                    <p class="mb-0 text-muted">Corte Simples - <span class="badge bg-warning">Em Andamento</span></p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">15:30 - Carlos Oliveira</h6>
                                    <p class="mb-0 text-muted">Barba + Bigode - <span class="badge bg-primary">Agendado</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-chart-pie me-2" style="color: #60a5fa;"></i>Serviços Mais Solicitados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="service-stat">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Corte + Barba</span>
                                <span class="fw-bold">45%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: 45%"></div>
                            </div>
                        </div>
                        <div class="service-stat">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Corte Simples</span>
                                <span class="fw-bold">30%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 30%"></div>
                            </div>
                        </div>
                        <div class="service-stat">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Barba</span>
                                <span class="fw-bold">25%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Produtos -->
    <div class="tab-content d-none" id="produtos-tab">
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">45</h4>
                            <p class="text-muted mb-0">Total de Produtos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">3</h4>
                            <p class="text-muted mb-0">Estoque Baixo</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">12</h4>
                            <p class="text-muted mb-0">Serviços Ativos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">8</h4>
                            <p class="text-muted mb-0">Mais Vendidos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-chart-bar me-2" style="color: #60a5fa;"></i>Produtos Mais Utilizados
                        </h6>
                        <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todos
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto/Serviço</th>
                                        <th>Categoria</th>
                                        <th>Tipo</th>
                                        <th>Preço</th>
                                        <th>Utilizações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-avatar me-3" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                    <i class="fas fa-cut"></i>
                                                </div>
                                                <span>Corte Masculino</span>
                                            </div>
                                        </td>
                                        <td>Serviços</td>
                                        <td><span class="badge bg-primary">Serviço</span></td>
                                        <td>R$ 25,00</td>
                                        <td><span class="badge bg-success">45x</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-avatar me-3" style="width: 35px; height: 35px; font-size: 0.8rem; background: linear-gradient(45deg, #10b981, #34d399);">
                                                    <i class="fas fa-spray-can"></i>
                                                </div>
                                                <span>Pomada Modeladora</span>
                                            </div>
                                        </td>
                                        <td>Produtos</td>
                                        <td><span class="badge bg-warning">Produto</span></td>
                                        <td>R$ 35,00</td>
                                        <td><span class="badge bg-info">12x</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                        <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                            <i class="fas fa-exclamation-circle me-2" style="color: #60a5fa;"></i>Alertas de Estoque
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert-item">
                            <div class="alert-icon bg-danger">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div class="alert-content">
                                <p class="mb-0">Shampoo Anticaspa</p>
                                <small class="text-muted">Estoque: 2 unidades</small>
                            </div>
                        </div>
                        <div class="alert-item">
                            <div class="alert-icon bg-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <p class="mb-0">Cera Modeladora</p>
                                <small class="text-muted">Estoque: 5 unidades</small>
                            </div>
                        </div>
                        <div class="alert-item">
                            <div class="alert-icon bg-info">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="alert-content">
                                <p class="mb-0">Óleo para Barba</p>
                                <small class="text-muted">Estoque: 8 unidades</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    .card-custom {
        background: white;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.15s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .btn-primary-custom {
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        border: none;
        color: white;
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
        color: white;
    }

    .btn-outline-primary {
        border-color: #60a5fa;
        color: #60a5fa;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .product-avatar {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .table {
        background: transparent;
        color: #1f2937;
    }

    .table th {
        border-bottom: 2px solid rgba(59, 130, 246, 0.2);
        font-weight: 600;
        padding: 1rem 0.75rem;
    }

    .table td {
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .progress {
        background: rgba(59, 130, 246, 0.1);
        border-radius: 4px;
    }

    /* Adicionando estilos para o sistema de navegação por abas */
    .dashboard-nav {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 0.5rem;
    }

    .dashboard-nav .nav-link {
        color: #6b7280;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .dashboard-nav .nav-link:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .dashboard-nav .nav-link.active {
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .quick-access-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: rgba(59, 130, 246, 0.05);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.3s ease;
        min-height: 120px;
    }

    .quick-access-card:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
        color: #3b82f6;
        text-decoration: none;
    }

    .quick-access-card i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #60a5fa;
    }

    .log-item, .alert-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
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
        background: rgba(59, 130, 246, 0.2);
    }

    .timeline-marker {
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .service-stat .progress {
        background: rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endpush
@endsection
