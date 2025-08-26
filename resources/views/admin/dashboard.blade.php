@extends('layouts.admin')

@section('title', 'Dashboard - Barbearia Tech')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do sistema tecnológico')

@section('content')
<style>
    /* Estilos tecnológicos para cards do dashboard */
    .tech-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .tech-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
    }

    .tech-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .card-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        font-family: 'JetBrains Mono', monospace;
    }

    .card-label {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tech-table {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        overflow: hidden;
    }

    .tech-table-header {
        background: rgba(59, 130, 246, 0.1);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .tech-table-title {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .tech-table-body {
        padding: 2rem;
    }

    .table-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s ease;
    }

    .table-row:hover {
        background: rgba(59, 130, 246, 0.05);
        border-radius: 8px;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .client-name {
        color: #ffffff;
        font-weight: 600;
    }

    .service-name {
        color: #64748b;
        font-size: 0.9rem;
    }

    .price {
        color: #06b6d4;
        font-weight: 600;
        font-family: 'JetBrains Mono', monospace;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-completed {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-progress {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
<div class="content-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Sistema de gerenciamento tecnológico da barbearia</p>
</div>
<div class="grid-4">
    <!-- Cards redesenhados com estética tecnológica -->
    <div class="tech-card">
        <div class="card-icon" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">
            <i class="fas fa-users" style="color: white;"></i>
        </div>
        <div class="card-value">150</div>
        <div class="card-label">Clientes Ativos</div>
    </div>
    
    <div class="tech-card">
        <div class="card-icon" style="background: linear-gradient(135deg, #06b6d4, #3b82f6);">
            <i class="fas fa-cut" style="color: white;"></i>
        </div>
        <div class="card-value">45</div>
        <div class="card-label">Serviços Hoje</div>
    </div>
    
    <div class="tech-card">
        <div class="card-icon" style="background: linear-gradient(135deg, #22c55e, #06b6d4);">
            <i class="fas fa-shopping-cart" style="color: white;"></i>
        </div>
        <div class="card-value">R$ 2.450</div>
        <div class="card-label">Vendas Hoje</div>
    </div>
    
    <div class="tech-card">
        <div class="card-icon" style="background: linear-gradient(135deg, #8b5cf6, #3b82f6);">
            <i class="fas fa-box" style="color: white;"></i>
        </div>
        <div class="card-value">28</div>
        <div class="card-label">Produtos</div>
    </div>
</div>

<div class="grid-2">
    <!-- Tabela redesenhada com estética tecnológica -->
    <div class="tech-table">
        <div class="tech-table-header">
            <h3 class="tech-table-title">Últimos Atendimentos</h3>
        </div>
        <div class="tech-table-body">
            <div class="table-row">
                <div>
                    <div class="client-name">João Silva</div>
                    <div class="service-name">Corte + Barba</div>
                </div>
                <div style="text-align: right;">
                    <div class="price">R$ 45,00</div>
                    <div class="status-badge status-completed">Concluído</div>
                </div>
            </div>
            <div class="table-row">
                <div>
                    <div class="client-name">Pedro Santos</div>
                    <div class="service-name">Corte Simples</div>
                </div>
                <div style="text-align: right;">
                    <div class="price">R$ 25,00</div>
                    <div class="status-badge status-progress">Em Andamento</div>
                </div>
            </div>
            <div class="table-row">
                <div>
                    <div class="client-name">Carlos Oliveira</div>
                    <div class="service-name">Barba + Bigode</div>
                </div>
                <div style="text-align: right;">
                    <div class="price">R$ 35,00</div>
                    <div class="status-badge status-completed">Concluído</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seção de agendamentos redesenhada -->
    <div class="tech-table">
        <div class="tech-table-header">
            <h3 class="tech-table-title">Próximos Agendamentos</h3>
        </div>
        <div class="tech-table-body">
            <div class="table-row">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #06b6d4); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="color: white;"></i>
                    </div>
                    <div>
                        <div class="client-name">14:30</div>
                        <div class="service-name">Carlos Oliveira</div>
                    </div>
                </div>
            </div>
            <div class="table-row">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #06b6d4, #22c55e); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="color: white;"></i>
                    </div>
                    <div>
                        <div class="client-name">15:00</div>
                        <div class="service-name">Roberto Lima</div>
                    </div>
                </div>
            </div>
            <div class="table-row">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #22c55e, #3b82f6); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="color: white;"></i>
                    </div>
                    <div>
                        <div class="client-name">15:30</div>
                        <div class="service-name">André Costa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
