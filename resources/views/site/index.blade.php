@extends('site.layout')

@section('title', $configuracoes['site_nome'] ?? 'BarberShop Premium')
@section('description', 'A melhor barbearia da cidade. Agende seu horário e tenha uma experiência premium.')

@push('styles')
<style>
    /* Criando nova estrutura com seções específicas: serviços, produtos, história, sobre e contatos */
    :root {
        --primary: {{ $configuracoes['site_cor_primaria'] ?? '#15803d' }};
        --secondary: {{ $configuracoes['site_cor_secundaria'] ?? '#16a34a' }};
        --accent: #22c55e;
        --background: #ffffff;
        --foreground: #0f172a;
        --muted: #f8fafc;
        --muted-foreground: #64748b;
        --card: #ffffff;
        --card-foreground: #0f172a;
        --border: #e2e8f0;
        --primary-foreground: #ffffff;
    }

    /* Hero Section */
    .hero {
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(21, 128, 61, 0.9) 0%, rgba(0, 0, 0, 0.7) 100%);
        @if(!empty($configuracoes['site_foto_principal']))
            background-image: linear-gradient(135deg, rgba(218,228,233, 0.9) 0%, rgba(0, 0, 0, 0.7) 100%), 
                              url('{{ $configuracoes['site_foto_principal'] }}');
        @else
            background-image: linear-gradient(135deg, rgba(218,228,233, 0.9) 0%, rgba(0, 0, 0, 0.7) 100%), 
                              url('/placeholder.svg?height=1080&width=1920');
        @endif
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
    }

    .hero-content h1 {
        font-size: clamp(3rem, 8vw, 6rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .hero-subtitle {
        font-size: clamp(1.2rem, 3vw, 1.8rem);
        margin-bottom: 3rem;
        opacity: 0.95;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 2.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        border: 2px solid transparent;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 10px 25px rgba(218,228,233, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(218,228,233, 0.4);
    }

    .btn-outline {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-outline:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }

    /* Section Styles */
    .section {
        padding: 6rem 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.3rem;
        color: var(--muted-foreground);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Seção de Serviços */
    .services {
        background: linear-gradient(180deg, var(--background) 0%, var(--muted) 100%);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .service-card {
        background: var(--card);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .service-image {
        height: 250px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .service-icon {
        font-size: 3rem;
        color: white;
    }

    .service-content {
        padding: 2rem;
        text-align: center;
    }

    .service-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--card-foreground);
    }

    .service-description {
        color: var(--muted-foreground);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .service-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    /* Seção de Produtos */
    .products {
        background: var(--background);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: var(--card);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .product-image {
        height: 200px;
        background: linear-gradient(45deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-content {
        padding: 1.5rem;
    }

    .product-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--card-foreground);
    }

    .product-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
    }

    /* Seção História */
    .history {
        background: linear-gradient(135deg, var(--muted) 0%, var(--background) 100%);
    }

    .history-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .history-text h2 {
        font-size: clamp(2.5rem, 4vw, 3.5rem);
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 2rem;
    }

    .history-text p {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--foreground);
        margin-bottom: 2rem;
    }

    .history-image {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .history-image img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    /* Seção Sobre */
    .about {
        background: var(--background);
    }

    .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
    }

    .about-card {
        background: var(--card);
        padding: 3rem 2rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .about-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .about-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .about-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--card-foreground);
    }

    .about-card p {
        color: var(--muted-foreground);
        line-height: 1.6;
    }

    /* Seção Contatos */
    .contact {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        text-align: center;
    }

    .contact .section-title,
    .contact .section-subtitle {
        color: white;
    }

    .contact-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }

    .contact-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .contact-icon {
        font-size: 2.5rem;
        opacity: 0.9;
    }

    .contact-text {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .history-content,
        .about-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .services-grid,
        .products-grid {
            grid-template-columns: 1fr;
        }

        .contact-info {
            grid-template-columns: 1fr;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
        }
    }

    /* Animações */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero" id="inicio">
    <div class="hero-content">
        <h1>{{ $configuracoes['site_nome'] ?? 'BarberShop Premium' }}</h1>
        <p class="hero-subtitle">
            {{ $configuracoes['site_slogan'] ?? 'Tradição, qualidade e estilo em cada corte. Experimente o melhor da barbearia moderna com profissionais especializados.' }}
        </p>
        <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
            <a href="{{ route('site.agendamento') }}" class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i>
                Agendar Horário
            </a>
            <a href="#servicos" class="btn btn-outline">
                <i class="fas fa-cut"></i>
                Nossos Serviços
            </a>
        </div>
    </div>
</section>

<!-- Seção de Serviços -->
<section class="section services" id="servicos">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title">Nossos Serviços</h2>
            <p class="section-subtitle">
                Oferecemos uma gama completa de serviços profissionais para cuidar do seu visual com excelência
            </p>
        </div>

        <div class="services-grid">
            @if($servicos->count() > 0)
                @foreach($servicos as $servico)
                    <div class="service-card fade-in">
                        <div class="service-image">
                            @if($servico->imagem)
                                <img src="{{ $servico->imagem }}" alt="{{ $servico->nome }}">
                            @else
                                <div class="service-icon">
                                    @switch(strtolower($servico->nome))
                                        @case('corte de cabelo')
                                        @case('corte masculino')
                                        @case('corte')
                                            <i class="fas fa-cut"></i>
                                            @break
                                        @case('barba')
                                        @case('aparar barba')
                                            <i class="fas fa-user-tie"></i>
                                            @break
                                        @case('bigode')
                                            <i class="fas fa-mustache"></i>
                                            @break
                                        @case('sobrancelha')
                                            <i class="fas fa-eye"></i>
                                            @break
                                        @default
                                            <i class="fas fa-scissors"></i>
                                    @endswitch
                                </div>
                            @endif
                        </div>
                        <div class="service-content">
                            <h3 class="service-title">{{ $servico->nome }}</h3>
                            <p class="service-description">
                                {{ $servico->descricao ?: 'Serviço profissional de alta qualidade executado por nossos especialistas' }}
                            </p>
                            <div class="service-price">
                                <i class="fas fa-tag"></i>
                                R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Seção de Produtos -->

@if($produtos->count() > 0)
    <section class="section products" id="produtos">
        <div class="container">
            <div class="section-header fade-in">
                <h2 class="section-title">Nossos Produtos</h2>
                <p class="section-subtitle">
                    Produtos de qualidade premium para manter seu visual impecável em casa
                </p>
            </div>
    
            <div class="products-grid">
            @foreach($produtos->where('tipo', 'produto')->take(6) as $produto)
                <div class="product-card fade-in">
                    <div class="product-image">
                        @if($produto->imagem)
                            <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}">
                        @else
                            <i class="fas fa-box" style="font-size: 3rem; color: var(--muted-foreground);"></i>
                        @endif
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">{{ $produto->nome }}</h3>
                        <div class="product-price">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
@endif
       

<!-- Seção História -->
<section class="section history" id="historia">
    <div class="container">
        <div class="history-content">
            <div class="history-text fade-in">
                <h2>Nossa História</h2>
                <p>
                    {{ $configuracoes['site_historia'] ?? 'Há mais de duas décadas, nossa barbearia tem sido sinônimo de qualidade e tradição. Começamos como um pequeno negócio familiar e crescemos para nos tornar referência na cidade.' }}
                </p>
                <p>
                    Ao longo dos anos, mantivemos nosso compromisso com a excelência, combinando técnicas tradicionais com as mais modernas tendências do mercado. Cada cliente que passa por aqui recebe um atendimento personalizado e de qualidade superior.
                </p>
                <a href="{{ route('site.agendamento') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i>
                    Faça Parte da Nossa História
                </a>
            </div>
            <div class="history-image fade-in">
                @if(!empty($configuracoes['site_foto_historia']))
                    <img src="{{ $configuracoes['site_foto_historia'] }}" alt="Nossa História">
                @elseif(!empty($configuracoes['site_foto_principal']))
                    <img src="{{ $configuracoes['site_foto_principal'] }}" alt="Nossa História">
                @else
                    <img src="/placeholder.svg?height=500&width=600" alt="Nossa História">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Seção Sobre -->
<section class="section about" id="sobre">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title">Por Que Nos Escolher?</h2>
            <p class="section-subtitle">
                Conheça os diferenciais que fazem da nossa barbearia a melhor escolha para o seu visual
            </p>
        </div>

        <div class="about-grid">
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Profissionais Qualificados</h3>
                <p>Nossa equipe é formada por barbeiros experientes e certificados, sempre atualizados com as últimas técnicas e tendências do mercado.</p>
            </div>
            
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Horários Flexíveis</h3>
                <p>Funcionamos em horários convenientes para você, incluindo finais de semana, para que nunca falte tempo para cuidar do seu visual.</p>
            </div>
            
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Higiene e Segurança</h3>
                <p>Seguimos rigorosamente todos os protocolos de higiene e segurança, garantindo um ambiente limpo e seguro para todos os clientes.</p>
            </div>
            
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Atendimento Premium</h3>
                <p>Cada cliente recebe um atendimento personalizado e exclusivo, com foco total na sua satisfação e bem-estar.</p>
            </div>
            
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Equipamentos Modernos</h3>
                <p>Utilizamos apenas equipamentos de última geração e produtos de alta qualidade para garantir os melhores resultados.</p>
            </div>
            
            <div class="about-card fade-in">
                <div class="about-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Tradição e Confiança</h3>
                <p>Mais de 20 anos de tradição e milhares de clientes satisfeitos comprovam nossa dedicação e qualidade no atendimento.</p>
            </div>
        </div>
    </div>
</section>

<!-- Seção Contatos -->
<section class="section contact" id="contato">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title">Entre em Contato</h2>
            <p class="section-subtitle">
                Estamos prontos para atendê-lo. Agende seu horário ou tire suas dúvidas conosco
            </p>
        </div>

        <div class="contact-info">
            <div class="contact-item fade-in">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-text">
                    {{ $configuracoes['site_telefone'] ?? '(11) 99999-9999' }}
                </div>
            </div>
            
            <div class="contact-item fade-in">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                    {{ $configuracoes['site_email'] ?? 'contato@barbershop.com' }}
                </div>
            </div>
            
            <div class="contact-item fade-in">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                    {{ $configuracoes['site_endereco'] ?? 'Rua da Barbearia, 123 - Centro' }}
                </div>
            </div>
            
            <div class="contact-item fade-in">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="contact-text">
                    {{ $configuracoes['site_horario'] ?? 'Seg-Sex: 8h-18h | Sáb: 8h-16h' }}
                </div>
            </div>
        </div>

        <div style="margin-top: 3rem;" class="fade-in">
            <a href="{{ route('site.agendamento') }}" class="btn btn-primary" style="background: white; color: var(--primary); font-size: 1.2rem; padding: 1.5rem 3rem;">
                <i class="fas fa-calendar-plus"></i>
                Agendar Agora Mesmo
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animações de entrada
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

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush
