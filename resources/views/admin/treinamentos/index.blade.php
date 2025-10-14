@extends('layouts.app')

@section('title', 'Treinamentos - BarberShop Pro')
@section('page-title', 'Central de Treinamentos')
@section('page-subtitle', 'Vídeos e tutoriais para dominar o sistema')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-graduation-cap me-2" style="color: #60a5fa;"></i>
                Central de Treinamentos
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Vídeos e tutoriais para dominar o sistema</p>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">17</h4>
                        <p class="text-muted mb-0">Total de Vídeos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">6</h4>
                        <p class="text-muted mb-0">Categorias</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">1h 52min</h4>
                        <p class="text-muted mb-0">Duração Total</p>
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
                        <h4 class="mb-0">Novo</h4>
                        <p class="text-muted mb-0">Conteúdo Atualizado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Filtros -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2); cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
            <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                <i class="fas fa-filter me-2" style="color: #60a5fa;"></i>Filtros
            </h6>
            <i class="fas fa-chevron-down" style="color: #60a5fa;"></i>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchVideos" placeholder="Buscar vídeos..." style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filterCategory" style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            <option value="">Todas as categorias</option>
                            <option value="dashboard">Dashboard</option>
                            <option value="clientes">Clientes</option>
                            <option value="agendamentos">Agendamentos</option>
                            <option value="produtos">Produtos</option>
                            <option value="financeiro">Financeiro</option>
                            <option value="relatorios">Relatórios</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                            <i class="fas fa-times"></i> Limpar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Player de Vídeo (inicialmente oculto) -->
    <div class="card-custom mb-4" id="videoPlayerCard" style="display: none;">
        <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);" id="currentVideoTitle">
                    <i class="fas fa-play-circle me-2" style="color: #60a5fa;"></i>
                    Reproduzindo Vídeo
                </h6>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="closeVideoPlayer()">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <video class="w-100" id="mainVideoPlayer" controls controlsList="nodownload" style="max-height: 600px; background: #000;">
                <source src="" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
            <div class="p-3">
                <p class="text-muted mb-0" id="currentVideoDescription"></p>
            </div>
        </div>
    </div>

    <!-- Lista de Vídeos por Categoria -->
    <div id="videosContainer">
        <!-- Dashboard -->
        <div class="card-custom mb-4 category-section" data-category="dashboard">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-home me-2" style="color: #60a5fa;"></i>
                    Dashboard
                    <span class="badge bg-primary ms-2">2 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('dashboard-visao-geral', 'Visão Geral do Dashboard', 'Aprenda a navegar e entender todas as métricas e indicadores do painel principal')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Visão Geral do Dashboard</h6>
                                    <p class="text-muted mb-0 small">Aprenda a navegar e entender todas as métricas e indicadores do painel principal</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-info">Básico</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>5:30</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('dashboard-graficos', 'Interpretando Gráficos', 'Como ler e analisar os gráficos de desempenho e faturamento')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Interpretando Gráficos</h6>
                                    <p class="text-muted mb-0 small">Como ler e analisar os gráficos de desempenho e faturamento</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>4:15</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="card-custom mb-4 category-section" data-category="clientes">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-users me-2" style="color: #60a5fa;"></i>
                    Clientes
                    <span class="badge bg-primary ms-2">3 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('clientes-cadastro', 'Cadastro de Clientes', 'Passo a passo completo para cadastrar novos clientes no sistema')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Cadastro de Clientes</h6>
                                    <p class="text-muted mb-0 small">Passo a passo completo para cadastrar novos clientes no sistema</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-info">Básico</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>6:45</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('clientes-historico', 'Histórico de Atendimentos', 'Como visualizar e gerenciar o histórico completo de cada cliente')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Histórico de Atendimentos</h6>
                                    <p class="text-muted mb-0 small">Como visualizar e gerenciar o histórico completo de cada cliente</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>5:20</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('clientes-detalhes', 'Detalhes do Cliente', 'Entenda a página de detalhes com timeline e estatísticas')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Detalhes do Cliente</h6>
                                    <p class="text-muted mb-0 small">Entenda a página de detalhes com timeline e estatísticas</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>7:10</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Agendamentos -->
        <div class="card-custom mb-4 category-section" data-category="agendamentos">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-calendar-alt me-2" style="color: #60a5fa;"></i>
                    Agendamentos
                    <span class="badge bg-primary ms-2">4 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('agendamentos-criar', 'Criar Agendamento', 'Como criar e configurar um novo agendamento no sistema')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Criar Agendamento</h6>
                                    <p class="text-muted mb-0 small">Como criar e configurar um novo agendamento no sistema</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-info">Básico</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>8:30</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('agendamentos-gerenciar', 'Gerenciar Agendamentos', 'Editar, cancelar e reagendar atendimentos')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Gerenciar Agendamentos</h6>
                                    <p class="text-muted mb-0 small">Editar, cancelar e reagendar atendimentos</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>6:15</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('agendamentos-horarios', 'Configurar Horários', 'Como definir horários disponíveis e bloqueios')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Configurar Horários</h6>
                                    <p class="text-muted mb-0 small">Como definir horários disponíveis e bloqueios</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">Avançado</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>5:45</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('agendamentos-confirmacao', 'Confirmação e Notificações', 'Sistema de confirmação automática e lembretes')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Confirmação e Notificações</h6>
                                    <p class="text-muted mb-0 small">Sistema de confirmação automática e lembretes</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>4:50</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Produtos -->
        <div class="card-custom mb-4 category-section" data-category="produtos">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-box me-2" style="color: #60a5fa;"></i>
                    Produtos
                    <span class="badge bg-primary ms-2">3 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('produtos-cadastro', 'Cadastro de Produtos', 'Como cadastrar produtos e serviços no sistema')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Cadastro de Produtos</h6>
                                    <p class="text-muted mb-0 small">Como cadastrar produtos e serviços no sistema</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-info">Básico</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>7:20</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('produtos-estoque', 'Controle de Estoque', 'Gerenciar entradas, saídas e alertas de estoque')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Controle de Estoque</h6>
                                    <p class="text-muted mb-0 small">Gerenciar entradas, saídas e alertas de estoque</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>6:35</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('produtos-vendas', 'Registro de Vendas', 'Como registrar vendas de produtos no sistema')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Registro de Vendas</h6>
                                    <p class="text-muted mb-0 small">Como registrar vendas de produtos no sistema</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">Básico</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>5:55</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Financeiro -->
        <div class="card-custom mb-4 category-section" data-category="financeiro">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-credit-card me-2" style="color: #60a5fa;"></i>
                    Financeiro
                    <span class="badge bg-primary ms-2">3 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('financeiro-movimentacoes', 'Movimentações Financeiras', 'Registrar entradas, saídas e categorizar movimentações')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Movimentações Financeiras</h6>
                                    <p class="text-muted mb-0 small">Registrar entradas, saídas e categorizar movimentações</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>8:10</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('financeiro-relatorios', 'Relatórios Financeiros', 'Gerar e interpretar relatórios de faturamento e despesas')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Relatórios Financeiros</h6>
                                    <p class="text-muted mb-0 small">Gerar e interpretar relatórios de faturamento e despesas</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">Avançado</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>9:25</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('financeiro-comissoes', 'Comissões', 'Como configurar e calcular comissões dos barbeiros')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Comissões</h6>
                                    <p class="text-muted mb-0 small">Como configurar e calcular comissões dos barbeiros</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>6:40</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="card-custom mb-4 category-section" data-category="relatorios">
            <div class="card-header" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
                <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                    <i class="fas fa-chart-bar me-2" style="color: #60a5fa;"></i>
                    Relatórios
                    <span class="badge bg-primary ms-2">2 vídeos</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('relatorios-gerar', 'Gerar Relatórios', 'Como gerar relatórios personalizados com filtros')">
                                <td style="width: 60px;">
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Gerar Relatórios</h6>
                                    <p class="text-muted mb-0 small">Como gerar relatórios personalizados com filtros</p>
                                </td>
                                <td style="width: 100px;" class="text-center">
                                    <span class="badge bg-warning">Intermediário</span>
                                </td>
                                <td style="width: 80px;" class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>7:50</span>
                                </td>
                            </tr>
                            <tr class="video-row" style="cursor: pointer;" onclick="playVideo('relatorios-analise', 'Análise de Dados', 'Interpretar dados e tomar decisões baseadas em relatórios')">
                                <td>
                                    <div class="video-thumbnail-small">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1" style="color: var(--text-primary);">Análise de Dados</h6>
                                    <p class="text-muted mb-0 small">Interpretar dados e tomar decisões baseadas em relatórios</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">Avançado</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i>10:15</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .product-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
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

    .video-thumbnail-small {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .video-row:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .video-row:hover .video-thumbnail-small {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
        transform: scale(1.1);
    }

    /* Estilos herdados do original */
    .training-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .category-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .category-section:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-2px);
    }

    .category-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(59, 130, 246, 0.3);
    }

    .category-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #60a5fa;
        margin: 0;
    }

    .category-count {
        margin-left: auto;
        background: rgba(59, 130, 246, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        color: #60a5fa;
        font-weight: 600;
    }

    .videos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .video-card {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .video-thumbnail {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: linear-gradient(135deg, #1e293b, #334155);
        overflow: hidden;
    }

    .video-thumbnail-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .play-button {
        width: 60px;
        height: 60px;
        background: rgba(59, 130, 246, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }

    .video-card:hover .play-button {
        background: #3b82f6;
        transform: scale(1.1);
    }

    .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .video-info {
        padding: 1.25rem;
    }

    .video-title {
        font-size: 1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .video-description {
        font-size: 0.875rem;
        color: #94a3b8;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .video-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .video-meta i {
        color: #3b82f6;
    }

    /* Modal de Vídeo */
    .video-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        padding: 2rem;
    }

    .video-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-modal-content {
        max-width: 1200px;
        width: 100%;
        background: #1e293b;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .video-modal-header {
        padding: 1.5rem 2rem;
        background: rgba(59, 130, 246, 0.1);
        border-bottom: 1px solid rgba(59, 130, 246, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .video-modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .video-modal-body {
        padding: 0;
    }

    .video-player {
        width: 100%;
        aspect-ratio: 16/9;
        background: #000;
    }

    @media (max-width: 768px) {
        .videos-grid {
            grid-template-columns: 1fr;
        }

        .video-modal {
            padding: 1rem;
        }

        .category-section {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function playVideo(videoId, videoTitle, videoDescription) {
    const videoPlayerCard = document.getElementById('videoPlayerCard');
    const mainVideoPlayer = document.getElementById('mainVideoPlayer');
    const currentVideoTitle = document.getElementById('currentVideoTitle');
    const currentVideoDescription = document.getElementById('currentVideoDescription');
    
    // Definir o caminho do vídeo (storage/app/treinamentos/)
    const videoPath = `/videos/treinamentos/${videoId}.mp4`;
    
    // Atualizar informações do vídeo
    currentVideoTitle.innerHTML = `<i class="fas fa-play-circle me-2" style="color: #60a5fa;"></i>${videoTitle}`;
    currentVideoDescription.textContent = videoDescription;
    
    // Configurar e exibir o player
    mainVideoPlayer.src = videoPath;
    videoPlayerCard.style.display = 'block';
    
    // Scroll suave até o player
    videoPlayerCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    // Reproduzir o vídeo
    mainVideoPlayer.play();
}

function closeVideoPlayer() {
    const videoPlayerCard = document.getElementById('videoPlayerCard');
    const mainVideoPlayer = document.getElementById('mainVideoPlayer');
    
    mainVideoPlayer.pause();
    mainVideoPlayer.src = '';
    videoPlayerCard.style.display = 'none';
}

document.getElementById('searchVideos').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const videoRows = document.querySelectorAll('.video-row');
    
    videoRows.forEach(row => {
        const title = row.querySelector('h6').textContent.toLowerCase();
        const description = row.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('filterCategory').addEventListener('change', function() {
    const selectedCategory = this.value;
    const categorySections = document.querySelectorAll('.category-section');
    
    categorySections.forEach(section => {
        if (selectedCategory === '' || section.dataset.category === selectedCategory) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
});

function clearFilters() {
    document.getElementById('searchVideos').value = '';
    document.getElementById('filterCategory').value = '';
    
    document.querySelectorAll('.video-row').forEach(row => {
        row.style.display = '';
    });
    
    document.querySelectorAll('.category-section').forEach(section => {
        section.style.display = 'block';
    });
}

// <ORIGINAL_CODE> Fechar modal ao pressionar ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        // Check if the video player is visible and close it if it is
        const videoPlayerCard = document.getElementById('videoPlayerCard');
        if (videoPlayerCard.style.display === 'block') {
            closeVideoPlayer();
        } else {
            // If not, assume the modal is the target (though it's removed in the updates)
            // For safety, we can keep this logic in case a modal is re-introduced
            const modal = document.getElementById('videoModal'); // This ID is removed in the updates
            if (modal && modal.classList.contains('active')) {
                closeVideo();
            }
        }
    }
});

// <ORIGINAL_CODE> Fechar modal ao clicar fora do conteúdo
// This listener is for the old modal, the new approach uses a close button on the player card
// Keeping it commented for reference or potential future use if modal is re-added.
/*
document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVideo();
    }
});
*/

// <ORIGINAL_CODE> Function to close the old modal (removed in updates)
/*
function closeVideo() {
    const modal = document.getElementById('videoModal');
    const videoPlayer = document.getElementById('videoPlayer');
    
    videoPlayer.pause();
    videoPlayer.src = '';
    modal.classList.remove('active');
}
*/

// <ORIGINAL_CODE> Function to open the old modal (removed in updates)
/*
function openVideo(videoId, videoTitle) {
    const modal = document.getElementById('videoModal');
    const modalTitle = document.getElementById('modalTitle');
    const videoPlayer = document.getElementById('videoPlayer');
    
    // Definir o caminho do vídeo (storage/app/treinamentos/)
    const videoPath = `/storage/treinamentos/${videoId}.mp4`;
    
    modalTitle.textContent = videoTitle;
    videoPlayer.src = videoPath;
    modal.classList.add('active');
    videoPlayer.play();
}
*/

</script>
@endpush

@endsection
