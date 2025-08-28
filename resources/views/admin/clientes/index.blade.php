@extends('layouts.app')

@section('title', 'Clientes - BarberShop Pro')
@section('page-title', 'Clientes')
@section('page-subtitle', 'Gerenciamento de clientes da barbearia')

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    /* Removendo todos os estilos de validação do Bootstrap */
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

    .btn-outline-primary {
        border-color: #60a5fa;
        color: #60a5fa;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .btn-outline-info {
        border-color: #06b6d4;
        color: #06b6d4;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        background: rgba(6, 182, 212, 0.1);
        border-color: #0891b2;
        color: #0891b2;
    }

    .btn-outline-danger {
        border-color: #ef4444;
        color: #ef4444;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #dc2626;
        color: #dc2626;
    }

    .client-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
    }

    .client-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .client-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(45deg, #60a5fa, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .client-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
    }

    .client-info p {
        margin: 0;
        font-size: 0.85rem;
        color: #6b7280;
    }

    .badge-tipo {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .badge-masculino { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .badge-feminino { background: rgba(236, 72, 153, 0.1); color: #ec4899; }

    .status-ativo { color: #10b981; }
    .status-inativo { color: #ef4444; }

    .table {
        background: transparent;
        color: #1f2937;
    }

    .table th {
        border-bottom: 2px solid rgba(59, 130, 246, 0.2);
        font-weight: 600;
        padding: 1rem 0.75rem;
    }

    .table td {
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .pagination-info {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
    }

    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .per-page-selector select {
        width: auto;
        min-width: 80px;
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 6px;
        padding: 0.5rem;
        color: #1f2937;
    }

    .pagination-wrapper {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        margin-top: 1.5rem;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
    }

    /* Corrigindo CSS da paginação Laravel */
    .pagination {
        margin: 0;
        justify-content: center;
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .page-item {
        margin: 0;
    }

    .page-link {
        color: #3b82f6 !important;
        border: 1px solid rgba(59, 130, 246, 0.2) !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 6px !important;
        transition: all 0.3s ease !important;
        background: white !important;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
    }

    .page-link:hover {
        background: rgba(59, 130, 246, 0.1) !important;
        color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        text-decoration: none !important;
    }

    .page-item.active .page-link {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }

    .page-item.disabled .page-link {
        color: #6b7280 !important;
        background: rgba(248, 250, 252, 0.5) !important;
        border-color: rgba(59, 130, 246, 0.1) !important;
        cursor: not-allowed !important;
    }

    /* Melhorando responsividade da paginação */
    @media (max-width: 768px) {
        .pagination {
            gap: 0.125rem;
        }
        
        .page-link {
            padding: 0.375rem 0.5rem !important;
            min-width: 35px;
            height: 35px;
            font-size: 0.875rem;
        }
    }

    .results-info {
        color: #1f2937;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .pagination-controls {
            flex-direction: column;
            align-items: stretch;
        }
        
        .per-page-selector {
            justify-content: center;
        }
    }

    #clientModal .form-control:focus,
    #clientModal .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
        outline: none;
    }
    
    #clientModal .form-control:hover,
    #clientModal .form-select:hover {
        border-color: rgba(59, 130, 246, 0.4);
    }
    
    #clientModal .btn:hover {
        transform: translateY(-1px);
    }

    /* Adicionando estilos para validação do Bootstrap */
    .was-validated .form-control:valid,
    .form-control.is-valid {
        border-color: #10b981 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.94-.94 1.38 1.38'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right calc(0.375em + 0.1875rem) center !important;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }

    .was-validated .form-control:invalid,
    .form-control.is-invalid {
        border-color: #ef4444 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4m0-2.4L5.8 7'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right calc(0.375em + 0.1875rem) center !important;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }

    .was-validated .form-select:valid,
    .form-select.is-valid {
        border-color: #10b981 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.94-.94 1.38 1.38'/%3e%3c/svg%3e") !important;
        background-position: right 0.75rem center, center right 2.25rem !important;
        background-size: 16px 12px, calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }

    .was-validated .form-select:invalid,
    .form-select.is-invalid {
        border-color: #ef4444 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4m0-2.4L5.8 7'/%3e%3c/svg%3e") !important;
        background-position: right 0.75rem center, center right 2.25rem !important;
        background-size: 16px 12px, calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }

    .valid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #10b981;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #ef4444;
    }

    .was-validated .valid-feedback,
    .was-validated .invalid-feedback {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
   

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $total ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Clientes</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $total_ativos ?? 0 }}</h4>
                        <p class="text-muted mb-0">Clientes Ativos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar" style="background: linear-gradient(45deg, #3b82f6, #60a5fa);">
                        <i class="fas fa-mars"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $total_masculino ?? 0 }}</h4>
                        <p class="text-muted mb-0">Masculino</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar" style="background: linear-gradient(45deg, #ec4899, #f472b6);">
                        <i class="fas fa-venus"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $total_feminino ?? 0 }}</h4>
                        <p class="text-muted mb-0">Feminino</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="card-custom mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <!-- Convertendo filtros JavaScript para formulário Laravel backend -->
                    <form method="GET" action="{{ route('clientes.index') }}" class="row g-3" id="filterForm">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar clientes..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="status" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                <option value="">Todos os status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <!-- Manter parâmetro per_page se existir -->
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary-custom" onclick="openModal()">
                        <i class="fas fa-plus me-2"></i>
                        Novo Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Info and Controls -->
    @if(isset($clientes) && $clientes->count() > 0)
    <div class="pagination-info">
        <div class="pagination-controls">
            <div class="results-info" id="resultsInfo">
                <i class="fas fa-info-circle me-1"></i>
                Mostrando <span id="showingFrom">{{ $clientes->firstItem() }}</span> a <span id="showingTo">{{ $clientes->lastItem() }}</span> de <span id="totalResults">{{ $clientes->total() }}</span> resultados
            </div>
            
            <div class="per-page-selector">
                <label for="perPage" class="form-label mb-0" style="color: #1f2937;">Itens por página:</label>
                <select class="form-select form-select-sm" id="perPage">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>
    </div>
    @endif

    <!-- Clients List -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($clientes) && $clientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="clientsTable">
                        <thead>
                            <tr>
                                <th style="color: #1f2937;">Cliente</th>
                                <th style="color: #1f2937;">Sexo</th>
                                <th style="color: #1f2937;">Contato</th>
                                <th style="color: #1f2937;">Email</th>
                                <th style="color: #1f2937;">Status</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="clientsTableBody">
                            @foreach($clientes as $cliente)
                            <tr data-client-id="{{ $cliente->id }}" 
                                data-nome="{{ strtolower($cliente->nome) }}" 
                                data-email="{{ strtolower($cliente->email ?? '') }}" 
                                data-cpf="{{ $cliente->cpf ?? '' }}" 
                                data-telefone="{{ $cliente->telefone1 ?? '' }} {{ $cliente->telefone2 ?? '' }}" 
                                data-status="{{ $cliente->ativo ? '1' : '0' }}"
                                data-sexo="{{ $cliente->sexo }}"
                                data-data-nascimento="{{ $cliente->data_nascimento }}"
                                data-telefone1="{{ $cliente->telefone1 }}"
                                data-telefone2="{{ $cliente->telefone2 }}"
                                data-endereco="{{ $cliente->endereco }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="client-avatar me-3">
                                            {{ strtoupper(substr($cliente->nome, 0, 2)) }}
                                        </div>
                                        <div class="client-info">
                                            <h6>{{ $cliente->nome }}</h6>
                                            @if($cliente->cpf)
                                                <p>{{ $cliente->cpf }}</p>
                                            @endif
                                            @if($cliente->data_nascimento)
                                                <p>{{ \Carbon\Carbon::parse($cliente->data_nascimento)->age }} anos</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-tipo badge-{{ $cliente->sexo == 'M' ? 'masculino' : 'feminino' }}">
                                        {{ $cliente->sexo == 'M' ? 'Masculino' : 'Feminino' }}
                                    </span>
                                </td>
                                <td>
                                    @if($cliente->telefone1)
                                        <div><i class="fas fa-mobile-alt me-1"></i> {{ $cliente->telefone1 }}</div>
                                    @endif
                                    @if($cliente->telefone2)
                                        <div><i class="fas fa-phone me-1"></i> {{ $cliente->telefone2 }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente->email)
                                        <a href="mailto:{{ $cliente->email }}" style="color: #3b82f6;">{{ $cliente->email }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $cliente->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewClient({{ $cliente->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editClient({{ $cliente->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $cliente->id }}, '{{ $cliente->nome }}')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Removendo paginação JavaScript e usando Laravel -->
                <!-- Aplicando estilos corretos na seção de paginação -->
                <div class="pagination-wrapper">
                    <div class="pagination-controls">
                        <div class="results-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Mostrando {{ $clientes->firstItem() ?? 0 }} a {{ $clientes->lastItem() ?? 0 }} de {{ $clientes->total() }} resultados
                        </div>
                        <div>
                            {{ $clientes->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x mb-3" style="color: #6b7280;"></i>
                    <h5 style="color: #6b7280;">Nenhum cliente encontrado</h5>
                    <p style="color: #6b7280;">Comece cadastrando o primeiro cliente da barbearia.</p>
                    <button type="button" class="btn btn-primary-custom" onclick="openModal()">
                        <i class="fas fa-plus me-2"></i>
                        Cadastrar Primeiro Cliente
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal simplificado para Laravel normal -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: white; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);">
                <h5 class="modal-title" id="clientModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-user-plus me-2" style="color: #60a5fa;"></i>
                    Novo Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white;">
                <!-- Adicionando classe needs-validation ao formulário -->
                <!-- Removendo classe needs-validation do formulário -->
                <form action="{{ route('clientes.store') }}" method="POST" id="clientForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nome" class="form-label" style="color: #374151; font-weight: 500;">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação -->
                            <!-- Removendo divs de feedback de validação -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label" style="color: #374151; font-weight: 500;">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="14" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação para CPF -->
                            <!-- Removendo divs de feedback de validação para CPF -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label" style="color: #374151; font-weight: 500;">Email</label>
                            <input type="email" class="form-control" id="email" name="email" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação para email -->
                            <!-- Removendo divs de feedback de validação para email -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label" style="color: #374151; font-weight: 500;">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexo" class="form-label" style="color: #374151; font-weight: 500;">Sexo *</label>
                            <select class="form-select" id="sexo" name="sexo" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <!-- Adicionando feedback de validação para sexo -->
                            <!-- Removendo divs de feedback de validação para sexo -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <!-- Removido required e asterisco do telefone1 -->
                            <label for="telefone1" class="form-label" style="color: #374151; font-weight: 500;">Telefone 1</label>
                            <input type="text" class="form-control" id="telefone1" name="telefone1" maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone2" class="form-label" style="color: #374151; font-weight: 500;">Telefone 2</label>
                            <input type="text" class="form-control" id="telefone2" name="telefone2" maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <!-- Removido required e asterisco do endereço -->
                        <label for="endereco" class="form-label" style="color: #374151; font-weight: 500;">Endereço</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; resize: vertical;"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1); max-width: 100%; overflow: hidden;">
                            <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="ativo" name="ativo" value="1" checked style="border: 2px solid rgba(59, 130, 246, 0.3); margin-top: 0;">
                            <label class="form-check-label flex-grow-1" for="ativo" style="color: #374151; font-weight: 500; margin-bottom: 0;">
                                <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                Cliente Ativo
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: rgba(59, 130, 246, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="clientForm" class="btn btn-primary-custom">
                    <i class="fas fa-save me-1"></i>
                    Salvar Cliente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar cliente -->
<div class="modal fade" id="viewClientModal" tabindex="-1" aria-labelledby="viewClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: white; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);">
                <h5 class="modal-title" id="viewClientModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-eye me-2" style="color: #60a5fa;"></i>
                    Visualizar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white;">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex align-items-center mb-4">
                            <div class="client-avatar me-3" id="viewClientAvatar" style="width: 80px; height: 80px; font-size: 2rem;">
                                <!-- Avatar será preenchido via JavaScript -->
                            </div>
                            <div>
                                <h4 class="mb-0" id="viewClientName" style="color: #1f2937;"></h4>
                                <p class="mb-0 text-muted" id="viewClientAge"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">CPF:</label>
                        <p class="mb-0" id="viewClientCpf" style="color: #1f2937;"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Email:</label>
                        <p class="mb-0" id="viewClientEmail" style="color: #1f2937;"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Data de Nascimento:</label>
                        <p class="mb-0" id="viewClientBirth" style="color: #1f2937;"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Sexo:</label>
                        <p class="mb-0" id="viewClientSex" style="color: #1f2937;"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Telefone 1:</label>
                        <p class="mb-0" id="viewClientPhone1" style="color: #1f2937;"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Telefone 2:</label>
                        <p class="mb-0" id="viewClientPhone2" style="color: #1f2937;"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: #374151; font-weight: 600;">Endereço:</label>
                    <p class="mb-0" id="viewClientAddress" style="color: #1f2937;"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: #374151; font-weight: 600;">Status:</label>
                    <p class="mb-0" id="viewClientStatus" style="color: #1f2937;"></p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: rgba(59, 130, 246, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar cliente -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: white; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);">
                <h5 class="modal-title" id="editClientModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-edit me-2" style="color: #60a5fa;"></i>
                    Editar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white;">
                <!-- Adicionando classe needs-validation ao formulário de edição -->
                <!-- Removendo classe needs-validation do formulário de edição -->
                <form method="POST" id="editClientForm">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_nome" class="form-label" style="color: #374151; font-weight: 500;">Nome *</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação -->
                            <!-- Removendo divs de feedback de validação -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_cpf" class="form-label" style="color: #374151; font-weight: 500;">CPF *</label>
                            <input type="text" class="form-control" id="edit_cpf" name="cpf" required maxlength="14" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação para CPF -->
                            <!-- Removendo divs de feedback de validação para CPF -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label" style="color: #374151; font-weight: 500;">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                            <!-- Adicionando feedback de validação para email -->
                            <!-- Removendo divs de feedback de validação para email -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_nascimento" class="form-label" style="color: #374151; font-weight: 500;">Data de Nascimento</label>
                            <input type="date" class="form-control" id="edit_data_nascimento" name="data_nascimento" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_sexo" class="form-label" style="color: #374151; font-weight: 500;">Sexo *</label>
                            <select class="form-select" id="edit_sexo" name="sexo" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <!-- Adicionando feedback de validação para sexo -->
                            <!-- Removendo divs de feedback de validação para sexo -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <!-- Removido required e asterisco do telefone1 no modal de edição -->
                            <label for="edit_telefone1" class="form-label" style="color: #374151; font-weight: 500;">Telefone 1</label>
                            <input type="text" class="form-control" id="edit_telefone1" name="telefone1" maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone2" class="form-label" style="color: #374151; font-weight: 500;">Telefone 2</label>
                            <input type="text" class="form-control" id="edit_telefone2" name="telefone2" maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <!-- Removido required e asterisco do endereço no modal de edição -->
                        <label for="edit_endereco" class="form-label" style="color: #374151; font-weight: 500;">Endereço</label>
                        <textarea class="form-control" id="edit_endereco" name="endereco" rows="3" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; resize: vertical;"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1); max-width: 100%; overflow: hidden;">
                            <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="edit_ativo" name="ativo" value="1" style="border: 2px solid rgba(59, 130, 246, 0.3); margin-top: 0;">
                            <label class="form-check-label flex-grow-1" for="edit_ativo" style="color: #374151; font-weight: 500; margin-bottom: 0;">
                                <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                Cliente Ativo
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: rgba(59, 130, 246, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="editClientForm" class="btn btn-primary-custom">
                    <i class="fas fa-save me-1"></i>
                    Atualizar Cliente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar exclusão -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: white; border: 2px solid rgba(239, 68, 68, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(239, 68, 68, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(248, 113, 113, 0.05) 100%);">
                <h5 class="modal-title" id="deleteClientModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444;"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white; text-align: center;">
                <div class="mb-4">
                    <i class="fas fa-user-times fa-3x mb-3" style="color: #ef4444;"></i>
                    <h5 style="color: #1f2937;">Tem certeza que deseja excluir este cliente?</h5>
                    <p class="text-muted mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #dc2626;">
                    <strong>Cliente:</strong> <span id="deleteClientName"></span>
                </div>
                <form method="POST" id="deleteClientForm">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(239, 68, 68, 0.2); padding: 1.5rem; background: rgba(239, 68, 68, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="deleteClientForm" class="btn" style="background: linear-gradient(45deg, #ef4444, #f87171); border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-trash me-1"></i>
                    Excluir Cliente
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
        
        // Mantendo apenas as máscaras e funcionalidades básicas
        document.getElementById('cpf').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.value = value;
        });

        document.getElementById('edit_cpf').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.value = value;
        });

        document.getElementById('telefone1').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3');
            this.value = value;
        });

        document.getElementById('telefone2').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3');
            this.value = value;
        });

        document.getElementById('edit_telefone1').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3');
            this.value = value;
        });

        document.getElementById('edit_telefone2').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3');
            this.value = value;
        });

        document.getElementById('perPage').addEventListener('change', function() {
            const perPage = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('per_page', perPage);
            currentUrl.searchParams.delete('page');
            window.location.href = currentUrl.toString();
        });

        // const searchInput = document.querySelector('input[name="search"]');
        // const statusSelect = document.querySelector('select[name="status"]');
        
        // let searchTimeout;
        // searchInput.addEventListener('input', function() {
        //     clearTimeout(searchTimeout);
        //     searchTimeout = setTimeout(() => {
        //         document.getElementById('filterForm').submit();
        //     }, 500); // Aguarda 500ms após parar de digitar
        // });

        // statusSelect.addEventListener('change', function() {
        //     document.getElementById('filterForm').submit();
        // });

    function openModal() {
        document.getElementById('clientForm').action = "{{ route('clientes.store') }}";
        document.getElementById('clientForm').method = "POST";
        document.getElementById('clientModalLabel').innerHTML = '<i class="fas fa-user-plus me-2" style="color: #60a5fa;"></i>Novo Cliente';
        document.getElementById('clientForm').reset();
        document.getElementById('ativo').checked = true;
        new bootstrap.Modal(document.getElementById('clientModal')).show();
    }

    function applyMasks() {
        const editCpfInput = document.getElementById('edit_cpf');
        const editTelefone1Input = document.getElementById('edit_telefone1');
        const editTelefone2Input = document.getElementById('edit_telefone2');

        if (editCpfInput) {
            let cpfValue = editCpfInput.value.replace(/\D/g, '');
            cpfValue = cpfValue.replace(/(\d{3})(\d)/, '$1.$2');
            cpfValue = cpfValue.replace(/(\d{3})(\d)/, '$1.$2');
            cpfValue = cpfValue.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            editCpfInput.value = cpfValue;
        }

        [editTelefone1Input, editTelefone2Input].forEach(input => {
            if (input && input.value) {
                let value = input.value.replace(/\D/g, '');
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                input.value = value;
            }
        });
    }

    // Máscaras para CPF e telefone
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        const telefone1Input = document.getElementById('telefone1');
        const telefone2Input = document.getElementById('telefone2');

        if (cpfInput) {
            cpfInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                this.value = value;
            });
        }

        [telefone1Input, telefone2Input].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length <= 10) {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace(/(\d{4})(\d)/, '$1-$2');
                    } else {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace (/(\d{5})(\d)/, '$1-$2');
                    }
                    this.value = value;
                });
            }
        });

        const editCpfInput = document.getElementById('edit_cpf');
        const editTelefone1Input = document.getElementById('edit_telefone1');
        const editTelefone2Input = document.getElementById('edit_telefone2');

        if (editCpfInput) {
            editCpfInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                this.value = value;
            });
        }

        [editTelefone1Input, editTelefone2Input].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length <= 10) {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace(/(\d{4})(\d)/, '$1-$2');
                    } else {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace (/(\d{5})(\d)/, '$1-$2');
                    }
                    this.value = value;
                });
            }
        });
    });

    // Funções para os novos modais
    function viewClient(clientId) {
        // Buscar dados do cliente na tabela
        const row = document.querySelector(`tr[data-client-id="${clientId}"]`);
        if (!row) return;

        const nome = row.querySelector('.client-info h6') ? row.querySelector('.client-info h6').textContent : '';
        const cpfElement = row.querySelector('.client-info p');
        const cpf = cpfElement ? cpfElement.textContent : row.dataset.cpf || 'Não informado';
        const avatar = row.querySelector('.client-avatar') ? row.querySelector('.client-avatar').textContent : '';
        const sexo = row.querySelector('.badge-tipo') ? row.querySelector('.badge-tipo').textContent : '';
        const telefones = Array.from(row.querySelectorAll('td:nth-child(3) div')).map(div => div.textContent);
        const emailElement = row.querySelector('td:nth-child(4) a');
        const email = emailElement ? emailElement.textContent : 'Não informado';
        const status = row.querySelector('td:nth-child(5)') ? row.querySelector('td:nth-child(5)').textContent.trim() : '';

        // Preencher modal de visualização
        document.getElementById('viewClientAvatar').textContent = avatar;
        document.getElementById('viewClientName').textContent = nome;
        document.getElementById('viewClientCpf').textContent = cpf;
        document.getElementById('viewClientEmail').textContent = email;
        document.getElementById('viewClientSex').textContent = sexo;
        document.getElementById('viewClientPhone1').textContent = telefones[0] || 'Não informado';
        document.getElementById('viewClientPhone2').textContent = telefones[1] || 'Não informado';
        document.getElementById('viewClientAddress').textContent = row.dataset.endereco || 'Não informado';
        document.getElementById('viewClientBirth').textContent = row.dataset.dataNascimento || 'Não informado';
        document.getElementById('viewClientStatus').textContent = status;

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('viewClientModal')).show();
    }

    function editClient(clientId) {
        const row = document.querySelector(`tr[data-client-id="${clientId}"]`);
        if (row) {
            // Configurar action do formulário
            document.getElementById('editClientForm').action = `/clientes/${clientId}`;
            
            const nome = row.querySelector('.client-info h6') ? row.querySelector('.client-info h6').textContent : '';
            
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_cpf').value = row.dataset.cpf || '';
            document.getElementById('edit_email').value = row.dataset.email || '';
            document.getElementById('edit_data_nascimento').value = row.dataset.dataNascimento || '';
            document.getElementById('edit_sexo').value = row.dataset.sexo || '';
            document.getElementById('edit_telefone1').value = row.dataset.telefone1 || '';
            document.getElementById('edit_telefone2').value = row.dataset.telefone2 || '';
            document.getElementById('edit_endereco').value = row.dataset.endereco || '';
            
            // Definir checkbox ativo
            const ativoCheckbox = document.getElementById('edit_ativo');
            ativoCheckbox.checked = row.dataset.status === '1';
            
            // Aplicar máscaras nos campos
            setTimeout(() => {
                applyMasks();
            }, 100);
        }

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('editClientModal')).show();
    }

    function confirmDelete(clientId, clientName) {
        // Configurar action do formulário
        document.getElementById('deleteClientForm').action = `/clientes/${clientId}`;
        
        // Preencher nome do cliente
        document.getElementById('deleteClientName').textContent = clientName;

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('deleteClientModal')).show();
    }

</script>
@endpush
