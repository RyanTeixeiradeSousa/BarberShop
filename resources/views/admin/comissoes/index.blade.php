@extends('layouts.app')

@section('title', 'Gerenciar Comissões - BarberShop Pro')
@section('page-title', 'Comissões')
@section('page-subtitle', 'Gerencie as comissões do barbeiro')

@section('content')
<div class="container-fluid">
    <!-- Aplicando header da página no estilo da tela de clientes -->
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0" style="color: var(--text-primary);">
                <i class="fas fa-percentage me-2" style="color: #60a5fa;"></i>
                Comissões - {{ $barbeiro->nome }}
            </h2>
            <p class="mb-0" style="color: var(--text-muted);">Gerencie as comissões do barbeiro na filial selecionada</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('barbeiros.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Adicionando cards de estatísticas no estilo da tela de clientes -->
    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $comissaoFilial ? ($comissaoFilial->tipo_comissao_filial == 'percentual' ? $comissaoFilial->valor_comissao_filial.'%' : 'R$ '.number_format($comissaoFilial->valor_comissao_filial, 2, ',', '.')) : 'Não definida' }}</h4>
                        <p class="text-muted mb-0">Comissão da Filial</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #10b981, #34d399);">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $comissoesServicos->count() }}</h4>
                        <p class="text-muted mb-0">Serviços com Comissão</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #06b6d4, #67e8f9);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $comissoesServicos->where('tipo_comissao', 'percentual')->count() }}</h4>
                        <p class="text-muted mb-0">Comissões Percentuais</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="product-card">
                <div class="d-flex align-items-center">
                    <div class="product-avatar" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">{{ $comissoesServicos->where('tipo_comissao', 'valor_fixo')->count() }}</h4>
                        <p class="text-muted mb-0">Comissões Fixas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Comissão da Filial no estilo da tela de clientes -->
    <!-- Card de Comissão da Filial -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
            <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                <i class="fas fa-building me-2" style="color: #60a5fa;"></i>Comissão da Filial
            </h6>
        </div>
        <div class="card-body">
            <form id="formComissaoFilial">
                <input type="hidden" name="barbeiro_id" value="{{ $barbeiro->id }}">
                <input type="hidden" name="filial_id" value="{{ $filialId }}">
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Comissão</label>
                        <select name="tipo_comissao_filial" class="form-select" required style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            <option value="percentual" {{ $comissaoFilial && $comissaoFilial->tipo_comissao_filial == 'percentual' ? 'selected' : '' }}>Percentual</option>
                            <option value="valor_fixo" {{ $comissaoFilial && $comissaoFilial->tipo_comissao_filial == 'valor_fixo' ? 'selected' : '' }}>Valor Fixo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Valor da Comissão</label>
                        <input type="number" name="valor_comissao_filial" class="form-control" step="0.01" min="0" 
                               value="{{ $comissaoFilial ? $comissaoFilial->valor_comissao_filial : '' }}" required
                               style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-save me-1"></i>
                            Salvar Comissão da Filial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card de Comissões por Serviço no estilo da tela de clientes -->
    <!-- Card de Comissões por Serviço -->
    <div class="card-custom mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--card-header-bg); border-bottom: 1px solid rgba(59, 130, 246, 0.2);">
            <h6 class="m-0 font-weight-bold" style="color: var(--text-primary);">
                <i class="fas fa-cogs me-2" style="color: #60a5fa;"></i>Nova Comissão por Serviço
            </h6>
        </div>
        <div class="card-body">
            <form id="formComissaoServico">
                <input type="hidden" name="barbeiro_id" value="{{ $barbeiro->id }}">
                <input type="hidden" name="filial_id" value="{{ $filialId }}">
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Serviço</label>
                        <select name="produto_id" class="form-select" required style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            <option value="">Selecione um serviço</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Comissão</label>
                        <select name="tipo_comissao" class="form-select" required style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                            <option value="percentual">Percentual</option>
                            <option value="valor_fixo">Valor Fixo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Valor da Comissão</label>
                        <input type="number" name="valor_comissao" class="form-control" step="0.01" min="0" required
                               style="background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-plus me-1"></i>
                            Adicionar Comissão
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card da Tabela no estilo da tela de clientes -->
    <!-- Card da Tabela -->
    <div class="card-custom">
        <div class="card-body">
            @if($comissoesServicos->count() > 0)
                <!-- Tabela -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: var(--text-primary);">Serviço</th>
                                <th style="color: var(--text-primary);">Tipo</th>
                                <th style="color: var(--text-primary);">Valor</th>
                                <th width="100" style="color: var(--text-primary);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comissoesServicos as $comissao)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            {{ strtoupper(substr($comissao->produto->nome, 0, 2)) }}
                                        </div>
                                        <div class="product-info">
                                            <h6>{{ $comissao->produto->nome }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $comissao->tipo_comissao == 'percentual' ? 'info' : 'warning' }}">
                                        {{ ucfirst($comissao->tipo_comissao) }}
                                    </span>
                                </td>
                                <td>
                                    @if($comissao->tipo_comissao == 'percentual')
                                        <strong>{{ $comissao->valor_comissao }}%</strong>
                                    @else
                                        <strong>R$ {{ number_format($comissao->valor_comissao, 2, ',', '.') }}</strong>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerComissaoServico({{ $comissao->id }})" title="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma comissão por serviço encontrada</h5>
                    <p class="text-muted">Configure a primeira comissão por serviço para começar.</p>
                </div>
            @endif
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

    .form-label {
        color: var(--text-primary) !important;
    }

    h2, h5, h6, p {
        color: var(--text-primary) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Salvar comissão da filial
    $('#formComissaoFilial').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("comissoes.salvar-filial") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function(xhr) {
                toastr.error('Erro ao salvar comissão da filial');
            }
        });
    });

    // Salvar comissão do serviço
    $('#formComissaoServico').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("comissoes.salvar-servico") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#formComissaoServico')[0].reset();
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function(xhr) {
                toastr.error('Erro ao salvar comissão do serviço');
            }
        });
    });
});

function removerComissaoServico(id) {
    if(confirm('Tem certeza que deseja remover esta comissão?')) {
        $.ajax({
            url: '{{ route("comissoes.remover-servico", "") }}/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function(xhr) {
                toastr.error('Erro ao remover comissão');
            }
        });
    }
}
</script>
@endpush
@endsection
