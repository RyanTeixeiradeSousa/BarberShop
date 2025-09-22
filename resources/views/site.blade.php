<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewTech - Inovação em Tecnologia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0D6EFD;
            --accent-green: #2DD9A0;
            --highlight-purple: #8C30FF;
            --text-dark: #333333;
            --bg-white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Exo 2', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(140, 48, 255, 0.3); }
            50% { box-shadow: 0 0 40px rgba(140, 48, 255, 0.6); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(13, 110, 253, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand,
        .hero h1,
        .section-title h2,
        .service-card h4,
        .footer-brand,
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Orbitron', monospace;
            font-weight: 700;
        }

        .navbar-brand {
            font-size: 1.8rem;
            color: var(--primary-blue) !important;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-blue) !important;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: var(--accent-green);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--bg-white) 0%, rgba(13, 110, 253, 0.05) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(140, 48, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            animation: slideInUp 1s ease-out;
        }

        .hero .subtitle {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 2rem;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .btn-primary-custom {
            background: var(--primary-blue);
            border: none;
            padding: 15px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom:hover {
            background: var(--accent-green);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(45, 217, 160, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--highlight-purple);
            color: var(--highlight-purple);
            padding: 13px 28px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-left: 15px;
        }

        .btn-secondary-custom:hover {
            background: var(--highlight-purple);
            color: white;
            transform: translateY(-3px);
            animation: glow 2s infinite;
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 4s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        /* Services Section */
        .services {
            padding: 100px 0;
            background: var(--bg-white);
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--text-dark);
            max-width: 600px;
            margin: 0 auto;
        }

        .service-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(13, 110, 253, 0.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(45, 217, 160, 0.1), transparent);
            transition: all 0.5s ease;
        }

        .service-card:hover::before {
            left: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-green), var(--primary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .service-card h4 {
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        /* About Section */
        .about {
            padding: 100px 0;
            background: linear-gradient(135deg, rgba(140, 48, 255, 0.05) 0%, var(--bg-white) 100%);
        }

        .stats {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--highlight-purple);
            display: block;
        }

        .stat-label {
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Contact Section */
        .contact {
            padding: 100px 0;
            background: var(--primary-blue);
            color: white;
            position: relative;
        }

        .contact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .contact-content {
            position: relative;
            z-index: 2;
        }

        .contact h2 {
            color: white;
            margin-bottom: 1rem;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            color: white;
            padding: 15px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.2rem rgba(45, 217, 160, 0.25);
            color: white;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-brand {
            font-size: 1.5rem;
            color: var(--accent-green);
            margin-bottom: 1rem;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-green);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero .subtitle {
                font-size: 1.1rem;
            }
            
            .btn-secondary-custom {
                margin-left: 0;
                margin-top: 15px;
                display: block;
                text-align: center;
            }
            
            .service-card {
                margin-bottom: 2rem;
            }
            
            .stats {
                margin-top: 2rem;
                padding: 2rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 2rem 0;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .contact-form {
                padding: 1.5rem;
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
     Navigation 
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <i class="fas fa-rocket me-2"></i>NewTech
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#solutions">Soluções</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

     Hero Section 
    <section id="home" class="hero">
        <div class="floating-element">
            <i class="fas fa-code" style="font-size: 3rem; color: var(--accent-green);"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-microchip" style="font-size: 2.5rem; color: var(--highlight-purple);"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-brain" style="font-size: 3.5rem; color: var(--primary-blue);"></i>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Inovação que <span style="color: var(--highlight-purple);">Transforma</span> o Futuro</h1>
                        <p class="subtitle">Na NewTech, criamos soluções tecnológicas revolucionárias que impulsionam seu negócio para o próximo nível. Experiência fresh, resultados extraordinários.</p>
                        <div class="hero-buttons">
                            <a href="#services" class="btn-primary-custom">
                                <i class="fas fa-rocket me-2"></i>Descobrir Soluções
                            </a>
                            <a href="#contact" class="btn-secondary-custom">
                                <i class="fas fa-comments me-2"></i>Falar Conosco
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="/placeholder.svg?height=500&width=600" alt="NewTech Innovation" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </section>

     Services Section 
    <section id="services" class="services">
        <div class="container">
            <div class="section-title fade-in">
                <h2>Nossos Serviços</h2>
                <p>Oferecemos soluções completas e inovadoras para transformar sua visão em realidade digital</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4>Desenvolvimento Web</h4>
                        <p>Websites e aplicações web modernas, responsivas e otimizadas para performance excepcional.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Desenvolvimento Mobile</h4>
                        <p>Apps nativos e híbridos com performance excepcional e UX inovadora para iOS e Android.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Data Analytics</h4>
                        <p>Transforme seus dados em insights estratégicos com análises avançadas e visualizações intuitivas.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>Desenvolvimento de Sites</h4>
                        <p>Sites institucionais, e-commerce e portais personalizados com design moderno e funcionalidades avançadas.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h4>Automação de Processos</h4>
                        <p>Otimize suas operações com soluções inteligentes de automação que aumentam eficiência e reduzem custos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

     Solutions Section 
    <section id="solutions" class="services" style="background: linear-gradient(135deg, rgba(140, 48, 255, 0.05) 0%, var(--bg-white) 100%);">
        <div class="container">
            <div class="section-title fade-in">
                <h2>Nossas Soluções</h2>
                <p>Projetos desenvolvidos com tecnologia de ponta para diferentes segmentos</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 mb-4">
                    <div class="service-card fade-in" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, var(--bg-white) 100%);">
                        <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-blue), var(--accent-green));">
                            <i class="fas fa-plane"></i>
                        </div>
                        <h4>Site para Venda de Turismo</h4>
                        <p>Plataforma completa para agências de turismo com sistema de reservas, pagamentos online, catálogo de destinos e gestão de clientes. Interface intuitiva e responsiva para maximizar conversões.</p>
                        <div class="mt-3">
                            <span class="badge" style="background: var(--accent-green); color: white; margin-right: 10px;">E-commerce</span>
                            <span class="badge" style="background: var(--highlight-purple); color: white;">Turismo</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-8 mb-4">
                    <div class="service-card fade-in" style="background: linear-gradient(135deg, rgba(45, 217, 160, 0.05) 0%, var(--bg-white) 100%);">
                        <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-green), var(--highlight-purple));">
                            <i class="fas fa-cut"></i>
                        </div>
                        <h4>Sistema de Gestão para Barbearia</h4>
                        <p>Sistema completo de agendamento e gestão para barbearias com controle de horários, clientes, serviços, relatórios financeiros e notificações automáticas via WhatsApp.</p>
                        <div class="mt-3">
                            <span class="badge" style="background: var(--primary-blue); color: white; margin-right: 10px;">Gestão</span>
                            <span class="badge" style="background: var(--highlight-purple); color: white;">Agendamento</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     About Section 
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="fade-in">
                        <h2 style="color: var(--primary-blue); font-size: 2.5rem; margin-bottom: 1.5rem;">
                            Pioneiros em <span style="color: var(--highlight-purple);">Inovação</span>
                        </h2>
                        <p style="font-size: 1.1rem; margin-bottom: 1.5rem;">
                            A NewTech nasceu da paixão por transformar ideias em soluções tecnológicas revolucionárias. 
                            Nossa equipe de especialistas combina criatividade, expertise técnica e visão estratégica 
                            para entregar resultados que superam expectativas.
                        </p>
                        <p style="font-size: 1.1rem; margin-bottom: 1.5rem;">
                            <strong style="color: var(--primary-blue);">Experiência Especializada:</strong> 
                            Temos forte atuação na área educacional e especialização em aplicar tecnologia 
                            para pequenos negócios, desenvolvendo soluções acessíveis e eficientes que 
                            impulsionam o crescimento. Nossa expertise se estende também para outros segmentos 
                            como saúde, varejo, turismo e serviços.
                        </p>
                        <p style="font-size: 1.1rem; margin-bottom: 2rem;">
                            Acreditamos que a tecnologia deve ser uma extensão natural dos seus objetivos de negócio, 
                            criando experiências únicas e impactantes para seus usuários.
                        </p>
                        <a href="#contact" class="btn-primary-custom">
                            <i class="fas fa-arrow-right me-2"></i>Vamos Conversar
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="/placeholder.svg?height=400&width=500" alt="NewTech Team" class="img-fluid" style="border-radius: 20px;">
                    </div>
                </div>
            </div>
            
            <div class="stats fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <span class="stat-number">150+</span>
                            <span class="stat-label">Projetos Entregues</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <span class="stat-number">98%</span>
                            <span class="stat-label">Satisfação do Cliente</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Anos de Experiência</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Suporte Técnico</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     Contact Section 
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="fade-in">
                            <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">
                                Pronto para <span style="color: var(--accent-green);">Inovar</span>?
                            </h2>
                            <p style="font-size: 1.1rem; margin-bottom: 2rem;">
                                Vamos transformar sua ideia em realidade. Entre em contato conosco e descubra 
                                como podemos impulsionar seu negócio para o futuro.
                            </p>
                            
                            <div class="contact-info">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-envelope me-3" style="color: var(--accent-green); font-size: 1.2rem;"></i>
                                    <span>contato@newtech.com.br</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-phone me-3" style="color: var(--accent-green); font-size: 1.2rem;"></i>
                                    <span>+55 (11) 9999-9999</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-map-marker-alt me-3" style="color: var(--accent-green); font-size: 1.2rem;"></i>
                                    <span>São Paulo, SP - Brasil</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="contact-form fade-in">
                            <form>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Seu Nome" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Seu E-mail" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control" placeholder="Seu Telefone">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="5" placeholder="Conte-nos sobre seu projeto..." required></textarea>
                                </div>
                                <button type="submit" class="btn-primary-custom w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     Footer 
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <i class="fas fa-rocket me-2"></i>NewTech
                    </div>
                    <p>Transformando o futuro através da inovação tecnológica. Sua parceira ideal para soluções digitais revolucionárias.</p>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 style="color: var(--accent-green); margin-bottom: 1rem;">Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" style="color: white; text-decoration: none;">Início</a></li>
                        <li><a href="#services" style="color: white; text-decoration: none;">Serviços</a></li>
                        <li><a href="#solutions" style="color: white; text-decoration: none;">Soluções</a></li>
                        <li><a href="#about" style="color: white; text-decoration: none;">Sobre</a></li>
                        <li><a href="#contact" style="color: white; text-decoration: none;">Contato</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 style="color: var(--accent-green); margin-bottom: 1rem;">Redes Sociais</h5>
                    <div class="social-links">
                        @if(!empty($configuracoes['linkedin_link']) ?? false)
                         <a href="#"><i class="fab fa-linkedin"></i></a>
                        @endif
                        @if (!empty($configuracoes['instagram_link']) ?? false)
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if (!empty($configuracoes['facebook_link']) ?? false)
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        @endif
                        @if (!empty($configuracoes['twitter_link']) ?? false)
                            <a href="#"><i class="fab fa-twitter"></i></a>  
                        @endif
                    </div>
                </div>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0 1rem;">
            
            <div class="text-center">
                <p>&copy; 2024 NewTech. Todos os direitos reservados. Feito com <i class="fas fa-heart" style="color: var(--accent-green);"></i> para o futuro.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
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

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });

        // Fade in animation on scroll
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

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Obrigado pelo contato! Retornaremos em breve.');
            this.reset();
        });

        // Add some interactive hover effects
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
