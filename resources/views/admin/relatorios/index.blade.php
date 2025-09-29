@extends('layouts.app')

@section('title', 'Relatórios - BarberShop Pro')
@section('page-title', 'Relatórios')
@section('page-subtitle', 'Gere relatórios detalhados do seu negócio')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-chart-bar me-2" style="color: #60a5fa;"></i>
                Relatórios
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gere relatórios detalhados para análise do seu negócio</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#historicoRelatoriosModal">
                    <i class="fas fa-history me-1"></i>
                    Histórico
                </button>
                <!-- Removido botão de Relatório Personalizado -->
            </div>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
            <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                <i class="fas fa-search me-2" style="color: #60a5fa;"></i>Buscar Relatórios
            </h6>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" id="searchReports" placeholder="Buscar relatórios por nome ou categoria...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter">
                        <option value="">Todas as categorias</option>
                        <option value="financeiro">Financeiro</option>
                        <option value="clientes">Clientes</option>
                        <option value="agendamentos">Agendamentos</option>
                        <option value="barbeiros">Barbeiros</option>
                        <option value="produtos">Produtos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="complexityFilter">
                        <option value="">Todos os tipos</option>
                        <option value="simples">Simples</option>
                        <option value="detalhado">Detalhado</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar de Categorias -->
        <div class="col-md-3">
            <div class="card-custom sticky-sidebar">
                <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                    <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                        <i class="fas fa-layer-group me-2" style="color: #60a5fa;"></i>Categorias
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="category-list">
                        <div class="category-item active" data-category="">
                            <i class="fas fa-th-large"></i>
                            <span>Todos os Relatórios</span>
                            <span class="badge">24</span>
                        </div>
                        <div class="category-item" data-category="financeiro">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Financeiro</span>
                            <span class="badge">8</span>
                        </div>
                        <div class="category-item" data-category="clientes">
                            <i class="fas fa-users"></i>
                            <span>Clientes</span>
                            <span class="badge">6</span>
                        </div>
                        <div class="category-item" data-category="agendamentos">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Agendamentos</span>
                            <span class="badge">5</span>
                        </div>
                        <div class="category-item" data-category="barbeiros">
                            <i class="fas fa-cut"></i>
                            <span>Barbeiros</span>
                            <span class="badge">3</span>
                        </div>
                        <div class="category-item" data-category="produtos">
                            <i class="fas fa-box"></i>
                            <span>Produtos</span>
                            <span class="badge">2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Relatórios -->
        <div class="col-md-9">
            <div class="reports-grid" id="reportsGrid">
                
                <!-- Relatórios Financeiros -->
                <div class="report-card" data-category="financeiro" data-complexity="detalhado">
                    <div class="report-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="report-content">
                        <h5>Faturamento Mensal</h5>
                        <p>Análise completa do faturamento por período, incluindo comparativos e tendências.</p>
                        <div class="report-tags">
                            <span class="tag tag-financeiro">Financeiro</span>
                            <span class="tag tag-detalhado">Detalhado</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Filial, Forma de Pagamento</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('faturamento-mensal')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('faturamento-mensal')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="report-card" data-category="financeiro" data-complexity="simples">
                    <div class="report-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="report-content">
                        <h5>Comissões dos Barbeiros</h5>
                        <p>Relatório de comissões pagas e a pagar para cada barbeiro no período.</p>
                        <div class="report-tags">
                            <span class="tag tag-financeiro">Financeiro</span>
                            <span class="tag tag-simples">Simples</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Barbeiro</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('comissoes-barbeiros')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('comissoes-barbeiros')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="report-card" data-category="financeiro" data-complexity="detalhado">
                    <div class="report-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="report-content">
                        <h5>Formas de Pagamento</h5>
                        <p>Análise detalhada das formas de pagamento utilizadas pelos clientes.</p>
                        <div class="report-tags">
                            <span class="tag tag-financeiro">Financeiro</span>
                            <span class="tag tag-detalhado">Detalhado</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Filial</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('formas-pagamento')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('formas-pagamento')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Relatórios de Clientes -->
                <div class="report-card" data-category="clientes" data-complexity="simples">
                    <div class="report-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="report-content">
                        <h5>Novos Clientes</h5>
                        <p>Lista de clientes cadastrados no período com informações de contato.</p>
                        <div class="report-tags">
                            <span class="tag tag-clientes">Clientes</span>
                            <span class="tag tag-simples">Simples</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Status</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('novos-clientes')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('novos-clientes')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="report-card" data-category="clientes" data-complexity="simples">
                    <div class="report-icon">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="report-content">
                        <h5>Aniversariantes do Mês</h5>
                        <p>Lista de clientes que fazem aniversário no mês para campanhas de marketing.</p>
                        <div class="report-tags">
                            <span class="tag tag-clientes">Clientes</span>
                            <span class="tag tag-simples">Simples</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Mês, Filial</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('aniversariantes')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('aniversariantes')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="report-card" data-category="clientes" data-complexity="detalhado">
                    <div class="report-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="report-content">
                        <h5>Perfil dos Clientes</h5>
                        <p>Análise demográfica dos clientes: idade, sexo, frequência de visitas.</p>
                        <div class="report-tags">
                            <span class="tag tag-clientes">Clientes</span>
                            <span class="tag tag-detalhado">Detalhado</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Filial, Faixa Etária</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('perfil-clientes')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('perfil-clientes')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Relatórios de Agendamentos -->
                <div class="report-card" data-category="agendamentos" data-complexity="detalhado">
                    <div class="report-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="report-content">
                        <h5>Taxa de Ocupação</h5>
                        <p>Análise da ocupação dos horários por barbeiro e período do dia.</p>
                        <div class="report-tags">
                            <span class="tag tag-agendamentos">Agendamentos</span>
                            <span class="tag tag-detalhado">Detalhado</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Barbeiro, Horário</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('taxa-ocupacao')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('taxa-ocupacao')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="report-card" data-category="agendamentos" data-complexity="simples">
                    <div class="report-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="report-content">
                        <h5>Agendamentos Cancelados</h5>
                        <p>Lista de agendamentos cancelados com motivos e estatísticas.</p>
                        <div class="report-tags">
                            <span class="tag tag-agendamentos">Agendamentos</span>
                            <span class="tag tag-simples">Simples</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Motivo, Barbeiro</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('cancelamentos')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('cancelamentos')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Relatórios de Barbeiros -->
                <div class="report-card" data-category="barbeiros" data-complexity="detalhado">
                    <div class="report-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="report-content">
                        <h5>Performance dos Barbeiros</h5>
                        <p>Análise completa da performance: atendimentos, faturamento, avaliações.</p>
                        <div class="report-tags">
                            <span class="tag tag-barbeiros">Barbeiros</span>
                            <span class="tag tag-detalhado">Detalhado</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Barbeiro, Métrica</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('performance-barbeiros')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('performance-barbeiros')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Relatórios de Produtos -->
                <div class="report-card" data-category="produtos" data-complexity="simples">
                    <div class="report-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="report-content">
                        <h5>Produtos Mais Vendidos</h5>
                        <p>Ranking dos produtos mais vendidos no período com quantidades e valores.</p>
                        <div class="report-tags">
                            <span class="tag tag-produtos">Produtos</span>
                            <span class="tag tag-simples">Simples</span>
                        </div>
                        <div class="report-params">
                            <small><i class="fas fa-cog me-1"></i>Parâmetros: Período, Categoria, Limite</small>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="openReportModal('produtos-vendidos')">
                            <i class="fas fa-play"></i> Gerar
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="previewReport('produtos-vendidos')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Estado vazio -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum relatório encontrado</h5>
                    <p class="text-muted">Tente ajustar os filtros ou buscar por outros termos.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Histórico de Relatórios -->
<div class="modal fade" id="historicoRelatoriosModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-history me-2"></i>Histórico de Relatórios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Relatório</th>
                                <th>Data/Hora</th>
                                <th>Usuário</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Faturamento Mensal</td>
                                <td>15/01/2024 14:30</td>
                                <td>Admin</td>
                                <td><span class="badge bg-success">Concluído</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Removido modal de Relatório Personalizado -->

<!-- Adicionados modais específicos para cada tipo de relatório -->

<!-- Modal Faturamento Mensal -->
<div class="modal fade" id="faturamentoMensalModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line me-2"></i>Relatório de Faturamento Mensal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="faturamentoMensalForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Filial</label>
                            <select class="form-select" name="filial_id">
                                <option value="">Todas as filiais</option>
                                <option value="1">Filial Centro</option>
                                <option value="2">Filial Shopping</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Forma de Pagamento</label>
                            <select class="form-select" name="forma_pagamento">
                                <option value="">Todas as formas</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao">Cartão</option>
                                <option value="pix">PIX</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formato" value="pdf" id="pdf1" checked>
                                    <label class="form-check-label" for="pdf1">PDF</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formato" value="excel" id="excel1">
                                    <label class="form-check-label" for="excel1">Excel</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formato" value="csv" id="csv1">
                                    <label class="form-check-label" for="csv1">CSV</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('faturamento-mensal')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Comissões dos Barbeiros -->
<div class="modal fade" id="comissoesBarbeirosModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-hand-holding-usd me-2"></i>Relatório de Comissões dos Barbeiros
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="comissoesBarbeirosForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Barbeiro</label>
                        <select class="form-select searchable-select" name="barbeiro_id" data-searchable="true">
                            <option value="">Todos os barbeiros</option>
                            <!-- Populando com dados reais do banco -->
                            @foreach($barbeiros as $barbeiro)
                                <option value="{{ $barbeiro->id }}">{{ $barbeiro->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status da Comissão</label>
                            <select class="form-select" name="status">
                                <option value="">Todos os status</option>
                                <option value="pago">Pago</option>
                                <option value="pendente">Pendente</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Formato do Relatório</label>
                            <select class="form-select" name="formato">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('comissoes-barbeiros')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Formas de Pagamento -->
<div class="modal fade" id="formasPagamentoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-credit-card me-2"></i>Relatório de Formas de Pagamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formasPagamentoForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Filial</label>
                        <select class="form-select" name="filial_id">
                            <option value="">Todas as filiais</option>
                            <option value="1">Filial Centro</option>
                            <option value="2">Filial Shopping</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incluir no Relatório</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="incluir[]" value="grafico" id="grafico1" checked>
                                    <label class="form-check-label" for="grafico1">Gráfico de Pizza</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="incluir[]" value="tabela" id="tabela1" checked>
                                    <label class="form-check-label" for="tabela1">Tabela Detalhada</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="incluir[]" value="percentual" id="percentual1" checked>
                                    <label class="form-check-label" for="percentual1">Percentuais</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="incluir[]" value="comparativo" id="comparativo1">
                                    <label class="form-check-label" for="comparativo1">Comparativo Mensal</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('formas-pagamento')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novos Clientes -->
<div class="modal fade" id="novosClientesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Relatório de Novos Clientes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="novosClientesForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status do Cliente</label>
                        <select class="form-select" name="status">
                            <option value="">Todos os status</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('novos-clientes')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aniversariantes -->
<div class="modal fade" id="aniversariantesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-birthday-cake me-2"></i>Relatório de Aniversariantes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="aniversariantesForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mês</label>
                            <select class="form-select" name="mes" required>
                                <option value="">Selecione o mês</option>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">Julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ano</label>
                            <select class="form-select" name="ano" required>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Filial</label>
                        <select class="form-select" name="filial_id">
                            <option value="">Todas as filiais</option>
                            <option value="1">Filial Centro</option>
                            <option value="2">Filial Shopping</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incluir Informações</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_telefone" id="telefone" checked>
                            <label class="form-check-label" for="telefone">Telefone</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_email" id="email" checked>
                            <label class="form-check-label" for="email">E-mail</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_ultima_visita" id="ultima_visita">
                            <label class="form-check-label" for="ultima_visita">Data da Última Visita</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('aniversariantes')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Perfil dos Clientes -->
<div class="modal fade" id="perfilClientesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-chart-pie me-2"></i>Relatório de Perfil dos Clientes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="perfilClientesForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Filial</label>
                            <select class="form-select" name="filial_id">
                                <option value="">Todas as filiais</option>
                                <option value="1">Filial Centro</option>
                                <option value="2">Filial Shopping</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Faixa Etária</label>
                            <select class="form-select" name="faixa_etaria">
                                <option value="">Todas as idades</option>
                                <option value="18-25">18 a 25 anos</option>
                                <option value="26-35">26 a 35 anos</option>
                                <option value="36-45">36 a 45 anos</option>
                                <option value="46-60">46 a 60 anos</option>
                                <option value="60+">Acima de 60 anos</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Análises a Incluir</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="idade" id="idade" checked>
                                    <label class="form-check-label" for="idade">Distribuição por Idade</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="sexo" id="sexo" checked>
                                    <label class="form-check-label" for="sexo">Distribuição por Sexo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="frequencia" id="frequencia" checked>
                                    <label class="form-check-label" for="frequencia">Frequência de Visitas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="ticket_medio" id="ticket_medio">
                                    <label class="form-check-label" for="ticket_medio">Ticket Médio</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="servicos_preferidos" id="servicos_preferidos">
                                    <label class="form-check-label" for="servicos_preferidos">Serviços Preferidos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="horarios_preferidos" id="horarios_preferidos">
                                    <label class="form-check-label" for="horarios_preferidos">Horários Preferidos</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('perfil-clientes')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Taxa de Ocupação -->
<div class="modal fade" id="taxaOcupacaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>Relatório de Taxa de Ocupação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="taxaOcupacaoForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Barbeiro</label>
                            <select class="form-select searchable-select" name="barbeiro_id" data-searchable="true">
                                <option value="">Todos os barbeiros</option>
                                <!-- Populando com dados reais do banco -->
                                @foreach($barbeiros as $barbeiro)
                                    <option value="{{ $barbeiro->id }}">{{ $barbeiro->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Período do Dia</label>
                            <select class="form-select" name="periodo">
                                <option value="">Todo o dia</option>
                                <option value="manha">Manhã (08:00 - 12:00)</option>
                                <option value="tarde">Tarde (12:00 - 18:00)</option>
                                <option value="noite">Noite (18:00 - 22:00)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dias da Semana</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="1" id="segunda" checked>
                                    <label class="form-check-label" for="segunda">Segunda-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="2" id="terca" checked>
                                    <label class="form-check-label" for="terca">Terça-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="3" id="quarta" checked>
                                    <label class="form-check-label" for="quarta">Quarta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="4" id="quinta" checked>
                                    <label class="form-check-label" for="quinta">Quinta-feira</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="5" id="sexta" checked>
                                    <label class="form-check-label" for="sexta">Sexta-feira</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="6" id="sabado" checked>
                                    <label class="form-check-label" for="sabado">Sábado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias[]" value="0" id="domingo">
                                    <label class="form-check-label" for="domingo">Domingo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('taxa-ocupacao')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agendamentos Cancelados -->
<div class="modal fade" id="cancelamentosModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Relatório de Agendamentos Cancelados
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="cancelamentosForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Motivo do Cancelamento</label>
                            <select class="form-select" name="motivo">
                                <option value="">Todos os motivos</option>
                                <option value="cliente">Cancelado pelo Cliente</option>
                                <option value="barbeiro">Cancelado pelo Barbeiro</option>
                                <option value="sistema">Cancelado pelo Sistema</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Barbeiro</label>
                            <select class="form-select searchable-select" name="barbeiro_id" data-searchable="true">
                                <option value="">Todos os barbeiros</option>
                                <!-- Populando com dados reais do banco -->
                                @foreach($barbeiros as $barbeiro)
                                    <option value="{{ $barbeiro->id }}">{{ $barbeiro->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incluir no Relatório</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_estatisticas" id="estatisticas" checked>
                            <label class="form-check-label" for="estatisticas">Estatísticas Gerais</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_grafico" id="grafico_cancel">
                            <label class="form-check-label" for="grafico_cancel">Gráfico por Motivo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_detalhes" id="detalhes" checked>
                            <label class="form-check-label" for="detalhes">Lista Detalhada</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('cancelamentos')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Performance dos Barbeiros -->
<div class="modal fade" id="performanceBarbeirosModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-trophy me-2"></i>Relatório de Performance dos Barbeiros
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="performanceBarbeirosForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Barbeiro</label>
                            <select class="form-select searchable-select" name="barbeiro_id" data-searchable="true">
                                <option value="">Todos os barbeiros</option>
                                <!-- Populando com dados reais do banco -->
                                @foreach($barbeiros as $barbeiro)
                                    <option value="{{ $barbeiro->id }}">{{ $barbeiro->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Métrica Principal</label>
                            <select class="form-select" name="metrica">
                                <option value="faturamento">Faturamento</option>
                                <option value="atendimentos">Número de Atendimentos</option>
                                <option value="avaliacao">Avaliação Média</option>
                                <option value="comissao">Comissão Gerada</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Análises a Incluir</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="ranking" id="ranking" checked>
                                    <label class="form-check-label" for="ranking">Ranking dos Barbeiros</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="evolucao" id="evolucao" checked>
                                    <label class="form-check-label" for="evolucao">Evolução Temporal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="servicos" id="servicos_perf">
                                    <label class="form-check-label" for="servicos_perf">Serviços Mais Realizados</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="horarios" id="horarios_perf">
                                    <label class="form-check-label" for="horarios_perf">Horários de Maior Performance</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="clientes_fidelizados" id="clientes_fidelizados">
                                    <label class="form-check-label" for="clientes_fidelizados">Clientes Fidelizados</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="analises[]" value="comparativo" id="comparativo_perf">
                                    <label class="form-check-label" for="comparativo_perf">Comparativo com Período Anterior</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('performance-barbeiros')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Produtos Mais Vendidos -->
<div class="modal fade" id="produtosVendidosModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-box-open me-2"></i>Relatório de Produtos Mais Vendidos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="produtosVendidosForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" name="data_inicial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" class="form-control" name="data_final" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoria do Produto</label>
                            <select class="form-select" name="categoria">
                                <option value="">Todas as categorias</option>
                                <option value="shampoo">Shampoo</option>
                                <option value="condicionador">Condicionador</option>
                                <option value="pomada">Pomada</option>
                                <option value="cera">Cera</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Limite de Produtos</label>
                            <select class="form-select" name="limite">
                                <option value="10">Top 10</option>
                                <option value="20">Top 20</option>
                                <option value="50">Top 50</option>
                                <option value="">Todos os produtos</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordenar Por</label>
                        <select class="form-select" name="ordenar_por">
                            <option value="quantidade">Quantidade Vendida</option>
                            <option value="valor">Valor Total</option>
                            <option value="lucro">Lucro Gerado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incluir no Relatório</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_grafico" id="grafico_produtos" checked>
                            <label class="form-check-label" for="grafico_produtos">Gráfico de Barras</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_percentual" id="percentual_produtos" checked>
                            <label class="form-check-label" for="percentual_produtos">Percentual de Participação</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="incluir_estoque" id="estoque_produtos">
                            <label class="form-check-label" for="estoque_produtos">Situação do Estoque</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Formato do Relatório</label>
                        <select class="form-select" name="formato">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generateReportWithParams('produtos-vendidos')">
                    <i class="fas fa-play me-1"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0a0a0a 0%, #1e293b 100%);
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    .card-custom {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
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

    .search-container {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        z-index: 2;
    }

    .search-input {
        padding-left: 40px;
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
    }

    .search-input:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25);
        background: var(--input-bg);
        color: var(--text-primary);
    }

    .sticky-sidebar {
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .category-list {
        padding: 0;
    }

    .category-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .category-item:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
    }

    .category-item.active {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border-left: 3px solid #60a5fa;
    }

    .category-item i {
        width: 20px;
        margin-right: 12px;
        text-align: center;
    }

    .category-item span:first-of-type {
        flex: 1;
    }

    .category-item .badge {
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }

    .report-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .report-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .report-card:hover::before {
        opacity: 1;
    }

    .report-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 16px;
    }

    .report-content h5 {
        color: var(--text-primary);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .report-content p {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .report-tags {
        display: flex;
        gap: 6px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .tag {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 500;
    }

    .tag-financeiro { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
    .tag-clientes { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .tag-agendamentos { background: rgba(168, 85, 247, 0.2); color: #a855f7; }
    .tag-barbeiros { background: rgba(249, 115, 22, 0.2); color: #f97316; }
    .tag-produtos { background: rgba(236, 72, 153, 0.2); color: #ec4899; }
    .tag-simples { background: rgba(107, 114, 128, 0.2); color: #6b7280; }
    .tag-detalhado { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .tag-personalizado { background: rgba(139, 92, 246, 0.2); color: #8b5cf6; }

    .report-params {
        margin-bottom: 16px;
    }

    .report-params small {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .report-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-outline-primary, .btn-outline-info {
        border-width: 1px;
        font-size: 0.875rem;
        padding: 6px 12px;
    }

    .btn-outline-primary {
        border-color: #60a5fa;
        color: #60a5fa;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .btn-outline-info {
        border-color: #06b6d4;
        color: #06b6d4;
        background: transparent;
    }

    .btn-outline-info:hover {
        background: rgba(6, 182, 212, 0.1);
        border-color: #0891b2;
        color: #0891b2;
    }

    .form-control, .form-select {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
    }

    .form-control:focus, .form-select:focus {
        background: var(--input-bg);
        border-color: #60a5fa;
        color: var(--text-primary);
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25);
    }

    .modal-content {
        background: var(--card-bg);
        color: var(--text-primary);
        border: 2px solid #60a5fa;
    }

    .modal-header {
        background: var(--card-header-bg);
        border-bottom: 1px solid #60a5fa;
        color: var(--text-primary);
    }

    .table {
        background: var(--card-bg);
        color: var(--text-primary);
    }

    .table th {
        border-bottom: 2px solid var(--border-color);
        color: var(--text-primary);
    }

    .table td {
        border-bottom: 1px solid var(--border-color);
    }

    .empty-state {
        grid-column: 1 / -1;
    }

    h2, h5, h6, p {
        color: var(--text-primary);
    }

    .text-muted {
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .reports-grid {
            grid-template-columns: 1fr;
        }
        
        .sticky-sidebar {
            position: static;
            margin-bottom: 20px;
        }
        
        .category-list {
            display: flex;
            overflow-x: auto;
            padding: 8px;
        }
        
        .category-item {
            white-space: nowrap;
            min-width: fit-content;
            border-bottom: none;
            border-right: 1px solid var(--border-color);
            border-radius: 8px;
            margin-right: 8px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchReports');
        const categoryFilter = document.getElementById('categoryFilter');
        const complexityFilter = document.getElementById('complexityFilter');
        const categoryItems = document.querySelectorAll('.category-item');
        const reportCards = document.querySelectorAll('.report-card');
        const emptyState = document.getElementById('emptyState');
        const reportsGrid = document.getElementById('reportsGrid');

        // Função para filtrar relatórios
        function filterReports() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value || getActiveCategoryFromSidebar();
            const selectedComplexity = complexityFilter.value;
            
            let visibleCount = 0;

            reportCards.forEach(card => {
                const title = card.querySelector('h5').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const cardCategory = card.dataset.category;
                const cardComplexity = card.dataset.complexity;

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesCategory = !selectedCategory || cardCategory === selectedCategory;
                const matchesComplexity = !selectedComplexity || cardComplexity === selectedComplexity;

                if (matchesSearch && matchesCategory && matchesComplexity) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Mostrar/esconder estado vazio
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
                reportsGrid.style.display = 'none';
            } else {
                emptyState.style.display = 'none';
                reportsGrid.style.display = 'grid';
            }
        }

        // Função para obter categoria ativa da sidebar
        function getActiveCategoryFromSidebar() {
            const activeItem = document.querySelector('.category-item.active');
            return activeItem ? activeItem.dataset.category : '';
        }

        // Event listeners para filtros
        searchInput.addEventListener('input', filterReports);
        categoryFilter.addEventListener('change', filterReports);
        complexityFilter.addEventListener('change', filterReports);

        // Event listeners para sidebar de categorias
        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active de todos os itens
                categoryItems.forEach(i => i.classList.remove('active'));
                // Adiciona active ao item clicado
                this.classList.add('active');
                
                // Atualiza o filtro de categoria
                categoryFilter.value = this.dataset.category;
                filterReports();
            });
        });

        // Sincronizar filtro de categoria com sidebar
        categoryFilter.addEventListener('change', function() {
            const selectedCategory = this.value;
            categoryItems.forEach(item => {
                if (item.dataset.category === selectedCategory) {
                    categoryItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                }
            });
        });
    });

    function openReportModal(reportType) {
        const modalMap = {
            'faturamento-mensal': 'faturamentoMensalModal',
            'comissoes-barbeiros': 'comissoesBarbeirosModal',
            'formas-pagamento': 'formasPagamentoModal',
            'novos-clientes': 'novosClientesModal',
            'aniversariantes': 'aniversariantesModal',
            'perfil-clientes': 'perfilClientesModal',
            'taxa-ocupacao': 'taxaOcupacaoModal',
            'cancelamentos': 'cancelamentosModal',
            'performance-barbeiros': 'performanceBarbeirosModal',
            'produtos-vendidos': 'produtosVendidosModal'
        };

        const modalId = modalMap[reportType];
        if (modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
    }

    function generateReportWithParams(reportType) {
        const modalMap = {
            'faturamento-mensal': 'faturamentoMensalForm',
            'comissoes-barbeiros': 'comissoesBarbeirosForm',
            'formas-pagamento': 'formasPagamentoForm',
            'novos-clientes': 'novosClientesForm',
            'aniversariantes': 'aniversariantesForm',
            'perfil-clientes': 'perfilClientesForm',
            'taxa-ocupacao': 'taxaOcupacaoForm',
            'cancelamentos': 'cancelamentosForm',
            'performance-barbeiros': 'performanceBarbeirosForm',
            'produtos-vendidos': 'produtosVendidosForm'
        };

        const formId = modalMap[reportType];
        if (formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            
            // Validar campos obrigatórios
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Campos obrigatórios',
                    text: 'Por favor, preencha todos os campos obrigatórios.',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
                return;
            }

            // Converter FormData para objeto
            const params = {};
            for (let [key, value] of formData.entries()) {
                if (params[key]) {
                    if (Array.isArray(params[key])) {
                        params[key].push(value);
                    } else {
                        params[key] = [params[key], value];
                    }
                } else {
                    params[key] = value;
                }
            }

            console.log('[v0] Gerando relatório com parâmetros:', reportType, params);
            
            // Mostrar loading
            Swal.fire({
                title: 'Gerando Relatório',
                text: 'Por favor, aguarde...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                background: 'var(--card-bg)',
                color: 'var(--text-primary)',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fazer requisição para o controller
            fetch(`/admin/relatorios/${reportType}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(params)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/pdf')) {
                    return response.blob();
                } else {
                    return response.json();
                }
            })
            .then(data => {
                Swal.close();
                
                if (data instanceof Blob) {
                    // É um PDF - fazer download
                    const url = window.URL.createObjectURL(data);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = `relatorio-${reportType}-${new Date().toISOString().split('T')[0]}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    // Fechar modal
                    const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                    modal.hide();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Relatório Gerado!',
                        text: 'O download do relatório foi iniciado.',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                } else if (data.success) {
                    // Resposta JSON de sucesso
                    const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                    modal.hide();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Relatório Gerado!',
                        text: data.message || 'Relatório gerado com sucesso!',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                    
                    if (data.download_url) {
                        // Se houver URL de download, abrir em nova aba
                        window.open(data.download_url, '_blank');
                    }
                } else {
                    throw new Error(data.message || 'Erro ao gerar relatório');
                }
            })
            .catch(error => {
                console.error('[v0] Erro ao gerar relatório:', error);
                Swal.close();
                
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao Gerar Relatório',
                    text: error.message || 'Ocorreu um erro inesperado. Tente novamente.',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            });
        }
    }

    function previewReport(reportType) {
        console.log('[v0] Visualizando preview do relatório:', reportType);
        
        // Mostrar loading
        Swal.fire({
            title: 'Carregando Preview',
            text: 'Gerando visualização do relatório...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            background: 'var(--card-bg)',
            color: 'var(--text-primary)',
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Fazer requisição para preview
        fetch(`/admin/relatorios/${reportType}/preview`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
                // Mostrar modal com preview
                Swal.fire({
                    title: `Preview: ${data.title}`,
                    html: `
                        <div class="text-start">
                            <p><strong>Descrição:</strong> ${data.description}</p>
                            <p><strong>Campos disponíveis:</strong></p>
                            <ul class="list-unstyled">
                                ${data.fields.map(field => `<li>• ${field}</li>`).join('')}
                            </ul>
                            <p><strong>Parâmetros necessários:</strong></p>
                            <ul class="list-unstyled">
                                ${data.parameters.map(param => `<li>• ${param}</li>`).join('')}
                            </ul>
                        </div>
                    `,
                    width: '600px',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)',
                    showCancelButton: true,
                    confirmButtonText: 'Gerar Relatório',
                    cancelButtonText: 'Fechar',
                    confirmButtonColor: '#3b82f6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        openReportModal(reportType);
                    }
                });
            } else {
                throw new Error(data.message || 'Erro ao carregar preview');
            }
        })
        .catch(error => {
            console.error('[v0] Erro ao carregar preview:', error);
            Swal.close();
            
            Swal.fire({
                icon: 'error',
                title: 'Erro ao Carregar Preview',
                text: error.message || 'Não foi possível carregar o preview do relatório.',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
        });
    }

    // Funções mantidas para compatibilidade
    function generateReport(reportType) {
        openReportModal(reportType);
    }
</script>
@endpush
@endsection
