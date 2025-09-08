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
        background: var(--secondary-color);
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
        border-color: var(--secondary-color);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-1px);
    }

    .calendar-nav select:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .calendar-nav button {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
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
        background: var(--secondary-color);
        color: white;
        transform: scale(1.1);
    }

    .calendar-day.selected {
        background: var(--secondary-color);
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
        border-color: var(--secondary-color);
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
    }

    .time-slot.selected {
        border-color: var(--secondary-color);
        background: var(--secondary-color);
        color: white;
    }

    .time-slot.unavailable {
        background: #fee2e2;
        border-color: #fecaca;
        color: #dc2626;
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
        border-color: var(--secondary-color);
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
        color: var(--secondary-color);
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
        background: var(--secondary-color);
        border-color: var(--secondary-color);
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
        color: var(--secondary-color);
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
        border-color: var(--secondary-color);
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
        background: var(--secondary-color);
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
        border-color: var(--secondary-color);
        background: linear-gradient(135deg, #fff 0%, #f0f9ff 100%);
        transform: scale(1.02);
    }

    .selection-counter {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--secondary-color);
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
</style>
@endpush

@push('scripts')
<script>
function adicionarProdutos() {
    const produtosSelecionados = [];
    document.querySelectorAll('.produto-card.selected').forEach(card => {
        const produtoId = card.dataset.produtoId;
        if (produtoId) {
            produtosSelecionados.push(produtoId);
        }
    });

    if (produtosSelecionados.length === 0) {
        // Se não selecionou produtos, apenas redireciona
        alert('Agendamento finalizado com sucesso!');
        window.location.href = '/';
        return;
    }

    if (produtosSelecionados.length > 0 && !document.getElementById('criarMovimentoFinanceiro').checked) {
        alert('Existem produtos selecionados. Para solicita-los marque confirmando a geração da cobrança para pagamento no dia do atendimento.');
        return
    }
    
    const formData = new FormData();
    formData.append('agendamento_id', window.agendamentoId);
    
    produtosSelecionados.forEach(produtoId => {
        formData.append('produtos[]', produtoId);
    });

    fetch('/api/adicionar-produtos', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Agendamento finalizado com produtos adicionados!');
            window.location.href = '/';
        } else {
            alert('Erro ao adicionar produtos: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao adicionar produtos. Agendamento já foi criado.');
        window.location.href = '/';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;
    let clientData = {};
    let currentStep = 1;
    let selectedSlotId = null;

    initCalendar();
    
    const today = new Date();
    selectedDate = today.toISOString().split('T')[0];
    updateTimeSlots(today);

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
            
            const dayDate = new Date(currentYear, currentMonth, day);
            const isToday = dayDate.toDateString() === today.toDateString();
            const isPast = dayDate < today && !isToday;
            const isSunday = dayDate.getDay() === 0;
            
            if (isPast || isSunday) {
                dayButton.classList.add('disabled');
                dayButton.disabled = true;
            } else {
                dayButton.addEventListener('click', () => selectDate(dayDate, dayButton));
            }
            
            if (isToday && !isPast) {
                dayButton.style.cssText += `
                    border: 2px solid var(--secondary-color);
                    font-weight: 700;
                    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
                `;
            }
            
            if (selectedDate && dayDate.toDateString() === selectedDate.toDateString()) {
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
        selectedDate = date.toISOString().split('T')[0];
        
        setTimeout(() => {
            const timeSection = document.querySelector('#step1 .time-slots').parentElement;
            timeSection.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start',
                inline: 'nearest'
            });
        }, 300);
        
        // Atualizar horários disponíveis
        updateTimeSlots(date);
        updateStepStatus();
    }
    
    function initTimeSlots() {
        const timeSlotsContainer = document.querySelector('.time-slots');
        timeSlotsContainer.innerHTML = '<div class="loading">Carregando horários...</div>';
    }

    function updateTimeSlots(date) {
        const timeSlotsContainer = document.querySelector('.time-slots');
        const dateString = date.toISOString().split('T')[0];
        
        timeSlotsContainer.innerHTML = '<div class="loading">Carregando horários...</div>';
        
        fetch(`/api/slots-disponiveis?data=${dateString}`)
            .then(response => response.json())
            .then(data => {
                timeSlotsContainer.innerHTML = '';
                
                if (data.horarios && data.horarios.length > 0) {
                    data.horarios.forEach(slot => {
                        const timeButton = document.createElement('button');
                        timeButton.className = 'time-slot';
                        timeButton.textContent = slot.hora;
                        timeButton.dataset.slotId = slot.id;
                        timeButton.addEventListener('click', () => selectTime(slot.hora, slot.id, timeButton));
                        timeSlotsContainer.appendChild(timeButton);
                    });
                } else {
                    timeSlotsContainer.innerHTML = '<p class="no-slots">Nenhum horário disponível para esta data</p>';
                }
            })
            .catch(error => {
                console.error('Erro ao carregar horários:', error);
                timeSlotsContainer.innerHTML = '<p class="error">Erro ao carregar horários</p>';
            });
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
    
    let selectedServices = [];
    let selectedProducts = [];

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

    document.addEventListener('click', function(e) {
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
        
        if (currentStep < 4 && canProceed()) {
            if (currentStep === 2) {
                // Após selecionar serviços, ir para produtos
                currentStep = 3;
                updateStepDisplay();
                return;
            }
            
            if (currentStep === 4) {
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
                return selectedDate && selectedTime;
            case 2:
                return selectedServices.length > 0;
            case 3:
                return true; // Produtos são opcionais
            case 4:
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
    
    function criarAgendamento() {
        const nome = document.getElementById('nome').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        
        if (!nome || !telefone || !selectedDate || !selectedTime || selectedServices.length === 0) {
            alert('Por favor, preencha todos os campos obrigatórios e selecione data, horário e serviços.');
            return;
        }

        const formData = new FormData();
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

        fetch('/api/finalizar-agendamento-completo', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Agendamento realizado com sucesso!');
                window.location.href = '/';
            } else {
                alert('Erro ao realizar agendamento: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
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

    document.getElementById('telefone').addEventListener('input', function(e) {
        applyPhoneMask(e.target);
    });

    const formClient = document.getElementById('clientForm');

    formClient.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function () {
            updateStepStatus();
        });
    });
});

// Função global para navegação do calendário
window.changeMonth = function(direction) {
    // Esta função será definida dentro do DOMContentLoaded
};

window.changeMonthYear = function() {
    // Esta função será definida dentro do DOMContentLoaded
};
</script>
@endpush

@section('content')
<div class="agendamento-container">
    <div class="agendamento-header">
        <h1>Agende seu Horário</h1>
        <p>Escolha a data, horário e serviços desejados. É rápido e fácil!</p>
    </div>
    
    <!-- Steps Indicator -->
    <div class="agendamento-steps">
        <div class="step active">
            <div class="step-number">1</div>
            <span>Data e Horário</span>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <span>Serviços</span>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <span>Produtos</span>
        </div>
        <div class="step">
            <div class="step-number">4</div>
            <span>Seus Dados</span>
        </div>
    </div>
    
    <div class="agendamento-content">
        <!-- Step 1: Data e Horário -->
        <div class="step-content active" id="step1">
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
                <div></div>
                <button class="btn-nav btn-next" disabled>
                    Próximo <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 2: Serviços -->
        <div class="step-content" id="step2">
            <h3 style="text-align: center; margin-bottom: 1rem; color: var(--primary-color);">
                <i class="fas fa-cut"></i> Escolha os Serviços
            </h3>
            
            <!-- Adicionando indicador de swipe e container para scroll horizontal -->
            <div class="swipe-indicator">
                <i class="fas fa-hand-point-right"></i> Deslize para ver mais serviços
            </div>
            
            <div class="services-container">
                <div class="services-swiper">
                    @forelse($produtos as $produto)
                        @if($produto->tipo == 'servico')

                            <div class="service-card" data-service-id="{{ $produto->id }}" data-price="{{ $produto->preco }}">
                                <div class="service-image">
                                    @if($produto->imagem)
                                        <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                                    @else
                                        @switch($produto->nome)
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
                                    @endif
                                </div>
                                
                                <div class="service-title">{{ $produto->nome }}</div>
                                <div class="service-description">
                                    {{ $produto->descricao ?: 'Serviço profissional de alta qualidade' }}
                                </div>
                                <div class="service-price">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                                <div class="service-duration">Duração: {{ $configuracoes['duracao_servico'] ?? 30 }} min</div>
                            </div>
                        @endif
                    @empty
                        <!-- Serviços padrão caso não haja cadastrados -->
                        <div class="service-card" data-service-id="1" data-price="25.00">
                            <div class="service-image"><i class="fas fa-cut"></i></div>
                            <div class="service-title">Corte Masculino</div>
                            <div class="service-description">Corte profissional personalizado</div>
                            <div class="service-price">R$ 25,00</div>
                            <div class="service-duration">Duração: 30 min</div>
                        </div>
                        
                        <div class="service-card" data-service-id="2" data-price="15.00">
                            <div class="service-image"><i class="fas fa-user-tie"></i></div>
                            <div class="service-title">Barba</div>
                            <div class="service-description">Aparar e modelar barba</div>
                            <div class="service-price">R$ 15,00</div>
                            <div class="service-duration">Duração: 20 min</div>
                        </div>
                        
                        <div class="service-card" data-service-id="3" data-price="35.00">
                            <div class="service-image"><i class="fas fa-scissors"></i></div>
                            <div class="service-title">Corte + Barba</div>
                            <div class="service-description">Pacote completo</div>
                            <div class="service-price">R$ 35,00</div>
                            <div class="service-duration">Duração: 45 min</div>
                        </div>
                    @endforelse
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
        
        <!-- Step 3: Produtos Sugeridos -->
        <div class="step-content" id="step3">
            <h3 style="text-align: center; margin-bottom: 1rem; color: var(--primary-color);">
                <i class="fas fa-shopping-bag"></i> Produtos Recomendados
            </h3>
            
            <p style="text-align: center; margin-bottom: 1rem; color: #666;">
                Que tal levar alguns produtos para cuidar do seu visual em casa?
            </p>
            
            <!-- Adicionando indicador de swipe e container para produtos -->
            <div class="swipe-indicator">
                <i class="fas fa-hand-point-right"></i> Deslize para ver mais produtos
            </div>
            
            <div class="produtos-container">
                <div class="produtos-swiper" id="produtosSugeridos">
                    @forelse($produtos as $produto)
                        @if($produto->tipo == 'produto')
                            <div class="produto-card" data-produto-id="{{ $produto->id }}" data-price="{{ $produto->preco }}">
                                <div class="produto-image">
                                    @if($produto->imagem)
                                        <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                                    @else
                                        <i class="fas fa-shopping-bag"></i>
                                    @endif
                                </div>
                                <div class="service-title">{{ $produto->nome }}</div>
                                <div class="service-description">{{ $produto->descricao ?: 'Produto de qualidade' }}</div>
                                <div class="service-price">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                            </div>
                        @endif
                    @empty
                        <!-- Produtos padrão caso não haja cadastrados -->
                        <div class="produto-card" data-produto-id="1" data-price="15.00">
                            <div class="produto-image"><i class="fas fa-shopping-bag"></i></div>
                            <div class="service-title">Pomada Modeladora</div>
                            <div class="service-description">Pomada para modelar cabelo</div>
                            <div class="service-price">R$ 15,00</div>
                        </div>
                        
                        <div class="produto-card" data-produto-id="2" data-price="12.00">
                            <div class="produto-image"><i class="fas fa-spray-can"></i></div>
                            <div class="service-title">Spray Fixador</div>
                            <div class="service-description">Spray para fixar penteado</div>
                            <div class="service-price">R$ 12,00</div>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Adicionando contador de produtos selecionados -->
            <div class="selection-counter" id="productCounter"></div>
            
            <div class="payment-option">
                <label>
                    <input type="checkbox" id="criarMovimentoFinanceiro" name="criar_movimento_financeiro">
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
        
        <!-- Step 4: Dados do Cliente -->
        <div class="step-content" id="step4">
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
                <button class="btn-nav btn-next" disabled>
                    Finalizar Agendamento <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
