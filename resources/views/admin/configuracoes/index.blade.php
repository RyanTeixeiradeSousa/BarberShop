@extends('layouts.app')

@section('title', 'Configurações')

@section('content')
<div class="container-fluid px-4">
    <!-- Header da Página -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="icon-container me-3">
                    <i class="fas fa-cogs"></i>
                </div>
                <div>
                    <h1 class="page-title mb-0">Configurações</h1>
                    <p class="page-subtitle mb-0">Gerencie as configurações do sistema</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>Nova Configuração
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
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ $configuracoes->count() }}</div>
                            <div class="stat-label">Total de Configurações</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-custom">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-stat bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stat-number">{{ \App\Models\Configuracao::get('duracao_servico_padrao', 60) }}min</div>
                            <div class="stat-label">Duração padrão dos serviços em minutos	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Configurações -->
    <div class="card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Chave</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                            <th>Última Atualização</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($configuracoes as $configuracao)
                        <tr>
                            <td>
                                <strong>{{ $configuracao->chave }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ Str::limit($configuracao->valor, 30) ?: 'Sem descrição'  }}</span>
                            </td>
                            <td>{{ $configuracao->descricao ?? '-' }}</td>
                            <td>{{ $configuracao->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-info btn-sm" 
                                            onclick="viewConfig({{ $configuracao->id }})"
                                            data-bs-toggle="modal" data-bs-target="#viewModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                            onclick="editConfig({{ $configuracao->id }})"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($configuracao->chave !== 'duracao_servico_padrao')
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            onclick="deleteConfig({{ $configuracao->id }}, '{{ $configuracao->chave }}')"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                                    <h5>Nenhuma configuração encontrada</h5>
                                    <p class="text-muted">Adicione a primeira configuração do sistema.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('configuracoes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Configuração</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="chave" class="form-label">Chave *</label>
                        <input type="text" class="form-control" id="chave" name="chave" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor *</label>
                        <input type="text" class="form-control" id="valor" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes da Configuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Chave:</strong>
                        <p id="view-chave"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Valor:</strong>
                        <p id="view-valor"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Descrição:</strong>
                        <p id="view-descricao"></p>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Configuração</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-chave" class="form-label">Chave *</label>
                        <input type="text" class="form-control" id="edit-chave" name="chave" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-valor" class="form-label">Valor *</label>
                        <input type="text" class="form-control" id="edit-valor" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit-descricao" name="descricao" rows="3"></textarea>
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
                            <strong>Configuração:</strong> <span id="delete-config-name"></span>
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

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    const configuracoes = @json($configuracoes);

    function viewConfig(id) {
        const config = configuracoes.find(c => c.id === id);
        if (config) {
            document.getElementById('view-chave').textContent = config.chave;
            document.getElementById('view-valor').textContent = config.valor;
            document.getElementById('view-descricao').textContent = config.descricao || '-';
        }
    }

    function editConfig(id) {
        const config = configuracoes.find(c => c.id === id);
        if (config) {
            document.getElementById('edit-chave').value = config.chave;
            document.getElementById('edit-valor').value = config.valor;
            document.getElementById('edit-descricao').value = config.descricao || '';
            document.getElementById('editForm').action = `configuracoes/${id}`;
        }
    }

    function deleteConfig(id, chave) {
        document.getElementById('delete-config-name').textContent = chave;
        document.getElementById('deleteForm').action = `configuracoes/${id}`;
    }
</script>
@endpush
@endsection
