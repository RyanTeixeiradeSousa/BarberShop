@extends('layouts.app')

@section('title', 'Gerenciar Categorias')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <div class="page-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h1 class="page-title">Gerenciar Categorias</h1>
                    <p class="page-subtitle">Organize produtos e serviços por categorias</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarCategoriaModal">
                <i class="fas fa-plus me-2"></i>Nova Categoria
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $totalCategorias }}</h3>
                    <p>Total de Categorias</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Filtros -->
    <div class="card-custom mb-4">
        <div class="card-header-custom">
            <h5 class="mb-0">
                <button class="btn btn-link-custom" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
                    <i class="fas fa-filter me-2"></i>Filtros
                    <i class="fas fa-chevron-down ms-2"></i>
                </button>
            </h5>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('categorias.index') }}" id="filtrosForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="busca">Buscar Categoria</label>
                                <input type="text" class="form-control" id="busca" name="busca" 
                                       value="{{ request('busca') }}" placeholder="Nome ou descrição...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="per_page">Itens por página</label>
                                <select class="form-control" id="per_page" name="per_page">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary-custom me-2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if($categorias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Produtos</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr data-id="{{ $categoria->id }}" 
                                data-nome="{{ $categoria->nome }}" 
                                data-descricao="{{ $categoria->descricao }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="table-avatar">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $categoria->nome }}</div>
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
                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                                onclick="visualizarCategoria(this)" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                onclick="editarCategoria(this)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                onclick="confirmarExclusao({{ $categoria->id }}, '{{ $categoria->nome }}')" title="Excluir">
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
                <div class="pagination-wrapper mt-4">
                    <div class="pagination-controls">
                        <div class="pagination-info">
                            Mostrando {{ $categorias->firstItem() ?? 0 }} a {{ $categorias->lastItem() ?? 0 }} de {{ $categorias->total() }} resultados
                        </div>
                        {{ $categorias->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3>Nenhuma categoria encontrada</h3>
                    <p>Não há categorias cadastradas ou que correspondam aos filtros aplicados.</p>
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarCategoriaModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Categoria
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

@push('styles')
<style>
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
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    }

    .form-control {
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .table-custom {
        margin: 0;
    }

    .table-custom th {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
        border: none;
        color: #1e40af;
        font-weight: 600;
        padding: 1rem;
    }

    .table-custom td {
        border: none;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .table-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 0.75rem;
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

    .pagination-wrapper {
        background: white;
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1rem;
        backdrop-filter: blur(10px);
    }

    .pagination-controls {
        display: flex;
        justify-content: between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: #64748b;
        font-size: 0.9rem;
    }

    .modal-content {
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .modal-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
    }

    .modal-danger .modal-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(220, 38, 38, 0.05) 100%);
        border-bottom: 1px solid rgba(239, 68, 68, 0.2);
    }

    .info-group {
        margin-bottom: 1rem;
    }

    .info-group label {
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 0.25rem;
        display: block;
    }

    .info-group p {
        margin: 0;
        color: #64748b;
        background: rgba(59, 130, 246, 0.05);
        padding: 0.5rem;
        border-radius: 6px;
        border: 1px solid rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit do filtro de busca
    let buscaTimeout;
    document.getElementById('busca').addEventListener('input', function() {
        clearTimeout(buscaTimeout);
        buscaTimeout = setTimeout(() => {
            document.getElementById('filtrosForm').submit();
        }, 500);
    });

    // Seletor de itens por página
    document.getElementById('per_page').addEventListener('change', function() {
        document.getElementById('filtrosForm').submit();
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
