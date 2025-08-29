@extends('layouts.app')

@section('title', 'Agendamentos - BarberShop Pro')
@section('page-title', 'Agendamentos')
@section('page-subtitle', 'Gerencie todos os agendamentos de serviços')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: #1f2937;">
                <i class="fas fa-calendar-alt me-2" style="color: #60a5fa;"></i>
                Agendamentos
            </h2>
            <p class="mb-0" style="color: #6b7280;">Gerencie todos os agendamentos de serviços</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="d-flex gap-2 justify-content-end">
                <div class="dropdown">
                    <button class="btn btn-processos dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs me-2"></i>
                        <span>Processos</span>
                        <i class="fas fa-chevron-down ms-2 dropdown-icon"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-processos">
                        <li>
                            <h6 class="dropdown-header">
                                <i class="fas fa-list-ul me-2"></i>Processos Disponíveis
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item dropdown-item-processos" href="#" data-bs-toggle="modal" data-bs-target="#gerarLoteModal">
                                <div class="dropdown-item-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="dropdown-item-content">
                                    <div class="dropdown-item-title">Gerar em Lote</div>
                                    <div class="dropdown-item-description">Criar múltiplos agendamentos automaticamente</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus me-1"></i>
                    Novo Agendamento
                </button>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $total ?? 0 }}</h4>
                        <p class="text-muted mb-0">Total de Agendamentos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $agendados ?? 0 }}</h4>
                        <p class="text-muted mb-0">Agendados</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $concluidos ?? 0 }}</h4>
                        <p class="text-muted mb-0">Concluídos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #ef4444, #f87171);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $cancelados ?? 0 }}</h4>
                        <p class="text-muted mb-0">Cancelados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Filtros -->
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
                        <form method="GET" action="{{ route('agendamentos.index') }}" class="row g-3" id="filterForm">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="busca" value="{{ request('busca') }}" placeholder="Buscar agendamentos..." style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                                    <option value="">Todos os status</option>
                                    <option value="disponivel" {{ request('status') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                                    <option value="agendado" {{ request('status') == 'agendado' ? 'selected' : '' }}>Agendado</option>
                                    <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="concluido" {{ request('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                    <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="data_inicio" value="{{ request('data_inicio') }}" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="data_fim" value="{{ request('data_fim') }}" style="background: white; border: 1px solid rgba(59, 130, 246, 0.2); color: #1f2937;">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-outline-primary w-100" style="border-color: #60a5fa; color: #60a5fa;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('agendamentos.index') }}" class="btn btn-outline-secondary w-100">
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

    <!-- Card dos Agendamentos -->
    <div class="card-custom">
        <div class="card-body">
            @if(isset($agendamentos) && $agendamentos->count() > 0)
                <!-- Informações da Paginação -->
                <div class="card-custom mb-4">
                    <div class="card-body">
                        <div class="pagination-controls">
                            <div class="results-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando {{ $agendamentos->firstItem() }} a {{ $agendamentos->lastItem() }} de {{ $agendamentos->total() }} resultados
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

                <!-- Cards de Agendamentos -->
                <div class="row">
                    @foreach($agendamentos as $agendamento)
                    <div class="col-xl-4 col-lg-6 mb-4">
                        <div class="card-agendamento" onclick="viewAgendamento({{ $agendamento->id }})" data-bs-toggle="modal" data-bs-target="#viewModal"
                             data-id="{{ $agendamento->id }}"
                             data-cliente-id="{{ $agendamento->cliente_id }}"
                             data-data="{{ $agendamento->data_agendamento->format('Y-m-d') }}"
                             data-hora-inicio="{{ $agendamento->hora_inicio->format('H:i') }}"
                             data-status="{{ $agendamento->status }}"
                             data-observacoes="{{ $agendamento->observacoes }}"
                             data-valor="{{ $agendamento->valor_total }}">
                            <div class="card-header-agendamento">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-2">
                                            {{ $agendamento->cliente ? strtoupper(substr($agendamento->cliente->nome, 0, 2)) : 'SL' }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $agendamento->cliente->nome ?? 'Slot Livre' }}</h6>
                                            <small class="text-muted">{{ $agendamento->cliente->telefone1 ?? '' }}</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ $agendamento->status_color }}">
                                        {{ $agendamento->status_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body-agendamento">
                                <!-- Mostrando múltiplos serviços em vez de um único produto -->
                                <div class="service-info mb-3">
                                    @if($agendamento->produtos->count() > 0)
                                        @foreach($agendamento->produtos as $produto)
                                            <div class="service-item mb-2">
                                                <h6 class="service-name mb-1">{{ $produto->nome }}</h6>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Qtd: {{ $produto->pivot->quantidade }}</small>
                                                    <small class="text-success fw-bold">R$ {{ number_format($produto->pivot->valor_unitario, 2, ',', '.') }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h5 class="service-name">Serviços não definidos</h5>
                                        <p class="service-category text-muted mb-0">Slot disponível</p>
                                    @endif
                                </div>
                                <div class="appointment-details">
                                    <div class="detail-item">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span>{{ $agendamento->data_agendamento->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <span>{{ $agendamento->hora_inicio->format('H:i') }} - {{ $agendamento->hora_fim->format('H:i') }}</span>
                                    </div>
                                    @if($agendamento->valor_total)
                                    <div class="detail-item">
                                        <i class="fas fa-dollar-sign text-success me-2"></i>
                                        <span class="fw-bold">R$ {{ number_format($agendamento->valor_total, 2, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-actions">
                                @if($agendamento->isSlotDisponivel())
                                    <button type="button" class="btn btn-outline-success btn-sm" 
                                            onclick="event.stopPropagation(); associarSlot({{ $agendamento->id }})"
                                            data-bs-toggle="modal" data-bs-target="#associarModal">
                                        <i class="fas fa-user-plus"></i> Associar
                                    </button>
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        onclick="event.stopPropagation(); editAgendamento({{ $agendamento->id }})"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="event.stopPropagation(); deleteAgendamento({{ $agendamento->id }}, '{{ $agendamento->cliente->nome ?? 'Slot' }}')"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="pagination-wrapper">
                    <div class="pagination-controls">
                        <div class="results-info">
                            Mostrando {{ $agendamentos->firstItem() }} a {{ $agendamentos->lastItem() }} de {{ $agendamentos->total() }} resultados
                        </div>
                        {{ $agendamentos->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum agendamento encontrado</h5>
                    <p class="text-muted">Crie o primeiro agendamento para começar.</p>
                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Agendamento
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Slot -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Criar Slot de Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_agendamento" class="form-label">Data *</label>
                                <input type="date" class="form-control" id="data_agendamento" name="data_agendamento" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hora_inicio" class="form-label">Horário *</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Este slot será criado como "disponível" e poderá ser associado a clientes e serviços posteriormente.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Criar Slot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Associar Cliente e Serviços -->
<div class="modal fade" id="associarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="associarForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Associar Cliente e Serviços</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="associar-cliente_id" class="form-label">Cliente *</label>
                        <select class="form-select" id="associar-cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Seção para múltiplos serviços -->
                    <div class="mb-3">
                        <label class="form-label">Serviços *</label>
                        <div id="servicos-container">
                            <div class="servico-item border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Serviço</label>
                                        <select class="form-select servico-select" name="servicos[0][produto_id]" required>
                                            <option value="">Selecione um serviço</option>
                                            @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                                {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Quantidade</label>
                                        <input type="number" class="form-control quantidade-input" name="servicos[0][quantidade]" value="1" min="1" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-servico" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-servico">
                            <i class="fas fa-plus me-1"></i> Adicionar Serviço
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <label for="associar-observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="associar-observacoes" name="observacoes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Associar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Agendamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Cliente:</strong>
                        <p id="view-cliente"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="view-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Data:</strong>
                        <p id="view-data"></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Horário:</strong>
                        <p id="view-horario"></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Valor Total:</strong>
                        <p id="view-valor"></p>
                    </div>
                </div>
                <!-- Seção para mostrar múltiplos serviços -->
                <div class="row">
                    <div class="col-12">
                        <strong>Serviços:</strong>
                        <div id="view-servicos"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Observações:</strong>
                        <p id="view-observacoes"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-cliente_id" class="form-label">Cliente *</label>
                                <select class="form-select" id="edit-cliente_id" name="cliente_id" required>
                                    <option value="">Selecione um cliente</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-status" class="form-label">Status *</label>
                                <select class="form-select" id="edit-status" name="status" required>
                                    <option value="disponivel">Disponível</option>
                                    <option value="agendado">Agendado</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-data_agendamento" class="form-label">Data *</label>
                                <input type="date" class="form-control" id="edit-data_agendamento" name="data_agendamento" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit-hora_inicio" class="form-label">Horário *</label>
                                <input type="time" class="form-control" id="edit-hora_inicio" name="hora_inicio" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Seção para editar múltiplos serviços -->
                    <div class="mb-3">
                        <label class="form-label">Serviços *</label>
                        <div id="edit-servicos-container">
                            <!-- Serviços serão carregados via JavaScript -->
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="edit-add-servico">
                            <i class="fas fa-plus me-1"></i> Adicionar Serviço
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="edit-observacoes" name="observacoes" rows="3"></textarea>
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
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h5>Tem certeza que deseja excluir?</h5>
                        <div class="alert alert-danger">
                            <strong>Agendamento:</strong> <span id="delete-agendamento-name"></span>
                        </div>
                        <p class="text-muted">Esta ação não pode ser desfeita.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Gerar em Lote -->
<div class="modal fade" id="gerarLoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Gerar Agendamentos em Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_inicio_lote" class="form-label">Data Início *</label>
                                <input type="date" class="form-control" id="data_inicio_lote" name="data_inicio" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_fim_lote" class="form-label">Data Fim *</label>
                                <input type="date" class="form-control" id="data_fim_lote" name="data_fim" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="hora_inicio_lote" class="form-label">Hora Início *</label>
                        <input type="time" class="form-control" id="hora_inicio_lote" name="hora_inicio" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dias da Semana *</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="segunda" name="dias[]" value="1">
                                    <label class="form-check-label" for="segunda">Segunda</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terca" name="dias[]" value="2">
                                    <label class="form-check-label" for="terca">Terça</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="quarta" name="dias[]" value="3">
                                    <label class="form-check-label" for="quarta">Quarta</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="quinta" name="dias[]" value="4">
                                    <label class="form-check-label" for="quinta">Quinta</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sexta" name="dias[]" value="5">
                                    <label class="form-check-label" for="sexta">Sexta</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sabado" name="dias[]" value="6">
                                    <label class="form-check-label" for="sabado">Sábado</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="domingo" name="dias[]" value="0">
                                    <label class="form-check-label" for="domingo">Domingo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Os agendamentos serão criados como "slots disponíveis" nos dias e horários selecionados.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Gerar Agendamentos</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    
    /* Estilos para múltiplos serviços */
    .servico-item {
        background: rgba(248, 250, 252, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.2) !important;
    }
    
    .service-item {
        padding: 0.5rem;
        background: rgba(59, 130, 246, 0.05);
        border-radius: 6px;
        border-left: 3px solid #3b82f6;
    }
    
    .service-name {
        color: #1f2937;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Aplicando estilos CSS no padrão da tela de clientes */
    body {
        background: linear-gradient(135deg, #0a0a0a 0%, #1e293b 100%);
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

    /* Botão Processos melhorado */
    .btn-processos {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-processos::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-processos:hover::before {
        left: 100%;
    }

    .btn-processos:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #6b21a8 100%);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .btn-processos .dropdown-icon {
        transition: transform 0.3s ease;
    }

    .btn-processos:hover .dropdown-icon {
        transform: rotate(180deg);
    }

    .dropdown-menu-processos {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(139, 92, 246, 0.2);
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(139, 92, 246, 0.15);
        padding: 0.5rem;
        min-width: 320px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item-processos {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: none;
        margin-bottom: 0.25rem;
    }

    .dropdown-item-processos:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.1);
    }

    .dropdown-item-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .dropdown-item-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .dropdown-item-description {
        font-size: 0.85rem;
        color: #6b7280;
        line-height: 1.3;
    }

    /* Cards de Agendamento */
    .card-agendamento {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(10px);
    }

    .card-agendamento:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .card-header-agendamento {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .card-body-agendamento {
        padding: 1rem;
    }

    .service-name {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        color: #4b5563;
    }

    .card-actions {
        padding: 0.75rem 1rem;
        background: rgba(248, 250, 252, 0.5);
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
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

    // Funções dos agendamentos
    function viewAgendamento(id) {
        // Implementar visualização do agendamento
        console.log('Visualizar agendamento:', id);
    }

    function editAgendamento(id) {
        // Implementar edição do agendamento
        console.log('Editar agendamento:', id);
    }

    function deleteAgendamento(id, nome) {
        // Implementar exclusão do agendamento
        console.log('Excluir agendamento:', id, nome);
    }
    
    let servicoIndex = 1;
    
    // Adicionar serviço no modal de associar
    document.getElementById('add-servico').addEventListener('click', function() {
        const container = document.getElementById('servicos-container');
        const servicoHtml = `
            <div class="servico-item border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Serviço</label>
                        <select class="form-select servico-select" name="servicos[${servicoIndex}][produto_id]" required>
                            <option value="">Selecione um serviço</option>
                            @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control quantidade-input" name="servicos[${servicoIndex}][quantidade]" value="1" min="1" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-servico">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', servicoHtml);
        servicoIndex++;
        updateRemoveButtons();
    });
    
    // Remover serviço
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-servico')) {
            e.target.closest('.servico-item').remove();
            updateRemoveButtons();
        }
    });
    
    function updateRemoveButtons() {
        const items = document.querySelectorAll('.servico-item');
        items.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-servico');
            if (items.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
    
    function associarSlot(id) {
        document.getElementById('associarForm').action = `/agendamentos/${id}/associar`;
    }
    
</script>
@endpush
@endsection
