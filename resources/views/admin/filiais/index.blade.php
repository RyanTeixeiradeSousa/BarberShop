@extends('layouts.app')

@section('title', 'Filiais - BarberShop Pro')
@section('page-title', 'Filiais')
@section('page-subtitle', 'Gerencie as filiais da barbearia')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-building me-2" style="color: #60a5fa;"></i>
                Filiais
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gerencie as filiais da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            {{-- <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarFilialModal">
                <i class="fas fa-plus me-1"></i>
                Nova Filial
            </button> --}}
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Total de filiais cadastradas no sistema">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Filiais</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Filiais ativas e operacionais">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['ativas'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Filiais Ativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Filiais temporariamente inativas">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['inativas'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Filiais Inativas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Filiais com CNPJ cadastrado">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['com_cnpj'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Com CNPJ</p>
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
                    <div class="col-md-10">
                        <form method="GET" action="{{ route('filiais.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar filiais..." style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status" style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
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
                                <a href="{{ route('filiais.index') }}" class="btn btn-outline-secondary w-100">
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
            @if(isset($filiais) && $filiais->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $filiais->firstItem() }} a {{ $filiais->lastItem() }} de {{ $filiais->total() }} resultados
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
                </div>

                <!-- Tabela -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: var(--text-primary);">Filial</th>
                                <th style="color: var(--text-primary);">CNPJ</th>
                                <th style="color: var(--text-primary);">Contato</th>
                                <th style="color: var(--text-primary);">Email</th>
                                <th style="color: var(--text-primary);">Status</th>
                                <th width="160" style="color: var(--text-primary);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filiais as $filial)
                            <tr data-filial-id="{{ $filial->id }}" 
                                data-nome="{{ $filial->nome }}" 
                                data-nome-fantasia="{{ $filial->nome_fantasia }}"
                                data-cnpj="{{ $filial->cnpj }}"
                                data-endereco="{{ $filial->endereco }}"
                                data-telefone="{{ $filial->telefone }}"
                                data-email="{{ $filial->email }}"
                                data-ativo="{{ $filial->ativo }}"
                                data-disponivel="{{ $filial->disponivel_site }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($filial->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $filial->nome }}</h6>
                                            @if($filial->nome_fantasia)
                                                <p>{{ $filial->nome_fantasia }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($filial->cnpj)
                                        {{ $filial->cnpj_formatado }}
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($filial->telefone)
                                        <div><i class="fas fa-phone me-1"></i> {{ $filial->telefone }}</div>
                                    @else
                                        <span class="text-muted">Sem telefone</span>
                                    @endif
                                </td>
                                <td>
                                    @if($filial->email)
                                        {{ $filial->email }}
                                    @else
                                        <span class="text-muted">Sem email</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $filial->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $filial->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarFilial({{ $filial->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarFilial({{ $filial->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        {{-- <a type="button" class="btn btn-sm btn-outline-{{ $filial->disponivel_site == 0 ? 'success' : 'danger' }}" href="" title="{{ $filial->disponivel_site == 0 ? 'Disponibilizar' : 'Indisponibilizar' }}">
                                           @if ($filial->disponivel_site == 0)
                                                <i class="fas fa-unlock"></i>
                                           @else
                                                <i class="fas fa-lock"></i>
                                           @endif
                                        </a> --}}
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
                            Mostrando {{ $filiais->firstItem() }} a {{ $filiais->lastItem() }} de {{ $filiais->total() }} resultados
                        </div>
                        {{ $filiais->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma filial encontrada</h5>
                    <p class="text-muted">Solicite cadastro de sua filial. Entre em contato com o suporte.</p>
                    {{-- <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarFilialModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Filial
                    </button> --}}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Filial -->
<div class="modal fade" id="criarFilialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Nova Filial
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('filiais.store') }}" method="POST" id="criarFilialForm">
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
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" id="cnpj" name="cnpj">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço *</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="ativo">
                            Filial Ativa
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

<!-- Modal Visualizar Filial -->
<div class="modal fade" id="visualizarFilialModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes da Filial
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarFilialContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Filial -->
<div class="modal fade" id="editarFilialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Filial
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarFilialForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nome" class="form-label">Nome *</label>
                            <input type="text" disabled class="form-control" id="edit_nome" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_nome_fantasia" class="form-label">Nome Fantasia</label>
                            <input type="text" disabled class="form-control" id="edit_nome_fantasia" name="nome_fantasia">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" disabled id="edit_cnpj" name="cnpj">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="edit_telefone" name="telefone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_endereco" class="form-label">Endereço *</label>
                        <textarea class="form-control" id="edit_endereco" name="endereco" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" disabled type="checkbox" id="edit_ativo" name="ativo" value="1">
                        <label class="form-check-label" for="edit_ativo">
                            Filial Ativa
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_disponivel" name="disponivel_site" value="1">
                        <label class="form-check-label" for="edit_disponivel">
                            Site
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

<!-- Modal Excluir Filial -->
<div class="modal fade" id="excluirFilialModal" tabindex="-1">
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
                <h5>Tem certeza que deseja excluir esta filial?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="filialNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirFilialForm" method="POST" style="display: inline;">
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
    /* Reutilizando os mesmos estilos da tela de clientes */
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

    // Seletor de itens por página
    const perPage = document.getElementById('perPage')

    if(perPage){
        perPage.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }
    

    // Máscaras
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

    function aplicarMascaraTelefone(elemento) {
        if (!elemento) return;
        elemento.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            if (valor.length <= 10) {
                valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
                valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
                valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = valor;
        });
    }

    // Aplicar máscaras
    aplicarMascaraCNPJ(document.getElementById('cnpj'));
    aplicarMascaraCNPJ(document.getElementById('edit_cnpj'));
    aplicarMascaraTelefone(document.getElementById('telefone'));
    aplicarMascaraTelefone(document.getElementById('edit_telefone'));

    // Função para visualizar filial
    function visualizarFilial(id) {
        const linha = document.querySelector(`tr[data-filial-id="${id}"]`);
        const nome = linha.dataset.nome;
        const nomeFantasia = linha.dataset.nomeFantasia;
        const cnpj = linha.dataset.cnpj;
        const endereco = linha.dataset.endereco;
        const telefone = linha.dataset.telefone;
        const email = linha.dataset.email;
        const ativo = linha.dataset.ativo;
        const disponivel = linha.dataset.disponivel;
        
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
                    <strong>CNPJ:</strong><br>
                    <span class="text-muted">${cnpj || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Telefone:</strong><br>
                    <span class="text-muted">${telefone || '-'}</span>
                </div>
                <div class="col-md-12 mb-3">
                    <strong>Email:</strong><br>
                    <span class="text-muted">${email || '-'}</span>
                </div>
                <div class="col-md-12 mb-3">
                    <strong>Endereço:</strong><br>
                    <span class="text-muted">${endereco || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${ativo == '1' ? 'success' : 'danger'}">${ativo == '1' ? 'Ativo' : 'Inativo'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Disponível site:</strong><br>
                    <span class="badge bg-${disponivel == '1' ? 'success' : 'danger'}">${disponivel == '1' ? 'Disponivel' : 'Indisponivel'}</span>
                </div>
            </div>
        `;
        
        document.getElementById('visualizarFilialContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('visualizarFilialModal')).show();
    }

    // Função para editar filial
    function editarFilial(id) {
        const linha = document.querySelector(`tr[data-filial-id="${id}"]`);
        
        document.getElementById('edit_nome').value = linha.dataset.nome;
        document.getElementById('edit_nome_fantasia').value = linha.dataset.nomeFantasia;
        document.getElementById('edit_cnpj').value = linha.dataset.cnpj;
        document.getElementById('edit_endereco').value = linha.dataset.endereco;
        document.getElementById('edit_telefone').value = linha.dataset.telefone;
        document.getElementById('edit_email').value = linha.dataset.email;
        document.getElementById('edit_ativo').checked = linha.dataset.ativo == '1';
        document.getElementById('edit_disponivel').checked = linha.dataset.disponivel == '1';
        
        document.getElementById('editarFilialForm').action = `/admin/filiais/${id}`;
        new bootstrap.Modal(document.getElementById('editarFilialModal')).show();
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('filialNomeExcluir').textContent = nome;
        document.getElementById('excluirFilialForm').action = `/admin/filiais/${id}`;
        new bootstrap.Modal(document.getElementById('excluirFilialModal')).show();
    }
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
@endsection
