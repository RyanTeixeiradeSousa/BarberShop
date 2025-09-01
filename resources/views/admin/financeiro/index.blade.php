@extends('layouts.app')

@section('title', 'Financeiro - BarberShop Pro')
@section('page-title', 'Financeiro')
@section('page-subtitle', 'Gerencie entradas e saídas da barbearia')

@section('content')
<div class="container-fluid">
    <!-- CHANGE> Aplicando header padronizado igual ao de clientes -->
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-chart-line me-2" style="color: #60a5fa;"></i>
                Controle Financeiro
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie entradas e saídas da barbearia</p>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#criarMovimentacaoModal">
                <i class="fas fa-plus me-1"></i>
                Nova Movimentação
            </button>
        </div>
    </div>

    <!-- CHANGE> Aplicando cards de estatísticas com avatars coloridos igual ao de clientes -->
    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">R$ {{ number_format($totalEntradas, 2, ',', '.') }}</h4>
                        <p class="text-muted mb-0">Total Entradas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">R$ {{ number_format($totalSaidas, 2, ',', '.') }}</h4>
                        <p class="text-muted mb-0">Total Saídas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0 {{ $saldoAtual >= 0 ? 'text-success' : 'text-danger' }}">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</h4>
                        <p class="text-muted mb-0">Saldo Atual</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $totalMovimentacoes }}</h4>
                        <p class="text-muted mb-0">Total Movimentações</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHANGE> Aplicando card de filtros colapsável com botão limpar igual ao de clientes -->
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
                        <form method="GET" action="{{ route('financeiro.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar movimentações..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;" id="busca">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="tipo" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;" id="tipo">
                                    <option value="">Todos os tipos</option>
                                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                    <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="data_inicio" value="{{ request('data_inicio') }}" placeholder="Data início" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;" id="data_inicio">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="data_fim" value="{{ request('data_fim') }}" placeholder="Data fim" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;" id="data_fim">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('financeiro.index') }}" class="btn btn-outline-secondary w-100">
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

    <!-- CHANGE> Aplicando card da tabela com mesmo estilo de clientes -->
    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($movimentacoes) && $movimentacoes->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $movimentacoes->firstItem() }} a {{ $movimentacoes->lastItem() }} de {{ $movimentacoes->total() }} resultados
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
                                <th style="color: #1f2937;">Data</th>
                                <th style="color: #1f2937;">Tipo</th>
                                <th style="color: #1f2937;">Descrição</th>
                                <th style="color: #1f2937;">Cliente</th>
                                <th style="color: #1f2937;">Categoria</th>
                                <th style="color: #1f2937;">Situação</th>
                                <th style="color: #1f2937;">Valor</th>
                                <th width="160" style="color: #1f2937;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimentacoes as $movimentacao)
                            <tr>
                                <td>{{ $movimentacao->data->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $movimentacao->tipo == 'entrada' ? 'success' : 'danger' }}">
                                        <i class="fas fa-arrow-{{ $movimentacao->tipo == 'entrada' ? 'up' : 'down' }} me-1"></i>
                                        {{ ucfirst($movimentacao->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $movimentacao->descricao }}</td>
                                <td>{{ $movimentacao->cliente->nome ?? '-' }}</td>
                                <td>{{ $movimentacao->categoriaFinanceira->nome ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $movimentacao->situacao == 'pago' ? 'success' : ($movimentacao->situacao == 'cancelado' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $movimentacao->situacao)) }}
                                    </span>
                                </td>
                                <td class="text-{{ $movimentacao->tipo == 'entrada' ? 'success' : 'danger' }} fw-bold">
                                    R$ {{ number_format($movimentacao->valor, 2, ',', '.') }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                         <!-- CHANGE> Removendo botão visualizar e adicionando botão processos -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarMovimentacao({{ $movimentacao->id }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" title="Processos">
                                                <i class="fas fa-cogs"></i> Processos
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($movimentacao->situacao == 'em_aberto')
                                                    <li><a class="dropdown-item" href="#" onclick="abrirModalBaixar({{ $movimentacao->id }})"><i class="fas fa-check me-2"></i>Baixar</a></li>
                                                @endif
                                                @if($movimentacao->situacao == 'em_aberto' || $movimentacao->situacao == 'pago')
                                                    <li><a class="dropdown-item" href="#" onclick="abrirModalCancelar({{ $movimentacao->id }}, '{{ $movimentacao->descricao }}')"><i class="fas fa-ban me-2"></i>Cancelar</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarExclusao({{ $movimentacao->id }}, '{{ $movimentacao->descricao }}')" title="Excluir">
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
                            Mostrando {{ $movimentacoes->firstItem() }} a {{ $movimentacoes->lastItem() }} de {{ $movimentacoes->total() }} resultados
                        </div>
                        {{ $movimentacoes->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma movimentação encontrada</h5>
                    <p class="text-muted">Cadastre a primeira movimentação financeira</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#criarMovimentacaoModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Movimentação
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Movimentação -->
<div class="modal fade" id="criarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">  <!-- CHANGE> Aumentando tamanho do modal para acomodar produtos -->
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Nova Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="data" class="form-label">Data *</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="data_vencimento" class="form-label">Data Vencimento</label>
                            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento">
                        </div>
                        <div class="col-md-3 mb-3">
                             <!-- CHANGE> Adicionando campo agendamento -->
                            <label for="agendamento_id" class="form-label">Agendamento</label>
                            <select class="form-select" id="agendamento_id" name="agendamento_id">
                                <option value="">Selecione...</option>
                                @foreach($agendamentos as $agendamento)
                                    <option value="{{ $agendamento->id }}">
                                        {{ $agendamento->data_agendamento->format('d/m/Y') }} - {{ $agendamento->cliente->nome ?? 'Sem cliente' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição *</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select class="form-select" id="cliente_id" name="cliente_id">
                                <option value="">Selecione...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categoria_financeira_id" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria_financeira_id" name="categoria_financeira_id">
                                <option value="">Selecione...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <!-- CHANGE> Adicionando seção de produtos -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 2px solid #0ea5e9;">
                            <h6 class="text-primary mb-0 fw-bold">
                                <i class="fas fa-box me-2"></i>Produtos/Serviços Associados
                            </h6>
                            <button type="button" class="btn btn-primary btn-sm shadow-sm" onclick="adicionarProduto()">
                                <i class="fas fa-plus me-1"></i>Adicionar Produto
                            </button>
                        </div>
                        <div id="produtos-container" class="produtos-highlight">
                             <!-- Produtos serão adicionados aqui via JavaScript -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="valor" class="form-label">Valor *</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="situacao" class="form-label">Situação *</label>
                            <select class="form-select" id="situacao" name="situacao" required>
                                <option value="em_aberto">Em Aberto</option>
                                <option value="pago">Pago</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                             <!-- CHANGE> Removendo checkbox baixar do modal criar -->
                        </div>
                    </div>
                    
                     <!-- CHANGE> Removendo seção de campos de pagamento do modal criar -->
                    
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                    </div>
                     <!-- CHANGE> Ocultando campo ativo com display none e sempre checked -->
                    <div class="form-check" style="display: none;">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="ativo">
                            Ativo
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

 <!-- CHANGE> Removendo modal de visualizar completamente -->
 <div class="modal fade" id="excluirMovimentacaoModal" tabindex="-1">
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
                <h5>Tem certeza que deseja excluir esta movimentação?</h5>
                <div class="alert alert-danger mt-3">
                    <strong id="movimentacaoNomeExcluir"></strong>
                </div>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="excluirMovimentacaoForm" method="POST" style="display: inline;">
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

<!-- Modal Editar Movimentação -->
<div class="modal fade" id="editarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Visualizar/Editar Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarMovimentacaoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_tipo" class="form-label">Tipo *</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <select class="form-select" id="edit_tipo" name="tipo" required disabled>
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_data" class="form-label">Data *</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <input type="date" class="form-control" id="edit_data" name="data" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_data_vencimento" class="form-label">Data Vencimento</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <input type="date" class="form-control" id="edit_data_vencimento" name="data_vencimento" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição *</label>
                         <!-- CHANGE> Tornando campo readonly -->
                        <input type="text" class="form-control" id="edit_descricao" name="descricao" required readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_cliente_id" class="form-label">Cliente</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <select class="form-select" id="edit_cliente_id" name="cliente_id" disabled>
                                <option value="">Selecione...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_categoria_financeira_id" class="form-label">Categoria</label>
                             <!-- CHANGE> Mantendo campo editável -->
                            <select class="form-select" id="edit_categoria_financeira_id" name="categoria_financeira_id">
                                <option value="">Selecione...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_valor" class="form-label">Valor *</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <input type="text" class="form-control" id="edit_valor" name="valor" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_situacao" class="form-label">Situação *</label>
                             <!-- CHANGE> Tornando campo readonly -->
                            <select class="form-select" id="edit_situacao" name="situacao" required disabled>
                                <option value="em_aberto">Em Aberto</option>
                                <option value="pago">Pago</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                             <!-- CHANGE> Removendo checkbox baixar -->
                        </div>
                    </div>
                    
                     <!-- CHANGE> Adicionando seção de dados de pagamento para visualização quando status for "Pago" -->
                    <div id="dadosPagamento" style="display: none;">
                        <hr>
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-credit-card me-2"></i>Dados do Pagamento
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_forma_pagamento_id" class="form-label">Forma de Pagamento</label>
                                <select class="form-select" id="edit_forma_pagamento_id" name="forma_pagamento_id" disabled>
                                    <option value="">Selecione...</option>
                                    @foreach($formasPagamento as $forma)
                                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_data_pagamento" class="form-label">Data do Pagamento</label>
                                <input type="date" class="form-control" id="edit_data_pagamento" name="data_pagamento" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_desconto" class="form-label">Desconto</label>
                                <input type="text" class="form-control" id="edit_desconto" name="desconto" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_valor_pago" class="form-label">Valor Pago</label>
                                <input type="text" class="form-control" id="edit_valor_pago" name="valor_pago" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_observacoes" class="form-label">Observações</label>
                         <!-- CHANGE> Mantendo campo editável -->
                        <textarea class="form-control" id="edit_observacoes" name="observacoes" rows="3"></textarea>
                    </div>
                     <!-- CHANGE> Ocultando campo ativo com display none e sempre checked -->
                    <div class="form-check" style="display: none;">
                        <input class="form-check-input" type="checkbox" id="edit_ativo" name="ativo" value="1" checked>
                        <label class="form-check-label" for="edit_ativo">
                            Ativo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- CHANGE> Adicionando modal para baixar movimentação -->
<div class="modal fade" id="baixarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #10b981; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-bottom: 1px solid #10b981;">
                <h5 class="modal-title text-success">
                    <i class="fas fa-check me-2"></i>Baixar Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="baixarMovimentacaoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Preencha os dados para baixar esta movimentação como paga.
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="baixar_forma_pagamento_id" class="form-label">Forma de Pagamento *</label>
                            <select class="form-select" id="baixar_forma_pagamento_id" name="forma_pagamento_id" required>
                                <option value="">Selecione...</option>
                                @foreach($formasPagamento as $forma)
                                    <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="baixar_data_pagamento" class="form-label">Data Pagamento *</label>
                            <input type="date" class="form-control" id="baixar_data_pagamento" name="data_pagamento" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="baixar_desconto" class="form-label">Desconto</label>
                            <input type="text" class="form-control" id="baixar_desconto" name="desconto" value="R$ 0,00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="baixar_valor_pago" class="form-label">Valor Pago *</label>
                            <input type="text" class="form-control" id="baixar_valor_pago" name="valor_pago" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Baixar Movimentação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- CHANGE> Adicionando modal para cancelar movimentação -->
<div class="modal fade" id="cancelarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #f59e0b; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-bottom: 1px solid #f59e0b;">
                <h5 class="modal-title text-warning">
                    <i class="fas fa-ban me-2"></i>Cancelar Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Tem certeza que deseja cancelar esta movimentação?</h5>
                <div class="alert alert-warning mt-3">
                    <strong id="movimentacaoNomeCancelar"></strong>
                </div>
                <p class="text-muted">O status será alterado para "Cancelado".</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <form id="cancelarMovimentacaoForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-ban me-2"></i>Sim, Cancelar
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

    /* Adicionando estilos para destacar produtos */
    .produtos-highlight .produto-item {
        background: linear-gradient(135deg, #fefefe 0%, #f8fafc 100%);
        border: 2px solid #60a5fa !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
        margin-bottom: 1rem !important;
        box-shadow: 0 4px 20px rgba(96, 165, 250, 0.15);
        transition: all 0.3s ease;
    }

    .produtos-highlight .produto-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(96, 165, 250, 0.25);
        border-color: #3b82f6 !important;
    }

    .produtos-highlight .form-label {
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 0.5rem;
    }

    .produtos-highlight .form-select,
    .produtos-highlight .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .produtos-highlight .form-select:focus,
    .produtos-highlight .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
    }

    .produto-header {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid #3b82f6;
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
    let produtoIndex = 1;

    function aplicarMascaraMonetaria(elemento) {
        if (!elemento) return;
        elemento.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            valor = (valor / 100).toFixed(2) + '';
            valor = valor.replace(".", ",");
            valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = 'R$ ' + valor;
        });
    }

    // Aplicar máscara nos campos de valor
    document.addEventListener('DOMContentLoaded', function() {
        aplicarMascaraMonetaria(document.getElementById('valor'));
        aplicarMascaraMonetaria(document.getElementById('edit_valor'));
        aplicarMascaraMonetaria(document.getElementById('baixar_desconto'));
        aplicarMascaraMonetaria(document.getElementById('baixar_valor_pago'));

    });


    function editarMovimentacao(id) {
        fetch(`/admin/financeiro/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editarMovimentacaoForm').action = `/financeiro/${id}`;
                
                // Preencher campos
                document.getElementById('edit_tipo').value = data.tipo || '';
                document.getElementById('edit_descricao').value = data.descricao || '';
                document.getElementById('edit_valor').value = data.valor ? `R$ ${parseFloat(data.valor).toFixed(2).replace('.', ',')}` : '';
                document.getElementById('edit_data').value = data.data || '';
                document.getElementById('edit_data_vencimento').value = data.data_vencimento || '';
                document.getElementById('edit_cliente_id').value = data.cliente_id || '';
                document.getElementById('edit_categoria_financeira_id').value = data.categoria_financeira_id || '';
                document.getElementById('edit_situacao').value = data.situacao || '';
                document.getElementById('edit_observacoes').value = data.observacoes || '';
                
                const dadosPagamento = document.getElementById('dadosPagamento');
                if (data.situacao === 'pago') {
                    dadosPagamento.style.display = 'block';
                    
                    // Preencher campos de pagamento
                    document.getElementById('edit_forma_pagamento_id').value = data.forma_pagamento_id || '';
                    document.getElementById('edit_data_pagamento').value = data.data_pagamento || '';
                    document.getElementById('edit_desconto').value = data.desconto ? `R$ ${parseFloat(data.desconto).toFixed(2).replace('.', ',')}` : 'R$ 0,00';
                    document.getElementById('edit_valor_pago').value = data.valor_pago ? `R$ ${parseFloat(data.valor_pago).toFixed(2).replace('.', ',')}` : '';
                } else {
                    dadosPagamento.style.display = 'none';
                }
                
                const modal = new bootstrap.Modal(document.getElementById('editarMovimentacaoModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar dados da movimentação');
            });
    }

    function abrirModalBaixar(id) {
        document.getElementById('baixarMovimentacaoForm').action = `/admin/financeiro/${id}/baixar`;
        
        // Definir data atual como padrão
        const hoje = new Date().toISOString().split('T')[0];
        document.getElementById('baixar_data_pagamento').value = hoje;
        
        const modal = new bootstrap.Modal(document.getElementById('baixarMovimentacaoModal'));
        modal.show();
    }

    function abrirModalCancelar(id, nome) {
        document.getElementById('cancelarMovimentacaoForm').action = `/admin/financeiro/${id}/cancelar`;
        document.getElementById('movimentacaoNomeCancelar').textContent = nome;
        
        const modal = new bootstrap.Modal(document.getElementById('cancelarMovimentacaoModal'));
        modal.show();
    }

    function confirmarExclusao(id, nome) {
        document.getElementById('excluirMovimentacaoForm').action = `/admin/financeiro/${id}`;
        document.getElementById('movimentacaoNomeExcluir').textContent = nome;
        const modal = new bootstrap.Modal(document.getElementById('excluirMovimentacaoModal'));
        modal.show();
    }

    function adicionarProduto() {
        const container = document.getElementById('produtos-container');
        const produtoHtml = `
            <div class="produto-item" data-index="${produtoIndex}">
                <div class="produto-header">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-tag me-2"></i>Produto/Serviço #${produtoIndex + 1}
                    </h6>
                </div>
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Produto/Serviço</label>
                        <select class="form-select" name="produtos[${produtoIndex}][id]" required>
                            <option value="">Selecione...</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control" name="produtos[${produtoIndex}][quantidade]" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Valor Unitário</label>
                        <input type="text" class="form-control valor-monetario" name="produtos[${produtoIndex}][valor_unitario]" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 shadow-sm" onclick="removerProduto(${produtoIndex})">
                            <i class="fas fa-trash me-1"></i> Remover
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', produtoHtml);
        
        // Aplicar máscara monetária no novo campo
        const novosCampos = container.querySelectorAll(`[data-index="${produtoIndex}"] .valor-monetario`);
        novosCampos.forEach(aplicarMascaraMonetaria);
        
        produtoIndex++;
    }

    function removerProduto(index) {
        const produto = document.querySelector(`[data-index="${index}"]`);
        if (produto) {
            produto.remove();
        }
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('valor-monetario')) {
            aplicarMascaraMonetaria(e.target);
        }
    });

    // Função para limpar filtros
    function limparFiltros() {
        document.getElementById('busca').value = '';
        document.getElementById('tipo').value = '';
        document.getElementById('situacao').value = '';
        document.getElementById('data_inicio').value = '';
        document.getElementById('data_fim').value = '';
        document.getElementById('filtrosForm').submit();
    }

    // Auto-submit dos filtros
    const buscaInput = document.querySelector('input[name="busca"]');
    const tipoSelect = document.querySelector('select[name="tipo"]');
    const situacaoSelect = document.querySelector('select[name="situacao"]');
    const dataInicioInput = document.querySelector('input[name="data_inicio"]');
    const dataFimInput = document.querySelector('input[name="data_fim"]');
    
    if (buscaInput) {
        buscaInput.addEventListener('input', function() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                const form = document.getElementById('filterForm') || document.getElementById('filtrosForm');
                if (form) form.submit();
            }, 500);
        });
    }

    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            const form = document.getElementById('filterForm') || document.getElementById('filtrosForm');
            if (form) form.submit();
        });
    }

    if (situacaoSelect) {
        situacaoSelect.addEventListener('change', function() {
            const form = document.getElementById('filterForm') || document.getElementById('filtrosForm');
            if (form) form.submit();
        });
    }

    if (dataInicioInput) {
        dataInicioInput.addEventListener('change', function() {
            const form = document.getElementById('filterForm') || document.getElementById('filtrosForm');
            if (form) form.submit();
        });
    }

    if (dataFimInput) {
        dataFimInput.addEventListener('change', function() {
            const form = document.getElementById('filterForm') || document.getElementById('filtrosForm');
            if (form) form.submit();
        });
    }

    // Seletor de itens por página
    const perPageSelect = document.getElementById('perPage');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }
</script>
@endpush
@endsection
