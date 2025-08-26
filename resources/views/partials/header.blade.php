<!-- Header -->
<div class="header">
    <div class="header-content">
        <div class="header-left">
            <!-- Adicionando botão de colapso da sidebar para desktop -->
            <button class="sidebar-collapse-toggle" id="sidebarCollapseToggle" style="display: none;">
                <i class="fas fa-angles-left"></i>
            </button>
            
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Logo movido para o header -->
            <div class="header-logo">
                <a href="#" class="logo-link">
                    <!-- Mantendo ícone e texto para barbearia -->
                    <i class="fas fa-cut me-2"></i>
                    <span class="logo-text">BarberShop Pro</span>
                </a>
            </div>
            
            <div class="page-info ms-4">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <p class="page-subtitle">@yield('page-subtitle', 'Sistema de Gerenciamento de Barbearia')</p>
            </div>
        </div>
        
        <div class="header-right">
            <!-- Sistema de Notificações adaptado para barbearia -->
            <div class="notifications-container">
                <button class="header-notifications" id="notificationsBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationCount">3</span>
                </button>
                
                <!-- Dropdown de Notificações -->
                <div class="notifications-dropdown" id="notificationsDropdown">
                    <div class="notifications-header">
                        <h6 class="mb-0">
                            <i class="fas fa-bell me-2"></i>
                            Notificações
                        </h6>
                        <button class="btn btn-sm btn-outline-primary" id="markAllReadBtn">
                            <i class="fas fa-check-double me-1"></i>
                            Marcar todas como lidas
                        </button>
                    </div>
                    
                    <div class="notifications-list" id="notificationsList">
                        <!-- Notificações serão inseridas aqui via JavaScript -->
                    </div>
                    
                    <div class="notifications-footer">
                        <a href="#" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-eye me-2"></i>
                            Ver todas as notificações
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="user-profile" onclick="logout()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'MS', 0, 2)) }}</div>
                <div class="user-info">
                    <h6>{{ auth()->user()->name ?? 'Maria Silva' }}</h6>
                    <p>{{ auth()->user()->tipo_usuario ?? 'Administrador' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
