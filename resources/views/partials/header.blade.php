<!-- Header -->
<div class="header">
    <div class="header-content">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Logo adaptado para barbearia -->
            <div class="header-logo">
                <a href="#" class="logo-link">
                    <i class="fas fa-cut me-2"></i>
                    <span class="logo-text">BarberShop Pro</span>
                </a>
            </div>
            
            <div class="page-info ms-4">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <p class="page-subtitle">@yield('page-subtitle', 'Sistema de Gerenciamento')</p>
            </div>
        </div>
        
        <div class="header-right">
            <!-- Adicionando toggle de modo dark -->
            <div class="dark-mode-toggle d-none">
                <input type="checkbox" id="darkModeToggle" class="dark-mode-checkbox">
                <label for="darkModeToggle" class="dark-mode-label">
                    <i class="fas fa-moon dark-icon"></i>
                    <i class="fas fa-sun light-icon"></i>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <!-- Sistema de Notificações -->
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
            
            <!-- Perfil adaptado para barbeiro/admin -->
            <div class="user-profile" onclick="logout()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'AB', 0, 2)) }}</div>
                <div class="user-info">
                    <h6>{{ auth()->user()->name ?? 'Admin Barbeiro' }}</h6>
                    <p>Administrador</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript para o Sistema de Notificações -->
