<!-- Header -->

<div class="header">
    <button id="btnSom" class="d-none">Tocar som</button>

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
            <div class="user-profile">
                @php
                    $nome = auth()->user()->nome ?? 'AB';
                    $partes = explode(' ', $nome);
                    $iniciais = strtoupper(
                        ($partes[0][0] ?? '') . ($partes[count($partes)-1][0] ?? '')
                    );
                    $primeiroUltimo = $partes[0] . (count($partes) > 1 ? ' ' . $partes[count($partes)-1] : '');

                @endphp
                <div class="user-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa) !important;">{{$iniciais}}</div>
                <div class="user-info">
                    <h6>{{ $primeiroUltimo }}</h6>
                    <a style="font-size: 12px;" class="perfil-link" href="{{route('categorias.index')}}">Meu perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    const audio = new Audio("{{asset('sounds/notification.mp3')}}");
    audio.play();
</script> --}}
@if (session()->has('type') && session()->has('message'))
    <script>
        const type = @json(session('type'));
        const message = @json(session('message'));
        const toastColors = {
            success: { background: "#10b981", icon: "check-circle" },  // verde
            error: { background: "#ef4444", icon: "times-circle" },    // vermelho
            warning: { background: "#f59e0b", icon: "exclamation-triangle" }, // amarelo
            info: { background: "#3b82f6", icon: "info-circle" }       // azul
        };
        function showToast(message, type) {
            const { background, icon } = toastColors[type] || toastColors.info;

            // Criar toast simples sem Bootstrap
            const toastHtml = `
                <div class="custom-toast toast-${type}" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${background};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 9999;
                    font-size: 0.9rem;
                    max-width: 300px;
                    opacity: 0;
                    transform: translateX(100%);
                    transition: all 0.3s ease;
                ">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-${icon}"></i>
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" style="
                            background: none;
                            border: none;
                            color: white;
                            margin-left: auto;
                            cursor: pointer;
                            padding: 0;
                            font-size: 1.2rem;
                        ">×</button>
                    </div>
                </div>
            `;


            document.body.insertAdjacentHTML("beforeend", toastHtml)
            const toastElement = document.body.lastElementChild

            // Animar entrada
            setTimeout(() => {
            toastElement.style.opacity = "1"
            toastElement.style.transform = "translateX(0)"
            }, 100)

            // Remover automaticamente após 3 segundos
            setTimeout(() => {
            if (toastElement && toastElement.parentElement) {
                toastElement.style.opacity = "0"
                toastElement.style.transform = "translateX(100%)"
                setTimeout(() => {
                if (toastElement && toastElement.parentElement) {
                    toastElement.remove()
                }
                }, 300)
            }
            }, 3000)
        }
        showToast(message, type)
    </script>
@endif