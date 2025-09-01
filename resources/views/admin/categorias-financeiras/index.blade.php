@extends('layouts.app')

@section('title', 'Categorias Financeiras - BarberShop Pro')
@section('page-title', 'Categorias Financeiras')
@section('page-subtitle', 'Gerencie as categorias para organizar suas movimentações financeiras')

@push('styles')
<style>
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
        background: rgba(96, 165, 250, 0.1);
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
        border-color: #f87171;
        color: #f87171;
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
    }

    .form-control, .form-select {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #1f2937;
        border-radius: 8px;
        transition: all 0.15s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .modal-content {
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .modal-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 51, 234, 0.05));
        border-bottom: 2px solid rgba(59, 130, 246, 0.1);
        border-radius: 10px 10px 0 0;
    }

    .badge-tipo {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-box me-2" style="color: #60a5fa;"></i>
                Categorias Financeiras
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie suas categorias financeiras da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createCategoriaFinanceiraModal">
                <i class="fas fa-plus me-1"></i>
                Nova Categoria
            </button>
        </div>
    </div>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $totalCategorias }}</h4>
                        <p class="text-muted mb-0">Total de Categorias</p>
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
                        <h4 class="mb-0">{{ $categoriasAtivas }}</h4>
                        <p class="text-muted mb-0">Categorias Ativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-pause"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $categoriasInativas }}</h4>
                        <p class="text-muted mb-0">Categorias Inativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="client-card">
                <div class="d-flex align-items-center">
                    <div class="client-avatar" style="background: linear-gradient(45deg, #06b6d4, #0891b2);">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $movimentacoesVinculadas ?? 0 }}</h4>
                        <p class="text-muted mb-0">Mov. Vinculadas</p>
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
                    <form method="GET" action="{{ route('categorias-financeiras.index') }}" class="row g-3" id="filterForm">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar categorias..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-2">
                            <a href="{{ route('categorias-financeiras.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createCategoriaFinanceiraModal">
                        <i class="fas fa-plus me-2"></i>
                        Nova Categoria
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Info and Controls -->
    @if(isset($categorias) && $categorias->count() > 0)
    <div class="pagination-info">
        <div class="pagination-controls">
            <div class="results-info" id="resultsInfo">
                <i class="fas fa-info-circle me-1"></i>
                Mostrando <span id="showingFrom">{{ $categorias->firstItem() }}</span> a <span id="showingTo">{{ $categorias->lastItem() }}</span> de <span id="totalResults">{{ $categorias->total() }}</span> resultados
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

    <!-- Categories List -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($categorias) && $categorias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: #1f2937;">Nome</th>
                                <th style="color: #1f2937;">Descrição</th>
                                <th style="color: #1f2937;">Tipo</th>
                                <th style="color: #1f2937;">Status</th>
                                <th style="color: #1f2937;">Movimentações</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr data-id="{{ $categoria->id }}" 
                                data-nome="{{ $categoria->nome }}" 
                                data-descricao="{{ $categoria->descricao }}" 
                                data-tipo="{{ $categoria->tipo }}"
                                data-ativo="{{ $categoria->ativo }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="client-avatar me-3">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $categoria->nome }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($categoria->descricao, 50) ?: 'Sem descrição' }}</td>
                                <td>
                                    @if($categoria->tipo === 'entrada')
                                        <span class="badge bg-success">Entrada</span>
                                    @elseif($categoria->tipo === 'saida')
                                        <span class="badge bg-danger">Saída</span>
                                    @else
                                        <span class="badge bg-info">Ambos</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $categoria->ativo ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $categoria->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $categoria->movimentacoes_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                                onclick="viewCategoriaFinanceira(this)" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                onclick="editCategoriaFinanceira(this)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteCategoriaFinanceira({{ $categoria->id }}, '{{ $categoria->nome }}')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="pagination-wrapper">
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Mostrando {{ $categorias->firstItem() ?? 0 }} a {{ $categorias->lastItem() ?? 0 }} de {{ $categorias->total() }} resultados
                        </div>
                        {{ $categorias->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma categoria encontrada</h5>
                    <p class="text-muted">Cadastre a primeira categoria financeira para começar.</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createCategoriaFinanceiraModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Categoria
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="viewCategoriaFinanceiraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualizar Categoria Financeira</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nome:</strong>
                        <p id="view-nome"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="view-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Descrição:</strong>
                        <p id="view-descricao"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Tipo:</strong>
                        <p id="view-tipo"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="createCategoriaFinanceiraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categorias-financeiras.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Categoria Financeira</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create-nome" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="create-nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="create-descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create-tipo" class="form-label">Tipo *</label>
                        <select class="form-select" id="create-tipo" name="tipo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                            <option value="ambos">Ambos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="create-ativo" name="ativo" value="1" checked>
                            <label class="form-check-label" for="create-ativo">
                                Categoria Ativa
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editCategoriaFinanceiraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCategoriaFinanceiraForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Categoria Financeira</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-nome" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="edit-nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit-descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tipo" class="form-label">Tipo *</label>
                        <select class="form-select" id="edit-tipo" name="tipo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                            <option value="ambos">Ambos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit-ativo" name="ativo" value="1">
                            <label class="form-check-label" for="edit-ativo">
                                Categoria Ativa
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div class="modal fade" id="deleteCategoriaFinanceiraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteCategoriaFinanceiraForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                    </div>
                    <p>Tem certeza que deseja excluir a categoria <strong id="delete-categoria-nome"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit dos filtros
    // document.querySelector('input[name="busca"]').addEventListener('input', function() {
    //     clearTimeout(this.searchTimeout);
    //     this.searchTimeout = setTimeout(() => {
    //         document.getElementById('filterForm').submit();
    //     }, 500);
    // });

    // document.querySelector('select[name="status"]').addEventListener('change', function() {
    //     document.getElementById('filterForm').submit();
    // });

    // Seletor de itens por página
    const perPageEl = document.getElementById('perPage');

    if (perPageEl) {
        perPageEl.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }

    // Função para visualizar categoria
    function viewCategoriaFinanceira(button) {
        const row = button.closest('tr');
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;
        const tipo = row.dataset.tipo;
        const ativo = row.dataset.ativo;

        document.getElementById('view-nome').textContent = nome;
        document.getElementById('view-descricao').textContent = descricao || 'Sem descrição';
        document.getElementById('view-status').innerHTML = ativo == '1' 
            ? '<span class="badge bg-success">Ativo</span>' 
            : '<span class="badge bg-secondary">Inativo</span>';
        document.getElementById('view-tipo').innerHTML = tipo == 'entrada' 
            ? '<span class="badge bg-success">Entrada</span>' 
            : tipo == 'saida' 
                ? '<span class="badge bg-danger">Saída</span>' 
                : '<span class="badge bg-info">Ambos</span>';

        new bootstrap.Modal(document.getElementById('viewCategoriaFinanceiraModal')).show();
    }

    // Função para editar categoria
    function editCategoriaFinanceira(button) {
        const row = button.closest('tr');
        const id = row.dataset.id;
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;
        const tipo = row.dataset.tipo;
        const ativo = row.dataset.ativo;

        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-descricao').value = descricao;
        document.getElementById('edit-tipo').value = tipo;
        document.getElementById('edit-ativo').checked = ativo == '1';

        const form = document.getElementById('editCategoriaFinanceiraForm');
        form.action = `/admin/categorias-financeiras/${id}`;

        new bootstrap.Modal(document.getElementById('editCategoriaFinanceiraModal')).show();
    }

    // Função para excluir categoria
    function deleteCategoriaFinanceira(id, nome) {
        document.getElementById('delete-categoria-nome').textContent = nome;
        
        const form = document.getElementById('deleteCategoriaFinanceiraForm');
        form.action = `/admin/categorias-financeiras/${id}`;

        new bootstrap.Modal(document.getElementById('deleteCategoriaFinanceiraModal')).show();
    }
</script>
@endpush
@endsection
