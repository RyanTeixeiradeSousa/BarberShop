@extends('site.layout')

@section('title', 'Agendamento - ' . ($configuracoes['site_nome'] ?? 'BarberShop Premium'))
@section('description', 'Agende seu horário de forma rápida e fácil. Escolha o melhor horário e serviços.')

@push('styles')
<style>
    .agendamento-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1rem 0; /* Reduzido padding para mobile */
        overflow-x: hidden; /* Previne overflow horizontal */
    }

    .agendamento-header {
        text-align: center;
        margin-bottom: 2rem; /* Reduzido margin para mobile */
        padding: 1rem; /* Reduzido padding */
    }

    .agendamento-header h1 {
        font-size: 2rem; /* Reduzido font-size para mobile */
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .agendamento-header p {
        font-size: 1rem; /* Reduzido font-size */
        color: #64748b;
        max-width: 600px;
        margin: 0 auto;
        padding: 0 1rem; /* Adicionado padding lateral */
    }

    .agendamento-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem; /* Reduzido margin */
        gap: 0.5rem; /* Reduzido gap para mobile */
        flex-wrap: wrap;
        padding: 0 1rem; /* Adicionado padding lateral */
    }

    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem; /* Reduzido padding */
        border-radius: 25px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        font-size: 0.875rem; /* Reduzido font-size */
    }

    .step.active {
        /* Changed from secondary to primary color for active step */
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }

    .step.completed {
        background: #10b981;
        color: white;
    }

    .step-number {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .step.active .step-number,
    .step.completed .step-number {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .agendamento-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
        width: 100%; /* Garantir largura total */
        box-sizing: border-box; /* Incluir padding na largura */
    }

    .step-content {
        display: none;
        animation: fadeInUp 0.5s ease-out;
    }

    .step-content.active {
        display: block;
    }

    /* Seleção de Filial */
    .filiais-grid {
        display: grid;
        grid-template-columns: 1fr; /* Uma coluna por padrão para mobile */
        gap: 1rem;
        margin-bottom: 2rem;
        max-width: 100%; /* Limitar largura máxima */
    }

    .filial-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden; /* Prevenir overflow */
        max-width: 100%; /* Limitar largura máxima */
        box-sizing: border-box; /* Incluir padding na largura */
        text-align: center; /* Centralizar conteúdo */
    }

    .filial-card.selected {
        border-color: var(--primary-color);
        background: linear-gradient(135deg, #fff 0%, #f0f9ff 100%);
    }

    .filial-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .filial-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .filial-endereco {
        color: #64748b;
        font-size: 0.9rem;
    }

    /* Seleção de Data e Horário */
    .datetime-selection {
        display: grid;
        grid-template-columns: 1fr; /* Uma coluna por padrão para mobile */
        gap: 1.5rem; /* Reduzido gap */
        margin-bottom: 2rem;
    }

    .date-picker, .time-picker {
        background: white;
        border-radius: 15px;
        padding: 1.5rem; /* Reduzido padding */
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        width: 100%; /* Garantir largura total */
        box-sizing: border-box; /* Incluir padding na largura */
    }

    .date-picker h3, .time-picker h3 {
        margin-bottom: 1.5rem;
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    /* Adicionando controles de navegação do calendário */
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 0.5rem;
    }

    .calendar-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .calendar-nav select {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--primary-color);
        cursor: pointer;
        min-width: 90px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .calendar-nav select:hover {
        /* Changed from secondary to primary color for hover state */
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-1px);
    }

    .calendar-nav select:focus {
        outline: none;
        /* Changed from secondary to primary color for focus state */
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .calendar-nav button {
        /* Changed from secondary to primary color for button background */
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.6rem;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }

    .calendar-nav button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
    }

    .calendar-nav button:active {
        transform: translateY(0);
    }

    .calendar-month-year {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1rem;
        text-align: center;
        flex: 1;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.25rem;
        margin-top: 1rem;
        max-width: 100%;
        overflow: hidden; /* Prevenir overflow */
    }

    .calendar-day {
        aspect-ratio: 1;
        border: none;
        background: #f8fafc;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 32px;
        max-width: 100%; /* Limitar largura máxima */
        overflow: hidden; /* Prevenir overflow de texto */
    }

    .calendar-day:hover {
        /* Changed from secondary to primary color for hover state */
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .calendar-day.selected {
        background: var(--primary-color);
        color: white;
    }

    .calendar-day.disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .time-slots {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); /* Mudança para auto-fill e menor minmax */
        gap: 0.5rem;
        margin-top: 1rem;
        max-width: 100%; /* Limitar largura máxima */
    }

    .time-slot {
        padding: 0.5rem 0.25rem; /* Reduzido padding horizontal */
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-size: 0.75rem; /* Reduzido font-size */
        font-weight: 500;
        color: var(--primary-color);
        min-height: 36px; /* Altura mínima para touch */
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap; /* Prevenir quebra de linha */
        overflow: hidden; /* Prevenir overflow */
    }

    .time-slot:hover {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .time-slot.selected {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
    }

    .time-slot.unavailable {
        background: #fee2e2;
        border-color: #fecaca;
        color: #dc3545;
        cursor: not-allowed;
    }

    /* Seleção de Serviços */
    .services-grid {
        display: grid;
        grid-template-columns: 1fr; /* Uma coluna por padrão no mobile */
        gap: 1rem;
        margin-bottom: 2rem;
        max-width: 100%; /* Limitar largura máxima */
    }

    .service-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden; /* Prevenir overflow */
        max-width: 100%; /* Limitar largura máxima */
        box-sizing: border-box; /* Incluir padding na largura */
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59,130,246,0.1), transparent);
        transition: left 0.5s;
    }

    .service-card:hover::before {
        left: 100%;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .service-card.selected {
        border-color: var(--primary-color);
        background: linear-gradient(135deg, #fff 0%, #f0f9ff 100%);
    }

    .service-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .service-icon {
        font-size: 2.5rem;
        /* Changed from secondary to primary color for service icon */
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .service-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid #e2e8f0;
        position: relative;
        cursor: pointer;
    }

    .service-card.selected .service-checkbox {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .service-card.selected .service-checkbox::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .service-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .service-description {
        color: #64748b;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .service-price {
        font-size: 1.5rem;
        font-weight: 700;
        /* Changed from secondary to primary color for service price */
        color: var(--primary-color);
    }

    .service-duration {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    /* Dados do Cliente */
    .client-form {
        background: white;
        border-radius: 15px;
        padding: 1.5rem; /* Reduzido padding */
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
        width: 100%; /* Garantir largura total */
        box-sizing: border-box; /* Incluir padding na largura */
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--primary-color);
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        /* Changed from secondary to primary color for form focus */
        border-color: var(--primary-color);
    }

    /* Resumo */
    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem; /* Reduzido padding */
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
        width: 100%; /* Garantir largura total */
        box-sizing: border-box; /* Incluir padding na largura */
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .summary-item:last-child {
        border-bottom: none;
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--primary-color);
    }

    .summary-label {
        color: #64748b;
    }

    .summary-value {
        font-weight: 500;
        color: var(--primary-color);
    }

    /* Botões de Navegação */
    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem; /* Reduzido margin */
        gap: 1rem;
        padding: 0 1rem; /* Adicionado padding lateral */
    }

    .btn-nav {
        padding: 0.75rem 1.5rem; /* Reduzido padding lateral */
        border: none;
        border-radius: 8px;
        font-size: 0.875rem; /* Reduzido font-size */
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 44px; /* Altura mínima para touch */
        white-space: nowrap; /* Evitar quebra de linha */
    }

    .btn-prev {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-prev:hover {
        background: #e2e8f0;
    }

    .btn-next {
        /* Changed from secondary to primary color for next button */
        background: var(--primary-color);
        color: white;
    }

    .btn-next:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-next:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive */
    @media (min-width: 768px) { /* Mudança para min-width approach */
        .agendamento-container {
            padding: 2rem 0; /* Mais padding em telas maiores */
        }
        
        .agendamento-header {
            margin-bottom: 3rem;
            padding: 2rem 0;
        }
        
        .agendamento-header h1 {
            font-size: 2.5rem;
        }
        
        .agendamento-header p {
            font-size: 1.1rem;
        }
        
        .agendamento-steps {
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .step {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
        
        .filiais-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .datetime-selection {
            grid-template-columns: 1fr 1fr; /* Duas colunas em telas maiores */
            gap: 2rem;
        }
        
        .date-picker, .time-picker {
            padding: 2rem;
        }
        
        .calendar-grid {
            gap: 0.5rem;
        }
        
        .calendar-day {
            font-size: 0.875rem;
            border-radius: 8px;
        }
        
        .time-slots {
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); /* Maior minmax para desktop */
            gap: 0.75rem;
        }
        
        .time-slot {
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem; /* Maior font-size para desktop */
        }
        
        .services-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .service-card {
            padding: 2rem;
        }
        
        .client-form, .summary-card {
            padding: 2rem;
        }
        
        .navigation-buttons {
            margin-top: 3rem;
            padding: 0;
        }
        
        .btn-nav {
            padding: 0.75rem 2rem;
            font-size: 1rem;
        }
    }
    
    @media (max-width: 480px) { /* Ajustes específicos para telas muito pequenas */
        .agendamento-header h1 {
            font-size: 1.75rem;
        }
        
        .step span {
            display: none; /* Ocultar texto dos steps em telas muito pequenas */
        }
        
        .calendar-day {
            font-size: 0.7rem;
            min-height: 28px;
        }
        
        .time-slots {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); /* Menor minmax para telas pequenas */
        }
        
        .time-slot {
            font-size: 0.7rem; /* Menor font-size */
            padding: 0.4rem 0.2rem; /* Menor padding */
        }
        
        .service-card {
            padding: 1rem;
        }
        
        /* Ajustes específicos para calendário em telas pequenas */
        .calendar-nav select {
            min-width: 60px;
            font-size: 0.75rem;
            padding: 0.3rem 0.4rem;
        }
        
        .calendar-nav button {
            min-width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }

    .loading, .no-slots, .error {
        text-align: center;
        padding: 20px;
        color: #666;
        font-style: italic;
    }

    .error {
        color: #dc3545;
    }

    /* Adicionando estilos para interface swipe com imagens */
    .services-container, .produtos-container {
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .services-swiper, .produtos-swiper {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 1rem 0;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .services-swiper::-webkit-scrollbar, .produtos-swiper::-webkit-scrollbar {
        display: none;
    }

    .service-card, .produto-card {
        min-width: 280px;
        flex-shrink: 0;
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .service-image, .produto-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--secondary-color);
    }

    .service-card.selected, .produto-card.selected {
        border-color: var(--primary-color);
        background: linear-gradient(135deg, #fff 0%, #f0f9ff 100%);
        transform: scale(1.02);
    }

    .selection-counter {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--primary-color);
        color: white;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: bold;
        box-shadow: 0 4px 20px rgba(59,130,246,0.3);
        z-index: 1000;
        display: none;
        animation: bounce 0.3s ease;
    }

    .selection-counter.show {
        display: block;
    }

    @keyframes bounce {
        0%, 20%, 60%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        80% { transform: translateY(-5px); }
    }

    .swipe-indicator {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    /* Adicionando estilos para botões de navegação lateral dos carrosséis */
    .carousel-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid var(--primary-color);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        /* Ocultando botões no mobile e corrigindo posicionamento */
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
        transition: all 0.3s ease;
    }

    @media (min-width: 768px) {
        .carousel-nav-btn {
            display: flex;
        }
    }

    .carousel-nav-btn:hover {
        background: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    }

    .carousel-nav-btn:hover i {
        color: white;
    }

    .carousel-nav-btn.prev {
        /* Ajustando posicionamento para não ser cortado */
        left: 10px;
    }

    .carousel-nav-btn.next {
        /* Ajustando posicionamento para não ser cortado */
        right: 10px;
    }

    .carousel-nav-btn i {
        color: var(--primary-color);
        font-size: 18px;
        transition: color 0.3s ease;
    }

    /* Adicionando container relativo para os carrosséis */
    .services-carousel, .products-carousel {
        position: relative;
        overflow: visible;
        padding: 0 60px;
    }

    @media (max-width: 767px) {
        .services-carousel, .products-carousel {
            padding: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;
    let selectedFilial = null;
    let clientData = {};
    let currentStep = 1;
    let selectedSlotId = null;
    let selectedServices = [];
    let selectedProducts = [];
document.addEventListener('DOMContentLoaded', function() {

    // initCalendar(); // Chamada removida, será inicializada dentro de selectFilial
    initTimeSlots();
    
    // Função para atualizar o calendário e carregar horários
    function updateCalendarAndSlots(filialId) {
        const today = new Date();
        const todayStr = today.toISOString().split('T')[0];
        selectedDate = todayStr; // Seleciona o dia atual por padrão
        
        // Atualizar o header do calendário e renderizar
        updateCalendarHeader();
        renderCalendar();
        
        // Carregar horários para o dia atual e filial selecionada
        loadTimeSlots(todayStr, filialId);
    }

    function selectFilial(filialId, filialCard) {
        // Remover seleção anterior
        document.querySelectorAll('.filial-card.selected').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Selecionar nova filial
        filialCard.classList.add('selected');
        selectedFilial = filialId;
        
        // Carregar serviços e produtos da filial
        carregarServicosPorFilial(filialId);
        carregarProdutosPorFilial(filialId);
        
        updateCalendarAndSlots(filialId);
        
        updateStepStatus();
        
        // Auto-advance para próximo step após selecionar filial
        setTimeout(() => {
            nextStep();
        }, 500);
    }

    function initCalendar() {
        const calendarGrid = document.querySelector('.calendar-grid');
        
        let calendarHeader = document.querySelector('.calendar-header');
        if (!calendarHeader) {
            calendarHeader = document.createElement('div');
            calendarHeader.className = 'calendar-header';
            calendarHeader.innerHTML = `
                <div class="calendar-nav">
                    <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                    <select id="monthSelect" onchange="changeMonthYear()">
                        <option value="0">Jan</option>
                        <option value="1">Fev</option>
                        <option value="2">Mar</option>
                        <option value="3">Abr</option>
                        <option value="4">Mai</option>
                        <option value="5">Jun</option>
                        <option value="6">Jul</option>
                        <option value="7">Ago</option>
                        <option value="8">Set</option>
                        <option value="9">Out</option>
                        <option value="10">Nov</option>
                        <option value="11">Dez</option>
                    </select>
                    <select id="yearSelect" onchange="changeMonthYear()"></select>
                </div>
                <div class="calendar-month-year"></div>
                <div class="calendar-nav">
                    <button onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                </div>
            `;
            calendarGrid.parentNode.insertBefore(calendarHeader, calendarGrid);
            
            // Preencher anos (atual + 2 anos)
            const yearSelect = document.getElementById('yearSelect');
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year <= currentYear + 2; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }
        }
        
        updateCalendarHeader();
        renderCalendar();
    }

    function updateCalendarHeader() {
        const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                           'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        
        document.querySelector('.calendar-month-year').textContent = 
            `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        
        document.getElementById('monthSelect').value = currentDate.getMonth();
        document.getElementById('yearSelect').value = currentDate.getFullYear();
    }

    function changeMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        updateCalendarHeader();
        renderCalendar();
    }

    function changeMonthYear() {
        const month = parseInt(document.getElementById('monthSelect').value);
        const year = parseInt(document.getElementById('yearSelect').value);
        currentDate = new Date(year, month, 1);
        updateCalendarHeader();
        renderCalendar();
    }

    function renderCalendar() {
        const calendarGrid = document.querySelector('.calendar-grid');
        const today = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();
        
        // Limpar calendário
        calendarGrid.innerHTML = '';
        
        // Dias da semana
        const weekDays = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        weekDays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.textContent = day;
            dayHeader.style.cssText = `
                font-weight: 600;
                color: #64748b;
                text-align: center;
                padding: 0.5rem 0.25rem;
                fontSize: 0.75rem;
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                border-radius: 6px;
                margin-bottom: 0.25rem;
            `;
            calendarGrid.appendChild(dayHeader);
        });
        
        // Calcular dias do mês anterior para preencher espaços
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const prevMonthDays = new Date(currentYear, currentMonth, 0).getDate();
        
        // Dias do mês anterior (esmaecidos)
        for (let i = firstDay - 1; i >= 0; i--) {
            const prevDay = document.createElement('div');
            prevDay.className = 'calendar-day disabled';
            prevDay.textContent = prevMonthDays - i;
            prevDay.style.opacity = '0.3';
            calendarGrid.appendChild(prevDay);
        }
        
        // Dias do mês atual
        for (let day = 1; day <= daysInMonth; day++) {
            const dayButton = document.createElement('button');
            dayButton.className = 'calendar-day';
            dayButton.textContent = day;
            dayButton.dataset.day = day;
            
            const dayDate = new Date(currentYear, currentMonth, day);
            const isToday = dayDate.toDateString() === today.toDateString();
            const isPast = dayDate < today && !isToday;
            
            if (isPast) {
                dayButton.classList.add('disabled');
                dayButton.disabled = true;
            } else {
                dayButton.addEventListener('click', () => selectDate(dayDate, dayButton));
            }
            
            if (isToday && !isPast) {
                dayButton.style.cssText += `
                    border: 2px solid var(--primary-color);
                    font-weight: 700;
                    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
                `;
            }
            
            if (selectedDate && dayDate.toDateString() === new Date(selectedDate).toDateString()) {
                dayButton.classList.add('selected');
            }
            
            calendarGrid.appendChild(dayButton);
        }
        
        // Preencher dias do próximo mês se necessário
        const totalCells = calendarGrid.children.length;
        const remainingCells = 42 - totalCells; // 6 semanas * 7 dias
        
        for (let day = 1; day <= remainingCells && remainingCells < 7; day++) {
            const nextDay = document.createElement('div');
            nextDay.className = 'calendar-day disabled';
            nextDay.textContent = day;
            nextDay.style.opacity = '0.3';
            calendarGrid.appendChild(nextDay);
        }
    }
    
    function selectDate(date, button) {
        // Remover seleção anterior
        document.querySelectorAll('.calendar-day.selected').forEach(day => {
            day.classList.remove('selected');
        });
        
        // Selecionar nova data
        button.classList.add('selected');
        selectedDate = date;
        loadTimeSlots(date, selectedFilial);
        updateStepStatus();
    }

    function initTimeSlots() {
        const timeSlotsContainer = document.querySelector('.time-slots');
        timeSlotsContainer.innerHTML = '<div class="loading">Carregando horários...</div>';
    }

    // Renomeada para loadTimeSlots para clareza
    function loadTimeSlots(date, filialId) {
        const timeSlotsContainer = document.querySelector('.time-slots');
        let dateString;
        if (typeof date === 'string') {
            dateString = date;
        } else {
            dateString = date.toISOString().split('T')[0];
        }
        
        if (!filialId) {
            timeSlotsContainer.innerHTML = '<p class="no-slots">Selecione uma filial primeiro</p>';
            return;
        }
        
        timeSlotsContainer.innerHTML = '<div class="loading">Carregando horários...</div>';
        
        fetch(`/api/slots-disponiveis?data=${dateString}&filial_id=${filialId}`)
            .then(response => response.json())
            .then(data => {
                    renderTimeSlots(data.horarios);
            })
            .catch(error => {
                console.error('Erro ao carregar horários:', error);
                timeSlotsContainer.innerHTML = '<p class="no-slots">Erro ao carregar horários</p>';
            });
    }

    // Função para renderizar os horários disponíveis
    function renderTimeSlots(slots) {
        const timeSlotsContainer = document.querySelector('.time-slots');
        timeSlotsContainer.innerHTML = ''; // Limpa o container antes de adicionar novos slots
        
        if (slots && slots.length > 0) {
            slots.forEach(slot => {
                const timeButton = document.createElement('button');
                timeButton.className = 'time-slot';
                // Formata a hora para HH:MM
                const horaFormatada = new Date(slot.hora).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
                timeButton.textContent = horaFormatada;
                timeButton.dataset.slotId = slot.id;
                timeButton.addEventListener('click', () => selectTime(slot.hora, slot.id, timeButton));
                timeSlotsContainer.appendChild(timeButton);
            });
        } else {
            timeSlotsContainer.innerHTML = '<p class="no-slots">Nenhum horário disponível para esta data</p>';
        }
    }
    
    function selectTime(time, slotId, button) {
        if (button.disabled) return;
        
        // Remover seleção anterior
        document.querySelectorAll('.time-slot.selected').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Selecionar novo horário
        button.classList.add('selected');
        selectedTime = time;
        selectedSlotId = slotId;
        updateStepStatus();
    }
    
    

    function carregarServicosPorFilial(filialId) {
        const servicosContainer = document.querySelector('.services-swiper');
        servicosContainer.innerHTML = '<div class="loading">Carregando serviços...</div>';
        
        fetch(`/api/servicos-por-filial/${filialId}`)
            .then(response => response.json())
            .then(data => {
                servicosContainer.innerHTML = '';
                
                if (data && data.length > 0) {
                    data.forEach(servico => {
                        const serviceCard = document.createElement('div');
                        serviceCard.className = 'service-card servico-card';
                        serviceCard.dataset.serviceId = servico.id;
                        serviceCard.dataset.price = servico.preco;
                        serviceCard.dataset.name = servico.nome.toLowerCase();
                        
                        serviceCard.innerHTML = `
                            <div class="service-image">
                                ${servico.imagem ? 
                                    `<img src="${servico.imagem}" alt="${servico.nome}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">` :
                                    '<i class="fas fa-cut"></i>'
                                }
                            </div>
                            <div class="service-title">${servico.nome}</div>
                            <div class="service-description">${servico.descricao || 'Serviço profissional de alta qualidade'}</div>
                            <div class="service-price">R$ ${parseFloat(servico.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                            <div class="service-duration">Duração: ${servico.duracao || 30} min</div>
                        `;
                        
                        servicosContainer.appendChild(serviceCard);
                    });
                } else {
                    servicosContainer.innerHTML = '<p class="no-slots">Nenhum serviço disponível para esta filial</p>';
                }
            })
            .catch(error => {
                console.error('Erro ao carregar serviços:', error);
                servicosContainer.innerHTML = '<p class="error">Erro ao carregar serviços</p>';
            });
    }

    function carregarProdutosPorFilial(filialId) {
        const produtosContainer = document.querySelector('.produtos-swiper');
        produtosContainer.innerHTML = '<div class="loading">Carregando produtos...</div>';
        
        fetch(`/api/produtos-por-filial/${filialId}`)
            .then(response => response.json())
            .then(data => {
                produtosContainer.innerHTML = '';
                
                if (data && data.length > 0) {
                    data.forEach(produto => {
                        const productCard = document.createElement('div');
                        productCard.className = 'produto-card';
                        productCard.dataset.produtoId = produto.id;
                        productCard.dataset.price = produto.preco;
                        productCard.dataset.name = produto.nome.toLowerCase();
                        
                        productCard.innerHTML = `
                            <div class="produto-image">
                                ${produto.imagem ? 
                                    `<img src="${produto.imagem}" alt="${produto.nome}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">` :
                                    '<i class="fas fa-shopping-bag"></i>'
                                }
                            </div>
                            <div class="service-title">${produto.nome}</div>
                            <div class="service-description">${produto.descricao || 'Produto de qualidade'}</div>
                            <div class="service-price">R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                        `;
                        
                        produtosContainer.appendChild(productCard);
                    });
                } else {
                    produtosContainer.innerHTML = '<p class="no-slots">Nenhum produto disponível para esta filial</p>';
                }
            })
            .catch(error => {
                console.error('Erro ao carregar produtos:', error);
                produtosContainer.innerHTML = '<p class="error">Erro ao carregar produtos</p>';
            });
    }

    function updateServiceCounter() {
        const counter = document.getElementById('serviceCounter');
        if (selectedServices.length > 0) {
            counter.textContent = `${selectedServices.length} serviço${selectedServices.length > 1 ? 's' : ''} selecionado${selectedServices.length > 1 ? 's' : ''}`;
            counter.classList.add('show');
        } else {
            counter.classList.remove('show');
        }
    }

    function updateProductCounter() {
        const counter = document.getElementById('productCounter');
        if (selectedProducts.length > 0) {
            counter.textContent = `${selectedProducts.length} produto${selectedProducts.length > 1 ? 's' : ''} selecionado${selectedProducts.length > 1 ? 's' : ''}`;
            counter.classList.add('show');
        } else {
            counter.classList.remove('show');
        }
    }

    // Event listeners
    document.addEventListener('click', function(e) {
        if (e.target.closest('.filial-card')) {
            const card = e.target.closest('.filial-card');
            const filialId = card.dataset.filialId;
            selectFilial(filialId, card);
        }
        
        if (e.target.closest('.service-card')) {
            const card = e.target.closest('.service-card');
            const serviceId = card.dataset.serviceId;
            const serviceName = card.querySelector('.service-title').textContent;
            const servicePrice = card.dataset.price;
            
            card.classList.toggle('selected');
            
            const existingIndex = selectedServices.findIndex(s => s.id === serviceId);
            if (existingIndex > -1) {
                selectedServices.splice(existingIndex, 1);
            } else {
                selectedServices.push({
                    id: serviceId,
                    name: serviceName,
                    price: servicePrice
                });
            }
            
            updateServiceCounter();
            updateStepStatus();
        }
        
        if (e.target.closest('.produto-card')) {
            const card = e.target.closest('.produto-card');
            const productId = card.dataset.produtoId;
            const productName = card.querySelector('.service-title').textContent;
            const productPrice = card.dataset.price;
            
            card.classList.toggle('selected');
            
            const existingIndex = selectedProducts.findIndex(p => p.id === productId);
            if (existingIndex > -1) {
                selectedProducts.splice(existingIndex, 1);
            } else {
                selectedProducts.push({
                    id: productId,
                    name: productName,
                    price: productPrice
                });
            }
            
            updateProductCounter();
        }
    });
    
    // Navegação entre steps
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', nextStep);
    });
    
    document.querySelectorAll('.btn-prev').forEach(btn => {
        btn.addEventListener('click', prevStep);
    });
    
    function nextStep() {
        if (currentStep < 5 && canProceed()) { // Alterado para 5 steps
            if (currentStep === 1) {
                // Resetar data para o dia atual ao avançar da filial
                const today = new Date();
                selectedDate = today;
                updateCalendarHeader(); // Atualiza o header do calendário
                renderCalendar(); // Re-renderiza o calendário para destacar o dia atual
                
                setTimeout(() => {
                    const section = document.querySelector('#step2 .date-picker');
                    section.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 200);
            }
            
            if (currentStep === 2) {
                // Após selecionar data/horário, ir para serviços
                setTimeout(() => {
                    const section = document.querySelector('.services-swiper');
                    section.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 200);
            }
            
            if (currentStep === 3) {
                // Após selecionar serviços, ir para produtos
                setTimeout(() => {
                    const section = document.querySelector('.produtos-swiper');
                    section.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 200);
            }
            
            if (currentStep === 4) {
                // Após produtos, ir para dados do cliente
                setTimeout(() => {
                    const section = document.querySelector('.client-form');
                    section.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 200);
            }
            
            if (currentStep === 5) {
                // Coletar dados do formulário e criar agendamento
                collectClientData();
                criarAgendamento();
                return; // Não avança automaticamente
            }
            
            currentStep++;
            updateStepDisplay();
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    }
    
    function updateStepDisplay() {
        // Atualizar indicadores de step
        document.querySelectorAll('.step').forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 === currentStep) {
                step.classList.add('active');
            } else if (index + 1 < currentStep) {
                step.classList.add('completed');
            }
        });
        
        // Mostrar conteúdo do step atual
        document.querySelectorAll('.step-content').forEach((content, index) => {
            content.classList.remove('active');
            if (index + 1 === currentStep) {
                content.classList.add('active');
            }
        });
        
        updateStepStatus();
    }
    
    function updateStepStatus() {
        const nextBtn = document.querySelector(`#step${currentStep} .btn-next`);
        if (nextBtn) {
            nextBtn.disabled = !canProceed();
        }
    }
    
    function canProceed() {
        switch (currentStep) {
            case 1:
                return selectedFilial; // Primeiro step agora é filial
            case 2:
                return selectedDate && selectedTime;
            case 3:
                return selectedServices.length > 0;
            case 4:
                return true; // Produtos são opcionais
            case 5:
                const form = document.querySelector('#clientForm');
                return form && form.checkValidity();
            default:
                return true;
        }
    }
    
    function collectClientData() {
        const form = document.querySelector('#clientForm');
        const formData = new FormData(form);
        clientData = Object.fromEntries(formData.entries());
    }

    // Máscara de telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
        applyPhoneMask(e.target);
    });

    // Validação do formulário
    const formClient = document.getElementById('clientForm');
    formClient.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function () {
            updateStepStatus();
        });
    });

    // Busca de produtos
    document.getElementById('searchProducts').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const productCards = document.querySelectorAll('.produto-card');
        
        productCards.forEach(card => {
            const productName = card.getAttribute('data-name') || '';
            if (productName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Busca de serviços
    document.getElementById('searchServices').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const serviceCards = document.querySelectorAll('.servico-card');
        
        serviceCards.forEach(card => {
            const serviceName = card.getAttribute('data-name') || '';
            if (serviceName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Inicializar o calendário ao carregar a página
    initCalendar();

    // Definir funções globais para navegação do calendário
    window.changeMonth = changeMonth;
    window.changeMonthYear = changeMonthYear;
});

function criarAgendamento() {
    console.log('[v0] Iniciando criação do agendamento');

    const nome = document.getElementById('nome').value.trim();
    const telefone = document.getElementById('telefone').value.trim();

    console.log('[v0] Dados coletados:', { nome, telefone, selectedDate, selectedTime, selectedServices: selectedServices.length, selectedFilial });

    if (!selectedFilial || !nome || !telefone || !selectedDate || !selectedTime || selectedServices.length === 0) {
        alert('Por favor, preencha todos os campos obrigatórios e selecione filial, data, horário e serviços.');
        return;
    }

    const formData = new FormData();
    formData.append('filial_id', selectedFilial);
    formData.append('slot_id', selectedSlotId);
    formData.append('nome', nome);
    formData.append('telefone', telefone);
    formData.append('email', document.getElementById('email').value);
    formData.append('observacoes', document.getElementById('observacoes').value);

    selectedServices.forEach(service => {
        formData.append('servicos[]', service.id);
    });

    // Adicionar produtos selecionados se houver
    selectedProducts.forEach(product => {
        formData.append('produtos[]', product.id);
    });

    // Verificar se deve criar cobrança
    const criarCobranca = document.getElementById('criarMovimentoFinanceiro') && 
                            document.getElementById('criarMovimentoFinanceiro').checked;
    formData.append('criar_cobranca', criarCobranca ? '1' : '0');

    console.log('[v0] Enviando dados para API');

    fetch('/api/finalizar-agendamento-completo', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        console.log('[v0] Resposta recebida:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('[v0] Dados da resposta:', data);
        if (data.success) {
            alert('Agendamento realizado com sucesso!');
            window.location.href = '/';
        } else {
            alert('Erro ao realizar agendamento: ' + data.message);
        }
    })
    .catch(error => {
        console.error('[v0] Erro na requisição:', error);
        alert('Erro ao realizar agendamento. Tente novamente.');
    });
}

function applyPhoneMask(input) {
    let value = input.value.replace(/\D/g, '');

    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }

    input.value = value;
}

// Função global para navegação do calendário
window.changeMonth = function(direction) {
    // Esta função será definida dentro do DOMContentLoaded
};

window.changeMonthYear = function() {
    // Esta função será definida dentro do DOMContentLoaded
};

    function scrollServicesLeft() {
        const container = document.querySelector('#step3 .services-swiper');
        container.scrollBy({ left: -300, behavior: 'smooth' });
    }

    function scrollServicesRight() {
        const container = document.querySelector('#step3 .services-swiper');
        container.scrollBy({ left: 300, behavior: 'smooth' });
    }

    function scrollProductsLeft() {
        const container = document.querySelector('#step4 .produtos-swiper');
        container.scrollBy({ left: -300, behavior: 'smooth' });
    }

    function scrollProductsRight() {
        const container = document.querySelector('#step4 .produtos-swiper');
        container.scrollBy({ left: 300, behavior: 'smooth' });
    }
</script>
@endpush

@section('content')
<div class="agendamento-container">
    <div class="agendamento-header">
        <h1>Agende seu Horário</h1>
        <p>Escolha a filial, data, horário e serviços desejados. É rápido e fácil!</p>
    </div>
    
    <!-- Steps Indicator -->
    <div class="agendamento-steps">
        <div class="step active">
            <div class="step-number">1</div>
            <span>Filial</span>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <span>Data e Horário</span>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <span>Serviços</span>
        </div>
        <div class="step">
            <div class="step-number">4</div>
            <span>Produtos</span>
        </div>
        <div class="step">
            <div class="step-number">5</div>
            <span>Seus Dados</span>
        </div>
    </div>
    
    <div class="agendamento-content">
        <!-- Step 1: Seleção de Filial -->
        <div class="step-content active" id="step1">
            <h3 style="text-align: center; margin-bottom: 1rem; color: var(--primary-color);">
                <i class="fas fa-map-marker-alt"></i> Escolha a Filial
            </h3>
            
            <!-- Restaurando cards das filiais para formato original -->
            <div class="filiais-grid">
                @forelse($filiais as $filial)
                    <div class="filial-card" data-filial-id="{{ $filial->id }}">
                        <div class="filial-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="filial-name">{{ $filial->nome }}</div>
                        <div class="filial-endereco">{{ $filial->endereco }}</div>
                    </div>
                @empty
                    <div class="filial-card" data-filial-id="1">
                        <div class="filial-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="filial-name">Filial Centro</div>
                        <div class="filial-endereco">Rua Principal, 123 - Centro</div>
                    </div>
                @endforelse
            </div>
            
            <div class="navigation-buttons">
                <div></div>
                <button class="btn-nav btn-next" disabled>
                    Próximo <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 2: Data e Horário -->
        <div class="step-content" id="step2">
            <div class="datetime-selection">
                <div class="date-picker">
                    <h3><i class="fas fa-calendar-alt"></i> Escolha a Data</h3>
                    <!-- Header do calendário será inserido aqui via JavaScript -->
                    <div class="calendar-grid"></div>
                </div>
                
                <div class="time-picker">
                    <h3><i class="fas fa-clock"></i> Escolha o Horário</h3>
                    <div class="time-slots"></div>
                </div>
            </div>
            
            <div class="navigation-buttons">
                <button class="btn-nav btn-prev">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <button class="btn-nav btn-next" disabled>
                    Próximo <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 3: Serviços -->
        <div class="step-content" id="step3">
            <h3 style="text-align: center; margin-bottom: 1rem; color: var(--primary-color);">
                <i class="fas fa-cut"></i> Escolha os Serviços
            </h3>
            
            <!-- Adicionando barra de pesquisa de serviços -->
            <div class="search-container" style="margin-bottom: 1rem;">
                <div style="position: relative; max-width: 400px; margin: 0 auto;">
                    <input type="text" id="searchServices" placeholder="Buscar serviços..." 
                           style="width: 100%; padding: 12px 40px 12px 15px; border: 2px solid #ddd; border-radius: 25px; font-size: 16px; outline: none; transition: border-color 0.3s;">
                    <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #666;"></i>
                </div>
            </div>
            
            <!-- Adicionando indicador de swipe e container para scroll horizontal -->
            <div class="swipe-indicator">
                <i class="fas fa-hand-point-right"></i> Deslize para ver mais serviços
            </div>
            
            <div class="services-container" style="position: relative;">
                <!-- Melhorando botões de navegação lateral para serviços -->
                <div class="carousel-nav-btn prev" onclick="scrollServicesLeft()">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="carousel-nav-btn next" onclick="scrollServicesRight()">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="services-swiper">
                    <!-- Serviços serão carregados dinamicamente via JavaScript -->
                </div>
            </div>
            
            <!-- Adicionando contador de serviços selecionados -->
            <div class="selection-counter" id="serviceCounter"></div>
            
            <div class="navigation-buttons">
                <button class="btn-nav btn-prev">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <button class="btn-nav btn-next" disabled>
                    Próximo <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 4: Produtos Sugeridos -->
        <div class="step-content" id="step4">
            <h3 style="text-align: center; margin-bottom: 1rem; color: var(--primary-color);">
                <i class="fas fa-shopping-bag"></i> Produtos Recomendados
            </h3>
            
            <p style="text-align: center; margin-bottom: 1rem; color: #666;">
                Que tal levar alguns produtos para cuidar do seu visual em casa?
            </p>
            
            <!-- Adicionando barra de pesquisa de produtos -->
            <div class="search-container" style="margin-bottom: 1rem;">
                <div style="position: relative; max-width: 400px; margin: 0 auto;">
                    <input type="text" id="searchProducts" placeholder="Buscar produtos..." 
                           style="width: 100%; padding: 12px 40px 12px 15px; border: 2px solid #ddd; border-radius: 25px; font-size: 16px; outline: none; transition: border-color 0.3s;">
                    <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #666;"></i>
                </div>
            </div>
            
            <!-- Adicionando indicador de swipe e container para produtos -->
            <div class="swipe-indicator">
                <i class="fas fa-hand-point-right"></i> Deslize para ver mais produtos
            </div>
            
            <div class="produtos-container" style="position: relative;">
                <!-- Melhorando botões de navegação lateral para produtos -->
                <div class="carousel-nav-btn prev" onclick="scrollProductsLeft()">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="carousel-nav-btn next" onclick="scrollProductsRight()">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="produtos-swiper" id="produtosSugeridos">
                    <!-- Produtos serão carregados dinamicamente via JavaScript -->
                </div>
            </div>
            
            <!-- Adicionando contador de produtos selecionados -->
            <div class="selection-counter" id="productCounter"></div>
            
            <div class="payment-option" style="display: none !important;">
                <label>
                    <input type="checkbox" checked id="criarMovimentoFinanceiro" name="criar_movimento_financeiro">
                    <span>Gerar cobrança para pagamento no dia do atendimento</span>
                </label>
            </div>
            
            <div class="navigation-buttons">
                <button class="btn-nav btn-prev">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <button class="btn-nav btn-next">
                    Próximo <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 5: Dados do Cliente -->
        <div class="step-content" id="step5">
            <div class="client-form">
                <h3 style="text-align: center; margin-bottom: 2rem; color: var(--primary-color);">
                    <i class="fas fa-user"></i> Seus Dados
                </h3>
                
                <form id="clientForm">
                    <div class="form-group">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefone">Telefone/WhatsApp *</label>
                        <input type="tel" id="telefone" name="telefone" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email">
                    </div>
                    
                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="3" placeholder="Alguma observação especial?"></textarea>
                    </div>
                </form>
            </div>
            
            <div class="navigation-buttons">
                <button class="btn-nav btn-prev">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <!-- Corrigindo botão de finalizar para chamar função correta -->
                <button class="btn-nav btn-next" onclick="criarAgendamento()">
                    Finalizar Agendamento <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
