@extends('site.layout')

@section('title', $configuracoes['site_nome'] ?? 'BarberShop Premium')
@section('description', 'A melhor barbearia da cidade. Agende seu horário e tenha uma experiência premium.')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        height: 100vh;
        /* Modificando para usar base64 das configurações como background principal */
        background: linear-gradient(rgba(26,26,26,0.7), rgba(26,26,26,0.7)), 
                    url('/placeholder.svg?height=800&width=1200');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--text-light);
        position: relative;
    }

    @if(!empty($configuracoes['site_foto_principal']))
    .hero {
        background: linear-gradient(rgba(26,26,26,0.7), rgba(26,26,26,0.7)), 
                    url('data:image/jpeg;base64,{{ $configuracoes['site_foto_principal'] }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    @endif

    .hero-content {
        max-width: 800px;
        padding: 0 1rem;
        z-index: 2;
        position: relative;
    }

    .hero h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        background: linear-gradient(45deg, #fff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero p {
        font-size: clamp(1.1rem, 2vw, 1.3rem);
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Services Section */
    .services {
        background: var(--bg-light);
        position: relative;
    }

    .services h2 {
        font-size: 2.5rem;
        margin-bottom: 3rem;
        color: var(--primary-color);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .service-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 4px solid var(--secondary-color);
        position: relative;
    }

    /* Simplificando hover effects para melhor performance */
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .service-icon {
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
        transition: color 0.3s ease;
    }

    .service-card:hover .service-icon {
        color: var(--primary-color);
    }

    .service-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .service-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-top: 1rem;
    }

    /* About Section */
    .about {
        padding: 6rem 0;
        position: relative;
    }

    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .about-text h2 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: var(--primary-color);
    }

    .about-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .about-image {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: transform 0.3s ease;
    }

    .about-image:hover {
        transform: scale(1.02);
    }

    .about-image img {
        width: 100%;
        /* Aumentando altura da imagem de 400px para 500px */
        height: 500px;
        object-fit: cover;
    }

    /* CTA Section */
    .cta {
        background: linear-gradient(135deg, var(--primary-color) 0%, rgba(26,26,26,0.9) 100%);
        color: var(--text-light);
        text-align: center;
        padding: 6rem 0;
        position: relative;
    }

    .cta h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .cta p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    /* Simplificando estatísticas sem animações pesadas */
    .stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin: 3rem 0;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        color: var(--text-light);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        opacity: 0.8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }

        .about-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .services-grid {
            grid-template-columns: 1fr;
        }

        .stats {
            gap: 2rem;
        }
    }

    /* Mantendo apenas animações leves e essenciais */
    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }

    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Simplificando efeitos de botão */
    .btn {
        position: relative;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // Mostrando valores estáticos
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const target = stat.dataset.target;
        stat.textContent = target + '+';
    });
});
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>{{ $configuracoes['site_nome'] ?? 'BarberShop Premium' }}</h1>
        <p>Experimente o melhor em cortes masculinos e cuidados com a barba. Tradição e modernidade em um só lugar.</p>
        <div class="hero-buttons">
            <a href="{{ route('site.agendamento') }}" class="btn btn-primary">
                <i class="fas fa-calendar-alt"></i> Agendar Horário
            </a>
            <a href="#servicos" class="btn btn-outline">
                <i class="fas fa-cut"></i> Ver Serviços
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services section" id="servicos">
    <div class="container">
        <h2 class="text-center fade-in-up">Nossos Serviços</h2>
        <div class="services-grid">
            @forelse($servicos as $servico)
                <div class="service-card fade-in-up">
                    <div class="service-icon">
                        @switch($servico->nome)
                            @case('Corte de Cabelo')
                            @case('Corte Masculino')
                                <i class="fas fa-cut"></i>
                                @break
                            @case('Barba')
                            @case('Aparar Barba')
                                <i class="fas fa-user-tie"></i>
                                @break
                            @case('Bigode')
                                <i class="fas fa-mustache"></i>
                                @break
                            @default
                                <i class="fas fa-scissors"></i>
                        @endswitch
                    </div>
                    <h3>{{ $servico->nome }}</h3>
                    <p>{{ $servico->descricao ?: 'Serviço profissional de alta qualidade' }}</p>
                    <div class="service-price">R$ {{ number_format($servico->preco, 2, ',', '.') }}</div>
                </div>
            @empty
                <div class="service-card fade-in-up">
                    <div class="service-icon"><i class="fas fa-cut"></i></div>
                    <h3>Corte Masculino</h3>
                    <p>Corte profissional personalizado</p>
                    <div class="service-price">R$ 25,00</div>
                </div>
                <div class="service-card fade-in-up">
                    <div class="service-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>Barba</h3>
                    <p>Aparar e modelar barba</p>
                    <div class="service-price">R$ 15,00</div>
                </div>
                <div class="service-card fade-in-up">
                    <div class="service-icon"><i class="fas fa-scissors"></i></div>
                    <h3>Corte + Barba</h3>
                    <p>Pacote completo</p>
                    <div class="service-price">R$ 35,00</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about section" id="sobre">
    <div class="container">
        <div class="about-content">
            <div class="about-text fade-in-up">
                <h2>Nossa História</h2>
                <p>{{ $configuracoes['site_historia'] ?? 'Há mais de 20 anos oferecendo os melhores serviços de barbearia da cidade.' }}</p>
                <p>Nossa equipe é formada por profissionais experientes e apaixonados pela arte da barbearia, sempre atualizados com as últimas tendências e técnicas do mercado.</p>
                
                <!-- Estatísticas estáticas para melhor performance -->
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number" data-target="500">500+</span>
                        <span class="stat-label">Clientes Satisfeitos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="20">20+</span>
                        <span class="stat-label">Anos de Experiência</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="15">15+</span>
                        <span class="stat-label">Serviços Oferecidos</span>
                    </div>
                </div>
                
                <a href="{{ route('site.agendamento') }}" class="btn btn-primary mt-4">
                    Agende Agora
                </a>
            </div>
            <div class="about-image fade-in-up">
                @if(!empty($configuracoes['site_foto_principal']))
                    <img src="data:image/jpeg;base64,{{ $configuracoes['site_foto_principal'] }}" alt="Nossa Barbearia">
                @else
                    <img src="/placeholder.svg?height=500&width=600" alt="Nossa Barbearia">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta" id="contato">
    <div class="container">
        <h2 class="fade-in-up">Pronto para uma Nova Experiência?</h2>
        <p class="fade-in-up">Agende seu horário e venha conhecer o melhor da barbearia tradicional</p>
        <a href="{{ route('site.agendamento') }}" class="btn btn-primary fade-in-up">
            <i class="fas fa-calendar-check"></i> Agendar Agora
        </a>
    </div>
</section>
@endsection
