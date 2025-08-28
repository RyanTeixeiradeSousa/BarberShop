@extends('layouts.app')

@section('title', 'Financeiro')

@section('content')
<div class="container-fluid">
    <!-- Header -->

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Entradas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                R$ {{ number_format($totalEntradas, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Saídas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                R$ {{ number_format($totalSaidas, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Saldo Atual
                            </div>
                            <div class="h5 mb-0 font-weight-bold {{ $saldoAtual >= 0 ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($saldoAtual, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Movimentações
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalMovimentacoes }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filtros
            </h6>
            <button class="btn btn-sm btn-outline-primary" type="button" id="toggleFiltros">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="card-body" id="filtrosContent">
            <form method="GET" action="{{ route('financeiro.index') }}" id="filtrosForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="busca" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="busca" name="busca" 
                               value="{{ request('busca') }}" placeholder="Descrição ou categoria...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos</option>
                            <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="{{ request('data_inicio') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="{{ request('data_fim') }}">
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('financeiro.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Movimentações -->
    <div class="card" style="background: white; border: 2px solid #60a5fa; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-body">
            @if($movimentacoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimentacoes as $movimentacao)
                            <tr>
                                <td>{{ $movimentacao->data->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $movimentacao->tipo_cor }}">
                                        <i class="{{ $movimentacao->tipo_icone }} me-1"></i>
                                        {{ ucfirst($movimentacao->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $movimentacao->descricao }}</td>
                                <td>{{ $movimentacao->categoria ?? '-' }}</td>
                                <td class="text-{{ $movimentacao->tipo_cor }} fw-bold">
                                    {{ $movimentacao->valor_formatado }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                            onclick="visualizarMovimentacao({{ $movimentacao->id }})"
                                            data-bs-toggle="modal" data-bs-target="#visualizarMovimentacaoModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info me-1" 
                                            onclick="editarMovimentacao({{ $movimentacao->id }})"
                                            data-bs-toggle="modal" data-bs-target="#editarMovimentacaoModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmarExclusao({{ $movimentacao->id }}, '{{ $movimentacao->descricao }}')"
                                            data-bs-toggle="modal" data-bs-target="#excluirMovimentacaoModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-3">Itens por página:</span>
                        <select class="form-select form-select-sm" style="width: auto;" id="perPageSelect">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="text-muted">
                        Mostrando {{ $movimentacoes->firstItem() ?? 0 }} a {{ $movimentacoes->lastItem() ?? 0 }} de {{ $movimentacoes->total() }} resultados
                    </div>
                    {{ $movimentacoes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma movimentação encontrada</h5>
                    <p class="text-muted">Cadastre a primeira movimentação financeira</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#criarMovimentacaoModal">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Movimentação
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Criar Movimentação -->
<div class="modal fade" id="criarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog">
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
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data" class="form-label">Data *</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição *</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="valor" class="form-label">Valor *</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="categoria" name="categoria">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
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

<!-- Modal Visualizar Movimentação -->
<div class="modal fade" id="visualizarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalhes da Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visualizarMovimentacaoContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Movimentação -->
<div class="modal fade" id="editarMovimentacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #60a5fa; border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #60a5fa;">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Editar Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editarMovimentacaoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="edit_tipo" name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_data" class="form-label">Data *</label>
                            <input type="date" class="form-control" id="edit_data" name="data" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição *</label>
                        <input type="text" class="form-control" id="edit_descricao" name="descricao" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_valor" class="form-label">Valor *</label>
                            <input type="text" class="form-control" id="edit_valor" name="valor" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_categoria" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="edit_categoria" name="categoria">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="edit_observacoes" name="observacoes" rows="3"></textarea>
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

<!-- Modal Excluir Movimentação -->
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

@push('styles')
<style>
    .card {
        transition: all 0.15s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        background-color: #f8fafc;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn {
        transition: all 0.15s ease-in-out;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.15s ease-in-out;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle filtros
    const toggleFiltros = document.getElementById('toggleFiltros');
    const filtrosContent = document.getElementById('filtrosContent');
    
    toggleFiltros.addEventListener('click', function() {
        if (filtrosContent.style.display === 'none') {
            filtrosContent.style.display = 'block';
            this.innerHTML = '<i class="fas fa-chevron-up"></i>';
        } else {
            filtrosContent.style.display = 'none';
            this.innerHTML = '<i class="fas fa-chevron-down"></i>';
        }
    });

    // Máscara monetária
    function aplicarMascaraMonetaria(elemento) {
        elemento.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            valor = (valor / 100).toFixed(2) + '';
            valor = valor.replace(".", ",");
            valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = 'R$ ' + valor;
        });
    }

    // Aplicar máscara nos campos de valor
    aplicarMascaraMonetaria(document.getElementById('valor'));
    aplicarMascaraMonetaria(document.getElementById('edit_valor'));

    // Seletor de itens por página
    document.getElementById('perPageSelect').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Auto-submit nos filtros
    let timeoutId;
    document.getElementById('busca').addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            document.getElementById('filtrosForm').submit();
        }, 500);
    });

    document.getElementById('tipo').addEventListener('change', function() {
        document.getElementById('filtrosForm').submit();
    });

    document.getElementById('data_inicio').addEventListener('change', function() {
        document.getElementById('filtrosForm').submit();
    });

    document.getElementById('data_fim').addEventListener('change', function() {
        document.getElementById('filtrosForm').submit();
    });

    // Definir data atual como padrão
    document.getElementById('data').valueAsDate = new Date();
});

function visualizarMovimentacao(id) {
    // Buscar dados da movimentação na tabela
    const linha = document.querySelector(`button[onclick="visualizarMovimentacao(${id})"]`).closest('tr');
    const colunas = linha.querySelectorAll('td');
    
    const data = colunas[0].textContent;
    const tipo = colunas[1].textContent.trim();
    const descricao = colunas[2].textContent;
    const categoria = colunas[3].textContent;
    const valor = colunas[4].textContent;
    
    const content = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Data:</strong><br>
                <span class="text-muted">${data}</span>
            </div>
            <div class="col-md-6 mb-3">
                <strong>Tipo:</strong><br>
                ${colunas[1].innerHTML}
            </div>
            <div class="col-12 mb-3">
                <strong>Descrição:</strong><br>
                <span class="text-muted">${descricao}</span>
            </div>
            <div class="col-md-6 mb-3">
                <strong>Categoria:</strong><br>
                <span class="text-muted">${categoria}</span>
            </div>
            <div class="col-md-6 mb-3">
                <strong>Valor:</strong><br>
                ${colunas[4].innerHTML}
            </div>
        </div>
    `;
    
    document.getElementById('visualizarMovimentacaoContent').innerHTML = content;
}

function editarMovimentacao(id) {
    // Buscar dados da movimentação na tabela
    const linha = document.querySelector(`button[onclick="editarMovimentacao(${id})"]`).closest('tr');
    const colunas = linha.querySelectorAll('td');
    
    // Converter data de dd/mm/yyyy para yyyy-mm-dd
    const dataTexto = colunas[0].textContent;
    const partesData = dataTexto.split('/');
    const dataFormatada = `${partesData[2]}-${partesData[1]}-${partesData[0]}`;
    
    // Extrair tipo do badge
    const tipoElement = colunas[1].querySelector('.badge');
    const tipo = tipoElement.textContent.toLowerCase().includes('entrada') ? 'entrada' : 'saida';
    
    // Preencher formulário
    document.getElementById('edit_data').value = dataFormatada;
    document.getElementById('edit_tipo').value = tipo;
    document.getElementById('edit_descricao').value = colunas[2].textContent;
    document.getElementById('edit_categoria').value = colunas[3].textContent === '-' ? '' : colunas[3].textContent;
    document.getElementById('edit_valor').value = colunas[4].textContent.trim();
    
    // Definir action do formulário
    document.getElementById('editarMovimentacaoForm').action = `/financeiro/${id}`;
}

function confirmarExclusao(id, descricao) {
    document.getElementById('movimentacaoNomeExcluir').textContent = descricao;
    document.getElementById('excluirMovimentacaoForm').action = `/financeiro/${id}`;
}
</script>
@endpush
@endsection
