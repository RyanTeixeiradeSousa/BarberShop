@extends('layouts.app')

@section('title', 'Agendamentos')

@section('content')
<div class="container-fluid px-4">
    <!-- Header da Página -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="icon-container me-3">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h1 class="page-title mb-0">Agendamentos</h1>
                    <p class="page-subtitle mb-0">Gerencie todos os agendamentos de serviços</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>Novo Agendamento
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-custom">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-stat bg-primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ $total }}</div>
                            <div class="stat-label">Total de Agendamentos</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-custom">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-stat bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ $agendados }}</div>
                            <div class="stat-label">Agendados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-custom">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-stat bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ $concluidos }}</div>
                            <div class="stat-label">Concluídos</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-custom">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-stat bg-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ $cancelados }}</div>
                            <div class="stat-label">Cancelados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card-custom mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('agendamentos.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="busca" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="busca" name="busca" 
                               value="{{ request('busca') }}" placeholder="Cliente ou serviço...">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos</option>
                            <option value="agendado" {{ request('status') == 'agendado' ? 'selected' : '' }}>Agendado</option>
                            <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                            <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="concluido" {{ request('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="{{ request('data_inicio') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="{{ request('data_fim') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="per_page" class="form-label">Itens por página</label>
                        <select class="form-select" id="per_page" name="per_page">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Agendamentos -->
    <div class="card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendamentos as $agendamento)
                        <tr data-id="{{ $agendamento->id }}"
                            data-cliente-id="{{ $agendamento->cliente_id }}"
                            data-produto-id="{{ $agendamento->produto_id }}"
                            data-data="{{ $agendamento->data_agendamento->format('Y-m-d') }}"
                            data-hora-inicio="{{ $agendamento->hora_inicio->format('H:i') }}"
                            data-status="{{ $agendamento->status }}"
                            data-observacoes="{{ $agendamento->observacoes }}"
                            data-valor="{{ $agendamento->valor }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        {{ substr($agendamento->cliente->nome, 0, 2) }}
                                    </div>
                                    <div>
                                        <strong>{{ $agendamento->cliente->nome }}</strong>
                                        <br><small class="text-muted">{{ $agendamento->cliente->telefone1 }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $agendamento->produto->nome }}</strong>
                                <br><small class="text-muted">{{ $agendamento->produto->categoria->nome ?? '' }}</small>
                            </td>
                            <td>{{ $agendamento->data_agendamento->format('d/m/Y') }}</td>
                            <td>
                                {{ $agendamento->hora_inicio->format('H:i') }} - 
                                {{ $agendamento->hora_fim->format('H:i') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $agendamento->status_color }}">
                                    {{ $agendamento->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($agendamento->valor)
                                    <strong>R$ {{ number_format($agendamento->valor, 2, ',', '.') }}</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-info btn-sm" 
                                            onclick="viewAgendamento({{ $agendamento->id }})"
                                            data-bs-toggle="modal" data-bs-target="#viewModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                            onclick="editAgendamento({{ $agendamento->id }})"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            onclick="deleteAgendamento({{ $agendamento->id }}, '{{ $agendamento->cliente->nome }}')"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5>Nenhum agendamento encontrado</h5>
                                    <p class="text-muted">Crie o primeiro agendamento do sistema.</p>
                                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
                                        <i class="fas fa-plus me-2"></i>Novo Agendamento
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if($agendamentos->hasPages())
            <div class="pagination-wrapper mt-4">
                <div class="pagination-controls d-flex justify-content-between align-items-center">
                    <div class="pagination-info text-muted">
                        Mostrando {{ $agendamentos->firstItem() ?? 0 }} a {{ $agendamentos->lastItem() ?? 0 }} de {{ $agendamentos->total() }} resultados
                    </div>
                    {{ $agendamentos->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Novo Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cliente_id" class="form-label">Cliente *</label>
                                <select class="form-select" id="cliente_id" name="cliente_id" required>
                                    <option value="">Selecione um cliente</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="produto_id" class="form-label">Serviço *</label>
                                <select class="form-select" id="produto_id" name="produto_id" required>
                                    <option value="">Selecione um serviço</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                        {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Agendar</button>
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
                        <strong>Serviço:</strong>
                        <p id="view-servico"></p>
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
                        <strong>Status:</strong>
                        <p id="view-status"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Valor:</strong>
                        <p id="view-valor"></p>
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
                                <label for="edit-produto_id" class="form-label">Serviço *</label>
                                <select class="form-select" id="edit-produto_id" name="produto_id" required>
                                    <option value="">Selecione um serviço</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}">
                                        {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit-data_agendamento" class="form-label">Data *</label>
                                <input type="date" class="form-control" id="edit-data_agendamento" name="data_agendamento" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit-hora_inicio" class="form-label">Horário *</label>
                                <input type="time" class="form-control" id="edit-hora_inicio" name="hora_inicio" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit-status" class="form-label">Status *</label>
                                <select class="form-select" id="edit-status" name="status" required>
                                    <option value="agendado">Agendado</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>
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

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 12px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
    }

    .icon-container {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }

    .page-subtitle {
        opacity: 0.8;
        font-size: 0.95rem;
    }

    .card-custom {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .card-custom:hover {
        border-color: #3b82f6;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.1);
    }

    .icon-stat {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .table th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #374151;
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-outline-info, .btn-outline-primary, .btn-outline-danger {
        border-width: 1.5px;
        padding: 0.375rem 0.5rem;
        transition: all 0.15s ease;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 2px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .pagination-wrapper {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
    }

    .pagination-controls {
        align-items: center;
    }

    .pagination-info {
        font-size: 0.9rem;
        color: #64748b;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit filtros
    let searchTimeout;
    document.getElementById('busca').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    document.getElementById('data_inicio').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    document.getElementById('data_fim').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    document.getElementById('per_page').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    function viewAgendamento(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            const cliente = row.querySelector('td:nth-child(1) strong').textContent;
            const servico = row.querySelector('td:nth-child(2) strong').textContent;
            const data = row.querySelector('td:nth-child(3)').textContent;
            const horario = row.querySelector('td:nth-child(4)').textContent;
            const status = row.querySelector('td:nth-child(5) .badge').textContent;
            const valor = row.querySelector('td:nth-child(6)').textContent;
            const observacoes = row.dataset.observacoes || '-';

            document.getElementById('view-cliente').textContent = cliente;
            document.getElementById('view-servico').textContent = servico;
            document.getElementById('view-data').textContent = data;
            document.getElementById('view-horario').textContent = horario;
            document.getElementById('view-status').innerHTML = `<span class="badge bg-${row.querySelector('td:nth-child(5) .badge').className.split(' ').pop()}">${status}</span>`;
            document.getElementById('view-valor').textContent = valor;
            document.getElementById('view-observacoes').textContent = observacoes;
        }
    }

    function editAgendamento(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            document.getElementById('edit-cliente_id').value = row.dataset.clienteId;
            document.getElementById('edit-produto_id').value = row.dataset.produtoId;
            document.getElementById('edit-data_agendamento').value = row.dataset.data;
            document.getElementById('edit-hora_inicio').value = row.dataset.horaInicio;
            document.getElementById('edit-status').value = row.dataset.status;
            document.getElementById('edit-observacoes').value = row.dataset.observacoes || '';
            document.getElementById('editForm').action = `/agendamentos/${id}`;
        }
    }

    function deleteAgendamento(id, cliente) {
        document.getElementById('delete-agendamento-name').textContent = cliente;
        document.getElementById('deleteForm').action = `/agendamentos/${id}`;
    }
</script>
@endpush
@endsection
