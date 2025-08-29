@extends('layouts.app')

@section('title', 'Gerenciar Categorias')

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .container-fluid {
        background: transparent;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 2rem;
        backdrop-filter: blur(10px);
    }

    .page-title-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle {
        color: #64748b;
        margin: 0;
        font-size: 1rem;
    }

    .stats-card {
        background: white;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .stats-content h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #1e40af;
    }

    .stats-content p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .card-custom {
        background: white;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.15s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .card-header-custom {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        padding: 1rem 1.5rem;
        border-radius: 10px 10px 0 0;
    }

    .btn-link-custom {
        color: #1e40af;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        border: none;
        background: none;
        padding: 0;
    }

    .btn-link-custom:hover {
        color: #3b82f6;
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

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-tags me-2" style="color: #60a5fa;"></i>
                Categorias
            </h2>
            <p class="mb-0" style="color: #6b7280;">Organize produtos e serviços por categorias</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarCategoriaModal">
                <i class="fas fa-plus me-1"></i>
                Nova Categoria
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
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
    </div>

    <!-- Card de Filtros -->
    <div class="card-custom mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('categorias.index') }}" class="row g-3" id="filterForm">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar categorias..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="per_page" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                                <option value="25" {{ request('per_page') == 25 || !request('per_page') ? 'selected' : '' }}>25 por página</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarCategoriaModal">
                        <i class="fas fa-plus me-2"></i>
                        Nova Categoria
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if($categorias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: #1f2937;">Categoria</th>
                                <th style="color: #1f2937;">Descrição</th>
                                <th style="color: #1f2937;">Produtos</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr data-id="{{ $categoria->id }}" 
                                data-nome="{{ $categoria->nome }}" 
                                data-descricao="{{ $categoria->descricao }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="client-avatar me-3">
                                            {{ strtoupper(substr($categoria->nome, 0, 2)) }}
                                        </div>
                                        <div class="client-info">
                                            <h6>{{ $categoria->nome }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($categoria->descricao, 50) ?: 'Sem descrição' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $categoria->produtos_count ?? 0 }} produtos</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarCategoria(this)" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarCategoria(this)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $categoria->id }}, '{{ $categoria->nome }}')" title="Excluir">
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
                            <i class="fas fa-info-circle me-1"></i>
                            Mostrando {{ $categorias->firstItem() ?? 0 }} a {{ $categorias->lastItem() ?? 0 }} de {{ $categorias->total() }} resultados
                        </div>
                        <div>
                            {{ $categorias->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x mb-3" style="color: #6b7280;"></i>
                    <h5 style="color: #6b7280;">Nenhuma categoria encontrada</h5>
                    <p style="color: #6b7280;">Comece cadastrando a primeira categoria.</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarCategoriaModal">
                        <i class="fas fa-plus me-2"></i>
                        Cadastrar Primeira Categoria
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Categoria -->
<div class="modal fade" id="criarCategoriaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Nova Categoria
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nome">Nome *</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" 
                                          placeholder="Descrição da categoria..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar Categoria -->
<div class="modal fade" id="visualizarCategoriaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes da Categoria
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="info-group">
                            <label>Nome</label>
                            <p id="view-nome"></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-group">
                            <label>Descrição</label>
                            <p id="view-descricao"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Categoria -->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editarCategoriaForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Editar Categoria
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-nome">Nome *</label>
                                <input type="text" class="form-control" id="edit-nome" name="nome" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-descricao">Descrição</label>
                                <textarea class="form-control" id="edit-descricao" name="descricao" rows="3" 
                                          placeholder="Descrição da categoria..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmar Exclusão -->
<div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Ajustando modal de exclusão para ficar igual ao de clientes -->
        <div class="modal-content" style="background: white; border: 2px solid rgba(239, 68, 68, 0.3); border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(239, 68, 68, 0.2); padding: 1.5rem; background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(248, 113, 113, 0.05) 100%);">
                <h5 class="modal-title" id="confirmarExclusaoModalLabel" style="color: #1f2937; font-weight: 600; font-size: 1.25rem;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444;"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: white; text-align: center;">
                <div class="mb-4">
                    <i class="fas fa-tag fa-3x mb-3" style="color: #ef4444;"></i>
                    <h5 style="color: #1f2937;">Tem certeza que deseja excluir esta categoria?</h5>
                    <p class="text-muted mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #dc2626;">
                    <strong>Categoria:</strong> <span id="categoria-nome-exclusao"></span>
                </div>
                <form method="POST" id="excluirCategoriaForm">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid rgba(239, 68, 68, 0.2); padding: 1.5rem; background: rgba(239, 68, 68, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="excluirCategoriaForm" class="btn" style="background: linear-gradient(45deg, #ef4444, #f87171); border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-trash me-1"></i>
                    Excluir Categoria
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit do filtro de busca
    let buscaTimeout;
    // document.querySelector('input[name="busca"]').addEventListener('input', function() {
    //     clearTimeout(buscaTimeout);
    //     buscaTimeout = setTimeout(() => {
    //         document.getElementById('filterForm').submit();
    //     }, 500);
    // });

    // Seletor de itens por página
    document.querySelector('select[name="per_page"]').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    // Função para visualizar categoria
    function visualizarCategoria(button) {
        const row = button.closest('tr');
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;

        document.getElementById('view-nome').textContent = nome;
        document.getElementById('view-descricao').textContent = descricao || 'Sem descrição';

        new bootstrap.Modal(document.getElementById('visualizarCategoriaModal')).show();
    }

    // Função para editar categoria
    function editarCategoria(button) {
        const row = button.closest('tr');
        const id = row.dataset.id;
        const nome = row.dataset.nome;
        const descricao = row.dataset.descricao;

        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-descricao').value = descricao || '';
        document.getElementById('editarCategoriaForm').action = `/admin/categorias/${id}`;

        new bootstrap.Modal(document.getElementById('editarCategoriaModal')).show();
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('categoria-nome-exclusao').textContent = nome;
        document.getElementById('excluirCategoriaForm').action = `/admin/categorias/${id}`;

        new bootstrap.Modal(document.getElementById('confirmarExclusaoModal')).show();
    }
</script>
@endpush
@endsection
