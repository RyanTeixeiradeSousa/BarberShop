@extends('layouts.app')

@section('title', 'Usuários - BarberShop Pro')
@section('page-title', 'Usuários')
@section('page-subtitle', 'Gerencie os usuários do sistema')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-users me-2" style="color: #60a5fa;"></i>
                Usuários
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie os usuários do sistema</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarUsuarioModal">
                <i class="fas fa-plus me-1"></i>
                Novo Usuário
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
                        <h4 class="mb-0">{{ $totalUsers ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Usuários</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $activeUsers ?? 0 }}</h4>
                        <p class="text-muted mb-0">Usuários Ativos</p>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->master == 1)
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $masterUsers ?? 0 }}</h4>
                            <p class="text-muted mb-0">Usuários Master</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $regularUsers ?? 0 }}</h4>
                            <p class="text-muted mb-0">Usuários Regulares</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Card de Filtros com collapse e botão limpar -->
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
                        <form method="GET" action="{{ route('users.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="nome" value="{{ request('nome') }}" placeholder="Buscar por nome..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-3">
                                <input type="email" class="form-control" name="email" value="{{ request('email') }}" placeholder="Buscar por e-mail..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-1">
                                <select class="form-select" name="ativo" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                    <option value="">Status</option>
                                    <option value="1" {{ request('ativo') == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ request('ativo') == '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            @if(Auth::user()->master == 1)
                            <div class="col-md-2">
                                <select class="form-select" name="master" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                    <option value="">Todos os tipos</option>
                                    <option value="1" {{ request('master') == '1' ? 'selected' : '' }}>Master</option>
                                    <option value="0" {{ request('master') == '0' ? 'selected' : '' }}>Regular</option>
                                </select>
                            </div>
                            @endif
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">
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
            @if(isset($users) && $users->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
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
                                <th style="color: #1f2937;">Usuário</th>
                                <th style="color: #1f2937;">E-mail</th>
                                <th style="color: #1f2937;">Tipo</th>
                                <th style="color: #1f2937;">Status</th>
                                <th style="color: #1f2937;">Último Acesso</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr data-user-id="{{ $user->id }}" 
                                data-nome="{{ $user->nome }}" 
                                data-email="{{ $user->email }}"
                                data-master="{{ $user->master }}"
                                data-ativo="{{ $user->ativo }}"
                                data-redefinir-senha="{{ $user->redefinir_senha_login }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($user->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $user->nome }}</h6>
                                            <p>{{ $user->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->master ? 'warning' : 'info' }}">
                                        {{ $user->master ? 'Master' : 'Regular' }}
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $user->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    @if($user->last_acess)
                                        {{ $user->last_acess}}
                                    @else
                                        <span class="text-muted">Nunca</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarUsuario({{ $user->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarUsuario({{ $user->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(!$user->master)
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $user->id }}, '{{ $user->nome }}')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
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
                            Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
                        </div>
                        {{ $users->appends(request()->query())->links() }}

                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum usuário encontrado</h5>
                    <p class="text-muted">Cadastre o primeiro usuário para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarUsuarioModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Usuário
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Usuário -->
<div class="modal fade" id="criarUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Novo Usuário
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
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
                            <label for="email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="senha" class="form-label">Senha *</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                            <div class="form-text">Mínimo 6 caracteres</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                                <label class="form-check-label" for="ativo">
                                    Usuário Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check d-none">
                        <input class="form-check-input" type="checkbox" id="redefinir_senha_login" name="redefinir_senha_login" value="1">
                        <label class="form-check-label" for="redefinir_senha_login">
                            Forçar redefinição de senha no próximo login
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

<!-- Modal Visualizar Usuário -->
<div class="modal fade" id="visualizarUsuarioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Usuário
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarUsuarioContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Usuário
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarUsuarioForm" method="POST">
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
                            <label for="edit_email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_senha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="edit_senha" name="senha">
                            <div class="form-text">Deixe em branco para manter a senha atual</div>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_ativo" name="ativo" value="1">
                                <label class="form-check-label" for="edit_ativo">
                                    Usuário Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check d-none">
                        <input class="form-check-input" type="checkbox" id="edit_redefinir_senha_login" name="redefinir_senha_login" value="1">
                        <label class="form-check-label" for="edit_redefinir_senha_login">
                            Forçar redefinição de senha no próximo login
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

<!-- Modal Excluir Usuário -->
<div class="modal fade" id="excluirUsuarioModal" tabindex="-1">
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
                <h5>Tem certeza que deseja excluir este usuário?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="usuarioNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirUsuarioForm" method="POST" style="display: inline;">
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
    /* Adicionando estilos CSS que estavam faltantes */
    .btn-primary-custom {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: white;
    }

    .product-card {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.2);
    }

    .product-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }

    .product-info h6 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    .product-info p {
        margin: 0;
        color: #6b7280;
        font-size: 12px;
    }

    .card-custom {
        background: white;
        border: 1px solid rgba(59, 130, 246, 0.1);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.1);
    }

    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .results-info {
        color: #6b7280;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .per-page-selector .form-select {
        width: auto;
        min-width: 80px;
    }

    .status-ativo {
        color: #10b981;
        font-size: 8px;
        margin-right: 8px;
    }

    .status-inativo {
        color: #ef4444;
        font-size: 8px;
        margin-right: 8px;
    }

    .table th {
        border-top: none;
        border-bottom: 2px solid #e5e7eb;
        font-weight: 600;
        font-size: 13px;
        padding: 12px;
    }

    .table td {
        border-top: 1px solid #f3f4f6;
        padding: 12px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }

    .btn-group .btn {
        margin-right: 2px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .pagination-wrapper {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .pagination-controls {
            flex-direction: column;
            text-align: center;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        
        .btn-group .btn {
            margin-right: 0;
            margin-bottom: 2px;
            border-radius: 4px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit dos filtros
    document.querySelector('input[name="nome"]').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    document.querySelector('input[name="email"]').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    @if(Auth::user()->master == 1)
    document.querySelector('select[name="master"]').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    @endif

    document.querySelector('select[name="ativo"]').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    // Seletor de itens por página
    document.getElementById('perPage').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Função para visualizar usuário
    function visualizarUsuario(id) {
        const linha = document.querySelector(`tr[data-user-id="${id}"]`);
        const nome = linha.dataset.nome;
        const email = linha.dataset.email;
        const master = linha.dataset.master;
        const ativo = linha.dataset.ativo;
        const redefinirSenha = linha.dataset.redefinirSenha;
        
        const content = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Nome:</strong><br>
                    <span class="text-muted">${nome}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>E-mail:</strong><br>
                    <span class="text-muted">${email}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Tipo:</strong><br>
                    <span class="badge bg-${master == '1' ? 'warning' : 'info'}">${master == '1' ? 'Master' : 'Regular'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${ativo == '1' ? 'success' : 'danger'}">${ativo == '1' ? 'Ativo' : 'Inativo'}</span>
                </div>
                <div class="col-12 mb-3">
                    <strong>Redefinir senha no login:</strong><br>
                    <span class="badge bg-${redefinirSenha == '1' ? 'warning' : 'secondary'}">${redefinirSenha == '1' ? 'Sim' : 'Não'}</span>
                </div>
            </div>
        `;
        
        document.getElementById('visualizarUsuarioContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('visualizarUsuarioModal')).show();
    }

    // Função para editar usuário
    function editarUsuario(id) {
        const linha = document.querySelector(`tr[data-user-id="${id}"]`);
        
        document.getElementById('edit_nome').value = linha.dataset.nome;
        document.getElementById('edit_email').value = linha.dataset.email;
        // document.getElementById('edit_master').checked = linha.dataset.master == '1';
        document.getElementById('edit_ativo').checked = linha.dataset.ativo == '1';
        document.getElementById('edit_redefinir_senha_login').checked = linha.dataset.redefinirSenha == '1';
        
        document.getElementById('editarUsuarioForm').action = `/admin/users/${id}`;
        new bootstrap.Modal(document.getElementById('editarUsuarioModal')).show();
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('usuarioNomeExcluir').textContent = nome;
        document.getElementById('excluirUsuarioForm').action = `/admin/users/${id}`;
        new bootstrap.Modal(document.getElementById('excluirUsuarioModal')).show();
    }
</script>
@endpush
@endsection
