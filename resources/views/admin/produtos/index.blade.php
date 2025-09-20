@extends('layouts.app')

@section('title', 'Produtos/Serviços - BarberShop Pro')
@section('page-title', 'Produtos/Serviços')
@section('page-subtitle', 'Gerenciamento de produtos e serviços da barbearia')

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

    .btn-outline-secondary {
        border-color: #6b7280;
        color: #6b7280;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: rgba(107, 114, 128, 0.1);
        border-color: #4b5563;
        color: #4b5563;
    }

    .btn-outline-success {
        border-color: #10b981;
        color: #10b981;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: rgba(16, 185, 121, 0.1);
        border-color: #047857;
        color: #047857;
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

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-box me-2" style="color: #60a5fa;"></i>
                Produtos/Serviços
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie produtos e serviços da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#productModal">
                <i class="fas fa-plus me-1"></i>
                Novo Produto/Serviço
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Itens</p>
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
                        <p class="text-muted mb-0">Itens Ativos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #8b5cf6, #a78bfa);">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['produtos'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Produtos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['servicos'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Serviços</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Filtros com collapse e botão limpar seguindo padrão de clientes -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2); cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
            <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                <i class="fas fa-filter me-2" style="color: #60a5fa;"></i>Filtros
            </h6>
            <i class="fas fa-chevron-down" style="color: #60a5fa;"></i>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-10">
                        <form method="GET" action="{{ route('produtos.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar produtos/serviços..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="tipo" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                    <option value="">Todos os tipos</option>
                                    <option value="produto" {{ request('tipo') == 'produto' ? 'selected' : '' }}>Produto</option>
                                    <option value="servico" {{ request('tipo') == 'servico' ? 'selected' : '' }}>Serviço</option>
                                </select>
                            </div>
                            <div class="col-md-2">
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
                                <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            @if(request('per_page'))
                                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($produtos) && $produtos->count() > 0)
                <!-- Informações da Paginação seguindo padrão de clientes -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} resultados
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
                                <th style="color: #1f2937;">Produto/Serviço</th>
                                <th style="color: #1f2937;">Tipo</th>
                                <th style="color: #1f2937;">Categoria</th>
                                <th style="color: #1f2937;">Preço</th>
                                <th style="color: #1f2937;">Status</th>
                                <th width="200" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $produto)
                            <tr data-produto-id="{{ $produto->id }}" 
                                data-nome="{{ $produto->nome }}" 
                                data-descricao="{{ $produto->descricao }}" 
                                data-preco="{{ $produto->preco }}" 
                                data-categoria-id="{{ $produto->categoria_id }}"
                                data-ativo="{{ $produto->ativo ? '1' : '0' }}"
                                data-tipo="{{ $produto->tipo }}"
                                data-imagem="{{ $produto->imagem }}"
                                data-site="{{ $produto->site ? '1' : '0' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            @if($produto->tipo == 'produto')
                                                <i class="fas fa-cube"></i>
                                            @else
                                                <i class="fas fa-cut"></i>
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $produto->nome }}</h6>
                                            @if($produto->descricao)
                                                <p>{{ Str::limit($produto->descricao, 50) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $produto->tipo == 'produto' ? 'info' : 'warning' }}">
                                        {{ $produto->tipo == 'produto' ? 'Produto' : 'Serviço' }}
                                    </span>
                                </td>
                                <td>{{ $produto->categoria->nome }}</td>
                                <td>
                                    <strong style="color: #10b981;">R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $produto->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarProduto({{ $produto->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarProduto({{ $produto->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Adicionando botão para gerenciar filiais -->
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="gerenciarFiliais({{ $produto->id }})" title="Gerenciar Filiais">
                                            <i class="fas fa-store"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $produto->id }}, '{{ $produto->nome }}')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação seguindo padrão de clientes -->
                <div class="pagination-wrapper">
                    <div class="pagination-controls">
                        <div class="results-info">
                            Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} resultados
                        </div>
                        {{ $produtos->appends(request()->query())->links() }}

                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum produto/serviço encontrado</h5>
                    <p class="text-muted">Cadastre o primeiro produto ou serviço para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#productModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Item
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para criar/editar produto -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="fas fa-plus me-2" style="color: #60a5fa;"></i>
                    Novo Produto/Serviço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('produtos.store') }}" method="POST" id="productForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Selecione</option>
                                <option value="produto">Produto</option>
                                <option value="servico">Serviço</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="categoria_id" class="form-label">Categoria *</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="">Selecione</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="preco" class="form-label">Preço *</label>
                            <!-- Alterando input de number para text e adicionando máscara monetária -->
                            <input type="text" class="form-control" id="preco" name="preco" required placeholder="R$ 0,00">
                        </div>
                        <!-- Removendo campo de estoque do modal de criação -->
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <!-- Alterando campo de imagem de textarea para input file -->
                        <label for="imagem" class="form-label">Imagem</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                        <small class="text-muted">Formatos aceitos: JPEG, PNG, JPG, GIF. Tamanho máximo: 2MB</small>
                        <!-- Adicionando preview da imagem -->
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid rgba(59, 130, 246, 0.2);">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1);">
                                <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="ativo" name="ativo" value="1" checked style="margin-top: 0;">
                                <label class="form-check-label flex-grow-1" for="ativo" style="margin-bottom: 0;">
                                    <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                    Ativo
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class=" d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1);">
                                <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="site" name="site" value="1" style="margin-top: 0;">
                                <label class="form-check-label flex-grow-1" for="site" style="margin-bottom: 0;">
                                    <i class="fas fa-globe me-1" style="color: #3b82f6;"></i>
                                    Exibir no Site
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="productForm" class="btn btn-primary-custom">
                    <i class="fas fa-save me-1"></i>
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar produto -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">
                    <i class="fas fa-eye me-2" style="color: #60a5fa;"></i>
                    Visualizar Produto/Serviço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex align-items-center mb-4">
                            <div class="product-avatar me-3" id="viewProductAvatar" style="width: 80px; height: 80px; font-size: 2rem;">
                                <!-- Avatar será preenchido via JavaScript -->
                            </div>
                            <div>
                                <h4 class="mb-0" id="viewProductName"></h4>
                                <p class="mb-0 text-muted" id="viewProductType"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Categoria:</label>
                        <p class="mb-0" id="viewProductCategory"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Preço:</label>
                        <p class="mb-0" id="viewProductPrice"></p>
                    </div>
                </div>
                <div class="row">
                    <!-- Removendo campo de estoque do modal de visualização -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #374151; font-weight: 600;">Status:</label>
                        <p class="mb-0" id="viewProductStatus"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: #374151; font-weight: 600;">Descrição:</label>
                    <p class="mb-0" id="viewProductDescription"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: #374151; font-weight: 600;">Exibir no Site:</label>
                    <p class="mb-0" id="viewProductSite"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar produto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">
                    <i class="fas fa-edit me-2" style="color: #60a5fa;"></i>
                    Editar Produto/Serviço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="edit_nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="edit_tipo" name="tipo" required>
                                <option value="">Selecione</option>
                                <option value="produto">Produto</option>
                                <option value="servico">Serviço</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_categoria_id" class="form-label">Categoria *</label>
                            <select class="form-select" id="edit_categoria_id" name="categoria_id" required>
                                <option value="">Selecione</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_preco" class="form-label">Preço *</label>
                            <!-- Alterando input de number para text e adicionando máscara monetária -->
                            <input type="text" class="form-control" id="edit_preco" name="preco" required placeholder="R$ 0,00">
                        </div>
                        <!-- Removendo campo de estoque do modal de edição -->
                    </div>
                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit_descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <!-- Alterando campo de imagem de textarea para input file no modal de edição -->
                        <label for="edit_imagem" class="form-label">Nova Imagem</label>
                        <input type="file" class="form-control" id="edit_imagem" name="imagem" accept="image/*">
                        <small class="text-muted">Deixe em branco para manter a imagem atual. Formatos aceitos: JPEG, PNG, JPG, GIF. Tamanho máximo: 2MB</small>
                        <!-- Adicionando preview da imagem atual e nova -->
                        <div id="editImagePreview" class="mt-2">
                            <div id="currentImage" style="display: none;">
                                <label class="form-label" style="color: #374151; font-weight: 500;">Imagem Atual:</label>
                                <img id="currentImg" src="" alt="Imagem Atual" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid rgba(59, 130, 246, 0.2);">
                            </div>
                            <div id="newImagePreview" style="display: none;">
                                <label class="form-label" style="color: #374151; font-weight: 500;">Nova Imagem:</label>
                                <img id="newPreviewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid rgba(59, 130, 246, 0.2);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class=" d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1);">
                                <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="edit_ativo" name="ativo" value="1" style="margin-top: 0;">
                                <label class="form-check-label flex-grow-1" for="edit_ativo" style="margin-bottom: 0;">
                                    <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                    Ativo
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class=" d-flex align-items-center" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 1px solid rgba(59, 130, 246, 0.1);">
                                <input type="checkbox" class="form-check-input me-2 flex-shrink-0" id="edit_site" name="site" value="1" style="margin-top: 0;">
                                <label class="form-check-label flex-grow-1" for="edit_site" style="margin-bottom: 0;">
                                    <i class="fas fa-globe me-1" style="color: #3b82f6;"></i>
                                    Exibir no Site
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="editProductForm" class="btn btn-primary-custom">
                    <i class="fas fa-save me-1"></i>
                    Atualizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar exclusão -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444;"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <i class="fas fa-box fa-3x mb-3" style="color: #ef4444;"></i>
                    <h5 style="color: #1f2937;">Tem certeza que deseja excluir este item?</h5>
                    <p class="text-muted mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #dc2626;">
                    <strong>Item:</strong> <span id="deleteProductName"></span>
                </div>
                <form method="POST" id="deleteProductForm">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: white; color: #6b7280; border: 2px solid rgba(107, 114, 128, 0.2); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="submit" form="deleteProductForm" class="btn" style="background: linear-gradient(45deg, #ef4444, #f87171); border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-trash me-1"></i>
                    Excluir Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Adicionando offcanvas para gerenciar filiais -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filiaisOffcanvas" aria-labelledby="filiaisOffcanvasLabel" style="width: 500px; z-index: 1060;">
    <div class="offcanvas-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid rgba(59, 130, 246, 0.2); position: relative; z-index: 1061;">
        <h5 class="offcanvas-title" id="filiaisOffcanvasLabel">
            <i class="fas fa-store me-2" style="color: #60a5fa;"></i>
            Gerenciar Filiais
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <div class="product-avatar me-3" id="offcanvasProductAvatar">
                    <!-- Avatar será preenchido via JavaScript -->
                </div>
                <div>
                    <h6 class="mb-0" id="offcanvasProductName"></h6>
                    <small class="text-muted" id="offcanvasProductType"></small>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h6 class="mb-3">
                <i class="fas fa-building me-2" style="color: #60a5fa;"></i>
                Filiais
            </h6>
            <div id="filiaisList">
                <!-- Lista de filiais será carregada via JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const toastColorsPerson = {
        success: { background: "#10b981", icon: "check-circle" },  // verde
        error: { background: "#ef4444", icon: "times-circle" },    // vermelho
        warning: { background: "#f59e0b", icon: "exclamation-triangle" }, // amarelo
        info: { background: "#3b82f6", icon: "info-circle" }       // azul
    };
    function showToastPerson(message, type) {
        const { background, icon } = toastColorsPerson[type] || toastColorsPerson.info;

        // Criar toast simples sem Bootstrap
        const toastHtml = `
            <div class="custom-toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${background};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-size: 0.9rem;
                max-width: 300px;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            ">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-${icon}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        margin-left: auto;
                        cursor: pointer;
                        padding: 0;
                        font-size: 1.2rem;
                    ">×</button>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", toastHtml)
        const toastElement = document.body.lastElementChild

        // Animar entrada
        setTimeout(() => {
        toastElement.style.opacity = "1"
        toastElement.style.transform = "translateX(0)"
        }, 100)

        // Remover automaticamente após 3 segundos
        setTimeout(() => {
        if (toastElement && toastElement.parentElement) {
            toastElement.style.opacity = "0"
            toastElement.style.transform = "translateX(100%)"
            setTimeout(() => {
            if (toastElement && toastElement.parentElement) {
                toastElement.remove()
            }
            }, 300)
        }
        }, 5000)
    }
    const perPageEl = document.getElementById('perPage');

    if (perPageEl) {
        perPageEl.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }

    function aplicarMascaraMonetaria(elemento) {
        elemento.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
            value = value.replace(/(\d)(\d{3}),/g, "$1.$2,");
            e.target.value = "R$ " + value;
        });
    }

    // AplicAR MÁSCARAS NOS CAMPOS DE PREÇO
    aplicarMascaraMonetaria(document.getElementById('preco'));
    aplicarMascaraMonetaria(document.getElementById('edit_preco'));

    function setupImagePreview(inputId, previewId, imgId) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById(previewId);
            const img = document.getElementById(imgId);
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    }

    setupImagePreview('imagem', 'imagePreview', 'previewImg');
    setupImagePreview('edit_imagem', 'newImagePreview', 'newPreviewImg');

    function visualizarProduto(id) {
        const row = document.querySelector(`tr[data-produto-id="${id}"]`);
        if (!row) return;

        document.getElementById('viewProductName').textContent = row.dataset.nome;
        document.getElementById('viewProductType').textContent = row.dataset.tipo === 'produto' ? 'Produto' : 'Serviço';
        document.getElementById('viewProductCategory').textContent = row.querySelector('td:nth-child(3)').textContent;
        document.getElementById('viewProductPrice').textContent = row.querySelector('td:nth-child(4)').textContent;
        document.getElementById('viewProductStatus').textContent = row.dataset.ativo === '1' ? 'Ativo' : 'Inativo';
        document.getElementById('viewProductDescription').textContent = row.dataset.descricao || 'Sem descrição';
        document.getElementById('viewProductSite').textContent = row.dataset.site === '1' ? 'Sim' : 'Não';

        // Avatar
        const avatar = document.getElementById('viewProductAvatar');
        avatar.innerHTML = row.dataset.tipo === 'produto' ? '<i class="fas fa-cube"></i>' : '<i class="fas fa-cut"></i>';

        new bootstrap.Modal(document.getElementById('viewProductModal')).show();
    }

    function editarProduto(id) {
        const row = document.querySelector(`tr[data-produto-id="${id}"]`);
        if (!row) return;

        // Preencher campos
        document.getElementById('edit_nome').value = row.dataset.nome;
        document.getElementById('edit_tipo').value = row.dataset.tipo;
        document.getElementById('edit_categoria_id').value = row.dataset.categoriaId;
        document.getElementById('edit_preco').value = `R$ ${parseFloat(row.dataset.preco).toFixed(2).replace('.', ',')}`;
        document.getElementById('edit_descricao').value = row.dataset.descricao || '';
        document.getElementById('edit_ativo').checked = row.dataset.ativo === '1';
        document.getElementById('edit_site').checked = row.dataset.site === '1';

        // Mostrar imagem atual se existir
        if (row.dataset.imagem) {
            document.getElementById('currentImg').src = row.dataset.imagem;
            document.getElementById('currentImage').style.display = 'block';
        } else {
            document.getElementById('currentImage').style.display = 'none';
        }

        // Configurar form action
        document.getElementById('editProductForm').action = `/admin/produtos/${id}`;

        new bootstrap.Modal(document.getElementById('editProductModal')).show();
    }

    function gerenciarFiliais(produtoId) {
        const row = document.querySelector(`tr[data-produto-id="${produtoId}"]`);
        if (!row) return;

        // Preencher informações do produto no offcanvas
        document.getElementById('offcanvasProductName').textContent = row.dataset.nome;
        document.getElementById('offcanvasProductType').textContent = row.dataset.tipo === 'produto' ? 'Produto' : 'Serviço';
        
        const avatar = document.getElementById('offcanvasProductAvatar');
        avatar.innerHTML = row.dataset.tipo === 'produto' ? '<i class="fas fa-cube"></i>' : '<i class="fas fa-cut"></i>';

        // Carregar filiais do backend
        carregarFiliais(produtoId, row.dataset.tipo);

        // Mostrar offcanvas
        new bootstrap.Offcanvas(document.getElementById('filiaisOffcanvas')).show();
    }

    async function carregarFiliais(produtoId, tipoProduto) {
        try {
            const response = await fetch(`/produtos/${produtoId}/filiais`);
            const data = await response.json();
            
            let html = '';
            
            // Filiais vinculadas
            if (data.vinculadas && data.vinculadas.length > 0) {
                data.vinculadas.forEach(item => {
                    const statusBadge = item.ativo ? 
                        '<span class="badge bg-success">Ativo</span>' : 
                        '<span class="badge bg-secondary">Inativo</span>';
                    
                    const estoqueBadge = tipoProduto === 'produto' ? 
                        `<span class="badge bg-info ms-1">Estoque: ${item.estoque || 0}</span> <span class="badge bg-danger ms-1">Comprometido: ${item.comprometido || 0}</span>` : '';

                    html += `
                        <div class="card mb-3" style="border: 1px solid rgba(59, 130, 246, 0.2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">${item.filial.nome}</h6>
                                        <small class="text-muted">${item.filial.endereco}</small>
                                        <div class="mt-2">
                                            ${statusBadge}
                                            ${estoqueBadge}
                                        </div>
                                    </div>
                                    <div class="btn-group-vertical" style="gap: 0.25rem;">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editarVinculacao(${produtoId}, ${item.filial.id}, '${tipoProduto}', ${item.estoque || 0}, ${item.ativo})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="desvincularFilial(${produtoId}, ${item.filial.id})" title="Desvincular">
                                            <i class="fas fa-unlink"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            // Filiais disponíveis para vincular
            if (data.disponiveis && data.disponiveis.length > 0) {
                html += '<hr><h6 class="mb-3 text-muted">Filiais Disponíveis</h6>';
                data.disponiveis.forEach(filial => {
                    html += `
                        <div class="card mb-2" style="border: 1px solid rgba(156, 163, 175, 0.3);">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">${filial.nome}</h6>
                                        <small class="text-muted">${filial.endereco}</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-success" onclick="vincularFilial(${produtoId}, ${filial.id}, '${tipoProduto}')" title="Vincular">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            if (html === '') {
                html = '<div class="text-center text-muted py-4">Nenhuma filial encontrada</div>';
            }

            document.getElementById('filiaisList').innerHTML = html;
        } catch (error) {
            console.error('Erro ao carregar filiais:', error);
            document.getElementById('filiaisList').innerHTML = '<div class="alert alert-danger">Erro ao carregar filiais</div>';
        }
    }

    async function vincularFilial(produtoId, filialId, tipoProduto) {
        try {
            const response = await fetch(`/produtos/${produtoId}/filiais/${filialId}/vincular`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            });

            const result = await response.json();
            
            if (result.success) {
                // Recarregar lista de filiais
                carregarFiliais(produtoId, tipoProduto);
                
                // Mostrar mensagem de sucesso
                showToastPerson('Filial vinculada com sucesso!', 'success');
                
            } else {
                showToastPerson('Erro ao vincular produto: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Erro ao vincular produto:', error);
            showToastPerson('Erro ao vincular produto', 'error');
        }
    }

    async function desvincularFilial(produtoId, filialId) {
        if (!confirm('Tem certeza que deseja desvincular este produto desta filial?')) {
            return;
        }

        try {
            const response = await fetch(`/produtos/${produtoId}/filiais/${filialId}/desvincular`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();
            
            if (result.success) {
                // Recarregar lista de filiais
                const row = document.querySelector(`tr[data-produto-id="${produtoId}"]`);
                const tipoProduto = row ? row.dataset.tipo : 'produto';
                carregarFiliais(produtoId, tipoProduto);
                
                // Mostrar mensagem de sucesso
                showToastPerson('Produto desvinculado da filial!', 'success');
            } else {
                showToastPerson('Erro ao desvincular produto: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Erro ao desvincular produto:', error);
            showToastPerson('Erro ao desvincular produto', 'error');
        }
    }

    function editarVinculacao(produtoId, filialId, tipoProduto, estoqueAtual, ativoAtual) {
        let modalHtml = `
            <div class="modal fade" id="editarVinculacaoModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Vinculação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editarVinculacaoForm">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="editarAtivo" required>
                                        <option value="1" ${ativoAtual ? 'selected' : ''}>Ativo</option>
                                        <option value="0" ${!ativoAtual ? 'selected' : ''}>Inativo</option>
                                    </select>
                                </div>
                                ${tipoProduto === 'produto' ? `
                                    <div class="mb-3">
                                        <label class="form-label">Estoque</label>
                                        <input type="number" class="form-control" id="editarEstoque" value="${estoqueAtual}" min="0" required>
                                    </div>
                                ` : ''}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="salvarVinculacao(${produtoId}, ${filialId}, '${tipoProduto}')">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remover modal existente se houver
        const existingModal = document.getElementById('editarVinculacaoModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Adicionar novo modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        new bootstrap.Modal(document.getElementById('editarVinculacaoModal')).show();
    }

    async function salvarVinculacao(produtoId, filialId, tipoProduto) {
        const ativo = document.getElementById('editarAtivo').value === '1';
        const estoque = tipoProduto === 'produto' ? parseInt(document.getElementById('editarEstoque').value) : null;

        try {
            const response = await fetch(`/produtos/${produtoId}/filiais/${filialId}/atualizar`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    ativo: ativo,
                    estoque: estoque
                })
            });

            const result = await response.json();
            
            if (result.success) {
                // Fechar modal
                bootstrap.Modal.getInstance(document.getElementById('editarVinculacaoModal')).hide();
                
                // Recarregar lista de filiais
                carregarFiliais(produtoId, tipoProduto);
                
                // Mostrar mensagem de sucesso
                showToastPerson('Vinculação atualizada com sucesso!', 'success');
            } else {
                showToastPerson('Erro ao atualizar vinculação: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Erro ao atualizar vinculação:', error);
            showToastPerson('Erro ao atualizar vinculação', 'error');
        }
    }

    function confirmarExclusao(id, nome) {
        document.getElementById('deleteProductName').textContent = nome;
        document.getElementById('deleteProductForm').action = `/admin/produtos/${id}`;
        new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
    }

    document.getElementById('productForm').addEventListener('submit', function() {
        const precoInput = document.getElementById('preco');
        precoInput.value = precoInput.value.replace(/[^\d,]/g, '').replace(',', '.');
    });

    document.getElementById('editProductForm').addEventListener('submit', function() {
        const precoInput = document.getElementById('edit_preco');
        precoInput.value = precoInput.value.replace(/[^\d,]/g, '').replace(',', '.');
    });
</script>
@endpush
