@extends('layouts.app')

@section('title', 'Detalhes do Cliente - BarberShop Pro')
@section('page-title', 'Detalhes do Cliente')
@section('page-subtitle', 'Informações completas e histórico')

@section('content')
<div class="container-fluid">
    <!-- Header do Cliente -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="client-avatar me-4">
                    {{ strtoupper(substr($cliente->nome, 0, 2)) }}
                </div>
                <div>
                    <h1 class="mb-1 client-name">{{ $cliente->nome }}</h1>
                    <div class="client-info">
                        <span class="badge bg-{{ $cliente->ativo ? 'success' : 'danger' }} me-2">
                            {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                        <span class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Cliente desde {{ $cliente->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>
                Voltar
            </a>
           
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $totalAgendamentos }}</h3>
                    <p>Total de Agendamentos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $agendamentosFinalizados }}</h3>
                    <p>Concluídos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stats-content">
                    <h3>R$ {{ number_format($valorTotalGasto, 2, ',', '.') }}</h3>
                    <p>Total Gasto</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon bg-info">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $filiaisMaisFrequentadas->count() }}</h3>
                    <p>Filiais Visitadas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Informações do Cliente -->
        <div class="col-lg-4">
            <div class="detail-card">
                <div class="card-header">
                    <h5><i class="fas fa-user me-2"></i>Informações Pessoais</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label>CPF:</label>
                        <span>{{ $cliente->cpf ?: 'Não informado' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span>{{ $cliente->email ?: 'Não informado' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Telefone 1:</label>
                        <span>{{ $cliente->telefone1 ?: 'Não informado' }}</span>
                    </div>
                    @if($cliente->telefone2)
                    <div class="info-item">
                        <label>Telefone 2:</label>
                        <span>{{ $cliente->telefone2 }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <label>Sexo:</label>
                        <span>{{ $cliente->sexo == 'M' ? 'Masculino' : 'Feminino' }}</span>
                    </div>
                    @if($cliente->data_nascimento)
                    <div class="info-item">
                        <label>Data de Nascimento:</label>
                        <span>{{ \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    @if($cliente->endereco)
                    <div class="info-item">
                        <label>Endereço:</label>
                        <span>{{ $cliente->endereco }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Filiais Mais Frequentadas -->
            @if($filiaisMaisFrequentadas->count() > 0)
            <div class="detail-card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-map-marker-alt me-2"></i>Filiais Frequentadas</h5>
                </div>
                <div class="card-body">
                    @foreach($filiaisMaisFrequentadas as $filial)
                    <div class="filial-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{ $filial->nome }}</h6>
                                <small class="text-muted">{{ $filial->endereco }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $filial->quantidade }}x</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Timeline de Agendamentos -->
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="card-header">
                    <h5><i class="fas fa-history me-2"></i>Timeline de Agendamentos</h5>
                </div>
                <div class="card-body">
                    @if($agendamentos->count() > 0)
                    <div class="timeline">
                        @foreach($agendamentos as $agendamento)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $agendamento->status == 'concluido' ? 'success' : ($agendamento->status == 'cancelado' ? 'danger' : 'warning') }}">
                                <i class="fas fa-{{ $agendamento->status == 'concluido' ? 'check' : ($agendamento->status == 'cancelado' ? 'times' : 'clock') }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <h6>{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y') }} - {{ $agendamento->hora_inicio }}</h6>
                                    <span class="badge bg-{{ $agendamento->status == 'concluido' ? 'success' : ($agendamento->status == 'cancelado' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($agendamento->status) }}
                                    </span>
                                </div>
                                <div class="timeline-body">
                                    <p><strong>Filial:</strong> {{ $agendamento->filial_nome }}</p>
                                    @if($agendamento->barbeiro_nome)
                                    <p><strong>Barbeiro:</strong> {{ $agendamento->barbeiro_nome }}</p>
                                    @endif
                                    <!-- Corrigindo acesso aos produtos e serviços do agendamento -->
                                    @if($agendamento->produtos_nomes)
                                    <p><strong>Produtos:</strong> {{ $agendamento->produtos_nomes }}</p>
                                    @endif
                                    @if($agendamento->servicos_nomes)
                                    <p><strong>Serviços:</strong> {{ $agendamento->servicos_nomes }}</p>
                                    @endif
                                    @if($agendamento->valor_total)
                                    <p><strong>Valor:</strong> R$ {{ number_format($agendamento->valor_total, 2, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum agendamento encontrado</h5>
                        <p class="text-muted">Este cliente ainda não possui agendamentos.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Mais Comprados -->
    <div class="row g-4 mt-4">
        @if($produtosMaisComprados->count() > 0)
        <div class="col-lg-12">
            <div class="detail-card">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-bag me-2"></i>Produtos Mais Comprados</h5>
                </div>
                <div class="card-body">
                    @foreach($produtosMaisComprados as $produto)
                    <div class="product-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{ $produto->nome }}</h6>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary">{{ $produto->quantidade }}x</span>
                                <div class="text-muted small">R$ {{ number_format($produto->total_gasto, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .client-avatar {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2rem;
        box-shadow: 0 8px 32px rgba(96, 165, 250, 0.3);
    }

    .client-name {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0;
    }

    .client-info {
        color: var(--text-muted);
        font-size: 1.1rem;
    }

    .stats-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(96, 165, 250, 0.5);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .stats-content h3 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .stats-content p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
    }

    .detail-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(96, 165, 250, 0.3);
    }

    .detail-card .card-header {
        background: var(--card-header-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
        border-radius: 14px 14px 0 0;
    }

    .detail-card .card-header h5 {
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
    }

    .detail-card .card-body {
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item label {
        color: var(--text-muted);
        font-weight: 600;
        margin: 0;
    }

    .info-item span {
        color: var(--text-primary);
        font-weight: 500;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--border-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0.5rem;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
        z-index: 1;
    }

    .timeline-content {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-left: 1rem;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .timeline-header h6 {
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
    }

    .timeline-body p {
        color: var(--text-primary);
        margin: 0.5rem 0;
        font-size: 0.9rem;
    }

    .timeline-body strong {
        color: var(--text-muted);
    }

    .product-item, .filial-item {
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .product-item:last-child, .filial-item:last-child {
        border-bottom: none;
    }

    .product-item h6, .filial-item h6 {
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
    }

    .btn-primary-custom {
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(45deg, #2563eb, #3b82f6);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #6b7280;
        color: #6b7280;
        background: var(--card-bg);
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: rgba(107, 114, 128, 0.1);
        border-color: #4b5563;
        color: #4b5563;
    }

    .bg-primary { background: linear-gradient(45deg, #3b82f6, #60a5fa) !important; }
    .bg-success { background: linear-gradient(45deg, #10b981, #34d399) !important; }
    .bg-warning { background: linear-gradient(45deg, #f59e0b, #fbbf24) !important; }
    .bg-info { background: linear-gradient(45deg, #06b6d4, #67e8f9) !important; }
    .bg-danger { background: linear-gradient(45deg, #ef4444, #f87171) !important; }

    h1, h2, h3, h4, h5, h6, p {
        color: var(--text-primary) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
    }

    @media (max-width: 768px) {
        .client-name {
            font-size: 2rem;
        }
        
        .client-avatar {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .stats-card {
            padding: 1.5rem;
        }
        
        .timeline {
            padding-left: 1.5rem;
        }
        
        .timeline-marker {
            left: -1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function editarCliente(id) {
        window.location.href = `/clientes/${id}/edit`;
    }
</script>
@endpush
@endsection
