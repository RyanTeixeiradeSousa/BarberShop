@extends('layouts.app')

@section('title', 'Barbeiros - BarberShop Pro')
@section('page-title', 'Barbeiros')
@section('page-subtitle', 'Gerencie os barbeiros da barbearia')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-cut me-2" style="color: #60a5fa;"></i>
                Barbeiros
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gerencie os barbeiros da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarBarbeiroModal">
                <i class="fas fa-plus me-1"></i>
                Novo Barbeiro
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Barbeiros</p>
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
                        <p class="text-muted mb-0">Barbeiros Ativos</p>
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
                        <h4 class="mb-0">{{ $stats['inativos'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Barbeiros Inativos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $stats['este_mes'] ?? 0 }}</h4>
                        <p class="text-muted mb-0">Cadastrados Este Mês</p>
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
                        <form method="GET" action="{{ route('barbeiros.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar barbeiros..." style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
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
                                <a href="{{ route('barbeiros.index') }}" class="btn btn-outline-secondary w-100">
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
            @if(isset($barbeiros) && $barbeiros->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $barbeiros->firstItem() }} a {{ $barbeiros->lastItem() }} de {{ $barbeiros->total() }} resultados
                            </div>
                            
                            <div class="per-page-selector">
                                <label for="perPage" class="form-label mb-0" style="color: var(--text-primary);">Itens por página:</label>
                                <select class="form-select form-select-sm" id="perPage" style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
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
                                <th style="color: var(--text-primary);">Barbeiro</th>
                                <th style="color: var(--text-primary);">Contato</th>
                                <th style="color: var(--text-primary);">Email</th>
                                <th style="color: var(--text-primary);">Data Nascimento</th>
                                <th style="color: var(--text-primary);">Status</th>
                                <th width="160" style="color: var(--text-primary);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barbeiros as $barbeiro)
                            <tr data-barbeiro-id="{{ $barbeiro->id }}" 
                                data-nome="{{ $barbeiro->nome }}" 
                                data-cpf="{{ $barbeiro->cpf }}"
                                data-rg="{{ $barbeiro->rg }}"
                                data-email="{{ $barbeiro->email }}"
                                data-data-nascimento="{{ $barbeiro->data_nascimento }}"
                                data-telefone="{{ $barbeiro->telefone }}"
                                data-endereco="{{ $barbeiro->endereco }}"
                                data-ativo="{{ $barbeiro->ativo }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($barbeiro->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $barbeiro->nome }}</h6>
                                            @if($barbeiro->cpf)
                                                <p>{{ $barbeiro->cpf }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($barbeiro->telefone)
                                        <div><i class="fas fa-phone me-1"></i> {{ $barbeiro->telefone }}</div>
                                    @else
                                        <span class="text-muted">Sem telefone</span>
                                    @endif
                                </td>
                                <td>
                                    @if($barbeiro->email)
                                        {{ $barbeiro->email }}
                                    @else
                                        <span class="text-muted">Sem email</span>
                                    @endif
                                </td>
                                <td>
                                    @if($barbeiro->data_nascimento)
                                        {{ $barbeiro->data_nascimento->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-circle status-{{ $barbeiro->ativo ? 'ativo' : 'inativo' }}"></i>
                                    {{ $barbeiro->ativo ? 'Ativo' : 'Inativo' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="visualizarBarbeiro({{ $barbeiro->id }})" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarBarbeiro({{ $barbeiro->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Adicionando botão para gerenciar filiais -->
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="gerenciarFiliais({{ $barbeiro->id }})" title="Gerenciar Filiais">
                                            <i class="fas fa-building"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $barbeiro->id }}, '{{ $barbeiro->nome }}')" title="Excluir">
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
                            Mostrando {{ $barbeiros->firstItem() }} a {{ $barbeiros->lastItem() }} de {{ $barbeiros->total() }} resultados
                        </div>
                        {{ $barbeiros->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-cut fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum barbeiro encontrado</h5>
                    <p class="text-muted">Cadastre o primeiro barbeiro para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarBarbeiroModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Barbeiro
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Barbeiro -->
<div class="modal fade" id="criarBarbeiroModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Novo Barbeiro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('barbeiros.store') }}" method="POST">
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
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="rg" name="rg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3"></textarea>
                    </div>
                    
                    <!-- Adicionando campos de comissão padrão -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h6 class="text-primary"><i class="fas fa-percentage me-2"></i>Comissão Padrão</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo_comissao_default" class="form-label">Tipo de Comissão *</label>
                            <select class="form-select" id="tipo_comissao_default" name="tipo_comissao_default" required onchange="toggleTipoComissaoDefault()">
                                <option value="percentual">Percentual (%)</option>
                                <option value="valor_fixo">Valor Fixo (R$)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="valor_comissao_default" class="form-label">
                                <span id="label_valor_default">Percentual (%)</span> *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="simbolo_default">%</span>
                                <input type="number" class="form-control" id="valor_comissao_default" name="valor_comissao_default" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="ativo">
                            Barbeiro Ativo
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

<!-- Modal Visualizar Barbeiro -->
<div class="modal fade" id="visualizarBarbeiroModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes do Barbeiro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarBarbeiroContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Barbeiro -->
<div class="modal fade" id="editarBarbeiroModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: var(--card-header-bg); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Barbeiro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarBarbeiroForm" method="POST">
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
                            <label for="edit_cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="edit_cpf" name="cpf" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="edit_rg" name="rg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone" class="form-label">Telefone *</label>
                            <input type="text" class="form-control" id="edit_telefone" name="telefone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="edit_data_nascimento" name="data_nascimento">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_endereco" class="form-label">Endereço</label>
                        <textarea class="form-control" id="edit_endereco" name="endereco" rows="3"></textarea>
                    </div>
                    
                    <!-- Adicionando campos de comissão padrão no formulário de edição -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h6 class="text-primary"><i class="fas fa-percentage me-2"></i>Comissão Padrão</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tipo_comissao_default" class="form-label">Tipo de Comissão *</label>
                            <select class="form-select" id="edit_tipo_comissao_default" name="tipo_comissao_default" required onchange="toggleTipoComissaoEditDefault()">
                                <option value="percentual">Percentual (%)</option>
                                <option value="valor_fixo">Valor Fixo (R$)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_valor_comissao_default" class="form-label">
                                <span id="edit_label_valor_default">Percentual (%)</span> *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="edit_simbolo_default">%</span>
                                <input type="number" class="form-control" id="edit_valor_comissao_default" name="valor_comissao_default" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_ativo" name="ativo" value="1">
                        <label class="form-check-label" for="edit_ativo">
                            Barbeiro Ativo
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

<!-- Modal Excluir Barbeiro -->
<div class="modal fade" id="excluirBarbeiroModal" tabindex="-1">
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
                <h5>Tem certeza que deseja excluir este barbeiro?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="barbeiroNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirBarbeiroForm" method="POST" style="display: inline;">
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

<!-- Modificando o offcanvas para incluir sistema de comissões -->
<!-- Simplificando offcanvas para apenas vincular filiais -->
<!-- Offcanvas Gerenciar Filiais -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="gerenciarFiliaisOffcanvas" style="width: 400px;">
    <div class="offcanvas-header" style="background: var(--card-header-bg); border-bottom: 2px solid #60a5fa;">
        <h5 class="offcanvas-title">
            <i class="fas fa-building me-2"></i>Gerenciar Filiais
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div id="filiaisContent">
            <!-- Conteúdo será carregado via JavaScript -->
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0a0a0a 0%, #1e293b 100%);
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

    /* Adicionando estilos para o offcanvas personalizado */
    .offcanvas-filiais {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1055;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .offcanvas-filiais.show {
        visibility: visible;
        opacity: 1;
    }

    .offcanvas-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .offcanvas-content {
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background: var(--card-bg);
        border-left: 2px solid var(--border-color);
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .offcanvas-filiais.show .offcanvas-content {
        transform: translateX(0);
    }

    .offcanvas-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--card-header-bg);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .offcanvas-title {
        margin: 0;
        color: var(--text-primary);
        font-weight: 600;
    }

    .btn-close-custom {
        background: none;
        border: none;
        color: var(--text-primary);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-close-custom:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .offcanvas-body {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
    }

    .barbeiro-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 8px;
        padding: 1rem;
    }

    .filial-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .filial-item:hover {
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateY(-1px);
    }

    .filial-item.vinculada {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }

    .filial-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .filial-nome {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .filial-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-weight: 500;
    }

    .status-vinculada {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .status-disponivel {
        background: rgba(107, 114, 128, 0.2);
        color: #6b7280;
    }

    .filial-info {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
    }

    .filial-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-vincular {
        background: linear-gradient(45deg, #10b981, #34d399);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-vincular:hover {
        background: linear-gradient(45deg, #059669, #10b981);
        transform: translateY(-1px);
        color: white;
    }

    .btn-desvincular {
        background: linear-gradient(45deg, #ef4444, #f87171);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-desvincular:hover {
        background: linear-gradient(45deg, #dc2626, #ef4444);
        transform: translateY(-1px);
        color: white;
    }

    .btn-outline-warning {
        border-color: #f59e0b;
        color: #f59e0b;
        background: var(--card-bg);
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover {
        background: rgba(245, 158, 11, 0.1);
        border-color: #d97706;
        color: #d97706;
    }

    /* Adicionando estilos para o sistema de comissões */
    .nav-tabs-custom .nav-tabs {
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        color: var(--text-muted);
        padding: 0.75rem 1rem;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-tabs-custom .nav-link:hover {
        color: var(--text-primary);
        background: rgba(59, 130, 246, 0.1);
    }

    .nav-tabs-custom .nav-link.active {
        color: #3b82f6;
        background: rgba(59, 130, 246, 0.1);
        border-bottom: 2px solid #3b82f6;
    }

    .comissao-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .comissao-card:hover {
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateY(-1px);
    }

    .comissao-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .comissao-filial {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .comissao-valor {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .comissao-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
    }

    .comissao-info-item {
        color: var(--text-muted);
    }

    .comissao-info-item strong {
        color: var(--text-primary);
    }

    .comissao-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-comissao-base {
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
        border: none;
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-comissao-base:hover {
        background: linear-gradient(45deg, #2563eb, #3b82f6);
        transform: translateY(-1px);
        color: white;
    }

    .btn-comissao-servicos {
        background: linear-gradient(45deg, #8b5cf6, #a78bfa);
        border: none;
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-comissao-servicos:hover {
        background: linear-gradient(45deg, #7c3aed, #8b5cf6);
        transform: translateY(-1px);
        color: white;
    }

    .servico-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    .servico-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .servico-nome {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .servico-preco {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .servico-comissao {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 0.75rem;
        align-items: center;
    }

    .input-comissao {
        max-width: 120px;
    }

    .comissao-atual {
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .comissao-atual.tem-comissao {
        color: #10b981;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .offcanvas-content {
            width: 100%;
        }

        .comissao-info {
            grid-template-columns: 1fr;
        }

        .servico-comissao {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .input-comissao {
            max-width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentBarbeiroId = null;

    function gerenciarFiliais(barbeiroId) {
        currentBarbeiroId = barbeiroId;
        carregarFiliais();
        new bootstrap.Offcanvas(document.getElementById('gerenciarFiliaisOffcanvas')).show();
    }

    function carregarFiliais() {
        if (!currentBarbeiroId) return;
        
        fetch(`/barbeiros/${currentBarbeiroId}/filiais`)
            .then(response => response.json())
            .then(data => {
                let html = '<div class="mb-3"><h6>Filiais Disponíveis</h6></div>';
                
                data.filiais.forEach(filial => {
                    const isVinculada = data.vinculadas.includes(filial.id);
                    
                    html += `
                        <div class="card mb-2">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">${filial.nome}</h6>
                                        <small class="text-muted">${filial.endereco || 'Endereço não informado'}</small>
                                    </div>
                                    <div>
                                        ${isVinculada ? 
                                            `<button class="btn btn-sm btn-danger me-2" onclick="desvincularFilial(${filial.id})">
                                                <i class="fas fa-unlink"></i> Desvincular
                                            </button>
                                            <button class="btn btn-sm btn-primary" onclick="gerenciarComissoes(${currentBarbeiroId}, ${filial.id})">
                                                <i class="fas fa-percentage"></i> Comissões
                                            </button>` :
                                            `<button class="btn btn-sm btn-success" onclick="vincularFilial(${filial.id})">
                                                <i class="fas fa-link"></i> Vincular
                                            </button>`
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                document.getElementById('filiaisContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao carregar filiais:', error);
                toastr.error('Erro ao carregar filiais');
            });
    }

    function vincularFilial(filialId) {
        if (!currentBarbeiroId) return;
        
        fetch(`/barbeiros/${currentBarbeiroId}/vincular-filial`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                filial_id: filialId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(data.message);
                carregarFiliais(); // Recarregar lista
            } else {
                alert(data.message || 'Erro ao desvincular filial');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            toastr.error('Erro ao vincular filial');
        });
    }

    function desvincularFilial(filialId) {
        if (!currentBarbeiroId) return;
        
        if (!confirm('Tem certeza que deseja desvincular esta filial?')) {
            return;
        }
        
        fetch(`/barbeiros/${currentBarbeiroId}/desvincular-filial`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            body: JSON.stringify({
                filial_id: filialId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(data.message);
                carregarFiliais(); // Recarregar lista
            } else {
                alert(data.message || 'Erro ao desvincular filial');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            toastr.error('Erro ao desvincular filial');
        });
    }

    function gerenciarComissoes(barbeiroId, filialId) {
        window.location.href = `/admin/comissoes/${barbeiroId}/${filialId}`;
    }


    // Auto-submit dos filtros
    document.querySelector('input[name="search"]').addEventListener('input', function() {
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
    aplicarMascaraTelefone(document.getElementById('telefone'));
    aplicarMascaraTelefone(document.getElementById('edit_telefone'));

    // Função para visualizar barbeiro
    function visualizarBarbeiro(id) {
        const linha = document.querySelector(`tr[data-barbeiro-id="${id}"]`);
        const nome = linha.dataset.nome;
        const cpf = linha.dataset.cpf;
        const rg = linha.dataset.rg;
        const email = linha.dataset.email;
        const dataNascimento = linha.dataset.dataNascimento;
        const telefone = linha.dataset.telefone;
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
                    <strong>RG:</strong><br>
                    <span class="text-muted">${rg || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong><br>
                    <span class="text-muted">${email || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Telefone:</strong><br>
                    <span class="text-muted">${telefone || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Data Nascimento:</strong><br>
                    <span class="text-muted">${dataNascimento || '-'}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${ativo == '1' ? 'success' : 'danger'}">${ativo == '1' ? 'Ativo' : 'Inativo'}</span>
                </div>
                <div class="col-12 mb-3">
                    <strong>Endereço:</strong><br>
                    <span class="text-muted">${endereco || '-'}</span>
                </div>
            </div>
        `;
        
        document.getElementById('visualizarBarbeiroContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('visualizarBarbeiroModal')).show();
    }

    // Função para editar barbeiro
    function editarBarbeiro(id) {
        fetch(`/barbeiros/${id}`)
            .then(response => response.json())
            .then(barbeiro => {
                document.getElementById('editarBarbeiroForm').action = `/barbeiros/${barbeiro.id}`;
                document.getElementById('edit_nome').value = barbeiro.nome;
                document.getElementById('edit_cpf').value = barbeiro.cpf;
                document.getElementById('edit_rg').value = barbeiro.rg || '';
                document.getElementById('edit_email').value = barbeiro.email;
                document.getElementById('edit_telefone').value = barbeiro.telefone;
                document.getElementById('edit_data_nascimento').value = barbeiro.data_nascimento || '';
                document.getElementById('edit_endereco').value = barbeiro.endereco || '';
                document.getElementById('edit_ativo').checked = barbeiro.ativo;
                
                document.getElementById('edit_tipo_comissao_default').value = barbeiro.tipo_comissao_default || 'percentual';
                document.getElementById('edit_valor_comissao_default').value = barbeiro.valor_comissao_default || '';
                toggleTipoComissaoEditDefault();
                
                new bootstrap.Modal(document.getElementById('editarBarbeiroModal')).show();
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('error', 'Erro ao carregar dados do barbeiro');
            });
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
        document.getElementById('barbeiroNomeExcluir').textContent = nome;
        document.getElementById('excluirBarbeiroForm').action = `/barbeiros/${id}`;
        new bootstrap.Modal(document.getElementById('excluirBarbeiroModal')).show();
    }

    function toggleTipoComissaoDefault() {
        const tipo = document.getElementById('tipo_comissao_default').value;
        const label = document.getElementById('label_valor_default');
        const simbolo = document.getElementById('simbolo_default');
        
        if (tipo === 'percentual') {
            label.textContent = 'Percentual (%)';
            simbolo.textContent = '%';
        } else {
            label.textContent = 'Valor Fixo (R$)';
            simbolo.textContent = 'R$';
        }
    }

    function toggleTipoComissaoEditDefault() {
        const tipo = document.getElementById('edit_tipo_comissao_default').value;
        const label = document.getElementById('edit_label_valor_default');
        const simbolo = document.getElementById('edit_simbolo_default');
        
        if (tipo === 'percentual') {
            label.textContent = 'Percentual (%)';
            simbolo.textContent = '%';
        } else {
            label.textContent = 'Valor Fixo (R$)';
            simbolo.textContent = 'R$';
        }
    }

    function showAlert(type, message) {
        // Implementação simples de alerta - pode ser substituída por uma biblioteca de toast
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'info' ? 'alert-info' : 'alert-warning';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-remover após 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }
</script>
@endpush
@endsection
