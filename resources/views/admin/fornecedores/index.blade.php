@extends('layouts.app')

@section('title', 'Fornecedores - BarberShop Pro')
@section('page-title', 'Fornecedores')
@section('page-subtitle', 'Gerencie os fornecedores da barbearia')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-truck me-2" style="color: #60a5fa;"></i>
                Fornecedores
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gerencie os fornecedores da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarFornecedorModal">
                <i class="fas fa-plus me-1"></i>
                Novo Fornecedor
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Fornecedores</p>
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
                        <h4 class="mb-0">{{ $stats['ativos'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Fornecedores Ativos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['pessoa_fisica'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Pessoa Física</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['pessoa_juridica'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Pessoa Jurídica</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Filtros -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2); cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
            <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                <i class="fas fa-filter me-2" style="color: #60a5fa;"></i>Filtros
            </h6>
            <i class="fas fa-chevron-down" style="color: #60a5fa;"></i>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('fornecedores.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar fornecedores..." style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status" style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                                    <option value="">Todos os status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="tipo" style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                                    <option value="">Todos os tipos</option>
                                    <option value="F" {{ request('tipo') == 'F' ? 'selected' : '' }}>Pessoa Física</option>
                                    <option value="J" {{ request('tipo') == 'J' ? 'selected' : '' }}>Pessoa Jurídica</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($fornecedores) && $fornecedores->count() > 0)
                <!-- Informações da Paginação -->
                <div class="pagination-wrapper">
                    <div class="pagination-controls">
                        <div class="results-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Mostrando {{ $fornecedores->firstItem() }} a {{ $fornecedores->lastItem() }} de {{ $fornecedores->total() }} resultados
                        </div>
                        
                        <div class="per-page-selector">
                            <label for="perPage" class="form-label mb-0" style="color: var(--text-primary);">Itens por página:</label>
                            <select class="form-select form-select-sm" id="perPage">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: var(--text-primary);">Fornecedor</th>
                                <th style="color: var(--text-primary);">Tipo</th>
                                <th style="color: var(--text-primary);">CPF/CNPJ</th>
                                <th style="color: var(--text-primary);">Endereço</th>
                                <th style="color: var(--text-primary);">Status</th>
                                <th width="160" style="color: var(--text-primary);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fornecedores as $fornecedor)
                            <tr data-fornecedor-id="{{ $fornecedor->id }}" 
                                data-nome="{{ $fornecedor->nome }}" 
                                data-nome-fantasia="{{ $fornecedor->nome_fantasia }}"
                                data-cpf-cnpj="{{ $fornecedor->cpf_cnpj }}"
                                data-endereco="{{ $fornecedor->endereco }}"
                                data-ativo="{{ $fornecedor->ativo }}"
                                data-pessoa-fisica-juridica="{{ $fornecedor->pessoa_fisica_juridica }}"
                                data-user-created="{{ $fornecedor->userCreated->name ?? 'N/A' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($fornecedor->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $fornecedor->nome }}</h6>
                                            @if($fornecedor->nome_fantasia)
                                                <p>{{ $fornecedor->nome_fantasia }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $fornecedor->pessoa_fisica_juridica == 'F' ? 'info' : 'warning' }}">
                                        {{ $fornecedor->pessoa_fisica_juridica == 'F' ? 'Pessoa Física' : 'Pessoa Jurídica' }}
                                    </span>
                                </td>
                                <td>{{ $fornecedor->cpf_cnpj }}</td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $fornecedor->endereco }}">
                                        {{ $fornecedor->endereco }}
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $fornecedor->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $fornecedor->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarFornecedor({{ $fornecedor->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarFornecedor({{ $fornecedor->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $fornecedor->id }}, '{{ $fornecedor->nome }}')" title="Excluir">
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
                            Mostrando {{ $fornecedores->firstItem() }} a {{ $fornecedores->lastItem() }} de {{ $fornecedores->total() }} resultados
                        </div>
                        {{ $fornecedores->appends(request()->query())->links() }}                   
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum fornecedor encontrado</h5>
                    <p class="text-muted">Cadastre o primeiro fornecedor para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarFornecedorModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Fornecedor
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Fornecedor -->
<div class="modal fade" id="criarFornecedorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Novo Fornecedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fornecedores.store') }}" method="POST" id="criarFornecedorForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                            <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pessoa_fisica_juridica" class="form-label">Tipo *</label>
                            <select class="form-select" id="pessoa_fisica_juridica" name="pessoa_fisica_juridica" required onchange="alterarTipoDocumento()">
                                <option value="">Selecione</option>
                                <option value="F">Pessoa Física</option>
                                <option value="J">Pessoa Jurídica</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cpf_cnpj" class="form-label" id="label_cpf_cnpj">CPF/CNPJ *</label>
                            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço *</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="ativo">
                            Fornecedor Ativo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar Fornecedor -->
<div class="modal fade" id="visualizarFornecedorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Fornecedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarFornecedorContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Fornecedor -->
<div class="modal fade" id="editarFornecedorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Fornecedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarFornecedorForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_nome_fantasia" class="form-label">Nome Fantasia</label>
                            <input type="text" class="form-control" id="edit_nome_fantasia" name="nome_fantasia">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_pessoa_fisica_juridica" class="form-label">Tipo *</label>
                            <select class="form-select" id="edit_pessoa_fisica_juridica" name="pessoa_fisica_juridica" required onchange="alterarTipoDocumentoEdit()">
                                <option value="">Selecione</option>
                                <option value="F">Pessoa Física</option>
                                <option value="J">Pessoa Jurídica</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_cpf_cnpj" class="form-label" id="edit_label_cpf_cnpj">CPF/CNPJ *</label>
                            <input type="text" class="form-control" id="edit_cpf_cnpj" name="cpf_cnpj" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_endereco" class="form-label">Endereço *</label>
                        <textarea class="form-control" id="edit_endereco" name="endereco" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_ativo" name="ativo" value="1">
                        <label class="form-check-label" for="edit_ativo">
                            Fornecedor Ativo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir Fornecedor -->
<div class="modal fade" id="excluirFornecedorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #dc3545; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #fee 0%, #fdd 100%); border-bottom: 1px solid #dc3545;">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h5>Tem certeza que deseja excluir este fornecedor?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="fornecedorNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirFornecedorForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir
                    </button>
                </form>
            </div>
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
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.15s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        border-color: rgba(59, 130, 246, 0.5);
    }

    .card-header {
        background: var(--card-header-bg) !important;
        color: var(--text-primary) !important;
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

    .product-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
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
        color: var(--text-primary);
    }

    .product-info p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .status-ativo { color: #10b981; }
    .status-inativo { color: #ef4444; }

    .table {
        background: var(--card-bg);
        color: var(--text-primary);
    }

    .table th {
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        padding: 1rem 0.75rem;
        color: var(--text-primary) !important;
    }

    .table td {
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    /* Adicionando estilos para paginação e seletor perpage */
    .pagination-wrapper {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        margin-top: 1.5rem;
        border: 1px solid var(--border-color);
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
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.5rem;
        color: var(--text-primary);
    }

    .results-info {
        color: var(--text-primary);
        font-size: 0.9rem;
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
        background: var(--card-bg) !important;
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
        background: var(--card-bg) !important;
        border-color: var(--border-color) !important;
        cursor: not-allowed !important;
        opacity: 0.5;
    }

    .form-control, .form-select {
        background: var(--input-bg) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .form-control:focus, .form-select:focus {
        background: var(--input-bg) !important;
        border-color: #60a5fa !important;
        color: var(--text-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25) !important;
    }

    .modal-content {
        background: var(--card-bg) !important;
        color: var(--text-primary) !important;
        border: 2px solid #60a5fa !important;
    }

    .modal-header {
        background: var(--card-header-bg) !important;
        border-bottom: 1px solid #60a5fa !important;
        color: var(--text-primary) !important;
    }

    .modal-body {
        background: var(--card-bg) !important;
        color: var(--text-primary) !important;
    }

    .modal-footer {
        background: var(--card-bg) !important;
        border-top: 1px solid var(--border-color) !important;
    }

    .form-label {
        color: var(--text-primary) !important;
    }

    /* Adicionando responsividade para mobile */
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
    // document.querySelector('input[name="search"]').addEventListener('input', function() {
    //     clearTimeout(this.searchTimeout);
    //     this.searchTimeout = setTimeout(() => {
    //         document.getElementById('filterForm').submit();
    //     }, 500);
    // });

    // document.querySelector('select[name="status"]').addEventListener('change', function() {
    //     document.getElementById('filterForm').submit();
    // });

    // document.querySelector('select[name="tipo"]').addEventListener('change', function() {
    //     document.getElementById('filterForm').submit();
    // });

    // Seletor de itens por página
    var perPage = document.getElementById('perPage')

    if(perPage) {
        perPage.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }

    // Função para alterar tipo de documento
    function alterarTipoDocumento() {
        const tipo = document.getElementById('pessoa_fisica_juridica').value;
        const label = document.getElementById('label_cpf_cnpj');
        const input = document.getElementById('cpf_cnpj');
        
        if (tipo === 'F') {
            label.textContent = 'CPF *';
            input.placeholder = '000.000.000-00';
            aplicarMascaraCPF(input);
        } else if (tipo === 'J') {
            label.textContent = 'CNPJ *';
            input.placeholder = '00.000.000/0000-00';
            aplicarMascaraCNPJ(input);
        } else {
            label.textContent = 'CPF/CNPJ *';
            input.placeholder = '';
        }
        input.value = '';
    }

    function alterarTipoDocumentoEdit() {
        const tipo = document.getElementById('edit_pessoa_fisica_juridica').value;
        const label = document.getElementById('edit_label_cpf_cnpj');
        const input = document.getElementById('edit_cpf_cnpj');
        
        if (tipo === 'F') {
            label.textContent = 'CPF *';
            aplicarMascaraCPF(input);
        } else if (tipo === 'J') {
            label.textContent = 'CNPJ *';
            aplicarMascaraCNPJ(input);
        } else {
            label.textContent = 'CPF/CNPJ *';
        }
    }

    // Máscaras
    function aplicarMascaraCPF(elemento) {
        if (!elemento) return;
        elemento.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = valor;
        });
    }

    function aplicarMascaraCNPJ(elemento) {
        if (!elemento) return;
        elemento.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            valor = valor.replace(/(\d{2})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1/$2');
            valor = valor.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
            e.target.value = valor;
        });
    }

    // Função para visualizar fornecedor
    function visualizarFornecedor(id) {
        const linha = document.querySelector(`tr[data-fornecedor-id="${id}"]`);
        const nome = linha.dataset.nome;
        const nomeFantasia = linha.dataset.nomeFantasia;
        const cpfCnpj = linha.dataset.cpfCnpj;
        const endereco = linha.dataset.endereco;
        const ativo = linha.dataset.ativo;
        const pessoaFisicaJuridica = linha.dataset.pessoaFisicaJuridica;
        const userCreated = linha.dataset.userCreated;
        
        const content = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Nome:</strong><br>
                    <span class="text-muted">${nome}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Nome Fantasia:</strong><br>
                    <span class="text-muted">${nomeFantasia || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Tipo:</strong><br>
                    <span class="text-muted">${pessoaFisicaJuridica === 'F' ? 'Pessoa Física' : 'Pessoa Jurídica'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>${pessoaFisicaJuridica === 'F' ? 'CPF' : 'CNPJ'}:</strong><br>
                    <span class="text-muted">${cpfCnpj}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${ativo == '1' ? 'success' : 'danger'}">${ativo == '1' ? 'Ativo' : 'Inativo'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Criado por:</strong><br>
                    <span class="text-muted">${userCreated}</span>
                </div>
                <div class="col-12 mb-3">
                    <strong>Endereço:</strong><br>
                    <span class="text-muted">${endereco}</span>
                </div>
            </div>
        `;
        
        document.getElementById('visualizarFornecedorContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('visualizarFornecedorModal')).show();
    }

    // Função para editar fornecedor
    function editarFornecedor(id) {
        const linha = document.querySelector(`tr[data-fornecedor-id="${id}"]`);
        
        document.getElementById('edit_nome').value = linha.dataset.nome;
        document.getElementById('edit_nome_fantasia').value = linha.dataset.nomeFantasia;
        document.getElementById('edit_cpf_cnpj').value = linha.dataset.cpfCnpj;
        document.getElementById('edit_endereco').value = linha.dataset.endereco;
        document.getElementById('edit_pessoa_fisica_juridica').value = linha.dataset.pessoaFisicaJuridica;
        document.getElementById('edit_ativo').checked = linha.dataset.ativo == '1';
        
        alterarTipoDocumentoEdit();
        
        document.getElementById('editarFornecedorForm').action = `/admin/fornecedores/${id}`;
        new bootstrap.Modal(document.getElementById('editarFornecedorModal')).show();
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('fornecedorNomeExcluir').textContent = nome;
        document.getElementById('excluirFornecedorForm').action = `/admin/fornecedores/${id}`;
        new bootstrap.Modal(document.getElementById('excluirFornecedorModal')).show();
    }
    
</script>
@endpush
@endsection
