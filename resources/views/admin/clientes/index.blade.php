@extends('layouts.app')

@section('title', 'Clientes - BarberShop Pro')
@section('page-title', 'Clientes')
@section('page-subtitle', 'Gerenciamento de clientes da barbearia')

@push('styles')
<style>
    .card-custom {
        background: white;
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 2px solid rgba(59, 130, 246, 0.2);
        transition: all 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .card-custom .card-body {
        padding: 1.5rem;
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
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 2px solid rgba(59, 130, 246, 0.2);
    }

    .client-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
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
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 2px solid rgba(59, 130, 246, 0.2);
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
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-top: 1.5rem;
        border: 2px solid rgba(59, 130, 246, 0.2);
    }

    .pagination {
        margin: 0;
        justify-content: center;
    }

    .page-link {
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
        background: white;
    }

    .page-link:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-color: #3b82f6;
    }

    .page-item.active .page-link {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6b7280;
        background: rgba(248, 250, 252, 0.5);
        border-color: rgba(59, 130, 246, 0.1);
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
</style>
@endpush

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-users me-2" style="color: #60a5fa;"></i>
                Clientes
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie os clientes da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="#" onclick="openModal()" class="btn btn-primary-custom">
                <i class="fas fa-plus me-1"></i>
                Novo Cliente
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
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
                        <h4 class="mb-0">{{ $stats['ativos'] ?? 0 }}</h4>
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
                        <h4 class="mb-0">{{ $stats['masculino'] ?? 0 }}</h4>
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
                        <h4 class="mb-0">{{ $stats['feminino'] ?? 0 }}</h4>
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
                    <form method="GET" class="row g-3" id="filterForm">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search" placeholder="Buscar clientes..." value="{{ request('search') }}" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="status" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                <option value="">Todos os status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <!-- Campo oculto para manter o per_page -->
                        <input type="hidden" name="per_page" value="{{ request('per_page', 15) }}">
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <a href="#" onclick="openModal()" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>
                        Novo Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Info and Controls -->
    @if(isset($clientes) && $clientes->count() > 0)
    <div class="pagination-info">
        <div class="pagination-controls">
            <div class="results-info">
                <i class="fas fa-info-circle me-1"></i>
                Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
            </div>
            
            <div class="per-page-selector">
                <label for="perPage" class="form-label mb-0" style="color: #1f2937;">Itens por página:</label>
                <select class="form-select form-select-sm" id="perPage" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
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
                    <table class="table table-hover">
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
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr>
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
                                        <button class="btn btn-sm btn-outline-info" onclick="viewClient({{ $cliente->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="editClient({{ $cliente->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteClient({{ $cliente->id }})" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x mb-3" style="color: #6b7280;"></i>
                    <h5 style="color: #6b7280;">Nenhum cliente encontrado</h5>
                    <p style="color: #6b7280;">Comece cadastrando o primeiro cliente da barbearia.</p>
                    <a href="#" onclick="openModal()" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>
                        Cadastrar Primeiro Cliente
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Pagination -->
    @if(isset($clientes) && $clientes->hasPages())
    <div class="pagination-wrapper">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="results-info mb-2 mb-md-0" style="color: #1f2937;">
                <strong>{{ $clientes->total() }}</strong> clientes encontrados
            </div>
            
            <nav aria-label="Navegação de páginas">
                {{ $clientes->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
            
            <div class="page-info mb-2 mb-md-0" style="color: #1f2937;">
                Página <strong>{{ $clientes->currentPage() }}</strong> de <strong>{{ $clientes->lastPage() }}</strong>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal para Criar/Editar Cliente -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: white; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);">
                <h5 class="modal-title" id="clientModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-user-plus me-2" style="color: #60a5fa;"></i>
                    Novo Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: rgba(59, 130, 246, 0.1); border-radius: 50%; padding: 0.5rem; opacity: 0.8;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white;">
                <form id="clientForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nome" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="14" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Data de Nascimento *</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexo" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Sexo *</label>
                            <select class="form-select" id="sexo" name="sexo" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefone1" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Telefone 1 *</label>
                            <input type="text" class="form-control" id="telefone1" name="telefone1" required maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone2" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Telefone 2</label>
                            <input type="text" class="form-control" id="telefone2" name="telefone2" maxlength="15" style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label" style="color: #374151; font-weight: 500; margin-bottom: 0.5rem;">Endereço *</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3" required style="background: white; border: 2px solid rgba(59, 130, 246, 0.2); color: #1f2937; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease; resize: vertical;"></textarea>
                    </div>
                    <div class="mb-3">
                        <!-- Corrigindo layout do checkbox Cliente Ativo para não estourar da div pai -->
                        <div class="d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1); max-width: 100%; overflow: hidden;">
                            <input type="checkbox" class="form-check-input mr-5 flex-shrink-0" id="ativo" name="ativo" value="1" checked style="border: 2px solid rgba(59, 130, 246, 0.3); margin-top: 0;">
                            <label class="form-check-label flex-grow-1" for="ativo" style="color: #374151; font-weight: 500; margin-bottom: 0;">
                                Cliente Ativo
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; background: rgba(59, 130, 246, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary-custom" onclick="saveClient()">
                    <i class="fas fa-save me-1"></i>
                    Salvar Cliente
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentClientId = null;

    // Auto-submit form on filter change
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Function to change items per page
    function changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page'); // Reset to first page
        window.location.href = url.toString();
    }

    function openModal() {
        currentClientId = null;
        document.getElementById('clientModalLabel').textContent = 'Novo Cliente';
        document.getElementById('clientForm').reset();
        document.getElementById('ativo').checked = true;
        new bootstrap.Modal(document.getElementById('clientModal')).show();
    }

    function editClient(id) {
        currentClientId = id;
        document.getElementById('clientModalLabel').textContent = 'Editar Cliente';
        
        // Aqui você faria uma requisição AJAX para buscar os dados do cliente
        // Por enquanto, apenas abre o modal
        new bootstrap.Modal(document.getElementById('clientModal')).show();
    }

    function viewClient(id) {
        // Implementar visualização do cliente
        alert('Visualizar cliente ID: ' + id);
    }

    function deleteClient(id) {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            // Implementar exclusão do cliente
            alert('Excluir cliente ID: ' + id);
        }
    }

    function saveClient() {
        // Implementar salvamento do cliente
        const formData = new FormData(document.getElementById('clientForm'));
        console.log('Salvando cliente...', Object.fromEntries(formData));
        
        // Fechar modal após salvar
        bootstrap.Modal.getInstance(document.getElementById('clientModal')).hide();
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
                        value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    }
                    this.value = value;
                });
            }
        });
    });

    // Smooth scroll to top when changing pages
    if (window.location.search.includes('page=')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endpush
