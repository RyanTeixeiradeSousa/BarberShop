@extends('layouts.app')

@section('title', 'Formas de Pagamento - BarberShop Pro')
@section('page-title', 'Formas de Pagamento')
@section('page-subtitle', 'Gerencie as formas de pagamento aceitas pela barbearia')

@section('content')
<div class="container-fluid">

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $totalFormas ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Formas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $formasAtivas ?? 0 }}</h4>
                        <p class="text-muted mb-0">Formas Ativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $formasInativas ?? 0 }}</h4>
                        <p class="text-muted mb-0">Formas Inativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
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

    <!-- Card de Filtros -->
    <div class="card-custom mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('formas-pagamento.index') }}" class="row g-3" id="filterForm">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar formas de pagamento..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
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
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createFormaPagamentoModal">
                        <i class="fas fa-plus me-2"></i>
                        Nova Forma de Pagamento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($formasPagamento) && $formasPagamento->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $formasPagamento->firstItem() }} a {{ $formasPagamento->lastItem() }} de {{ $formasPagamento->total() }} resultados
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
                </div>

                <!-- Tabela -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: #1f2937;">Forma de Pagamento</th>
                                <th style="color: #1f2937;">Descrição</th>
                                <th style="color: #1f2937;">Status</th>
                                <th style="color: #1f2937;">Movimentações</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formasPagamento as $forma)
                            <tr data-id="{{ $forma->id }}" 
                                data-nome="{{ $forma->nome }}" 
                                data-descricao="{{ $forma->descricao }}" 
                                data-ativo="{{ $forma->ativo ? '1' : '0' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $forma->nome }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($forma->descricao)
                                        {{ Str::limit($forma->descricao, 50) }}
                                    @else
                                        <span class="text-muted">Sem descrição</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $forma->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $forma->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $forma->movimentacoes_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewFormaPagamento(this)" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFormaPagamento(this)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteFormaPagamento({{ $forma->id }}, '{{ $forma->nome }}')" title="Excluir">
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
                    <div class="pagination-controls">
                        <div class="results-info">
                            Mostrando {{ $formasPagamento->firstItem() }} a {{ $formasPagamento->lastItem() }} de {{ $formasPagamento->total() }} resultados
                        </div>
                        {{ $formasPagamento->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma forma de pagamento encontrada</h5>
                    <p class="text-muted">Cadastre a primeira forma de pagamento para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#createFormaPagamentoModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Forma
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="viewFormaPagamentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualizar Forma de Pagamento</h5>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="createFormaPagamentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('formas-pagamento.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Forma de Pagamento</h5>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="create-ativo" name="ativo" value="1" checked>
                            <label class="form-check-label" for="create-ativo">
                                Forma de Pagamento Ativa
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
<div class="modal fade" id="editFormaPagamentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editFormaPagamentoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Forma de Pagamento</h5>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit-ativo" name="ativo" value="1">
                            <label class="form-check-label" for="edit-ativo">
                                Forma de Pagamento Ativa
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
<div class="modal fade" id="deleteFormaPagamentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteFormaPagamentoForm" method="POST">
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
                    <p>Tem certeza que deseja excluir a forma de pagamento <strong id="delete-forma-nome"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

    .product-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
    }

    .product-info p {
        margin: 0;
        font-size: 0.85rem;
        color: #6b7280;
    }

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

    .pagination-wrapper {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        margin-top: 1.5rem;
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
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit dos filtros
    document.querySelector('input[name="busca"]').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    document.querySelector('select[name="status"]').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    // Seletor de itens por página
    document.getElementById('perPage').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Função para visualizar forma de pagamento
    function viewFormaPagamento(button) {
        const row = button.closest('tr');
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;
        const ativo = row.dataset.ativo;

        document.getElementById('view-nome').textContent = nome;
        document.getElementById('view-descricao').textContent = descricao || 'Sem descrição';
        document.getElementById('view-status').innerHTML = ativo == '1' 
            ? '<i class="fas fa-circle status-ativo"></i> Ativo' 
            : '<i class="fas fa-circle status-inativo"></i> Inativo';

        new bootstrap.Modal(document.getElementById('viewFormaPagamentoModal')).show();
    }

    // Função para editar forma de pagamento
    function editFormaPagamento(button) {
        const row = button.closest('tr');
        const id = row.dataset.id;
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;
        const ativo = row.dataset.ativo;

        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-descricao').value = descricao;
        document.getElementById('edit-ativo').checked = ativo == '1';

        const form = document.getElementById('editFormaPagamentoForm');
        form.action = `/admin/formas-pagamento/${id}`;

        new bootstrap.Modal(document.getElementById('editFormaPagamentoModal')).show();
    }

    // Função para excluir forma de pagamento
    function deleteFormaPagamento(id, nome) {
        document.getElementById('delete-forma-nome').textContent = nome;
        
        const form = document.getElementById('deleteFormaPagamentoForm');
        form.action = `/admin/formas-pagamento/${id}`;

        new bootstrap.Modal(document.getElementById('deleteFormaPagamentoModal')).show();
    }
</script>
@endpush

@endsection
