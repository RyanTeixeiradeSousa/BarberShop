<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $configuracoes['site_nome'] ?? 'BarberShop')</title>
    <meta name="description" content="@yield('description', 'Agende seu horário na melhor barbearia da cidade')">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $configuracoes['site_cor_primaria'] ?? '#1a1a1a' }};
            --secondary-color: {{ $configuracoes['site_cor_secundaria'] ?? '#d4af37' }};
            --text-light: #ffffff;
            --text-dark: #333333;
            --bg-light: #f8f9fa;
            --shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, rgba(26,26,26,0.9) 100%);
            color: var(--text-light);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .header.scrolled {
            backdrop-filter: blur(20px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--text-light);
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--secondary-color);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Footer */
        .footer {
            background: var(--primary-color);
            color: var(--text-light);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .footer-section p,
        .footer-section a {
            color: var(--text-light);
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--secondary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: var(--primary-color);
                flex-direction: column;
                justify-content: flex-start;
                padding-top: 2rem;
                transition: left 0.3s ease;
            }

            .nav-menu.active {
                left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Utility Classes */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #b8941f 100%);
            color: var(--primary-color);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--secondary-color);
            border: 2px solid var(--secondary-color);
        }

        .btn-outline:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .section {
            padding: 4rem 0;
        }

        .text-center {
            text-align: center;
        }

        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 2rem; }
        .mt-4 { margin-top: 2rem; }
    </style>

    @stack('styles')
</head>
<body>
    <header class="header" id="header">
        <div class="nav-container">
            <a href="{{ route('site.home') }}" class="logo">
                @if(!empty($configuracoes['site_logomarca']))
                    <img src="data:image/jpeg;base64,{{ $configuracoes['site_logomarca'] }}" alt="Logo" class="logo-img">
                @else
                    <i class="fas fa-cut"></i>
                @endif
                {{ $configuracoes['site_nome'] ?? 'BarberShop' }}
            </a>

            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('site.home') }}" class="nav-link">Início</a>
                <a href="#sobre" class="nav-link">Sobre</a>
                <a href="#servicos" class="nav-link">Serviços</a>
                <a href="#produtos" class="nav-link">Produtos</a>
                <a href="{{ route('site.agendamento') }}" class="nav-link">Agendamento</a>
                <a href="#contato" class="nav-link">Contato</a>
            </nav>

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>{{ $configuracoes['site_nome'] ?? 'BarberShop' }}</h3>
                <p>{{ $configuracoes['site_historia'] ?? 'A melhor barbearia da cidade' }}</p>
            </div>
            
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="fas fa-map-marker-alt"></i> {{ $configuracoes['site_endereco'] ?? 'Endereço não informado' }}</p>
                <p><i class="fas fa-phone"></i> {{ $configuracoes['site_telefone'] ?? 'Telefone não informado' }}</p>
                <p><i class="fas fa-clock"></i> {{ $configuracoes['site_horario_funcionamento'] ?? 'Horário não informado' }}</p>
            </div>
            
            <div class="footer-section">
                <h3>Redes Sociais</h3>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="#"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $configuracoes['site_nome'] ?? 'BarberShop' }}. Todos os direitos reservados.</p>
            @if(!empty($configuracoes['site_cnpj']))
                <p>CNPJ: {{ $configuracoes['site_cnpj'] }}</p>
            @endif
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');

        mobileMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = mobileMenuBtn.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
