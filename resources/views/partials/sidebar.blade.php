<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Mobile Header -->
    <div class="sidebar-header d-lg-none">
        <div class="d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-cut me-2 text-primary"></i>
                <span class="fw-bold text-primary">BarberShop Pro</span>
            </div>
            <button class="btn btn-link p-1" id="sidebarClose" title="Fechar menu">
                <i class="fas fa-times text-secondary fs-5"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Controls -->
    <div class="sidebar-controls">
        <button class="expand-all-btn" id="expandAllBtn" title="Expandir todos os menus">
            <i class="fas fa-expand-arrows-alt"></i>
            <span class="btn-text">Expandir Todos</span>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="#" class="nav-link active" title="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <!-- Categoria: Clientes -->
        <div class="nav-category">
            <button class="nav-category-toggle active" data-target="clients-menu" title="Clientes">
                <div class="nav-category-header">
                    <i class="fas fa-users me-2"></i>
                    <span class="nav-text">Clientes</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu show" id="clients-menu">
                <div class="nav-item">
                    <a href="#" class="nav-link active" title="Gerenciar Clientes">
                        <i class="fas fa-address-book"></i>
                        <span class="nav-text">Gerenciar Clientes</span>
                        <span class="nav-badge-primary">12</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Novo Cliente">
                        <i class="fas fa-user-plus"></i>
                        <span class="nav-text">Novo Cliente</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categoria: Serviços -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="services-menu" title="Serviços">
                <div class="nav-category-header">
                    <i class="fas fa-cut me-2"></i>
                    <span class="nav-text">Serviços</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="services-menu">
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Gerenciar Serviços">
                        <i class="fas fa-scissors"></i>
                        <span class="nav-text">Gerenciar Serviços</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Agendamentos">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="nav-text">Agendamentos</span>
                        <span class="nav-badge-warning">5</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categoria: Produtos -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="products-menu" title="Produtos">
                <div class="nav-category-header">
                    <i class="fas fa-box me-2"></i>
                    <span class="nav-text">Produtos</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="products-menu">
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Estoque">
                        <i class="fas fa-boxes"></i>
                        <span class="nav-text">Estoque</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Vendas">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="nav-text">Vendas</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categoria: Financeiro -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="financial-menu" title="Financeiro">
                <div class="nav-category-header">
                    <i class="fas fa-dollar-sign me-2"></i>
                    <span class="nav-text">Financeiro</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="financial-menu">
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Caixa">
                        <i class="fas fa-cash-register"></i>
                        <span class="nav-text">Caixa</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" title="Relatórios">
                        <i class="fas fa-chart-line"></i>
                        <span class="nav-text">Relatórios</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Configurações -->
        <div class="nav-item">
            <a href="#" class="nav-link" title="Configurações">
                <i class="fas fa-cog"></i>
                <span class="nav-text">Configurações</span>
            </a>
        </div>

        <!-- Ajuda -->
        <div class="nav-item">
            <a href="#" class="nav-link" title="Ajuda">
                <i class="fas fa-question-circle"></i>
                <span class="nav-text">Ajuda</span>
            </a>
        </div>

        <!-- Sair -->
        <div class="nav-item">
            <a href="#" class="nav-link" title="Sair" onclick="logout()">
                <i class="fas fa-right-from-bracket"></i>
                <span class="nav-text">Sair</span>
            </a>
        </div>
    </nav>
</div>
