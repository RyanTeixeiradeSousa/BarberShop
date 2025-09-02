@extends('layouts.app')

@section('title', 'Meu Perfil - BarberShop Pro')
@section('page-title', 'Meu Perfil')
@section('page-subtitle', 'Visualize suas informações pessoais')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-user me-2" style="color: #60a5fa;"></i>
                Meu Perfil
            </h2>
            <p class="mb-0" style="color: #6b7280;">Visualize suas informações pessoais</p>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ explode(' ', $user->nome )[0];}}</h4>
                        <p class="text-muted mb-0">Nome</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-{{ $user->ativo ? 'check' : 'times' }}"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $user->ativo ? 'Ativo' : 'Inativo' }}</h4>
                        <p class="text-muted mb-0">Status</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                        <i class="fas fa-{{ $user->master ? 'crown' : 'user' }}"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $user->master ? 'Master' : 'Regular' }}</h4>
                        <p class="text-muted mb-0">Tipo de Usuário</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</h4>
                        <p class="text-muted mb-0">Membro desde</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Informações -->
    <div class="card-custom">
        <div class="card-body">
            <div class="row g-4">
                <!-- Nome -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-user text-primary me-2"></i>
                            Nome Completo
                        </label>
                        <div class="info-value">{{ $user->nome }}</div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            E-mail
                        </label>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                </div>

                <!-- Tipo de Usuário -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-crown text-primary me-2"></i>
                            Tipo de Usuário
                        </label>
                        <div class="info-value">
                            @if($user->master)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-crown me-1"></i>
                                    Master
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="fas fa-user me-1"></i>
                                    Regular
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-toggle-on text-primary me-2"></i>
                            Status
                        </label>
                        <div class="info-value">
                            @if($user->ativo)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Ativo
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Inativo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Último Acesso -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-clock text-primary me-2"></i>
                            Último Acesso
                        </label>
                        <div class="info-value">
                            @if($user->last_acess)
                                {{ \Carbon\Carbon::parse($user->last_acess)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Nunca acessou</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Redefinir Senha -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-key text-primary me-2"></i>
                            Redefinir Senha no Login
                        </label>
                        <div class="info-value">
                            @if($user->redefinir_senha_login)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Sim
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>
                                    Não
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Data de Criação -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-calendar-plus text-primary me-2"></i>
                            Membro desde
                        </label>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- Última Atualização -->
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="info-label">
                            <i class="fas fa-edit text-primary me-2"></i>
                            Última Atualização
                        </label>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Aplicando CSS completo no padrão da tela de clientes */
    body {
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    .card-custom {
        background: white;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.15s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .product-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .product-avatar {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .info-group {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1rem;
        border-left: 3px solid #3b82f6;
        transition: all 0.3s ease;
    }

    .info-group:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
    }

    .text-primary {
        color: #3b82f6 !important;
    }

    @media (max-width: 768px) {
        .info-group {
            padding: 0.75rem;
        }
        
        .info-label {
            font-size: 0.8rem;
        }
        
        .info-value {
            font-size: 0.9rem;
        }
        
        .product-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>
@endpush
