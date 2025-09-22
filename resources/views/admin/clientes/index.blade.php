@extends('layouts.app')

@section('title', 'Clientes - BarberShop Pro')
@section('page-title', 'Clientes')
@section('page-subtitle', 'Gerencie os clientes da barbearia')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-users me-2" style="color: #60a5fa;"></i>
                Clientes
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gerencie os clientes da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarClienteModal">
                <i class="fas fa-plus me-1"></i>
                Novo Cliente
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
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
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
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
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
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
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
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

    <!-- Card de Filtros com collapse e botão limpar -->
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
                        <form method="GET" action="{{ route('clientes.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar clientes..." style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
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
                                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary w-100">
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
            @if(isset($clientes) && $clientes->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
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
                                <th style="color: var(--text-primary);">Cliente</th>
                                <th style="color: var(--text-primary);">Sexo</th>
                                <th style="color: var(--text-primary);">Contato</th>
                                <th style="color: var(--text-primary);">Email</th>
                                <th style="color: var(--text-primary);">Status</th>
                                <th width="160" style="color: var(--text-primary);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr data-client-id="{{ $cliente->id }}" 
                                data-nome="{{ $cliente->nome }}" 
                                data-cpf="{{ $cliente->cpf }}"
                                data-email="{{ $cliente->email }}"
                                data-data-nascimento="{{ $cliente->data_nascimento }}"
                                data-sexo="{{ $cliente->sexo }}"
                                data-telefone1="{{ $cliente->telefone1 }}"
                                data-telefone2="{{ $cliente->telefone2 }}"
                                data-endereco="{{ $cliente->endereco }}"
                                data-ativo="{{ $cliente->ativo }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($cliente->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $cliente->nome }}</h6>
                                            @if($cliente->cpf)
                                                <p>{{ $cliente->cpf }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $cliente->sexo == 'M' ? 'info' : 'warning' }}">
                                        {{ $cliente->sexo == 'M' ? 'Masculino' : 'Feminino' }}
                                    </span>
                                </td>
                                <td>
                                    @if($cliente->telefone1)
                                        <div><i class="fas fa-phone me-1"></i> {{ $cliente->telefone1 }}</div>
                                    @endif
                                    @if($cliente->telefone2)
                                        <div><i class="fas fa-mobile me-1"></i> {{ $cliente->telefone2 }}</div>
                                    @endif
                                    @if(!$cliente->telefone1 && !$cliente->telefone2)
                                        <span class="text-muted">Sem telefone</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente->email)
                                        {{ $cliente->email }}
                                    @else
                                        <span class="text-muted">Sem email</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $cliente->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="verDetalhesCliente({{ $cliente->id }})" title="Detalhes">
                                            <i class="fas fa-chart-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarCliente({{ $cliente->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarCliente({{ $cliente->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $cliente->id }}, '{{ $cliente->nome }}')" title="Excluir">
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
                            Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
                        </div>
                        {{ $clientes->appends(request()->query())->links() }}                   

                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum cliente encontrado</h5>
                    <p class="text-muted">Cadastre o primeiro cliente para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarClienteModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Cliente
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Cliente -->
<div class="modal fade" id="criarClienteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Novo Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF </label>
                            <input type="text" class="form-control" id="cpf" name="cpf">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexo" class="form-label">Sexo *</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefone1" class="form-label">Telefone 1 *</label>
                            <input type="text" class="form-control" id="telefone1" required name="telefone1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone2" class="form-label">Telefone 2</label>
                            <input type="text" class="form-control" id="telefone2" name="telefone2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="ativo">
                            Cliente Ativo
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

<!-- Modal Visualizar Cliente -->
<div class="modal fade" id="visualizarClienteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarClienteContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="editarClienteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarClienteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_cpf" class="form-label">CPF </label>
                            <input type="text" class="form-control" id="edit_cpf" name="cpf">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="edit_data_nascimento" name="data_nascimento">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_sexo" class="form-label">Sexo *</label>
                            <select class="form-select" id="edit_sexo" name="sexo" required>
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone1" class="form-label">Telefone 1 *</label>
                            <input type="text" class="form-control" id="edit_telefone1" required name="telefone1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone2" class="form-label">Telefone 2</label>
                            <input type="text" class="form-control" id="edit_telefone2" name="telefone2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_endereco" class="form-label">Endereço</label>
                        <textarea class="form-control" id="edit_endereco" name="endereco" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_ativo" name="ativo" value="1">
                        <label class="form-check-label" for="edit_ativo">
                            Cliente Ativo
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

<!-- Modal Excluir Cliente -->
<div class="modal fade" id="excluirClienteModal" tabindex="-1">
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
                <h5>Tem certeza que deseja excluir este cliente?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="clienteNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirClienteForm" method="POST" style="display: inline;">
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

    .btn-outline-success {
        border-color: #10b981;
        color: #10b981;
        background: var(--card-bg);
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: rgba(16, 185, 129, 0.1);
        border-color: #059669;
        color: #059669;
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

    .btn-outline-primary {
        border-color: #60a5fa;
        color: #60a5fa;
        background: var(--card-bg);
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
        background: var(--card-bg);
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
        background: var(--card-bg);
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
        background: var(--card-bg);
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: rgba(107, 114, 128, 0.1);
        border-color: #4b5563;
        color: #4b5563;
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

    .results-info {
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    h2, h5, h6, p {
        color: var(--text-primary) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
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

    // Seletor de itens por página
    var perPage = document.getElementById('perPage')
    if(perPage){
        perPage.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
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
    aplicarMascaraCPF(document.getElementById('cpf'));
    aplicarMascaraCPF(document.getElementById('edit_cpf'));
    aplicarMascaraTelefone(document.getElementById('telefone1'));
    aplicarMascaraTelefone(document.getElementById('telefone2'));
    aplicarMascaraTelefone(document.getElementById('edit_telefone1'));
    aplicarMascaraTelefone(document.getElementById('edit_telefone2'));

    // Função para visualizar cliente
    function visualizarCliente(id) {
        const linha = document.querySelector(`tr[data-client-id="${id}"]`);
        const nome = linha.dataset.nome;
        const cpf = linha.dataset.cpf;
        const email = linha.dataset.email;
        const dataNascimento = linha.dataset.dataNascimento;
        const sexo = linha.dataset.sexo;
        const telefone1 = linha.dataset.telefone1;
        const telefone2 = linha.dataset.telefone2;
        const endereco = linha.dataset.endereco;
        const ativo = linha.dataset.ativo;
        
        const content = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Nome:</strong><br>
                    <span class="text-muted">${nome}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>CPF:</strong><br>
                    <span class="text-muted">${cpf || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong><br>
                    <span class="text-muted">${email || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Sexo:</strong><br>
                    <span class="text-muted">${sexo === 'M' ? 'Masculino' : 'Feminino'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Data Nascimento:</strong><br>
                    <span class="text-muted">${dataNascimento || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${ativo == '1' ? 'success' : 'danger'}">${ativo == '1' ? 'Ativo' : 'Inativo'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Telefone 1:</strong><br>
                    <span class="text-muted">${telefone1 || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Telefone 2:</strong><br>
                    <span class="text-muted">${telefone2 || '-'}</span>
                </div>
                <div class="col-12 mb-3">
                    <strong>Endereço:</strong><br>
                    <span class="text-muted">${endereco || '-'}</span>
                </div>
            </div>
        `;
        
        document.getElementById('visualizarClienteContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('visualizarClienteModal')).show();
    }

    // Função para editar cliente
    function editarCliente(id) {
        const linha = document.querySelector(`tr[data-client-id="${id}"]`);
        
        document.getElementById('edit_nome').value = linha.dataset.nome;
        document.getElementById('edit_cpf').value = linha.dataset.cpf;
        document.getElementById('edit_email').value = linha.dataset.email;
        document.getElementById('edit_data_nascimento').value = linha.dataset.dataNascimento;
        document.getElementById('edit_sexo').value = linha.dataset.sexo;
        document.getElementById('edit_telefone1').value = linha.dataset.telefone1;
        document.getElementById('edit_telefone2').value = linha.dataset.telefone2;
        document.getElementById('edit_endereco').value = linha.dataset.endereco;
        document.getElementById('edit_ativo').checked = linha.dataset.ativo == '1';
        
        document.getElementById('editarClienteForm').action = `/admin/clientes/${id}`;
        new bootstrap.Modal(document.getElementById('editarClienteModal')).show();
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('clienteNomeExcluir').textContent = nome;
        document.getElementById('excluirClienteForm').action = `/admin/clientes/${id}`;
        new bootstrap.Modal(document.getElementById('excluirClienteModal')).show();
    }

    function verDetalhesCliente(id) {
        window.location.href = `/admin/clientes/${id}/detalhes`;
    }
</script>
@endpush
@endsection
