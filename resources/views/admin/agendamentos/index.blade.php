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
                                    <option value="atual" {{ request('status') == 'atual' ? 'selected' : '' }}>Atual</option>
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

    <div class="card-custom">
        <div class="card-body">
            @if(isset($agendamentos) && $agendamentos->count() > 0)
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

                <div class="row">
                    @foreach($agendamentos as $agendamento)
                    <div class="col-xl-4 col-lg-6 mb-4">
                        <!-- Removendo onclick e data-bs-toggle do card para não abrir modal ao clicar -->
                        <div class="card-agendamento"
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
                                <!-- Reorganizando botões para mobile: Iniciar em cima, Visualizar e Excluir embaixo lado a lado -->
                                <div class="actions-mobile-layout">
                                    <!-- Botão Iniciar/Finalizar em cima no mobile -->
                                    <div class="action-top">
                                        @if($agendamento->status === 'agendado')
                                            <button type="button" class="btn btn-outline-primary btn-sm w-100" 
                                                    onclick="iniciarAtendimento({{ $agendamento->id }})"
                                                    title="Iniciar Atendimento">
                                                <i class="fas fa-play"></i> Iniciar
                                            </button>
                                        @elseif($agendamento->status === 'em_andamento')
                                            <button type="button" class="btn btn-outline-success btn-sm w-100" 
                                                    onclick="finalizarAtendimentoDireto({{ $agendamento->id }})"
                                                    title="Finalizar Atendimento">
                                                <i class="fas fa-check"></i> Finalizar
                                            </button>
                                        @elseif($agendamento->status === 'disponivel')
                                            <button type="button" class="btn btn-outline-success btn-sm w-100" 
                                                    onclick="associarSlot({{ $agendamento->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#associarModal">
                                                <i class="fas fa-user-plus"></i> Associar
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <!-- Botões Visualizar e Excluir lado a lado embaixo no mobile -->
                                    <div class="action-bottom">
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                onclick="viewAgendamento({{ $agendamento->id }})"
                                                data-bs-toggle="modal" data-bs-target="#viewModal"
                                                title="Visualizar Detalhes">
                                            <i class="fas fa-eye"></i> <span class="btn-text">Visualizar</span>
                                        </button>
                                        
                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteAgendamento({{ $agendamento->id }}, '{{ $agendamento->cliente->nome ?? 'Slot disponível' }}')"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i> <span class="btn-text">Excluir</span>
                                        </button>
                                    </div>
                                </div>
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
                        {{ $agendamentos->appends(request()->query())->links() }}
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
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Filial *</label>
                            <select class="form-select" id="filial" name="filial_id" required>
                                @foreach ($filialSelect as $key => $filial)
                                    <option value="{{$filial->id}}" {{$key == 0 ? 'select' : ''}}>{{$filial->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="data_agendamento" class="form-label">Data *</label>
                                <input type="date" class="form-control" id="data_agendamento" name="data_agendamento" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
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

                    <div class="mb-3">
                        <label for="associar-cliente_id" class="form-label">Barbeiro *</label>
                        <select class="form-select" id="associar-barbeiro_id" name="barbeiro_id" required>
                            
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Detalhes do Agendamento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                 {{-- Melhorando estrutura do modal com cards organizados --}}
                <div class="row g-4">
                     {{-- Card Informações do Cliente --}}
                    <div class="col-lg-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-user text-primary me-2"></i>
                                <h6 class="mb-0">Informações do Cliente</h6>
                            </div>
                            <div class="info-card-body">
                                <div class="info-item">
                                    <label>Nome:</label>
                                    <span id="view-cliente" class="fw-bold"></span>
                                </div>
                                <div class="info-item">
                                    <label>Status:</label>
                                    <span id="view-status"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                     {{-- Card Informações do Agendamento --}}
                    <div class="col-lg-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-calendar-check text-success me-2"></i>
                                <h6 class="mb-0">Detalhes do Agendamento</h6>
                            </div>
                            <div class="info-card-body">
                                <div class="info-item">
                                    <label>Data:</label>
                                    <span id="view-data" class="fw-bold"></span>
                                </div>
                                <div class="info-item">
                                    <label>Horário:</label>
                                    <span id="view-horario" class="fw-bold"></span>
                                </div>
                                <div class="info-item">
                                    <label>Valor Total:</label>
                                    <span id="view-valor" class="fw-bold text-success"></span>
                                </div>
                                <div class="info-item">
                                    <label>Filial:</label>
                                    <span id="view-filial" class="fw-bold"></span>
                                </div>
                                <div class="info-item">
                                    <label>Barbeiro(a):</label>
                                    <span id="view-barbeiro" class="fw-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 {{-- Card Serviços Associados --}}
                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-cut text-warning me-2"></i>
                                <h6 class="mb-0">Serviços Associados</h6>
                            </div>
                            <div class="info-card-body">
                                <div id="view-servicos" class="services-grid"></div>
                            </div>
                        </div>
                    </div>
                </div>

                 {{-- Card Observações --}}
                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-sticky-note text-info me-2"></i>
                                <h6 class="mb-0">Observações</h6>
                            </div>
                            <div class="info-card-body">
                                <p id="view-observacoes" class="mb-0 text-muted"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                         {{-- Removendo botões de ação do modal pois agora estão nos cards --}}
                         {{-- Botão Cancelar Atendimento - só aparece se status for "agendado" --}}
                        <button type="button" class="btn btn-outline-warning" id="btn-cancelar-atendimento" style="display: none;" onclick="cancelarAtendimento()">
                            <i class="fas fa-times me-1"></i> Cancelar Atendimento
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
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
            <form action="{{ route('agendamentos.gerar-lote') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Gerar Agendamentos em Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Filial *</label>
                            <select class="form-select" id="filialLote" name="filial_id" required>
                                @foreach ($filialSelect as $key => $filial)
                                    <option value="{{$filial->id}}" {{$key == 0 ? 'select' : ''}}>{{$filial->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="data_inicio_lote" class="form-label">Data Início *</label>
                                <input type="date" class="form-control" id="data_inicio_lote" name="data_inicio" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="data_fim_lote" class="form-label">Data Fim *</label>
                                <input type="date" class="form-control" id="data_fim_lote" name="data_fim" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hora_inicio_lote" class="form-label">Hora Início *</label>
                                <input type="time" class="form-control" id="hora_inicio_lote" name="hora_inicio" required>
                            </div>
                        </div>
                        <!-- CHANGE> Adicionando campo hora fim no processo de gerar lote -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hora_fim_lote" class="form-label">Hora Fim *</label>
                                <input type="time" class="form-control" id="hora_fim_lote" name="hora_fim" required>
                            </div>
                        </div>
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

<!-- Modal Finalizar Atendimento -->
<div class="modal fade" id="finalizarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="finalizarForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Finalizar Atendimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="forma_pagamento_id" class="form-label">Forma de Pagamento *</label>
                                <select class="form-select" id="forma_pagamento_id" name="forma_pagamento_id" required>
                                    <option value="">Selecione uma forma de pagamento</option>
                                    @foreach($formasPagamento ?? [] as $forma)
                                    <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="desconto" class="form-label">Desconto</label>
                                <input type="text" class="form-control money-mask" id="desconto" name="desconto" value="0,00">
                                 <!-- CHANGE> Campo oculto para enviar valor decimal -->
                                <input type="hidden" id="desconto_decimal" name="desconto_decimal">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="valor_pago" class="form-label">Valor Pago *</label>
                                <input type="text" class="form-control money-mask" id="valor_pago" name="valor_pago" required>
                                 <!-- CHANGE> Campo oculto para enviar valor decimal -->
                                <input type="hidden" id="valor_pago_decimal" name="valor_pago_decimal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Valor Total dos Serviços</label>
                                <div class="form-control-plaintext fw-bold text-success" id="valor-total-servicos">R$ 0,00</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        O valor pago foi preenchido automaticamente com a soma dos serviços. Você pode ajustar se necessário.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Finalizar Atendimento</button>
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
        /* transition: all 0.05s ease; */
    }

    .card-custom:hover {
        /* transform: translateY(-2px); */
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
        font-weight: 700;
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
        /* Removendo cursor pointer para não indicar que é clicável */
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(10px);
    }

    .card-agendamento:hover {
        /* transform: translateY(-5px); */
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
    }

    /* Adicionando estilos para layout mobile dos botões */
    .actions-mobile-layout {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .action-top {
        display: flex;
        justify-content: center;
    }

    .action-bottom {
        display: flex;
        gap: 0.5rem;
        justify-content: space-between;
    }

    .action-bottom .btn {
        flex: 1;
    }

    /* Desktop: layout horizontal tradicional */
    @media (min-width: 769px) {
        .actions-mobile-layout {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .action-top {
            order: 2;
        }
        
        .action-bottom {
            order: 1;
            flex: 0 0 auto;
            justify-content: flex-start;
        }
        
        .action-bottom .btn {
            flex: 0 0 auto;
        }
    }

    /* Mobile: esconder texto dos botões para economizar espaço */
    @media (max-width: 768px) {
        .btn-text {
            display: none;
        }
        
        .action-bottom .btn {
            min-width: 45px;
        }
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

    /* Adicionando estilos para o modal melhorado */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    }

    .info-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .info-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        display: flex;
        align-items: center;
    }

    .info-card-header h6 {
        color: #1f2937;
        font-weight: 600;
        margin: 0;
    }

    .info-card-body {
        padding: 1.25rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item label {
        color: #6b7280;
        font-weight: 500;
        margin: 0;
        font-size: 0.9rem;
    }

    .info-item span {
        color: #1f2937;
        font-size: 0.95rem;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .service-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 10px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .service-card h6 {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .service-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .service-quantity {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .service-price {
        color: #059669;
        font-weight: 700;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let agendamentoAtual = null;

    // Auto-submit dos filtros
    // document.querySelector('input[name="busca"]').addEventListener('input', function() {
    //     clearTimeout(this.searchTimeout);
    //     this.searchTimeout = setTimeout(() => {
    //         document.getElementById('filterForm').submit();
    //     }, 500);
    // });

    // document.querySelector('select[name="status"]').addEventListener('change', function() {
    //     document.getElementById('filterForm').submit();
    // });

    // Seletor de itens por página
    document.getElementById('perPage').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    function iniciarAtendimento(id) {
        if (confirm('Deseja iniciar este atendimento?')) {
            fetch(`/admin/agendamentos/${id}/iniciar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Atendimento iniciado com sucesso!');
                    location.reload();
                } else {
                    alert('Erro ao iniciar atendimento: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao iniciar atendimento');
            });
        }
    }

    function finalizarAtendimentoDireto(id) {
        // Buscar dados do agendamento primeiro
        fetch(`/admin/agendamentos/${id}`)
            .then(response => response.json())
            .then(data => {
                agendamentoAtual = data;
                abrirModalFinalizacao();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar dados do agendamento');
            });
    }

    function viewAgendamento(id) {
            fetch(`/admin/agendamentos/${id}`)
                .then(response => response.json())
                .then(data => {
                    agendamentoAtual = data;
                    
                    const elements = {
                        'view-cliente': data.cliente ? data.cliente.nome : 'Slot Livre',
                        'view-status': `<span class="badge bg-${data.status_color}">${data.status_label}</span>`,
                        'view-data': new Date(data.data_agendamento).toLocaleDateString('pt-BR'),
                        'view-horario': `${data.hora_inicio} - ${data.hora_fim}`,
                        'view-valor': data.valor_total ? `R$ ${parseFloat(data.valor_total).toLocaleString('pt-BR', {minimumFractionDigits: 2})}` : 'N/A',
                        'view-observacoes': data.observacoes || 'Nenhuma observação registrada',
                        'view-barbeiro': data.barbeiro.nome || 'Não informado',
                        'view-filial': data.filial.nome || 'Não informado'
                    };
                    
                    Object.entries(elements).forEach(([id, content]) => {
                        const element = document.getElementById(id);
                        if (element) {
                            if (id === 'view-status') {
                                element.innerHTML = content;
                            } else {
                                element.textContent = content;
                            }
                        }
                    });
                    
                    const servicosContainer = document.getElementById('view-servicos');
                    if (data.produtos && data.produtos.length > 0) {
                        const servicosHtml = data.produtos.map(produto => `
                            <div class="service-card">
                                <h6>${produto.nome}</h6>
                                <div class="service-details">
                                    <span class="service-quantity">Qtd: ${produto.pivot.quantidade}</span>
                                    <span class="service-price">R$ ${parseFloat(produto.pivot.valor_unitario).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                                </div>
                            </div>
                        `).join('');
                        servicosContainer.innerHTML = servicosHtml;
                    } else {
                        servicosContainer.innerHTML = '<div class="text-center text-muted py-3"><i class="fas fa-info-circle me-2"></i>Nenhum serviço associado a este agendamento</div>';
                    }
                    
                    // Configurar botões baseado no status
                    const btnCancelar = document.getElementById('btn-cancelar-atendimento');
                    if (btnCancelar) {
                        btnCancelar.style.display = data.status === 'agendado' ? 'inline-block' : 'none';
                    }
                    
                    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erro ao carregar agendamento:', error);
                    alert('Erro ao carregar dados do agendamento');
                });
        }

    function configurarBotoesStatus(status) {
        const btnCancelar = document.getElementById('btn-cancelar-atendimento');
        const btnMudarStatus = document.getElementById('btn-mudar-status');
        const btnStatusText = document.getElementById('btn-status-text');
        
        // Resetar visibilidade
        btnCancelar.style.display = 'none';
        btnMudarStatus.style.display = 'none';
        
        if (status === 'agendado') {
            btnCancelar.style.display = 'inline-block';
            btnMudarStatus.style.display = 'inline-block';
            btnStatusText.textContent = 'Iniciar Atendimento';
            btnMudarStatus.className = 'btn btn-success';
            btnMudarStatus.innerHTML = '<i class="fas fa-play me-1"></i> <span id="btn-status-text">Iniciar Atendimento</span>';
        } else if (status === 'em_andamento') {
            btnMudarStatus.style.display = 'inline-block';
            btnStatusText.textContent = 'Finalizar Atendimento';
            btnMudarStatus.className = 'btn btn-primary';
            btnMudarStatus.innerHTML = '<i class="fas fa-check me-1"></i> <span id="btn-status-text">Finalizar Atendimento</span>';
        }
    }

    function cancelarAtendimento() {
        if (!agendamentoAtual) return;
        
        if (confirm('Tem certeza que deseja cancelar este atendimento? O cliente e serviços serão desassociados.')) {
            fetch(`/admin/agendamentos/${agendamentoAtual.id}/cancelar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Atendimento cancelado com sucesso!');
                    location.reload();
                } else {
                    alert('Erro ao cancelar atendimento: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao cancelar atendimento');
            });
        }
    }

    function mudarStatus() {
        if (!agendamentoAtual) return;
        
        if (agendamentoAtual.status === 'agendado') {
            // Mudar para "em andamento"
            fetch(`/admin/agendamentos/${agendamentoAtual.id}/iniciar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Atendimento iniciado!');
                    location.reload();
                } else {
                    alert('Erro ao iniciar atendimento: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao iniciar atendimento');
            });
        } else if (agendamentoAtual.status === 'em_andamento') {
            // Abrir modal de finalização
            abrirModalFinalizacao();
        }
    }

    function abrirModalFinalizacao() {
        if (!agendamentoAtual) return;
        
        // Calcular valor total dos serviços
        let valorTotal = 0;
        if (agendamentoAtual.produtos) {
            agendamentoAtual.produtos.forEach(produto => {
                valorTotal += parseFloat(produto.pivot.valor_unitario) * parseInt(produto.pivot.quantidade);
            });
        }
        
        // Preencher campos
        document.getElementById('valor-total-servicos').textContent = `R$ ${valorTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        document.getElementById('valor_pago').value = valorTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        document.getElementById('desconto').value = '0,00';
        
        document.getElementById('valor_pago_decimal').value = valorTotal.toFixed(2);
        document.getElementById('desconto_decimal').value = '0.00';
        
        // Configurar action do form
        document.getElementById('finalizarForm').action = `/admin/agendamentos/${agendamentoAtual.id}/finalizar`;
        
        // Fechar modal de visualização e abrir modal de finalização
        const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
        if (viewModal) viewModal.hide();
        
        const finalizarModal = new bootstrap.Modal(document.getElementById('finalizarModal'));
        finalizarModal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        function setupMoneyMask() {
            document.querySelectorAll('.money-mask').forEach(function(element) {
                element.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    const decimalValue = (value / 100).toFixed(2);
                    value = decimalValue.replace(".", ",");
                    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                    e.target.value = value;
                    
                    const fieldName = e.target.name;
                    const decimalField = document.getElementById(fieldName + '_decimal');
                    if (decimalField) {
                        decimalField.value = decimalValue;
                    }
                });
            });
        }
        
        setupMoneyMask();
        
        const finalizarForm = document.getElementById('finalizarForm');
        if (finalizarForm) {
            finalizarForm.addEventListener('submit', function(e) {
                // Garantir que os valores decimais estão atualizados
                const valorPago = document.getElementById('valor_pago').value;
                const desconto = document.getElementById('desconto').value;
                
                document.getElementById('valor_pago_decimal').value = valorPago.replace(/\./g, '').replace(',', '.');
                document.getElementById('desconto_decimal').value = desconto.replace(/\./g, '').replace(',', '.');
            });
        }

    });

    function deleteAgendamento(id, nome) {
        document.getElementById('deleteForm').action = `/admin/agendamentos/${id}`;
        document.getElementById('delete-agendamento-name').textContent = nome;
    }
    
    let servicoIndex = 1;
    
    document.getElementById('add-servico')?.addEventListener('click', function() {
        const container = document.getElementById('servicos-container');
        const servicoDiv = document.createElement('div');
        servicoDiv.className = 'servico-item border rounded p-3 mb-3';
        servicoDiv.innerHTML = `
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
        `;
        container.appendChild(servicoDiv);
        servicoIndex++;
        updateRemoveButtons();
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-servico')) {
            e.target.closest('.servico-item').remove();
            updateRemoveButtons();
        }
    });
    
    function updateRemoveButtons() {
        const items = document.querySelectorAll('.servico-item');
        const showRemove = items.length > 1;
        items.forEach(item => {
            const removeBtn = item.querySelector('.remove-servico');
            if (removeBtn) {
                removeBtn.style.display = showRemove ? 'block' : 'none';
            }
        });
    }
    
    function associarSlot(id) {
        document.getElementById('associarForm').action = `/agendamentos/${id}/associar`;
        const selectAssociarBarbeiro = document.getElementById('associar-barbeiro_id')
        selectAssociarBarbeiro.innerHTML= ''
        var html = ''
        html = `<option value='' selected>Selecione um barbeiro</option>`
        fetch(`/admin/agendamentos/barbeiros/${id}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(barbeiro => {
                    console.log(barbeiro)
                    html += `<option value="${barbeiro.id}">${barbeiro.nome}</option>`
                });

                selectAssociarBarbeiro.innerHTML = html
            })
            .catch(error => {
                console.error('Erro ao carregar barbeiros:', error);
                alert('Erro ao carregar possíveis barbeiros do agendamento');
            });
    }
    

    document.addEventListener('DOMContentLoaded', function() {
        // Função para limpar backdrop dos modais
        function clearModalBackdrop() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        // Event listeners para todos os modais
        const modals = ['createModal', 'associarModal', 'viewModal', 'finalizarModal', 'excluirModal', 'gerarLoteModal'];
        
        modals.forEach(modalId => {
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function() {
                    clearModalBackdrop();
                });
            }
        });

        window.viewAgendamento = function(id) {
            clearModalBackdrop(); // Limpar qualquer backdrop residual
            
            fetch(`/admin/agendamentos/${id}`)
                .then(response => response.json())
                .then(data => {
                    agendamentoAtual = data;
                    console.log(data)
                    const elements = {
                        'view-cliente': data.cliente ? data.cliente.nome : 'Slot Livre',
                        'view-status': `<span class="badge bg-${data.status_color}">${data.status_label}</span>`,
                        'view-data': new Date(data.data_agendamento).toLocaleDateString('pt-BR'),
                        'view-horario': `${new Date(data.hora_inicio).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })} - ${new Date(data.hora_fim).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}`,
                        'view-valor': data.valor_total ? `R$ ${parseFloat(data.valor_total).toLocaleString('pt-BR', {minimumFractionDigits: 2})}` : 'N/A',
                        'view-observacoes': data.observacoes || 'Nenhuma observação registrada',
                        'view-barbeiro': data.barbeiro.nome || 'Não informado',
                        'view-filial': data.filial.nome || 'Não informado'
                    };
                    
                    Object.entries(elements).forEach(([id, content]) => {
                        const element = document.getElementById(id);
                        if (element) {
                            if (id === 'view-status') {
                                element.innerHTML = content;
                            } else {
                                element.textContent = content;
                            }
                        }
                    });
                    
                    const servicosContainer = document.getElementById('view-servicos');
                    if (data.produtos && data.produtos.length > 0) {
                        const servicosHtml = data.produtos.map(produto => `
                            <div class="service-card">
                                <h6>${produto.nome}</h6>
                                <div class="service-details">
                                    <span class="service-quantity">Qtd: ${produto.pivot.quantidade}</span>
                                    <span class="service-price">R$ ${parseFloat(produto.pivot.valor_unitario).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                                </div>
                            </div>
                        `).join('');
                        servicosContainer.innerHTML = servicosHtml;
                    } else {
                        servicosContainer.innerHTML = '<div class="text-center text-muted py-3"><i class="fas fa-info-circle me-2"></i>Nenhum serviço associado a este agendamento</div>';
                    }
                    
                    // Configurar botões baseado no status
                    const btnCancelar = document.getElementById('btn-cancelar-atendimento');
                    if (btnCancelar) {
                        btnCancelar.style.display = data.status === 'agendado' ? 'inline-block' : 'none';
                    }
                    
                    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erro ao carregar agendamento:', error);
                    alert('Erro ao carregar dados do agendamento');
                });
        }

        window.finalizarAtendimento = function() {
            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
            if (viewModal) {
                viewModal.hide();
                // Aguardar o modal fechar completamente antes de abrir o próximo
                setTimeout(() => {
                    clearModalBackdrop();
                    const finalizarModal = new bootstrap.Modal(document.getElementById('finalizarModal'));
                    finalizarModal.show();
                }, 300);
            } else {
                clearModalBackdrop();
                const finalizarModal = new bootstrap.Modal(document.getElementById('finalizarModal'));
                finalizarModal.show();
            }
        }

    });
    
</script>
@endpush
@endsection
