
<div class="sidebar" id="sidebar">
    <!-- Botão de fechar para mobile -->
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

    <!-- Controles da Sidebar -->
    <div class="sidebar-controls">
        <button class="expand-all-btn" id="expandAllBtn" title="Expandir todos os menus">
            <i class="fas fa-expand-arrows-alt"></i>
            <span class="btn-text">Expandir Todos</span>
        </button>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link" title="Dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <!-- Categoria: Clientes -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="clients-menu" title="Clientes">
                <div class="nav-category-header">
                    <i class="fas fa-users me-2"></i>
                    <span class="nav-text">Clientes</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="clients-menu">
                <div class="nav-item">
                    <a href="{{route('clientes.index')}}" class="nav-link " title="Gerenciar Clientes">
                        <i class="fas fa-user-friends"></i>
                        <span class="nav-text">Gerenciar Clientes</span>
                    </a>
                </div>
                {{-- <div class="nav-item">
                    <a href="#" class="nav-link" title="Histórico de Atendimentos">
                        <i class="fas fa-history"></i>
                        <span class="nav-text">Histórico</span>
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- Categoria: Serviços -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="services-menu" title="Serviços">
                <div class="nav-category-header">
                    <i class="fas fa-cut me-2"></i>
                    <span class="nav-text">Produtos/Serviços</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="services-menu">
                <div class="nav-item">
                    <a href="{{route('categorias.index')}}" class="nav-link " title="Categorias">
                        <i class="fas fa-layer-group"></i>
                        <span class="nav-text">Categorias</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{route('produtos.index')}}" class="nav-link " title="Gerenciar Produtos/Serviços">
                        <i class="fas fa-cart-shopping"></i>
                        <span class="nav-text">Gerenciar Produtos/Serviços</span>
                    </a>
                </div>
                {{-- <div class="nav-item">
                    <a href="#" class="nav-link" title="Tratamentos">
                        <i class="fas fa-spa"></i>
                        <span class="nav-text">Tratamentos</span>
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- Categoria: Financeiro -->
        <div class="nav-category">
            <button class="nav-category-toggle" data-target="financial-menu" title="Financeiro">
                <div class="nav-category-header">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>
                    <span class="nav-text ml-2">Financeiro</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="financial-menu">
                <div class="nav-item">
                    <a href="{{route('categorias-financeiras.index')}}" class="nav-link " title="Categorias">
                        <i class="fas fa-tags"></i>
                        <span class="nav-text">Categorias</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{route('formas-pagamento.index')}}" class="nav-link " title="Formas de Pagamento">
                        <i class="fas fa-wallet"></i>
                        <span class="nav-text">Formas de Pagamento</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{route('financeiro.index')}}" class="nav-link " title="Movimentações Financeiras">
                        <i class="fas fa-arrows-rotate"></i>
                        <span class="nav-text">Movimentações Financeiras</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Agendamentos -->
        <div class="nav-item">
            <a href="{{route('agendamentos.index')}}" class="nav-link " title="Agendamentos">
                <i class="fas fa-calendar-alt"></i>
                <span class="nav-text">Agendamentos</span>
                <span class="nav-badge-primary">5</span>
            </a>
        </div>

        <div class="nav-category">
            <button class="nav-category-toggle" data-target="security-menu" title="Segurança">
                <div class="nav-category-header">
                    <i class="fas fa-shield me-2"></i>
                    <span class="nav-text ml-2">Segurança</span>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="nav-submenu" id="security-menu">
                <div class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link " title="Usuários">
                        <i class="fas fa-user-shield"></i>
                        <span class="nav-text">Usuários</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="nav-item">
            <a href="{{route('perfilindex')}}" class="nav-link" title="Configurações">
                <i class="fas fa-address-card"></i>
                <span class="nav-text">Meu perfil</span>
            </a>
        </div>

        <!-- Configurações -->
        <div class="nav-item">
            <a href="{{route('configuracoes.index')}}" class="nav-link" title="Configurações">
                <i class="fas fa-cog"></i>
                <span class="nav-text">Configurações</span>
            </a>
        </div>

        <!-- Sair -->
        <div class="nav-item">
            <a href="{{route('logout')}}" class="nav-link" title="Sair">
                <i class="fas fa-right-from-bracket"></i>
                <span class="nav-text">Sair</span>
            </a>
        </div>
    </nav>
</div>
