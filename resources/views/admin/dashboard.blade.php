@extends('layouts.app')

@section('title', 'Dashboard - BarberShop Pro')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Bem-vindo ao sistema')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <!-- Mudando cor do título de preto para gradiente azul -->
            <h1 class="display-4 mb-2" style="background: linear-gradient(135deg, #60a5fa, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">
                Bem-vindo ao BarberShop Pro
            </h1>
            <p class="lead mb-0" style="color: var(--text-muted);">Gerencie sua barbearia de forma profissional</p>
        </div>
    </div>

    <!-- Carousel de Novidades com Imagens -->
    <div class="row mb-5" id="carousel-section">
        <div class="col-12">
            <div class="carousel-container">
                <div id="novidadesCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#novidadesCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#novidadesCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#novidadesCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#novidadesCarousel" data-bs-slide-to="3"></button>
                    </div>
                    <div class="carousel-inner">
                        <!-- Slide 1: Relatórios Avançados -->
                        <div class="carousel-item active">
                            <img src="/videos/dashboard/relatorios.png" class="d-block w-100 carousel-image" alt="Relatórios Avançados">
                            <div class="carousel-caption-custom">
                                <div class="carousel-content">
                                    <span class="carousel-badge">Novo</span>
                                    <h2>Relatórios Avançados</h2>
                                    <p>Análises detalhadas de faturamento, despesas, produtos e serviços. Tome decisões baseadas em dados reais.</p>
                                    <a href="{{ route('relatorios.index') }}" class="btn btn-carousel">
                                        Acessar Relatórios <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2: Central de Treinamentos -->
                        <div class="carousel-item">
                            <img src="/videos/dashboard/treinamentos.png?height=500&width=1200" class="d-block w-100 carousel-image" alt="Central de Treinamentos">
                            <div class="carousel-caption-custom">
                                <div class="carousel-content">
                                    <span class="carousel-badge" style="background: linear-gradient(45deg, #10b981, #34d399);">Aprenda</span>
                                    <h2>Central de Treinamentos</h2>
                                    <p>Vídeos tutoriais organizados por categoria. Aprenda a usar todas as funcionalidades do sistema.</p>
                                    <a href="{{ route('treinamentos.index') }}" class="btn btn-carousel" style="background: linear-gradient(45deg, #10b981, #34d399);">
                                        Ver Treinamentos <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3: Gestão de Clientes -->
                        <div class="carousel-item">
                            <img src="/videos/dashboard/clientes.png" class="d-block w-100 carousel-image" alt="Gestão de Clientes">
                            <div class="carousel-caption-custom">
                                <div class="carousel-content">
                                    <span class="carousel-badge" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">Destaque</span>
                                    <h2>Gestão Completa de Clientes</h2>
                                    <p>Histórico detalhado, análise de comportamento e estatísticas personalizadas para cada cliente.</p>
                                    <a href="{{ route('clientes.index') }}" class="btn btn-carousel" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                                        Gerenciar Clientes <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4: Agendamentos Inteligentes -->
                        <div class="carousel-item">
                            <img src="/videos/dashboard/agendamentos.png" class="d-block w-100 carousel-image" alt="Agendamentos">
                            <div class="carousel-caption-custom">
                                <div class="carousel-content">
                                    <span class="carousel-badge" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">Popular</span>
                                    <h2>Sistema de Agendamentos</h2>
                                    <p>Organize sua agenda de forma eficiente. Controle horários, barbeiros e serviços em tempo real.</p>
                                    <a href="{{ route('agendamentos.index') }}" class="btn btn-carousel" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                                        Ver Agenda <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#novidadesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#novidadesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações de Versão -->
    <div class="row mb-4" id="version-section">
        <div class="col-12">
            <div class="version-card">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <div class="version-info">
                            <div class="version-icon">
                                <i class="fas fa-code-branch"></i>
                            </div>
                            <div>
                                <span class="version-label">Versão Atual</span>
                                <!-- Atualizando versão de 2.5.3 para 2.2.1 -->
                                <h3 class="version-number">v2.2.1</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <div class="version-info">
                            <div class="version-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <span class="version-label">Última Atualização</span>
                                <h3 class="version-number">15/01/2025</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <div class="version-info">
                            <div class="version-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <span class="version-label">Próxima Versão</span>
                                <!-- Atualizando próxima versão de 2.6.0 para 2.2.2 -->
                                <h3 class="version-number">v2.2.2</h3>
                                <span class="version-date">Prevista: 10/01/2026</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="button" class="btn-novidades" data-bs-toggle="modal" data-bs-target="#novidadesModal">
                            <i class="fas fa-rocket me-2"></i>
                            <span>Próximas Novidades</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Novidades da Versão Atual -->
    <div class="row mb-5" id="current-features-section">
        <div class="col-12">
            <div class="current-version-section">
                <div class="text-center mb-4">
                    <div class="current-version-badge">
                        <i class="fas fa-star me-2"></i>
                        <!-- Atualizando badge para v2.2.1 -->
                        <span>Novidades da v2.2.1</span>
                    </div>
                    <h3 class="mt-3" style="color: var(--text-primary); font-weight: 600;">O que há de novo nesta versão</h3>
                    <p style="color: var(--text-muted);">Confira as funcionalidades que acabaram de chegar no sistema</p>
                </div>

                <!-- Substituindo os 6 cards por apenas 5 conforme solicitado -->
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <h5>Sistema de Relatórios Completo</h5>
                            <p>Relatórios avançados de faturamento, despesas, produtos mais vendidos, serviços realizados e análise completa de clientes com exportação em PDF.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h5>Centro de Treinamentos</h5>
                            <p>Vídeos tutoriais organizados por categoria para capacitar sua equipe. Os vídeos serão lançados aos poucos para garantir conteúdo de qualidade.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5>Análise Detalhada de Clientes</h5>
                            <p>Visualize histórico completo, produtos mais comprados, serviços preferidos e estatísticas personalizadas de cada cliente.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <h5>Relatório de Aniversariantes</h5>
                            <p>Identifique clientes que fazem aniversário no mês e envie mensagens personalizadas para fortalecer o relacionamento.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                                <i class="fas fa-bug"></i>
                            </div>
                            <h5>Correção de Bugs</h5>
                            <p>Diversas correções e melhorias de estabilidade para garantir uma experiência mais fluida e confiável no uso do sistema.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="current-feature-card">
                            <div class="current-feature-icon" style="background: linear-gradient(135deg, #06b6d4, #67e8f9);">
                                <i class="fas fa-shield"></i>
                            </div>
                            <h5>+ Segurança</h5>
                            <p>Agora é possível gerenciar permissões de acesso por usuário, sendo assim, garantindo mais segurança a aplicação.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row" id="quick-actions-section">
        <div class="col-12">
            <div class="text-center mb-4">
                <h3 style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-bolt me-2" style="color: #60a5fa;"></i>
                    Ações Rápidas
                </h3>
                <p style="color: var(--text-muted);">Acesse rapidamente as principais funcionalidades do sistema</p>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Agendamentos -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('agendamentos.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5>Agendamentos</h5>
                <p>Gerencie a agenda e horários</p>
            </a>
        </div>

        <!-- Clientes -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('clientes.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Clientes</h5>
                <p>Cadastro e histórico completo</p>
            </a>
        </div>

        <!-- Produtos -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('produtos.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #06b6d4, #67e8f9);">
                    <i class="fas fa-box"></i>
                </div>
                <h5>Produtos</h5>
                <p>Controle de estoque e vendas</p>
            </a>
        </div>

        <!-- Financeiro -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('financeiro.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h5>Financeiro</h5>
                <p>Movimentações e fluxo de caixa</p>
            </a>
        </div>

        <!-- Relatórios -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('relatorios.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h5>Relatórios</h5>
                <p>Análises e estatísticas</p>
            </a>
        </div>

        <!-- Barbeiros -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('barbeiros.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #ec4899, #f472b6);">
                    <i class="fas fa-cut"></i>
                </div>
                <h5>Barbeiros</h5>
                <p>Equipe e comissões</p>
            </a>
        </div>

        <!-- Filiais -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('filiais.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                    <i class="fas fa-store"></i>
                </div>
                <h5>Filiais</h5>
                <p>Gestão de unidades</p>
            </a>
        </div>

        <!-- Treinamentos -->
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('treinamentos.index') }}" class="action-card">
                <div class="action-icon" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h5>Treinamentos</h5>
                <p>Vídeos e tutoriais</p>
            </a>
        </div>
    </div>
</div>

<!-- Floating Navigation Buttons -->
<div class="floating-nav">
     <!-- Mudando nome de "Carousel" para "Sistema" e adicionando ícone de engrenagem -->
    <button class="floating-btn" onclick="scrollToSection('carousel-section')" title="Sistema">
        <i class="fas fa-cog"></i>
        <span class="floating-btn-text">Sistema</span>
    </button>
    <button class="floating-btn" onclick="scrollToSection('version-section')" title="Versão">
        <i class="fas fa-code-branch"></i>
        <span class="floating-btn-text">Versão</span>
    </button>
    <button class="floating-btn" onclick="scrollToSection('current-features-section')" title="Novidades">
        <i class="fas fa-star"></i>
        <span class="floating-btn-text">Novidades</span>
    </button>
    <button class="floating-btn" onclick="scrollToSection('quick-actions-section')" title="Ações Rápidas">
        <i class="fas fa-bolt"></i>
        <span class="floating-btn-text">Ações</span>
    </button>
    <button class="floating-btn floating-btn-top" onclick="scrollToTop()" title="Voltar ao Topo">
        <i class="fas fa-arrow-up"></i>
        <span class="floating-btn-text">Topo</span>
    </button>
</div>

<!-- Modal de Próximas Novidades -->
<div class="modal fade" id="novidadesModal" tabindex="-1" aria-labelledby="novidadesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novidadesModalLabel">
                    <i class="fas fa-star me-2" style="color: #f59e0b;"></i>
                    <!-- Atualizando título do modal para v2.2.2 -->
                    Novidades da v2.2.2
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="coming-soon-header">
                    <div class="coming-soon-badge-modal">
                        <i class="fas fa-rocket me-2"></i>
                        <span>Em Breve</span>
                    </div>
                    <p class="text-muted mb-4">Confira as novidades que estão chegando na próxima versão do sistema</p>
                </div>

                <!-- Substituindo as 6 novidades pelas 5 novas funcionalidades solicitadas -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="feature-item-modal">
                            <div class="feature-icon-modal" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6>Comunicação</h6>
                                <p>Sistema completo de comunicação via email com clientes, permitindo envio de mensagens personalizadas e automáticas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-item-modal">
                            <div class="feature-icon-modal" style="background: linear-gradient(135deg, #10b981, #34d399);">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div>
                                <h6>Campanhas de Mensagens</h6>
                                <p>Crie e gerencie campanhas de marketing por email e WhatsApp para engajar seus clientes e aumentar as vendas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-item-modal">
                            <div class="feature-icon-modal" style="background: linear-gradient(135deg, #10b981, #34d399);">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h6>Integração WhatsApp</h6>
                                <p>Integração completa com WhatsApp para envio de mensagens, confirmações de agendamento e comunicação direta com clientes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-item-modal">
                            <div class="feature-icon-modal" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div>
                                <h6>Atendimento e Agendamento via Chatbot com IA</h6>
                                <p>Chatbot inteligente integrado ao WhatsApp para atendimento automático e agendamentos 24/7 usando inteligência artificial.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="feature-item-modal">
                            <div class="feature-icon-modal" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h6>Melhoria na Tela de Agendamentos</h6>
                                <p>Interface de agendamentos completamente reformulada com visualização em calendário, drag and drop, filtros avançados e melhor experiência do usuário.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Data de Lançamento:</strong> Previsto para 10/01/2026
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        /* background: linear-gradient(135deg, #0a0a0a 0%, #1e293b 100%); */
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        padding-top: 2rem;
        padding-bottom: 3rem;
    }

    /* Carousel Styles */
    .carousel-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        border: 2px solid rgba(59, 130, 246, 0.2);
    }

    .carousel-image {
        height: 500px;
        object-fit: cover;
        filter: brightness(0.6);
    }

    .carousel-caption-custom {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.3) 100%);
        padding: 3rem;
    }

    .carousel-content {
        max-width: 700px;
        text-align: center;
    }

    .carousel-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .carousel-content h2 {
        color: white;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    .carousel-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.25rem;
        margin-bottom: 2rem;
        line-height: 1.6;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .btn-carousel {
        padding: 1rem 2.5rem;
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-carousel:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
        color: white;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
        margin: 0 6px;
    }

    .carousel-indicators button.active {
        background-color: white;
        width: 40px;
        border-radius: 6px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 60px;
        opacity: 1;
        transition: all 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        transform: scale(1.1);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        border: 3px solid rgba(59, 130, 246, 0.8);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        position: relative;
        background-image: none;
    }

    .carousel-control-prev-icon::before,
    .carousel-control-next-icon::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0;
        height: 0;
        border-style: solid;
    }

    .carousel-control-prev-icon::before {
        border-width: 10px 15px 10px 0;
        border-color: transparent #3b82f6 transparent transparent;
        margin-left: -3px;
    }

    .carousel-control-next-icon::before {
        border-width: 10px 0 10px 15px;
        border-color: transparent transparent transparent #3b82f6;
        margin-left: 3px;
    }

    .carousel-control-prev:hover .carousel-control-prev-icon,
    .carousel-control-next:hover .carousel-control-next-icon {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        border-color: white;
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
        transform: scale(1.15);
    }

    .carousel-control-prev:hover .carousel-control-prev-icon::before {
        border-color: transparent white transparent transparent;
    }

    .carousel-control-next:hover .carousel-control-next-icon::before {
        border-color: transparent transparent transparent white;
    }

    .carousel-control-prev {
        left: 20px;
    }

    .carousel-control-next {
        right: 20px;
    }

    /* Action Cards */
    .action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 2.5rem 1.5rem;
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .action-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
    }

    .action-icon i {
        font-size: 2rem;
        color: white;
    }

    .action-card h5 {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .action-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin: 0;
    }

    /* Version Card Styles */
    .version-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .version-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .version-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .version-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .version-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .version-label {
        display: block;
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .version-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        line-height: 1;
    }

    .version-date {
        display: block;
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    .btn-novidades {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        font-weight: 700;
        font-size: 1.25rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        border: none;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-novidades:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
    }

    .modal-content {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 20px;
    }

    .modal-header {
        border-bottom: 2px solid var(--border-color);
        padding: 1.5rem 2rem;
    }

    .modal-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .coming-soon-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .coming-soon-badge-modal {
        display: inline-block;
        background: linear-gradient(135deg, #3b82f6, #60a5fa); /* Mudado de rosa para azul */
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        margin-bottom: 1rem;
    }

    .feature-item-modal {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
        background: rgba(59, 130, 246, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 15px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-item-modal:hover {
        transform: translateY(-5px);
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .feature-icon-modal {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .feature-icon-modal i {
        font-size: 1.5rem;
        color: white;
    }

    .feature-item-modal h6 {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .feature-item-modal p {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin: 0;
        line-height: 1.5;
    }

    .modal-footer {
        border-top: 2px solid var(--border-color);
        padding: 1.5rem 2rem;
    }

    .btn-close {
        filter: invert(1);
    }

    /* Adicionando estilos para seção de novidades da versão atual */
    .current-version-section {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 20px;
        padding: 3rem 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .current-version-badge {
        display: inline-block;
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .current-feature-card {
        background: rgba(59, 130, 246, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .current-feature-card:hover {
        transform: translateY(-8px);
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    .current-feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .current-feature-card:hover .current-feature-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .current-feature-icon i {
        font-size: 2rem;
        color: white;
    }

    .current-feature-card h5 {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .current-feature-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Floating Navigation Buttons */
    .floating-nav {
        position: fixed;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .floating-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        border: 3px solid rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        position: relative;
        overflow: visible;
    }

    .floating-btn:hover {
        transform: scale(1.15);
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .floating-btn i {
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .floating-btn:hover i {
        transform: scale(1.1);
    }

    .floating-btn-text {
        position: absolute;
        right: 70px;
        background: rgba(10, 10, 10, 0.95);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .floating-btn:hover .floating-btn-text {
        opacity: 1;
        right: 75px;
    }

    .floating-btn-top {
        background: linear-gradient(135deg, #10b981, #34d399);
        margin-top: 8px;
    }

    .floating-btn-top:hover {
        box-shadow: 0 12px 35px rgba(16, 185, 129, 0.6);
    }

    /* Scroll suave */
    html {
        scroll-behavior: smooth;
    }

    /* Responsividade dos botões flutuantes */
    @media (max-width: 768px) {
        .floating-nav {
            right: 15px;
            gap: 10px;
        }

        .floating-btn {
            width: 48px;
            height: 48px;
        }

        .floating-btn i {
            font-size: 1.1rem;
        }

        .floating-btn-text {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .floating-nav {
            right: 10px;
            gap: 8px;
        }

        .floating-btn {
            width: 42px;
            height: 42px;
            border-width: 2px;
        }

        .floating-btn i {
            font-size: 1rem;
        }
    }


    /* Media queries for responsiveness */
    @media (max-width: 768px) {
        .container-fluid {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        /* Header responsive */
        .display-4 {
            font-size: 2rem !important;
        }

        .lead {
            font-size: 1rem !important;
        }

        /* Carousel responsive */
        .carousel-container {
            border-radius: 12px;
        }

        .carousel-image {
            height: 300px;
        }

        .carousel-caption-custom {
            padding: 1.5rem;
        }

        .carousel-content h2 {
            font-size: 1.75rem;
        }

        .carousel-content p {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .carousel-badge {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }

        .btn-carousel {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
        }

        /* Botões do carousel menores no mobile */
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 35px;
            height: 35px;
            border-width: 2px;
        }

        .carousel-control-prev-icon::before {
            border-width: 7px 10px 7px 0;
        }

        .carousel-control-next-icon::before {
            border-width: 7px 0 7px 10px;
        }

        .carousel-control-prev {
            left: 10px;
        }

        .carousel-control-next {
            right: 10px;
        }

        .carousel-indicators {
            margin-bottom: 0.5rem;
        }

        .carousel-indicators button {
            width: 8px;
            height: 8px;
            margin: 0 4px;
        }

        .carousel-indicators button.active {
            width: 24px;
        }

        /* Version card responsivo */
        .version-card {
            padding: 1.5rem;
        }

        .version-info {
            justify-content: center;
            text-align: center;
            flex-direction: column;
        }

        .version-icon {
            width: 50px;
            height: 50px;
        }

        .version-icon i {
            font-size: 1.25rem;
        }

        .version-number {
            font-size: 1.5rem;
        }

        .version-label {
            font-size: 0.75rem;
        }

        .btn-novidades {
            padding: 1rem;
            font-size: 1rem;
        }

        /* Action cards responsivo - 2 colunas no mobile */
        .action-card {
            padding: 1.5rem 1rem;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }

        .action-icon i {
            font-size: 1.5rem;
        }

        .action-card h5 {
            font-size: 1rem;
        }

        .action-card p {
            font-size: 0.85rem;
        }

        /* Modal responsivo */
        .modal-header {
            padding: 1rem 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .coming-soon-badge-modal {
            padding: 0.6rem 1.5rem;
            font-size: 0.875rem;
        }

        .feature-item-modal {
            padding: 1rem;
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .feature-icon-modal {
            width: 45px;
            height: 45px;
            min-width: 45px;
        }

        .feature-icon-modal i {
            font-size: 1.25rem;
        }

        .feature-item-modal h6 {
            font-size: 0.95rem;
        }

        .feature-item-modal p {
            font-size: 0.8rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
        }

        /* Responsividade para seção de novidades da versão atual */
        .current-version-section {
            padding: 2rem 1.5rem;
        }

        .current-version-badge {
            padding: 0.6rem 1.5rem;
            font-size: 0.875rem;
        }

        .current-feature-card {
            padding: 1.5rem;
        }

        .current-feature-icon {
            width: 60px;
            height: 60px;
        }

        .current-feature-icon i {
            font-size: 1.5rem;
        }

        .current-feature-card h5 {
            font-size: 1.1rem;
        }

        .current-feature-card p {
            font-size: 0.875rem;
        }
    }

    /* Media query for very small screens */
    @media (max-width: 576px) {
        .display-4 {
            font-size: 1.5rem !important;
        }

        .carousel-image {
            height: 250px;
        }

        .carousel-content h2 {
            font-size: 1.5rem;
        }

        .carousel-content p {
            font-size: 0.875rem;
        }

        .btn-carousel {
            padding: 0.6rem 1.25rem;
            font-size: 0.875rem;
        }

        .version-card {
            padding: 1rem;
        }

        .btn-novidades {
            font-size: 0.875rem;
            padding: 0.875rem;
        }

        /* Responsividade extra para telas muito pequenas */
        .current-version-section {
            padding: 1.5rem 1rem;
        }

        .current-version-badge {
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
        }

        .current-feature-card {
            padding: 1.25rem;
        }

        .current-feature-icon {
            width: 50px;
            height: 50px;
        }

        .current-feature-icon i {
            font-size: 1.25rem;
        }

        .current-feature-card h5 {
            font-size: 1rem;
        }

        .current-feature-card p {
            font-size: 0.825rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            const offset = 80; // Offset para compensar header fixo
            const elementPosition = section.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Adicionar efeito de destaque ao chegar na seção
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        // Observar seções para animação de entrada
        const sections = document.querySelectorAll('[id$="-section"]');
        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'all 0.6s ease';
            observer.observe(section);
        });
    });
</script>
@endpush
@endsection
