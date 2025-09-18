{{-- {{dd($filial)}} --}}
@extends('layouts.app')

@section('title', 'Gerenciar Comissões - BarberShop Pro')
@section('page-title', 'Comissões')
@section('page-subtitle', 'Gerencie as comissões do barbeiro')

@section('content')
<div class="container-fluid">
    <!-- Header da Página -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="header-icon me-3">
                    <i class="fas fa-percentage"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold">Comissões - {{ $barbeiro->nome }}</h2>
                    <p class="mb-0 text-muted"><span class=" badge bg-primary">{{ $filial->nome ?? 'Filial Selecionada' }}</span> • Gerencie comissões da filial e por serviço</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('barbeiros.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>
                Voltar aos Barbeiros
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card primary">
                <div class="stats-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $comissaoFilial ? ($comissaoFilial->tipo_comissao_filial == 'percentual' ? $comissaoFilial->valor_comissao_filial.'%' : 'R$ '.number_format($comissaoFilial->valor_comissao_filial, 2, ',', '.')) : 'Não definida' }}</h3>
                    <p class="stats-label">Comissão da Filial</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="stats-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $comissoesServicos->count() }}</h3>
                    <p class="stats-label">Serviços com Comissão</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card info">
                <div class="stats-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $comissoesServicos->where('tipo_comissao', 'percentual')->count() }}</h3>
                    <p class="stats-label">Comissões Percentuais</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="stats-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $comissoesServicos->where('tipo_comissao', 'valor_fixo')->count() }}</h3>
                    <p class="stats-label">Comissões Fixas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Comissão da Filial -->
    <div class="main-card mb-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <i class="fas fa-building me-2"></i>
                <h5 class="mb-0">Comissão da Filial</h5>
            </div>
        </div>
        <div class="card-body">
            <form id="formComissaoFilial">
                <input type="hidden" name="barbeiro_id" value="{{ $barbeiro->id }}">
                <input type="hidden" name="filial_id" value="{{ $filialId }}">
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tipo de Comissão</label>
                            <select name="tipo_comissao_filial" class="form-select" required>
                                <option value="percentual" {{ $comissaoFilial && $comissaoFilial->tipo_comissao_filial == 'percentual' ? 'selected' : '' }}>Percentual (%)</option>
                                <option value="valor_fixo" {{ $comissaoFilial && $comissaoFilial->tipo_comissao_filial == 'valor_fixo' ? 'selected' : '' }}>Valor Fixo (R$)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Valor da Comissão</label>
                            <input type="text" name="valor_comissao_filial" id="valor_comissao_filial" class="form-control" 
                                   value="{{ $comissaoFilial ? $comissaoFilial->valor_comissao_filial : '' }}" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>
                            Salvar Comissão
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card de Nova Comissão por Serviço -->
    <div class="main-card mb-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <i class="fas fa-plus-circle me-2"></i>
                <h5 class="mb-0">Nova Comissão por Serviço</h5>
            </div>
        </div>
        <div class="card-body">
            <form id="formComissaoServico">
                <input type="hidden" name="barbeiro_id" value="{{ $barbeiro->id }}">
                <input type="hidden" name="filial_id" value="{{ $filialId }}">
                
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Serviço</label>
                            <select name="produto_id" class="form-select" required>
                                <option value="">Selecione um serviço</option>
                                @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tipo de Comissão</label>
                            <select name="tipo_comissao" class="form-select" required>
                                <option value="percentual">Percentual (%)</option>
                                <option value="valor_fixo">Valor Fixo (R$)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Valor da Comissão</label>
                            <input type="text" name="valor_comissao" id="valor_comissao" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-1"></i>
                            Adicionar Comissão
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card da Tabela -->
    <div class="main-card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list me-2"></i>
                    <h5 class="mb-0">Comissões por Serviço</h5>
                </div>
                <span class="badge bg-primary">{{ $comissoesServicos->count() }} comissões</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($comissoesServicos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Serviço</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th width="80">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comissoesServicos as $comissao)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="service-avatar me-3">
                                            {{ strtoupper(substr($comissao->produto->nome, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $comissao->produto->nome }}</h6>
                                            <small class="text-muted">Serviço</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $comissao->tipo_comissao == 'percentual' ? 'info' : 'warning' }}">
                                        {{ $comissao->tipo_comissao == 'percentual' ? 'Percentual' : 'Valor Fixo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="commission-value">
                                        @if($comissao->tipo_comissao == 'percentual')
                                            <strong class="text-info">{{ $comissao->valor_comissao }}%</strong>
                                        @else
                                            <strong class="text-warning">R$ {{ number_format($comissao->valor_comissao, 2, ',', '.') }}</strong>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="removerComissaoServico({{ $comissao->id }})" 
                                            title="Remover comissão">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h5>Nenhuma comissão por serviço</h5>
                    <p>Configure a primeira comissão por serviço para começar a gerenciar as comissões individuais.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #1e293b;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Styles */
    .header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
    }

    h2 {
        color: #1e293b !important;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .text-muted {
        color: #64748b !important;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .stats-card:hover::before {
        opacity: 1;
    }

    .stats-card.primary::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stats-card.success::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stats-card.info::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
    .stats-card.warning::before { background: linear-gradient(90deg, #f59e0b, #d97706); }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        color: white;
    }

    .stats-card.primary .stats-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .stats-card.success .stats-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .stats-card.info .stats-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    .stats-card.warning .stats-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .stats-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .stats-label {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Main Cards */
    .main-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .main-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        border-color: rgba(59, 130, 246, 0.2);
    }

    .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        border-radius: 16px 16px 0 0;
    }

    .card-header h5 {
        color: #1e293b;
        font-weight: 600;
        font-size: 1.125rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        color: #374151 !important;
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control, .form-select {
        background: white !important;
        border: 1px solid #d1d5db !important;
        color: #1f2937 !important;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        color: #1f2937 !important;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border: 1px solid #d1d5db;
        color: #6b7280;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: #374151;
    }

    .btn-outline-danger {
        border: 1px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #dc2626;
        color: #dc2626;
    }

    /* Table Styles */
    .table {
        color: #1e293b;
        margin: 0;
    }

    .table th {
        background: #f8fafc;
        border: none;
        color: #374151 !important;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 1rem 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .table td {
        border: none;
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .service-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .commission-value strong {
        font-size: 1rem;
        font-weight: 600;
    }

    /* Badge Styles */
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
    }

    .bg-info { background: linear-gradient(135deg, #06b6d4, #0891b2) !important; }
    .bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }
    .bg-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: #3b82f6;
        font-size: 2rem;
    }

    .empty-state h5 {
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #64748b;
        margin: 0;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .header-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        .stats-card {
            padding: 1.25rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function aplicarMascaraFilial() {
        const tipo = document.querySelector('select[name="tipo_comissao_filial"]').value;
        const input = document.getElementById('valor_comissao_filial');
        
        if (tipo === 'percentual') {
            input.placeholder = 'Ex: 15,50';
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
                }
                e.target.value = value;
            });
        } else {
            input.placeholder = 'Ex: 25,00';
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = (parseInt(value) / 100).toFixed(2);
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace('.', ',');
                    if (value.indexOf(',') === -1) {
                        value += ',00';
                    }
                }
                e.target.value = value;
            });
        }
    }
    
    function aplicarMascaraServico() {
        const tipo = document.querySelector('select[name="tipo_comissao"]').value;
        const input = document.getElementById('valor_comissao');
        
        if (tipo === 'percentual') {
            input.placeholder = 'Ex: 15,50';
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
                }
                e.target.value = value;
            });
        } else {
            input.placeholder = 'Ex: 25,00';
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = (parseInt(value) / 100).toFixed(2);
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace('.', ',');
                    if (value.indexOf(',') === -1) {
                        value += ',00';
                    }
                }
                e.target.value = value;
            });
        }
    }
    
    aplicarMascaraFilial();
    aplicarMascaraServico();
    
    document.querySelector('select[name="tipo_comissao_filial"]').addEventListener('change', function() {
        document.getElementById('valor_comissao_filial').value = '';
        aplicarMascaraFilial();
    });
    
    document.querySelector('select[name="tipo_comissao"]').addEventListener('change', function() {
        document.getElementById('valor_comissao').value = '';
        aplicarMascaraServico();
    });
    
    function validarValor(valor, tipo) {
        const valorNumerico = parseFloat(valor.replace(',', '.'));
        
        if (isNaN(valorNumerico) || valorNumerico <= 0) {
            return 'O valor deve ser maior que zero';
        }
        
        if (tipo === 'percentual' && valorNumerico > 100) {
            return 'O percentual não pode ser maior que 100%';
        }
        
        return null;
    }
    
    document.getElementById('valor_comissao_filial').addEventListener('blur', function() {
        const valor = this.value;
        const tipo = document.querySelector('select[name="tipo_comissao_filial"]').value;
        const erro = validarValor(valor, tipo);
        
        if (erro) {
            this.classList.add('is-invalid');
            this.nextElementSibling.textContent = erro;
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    document.getElementById('valor_comissao').addEventListener('blur', function() {
        const valor = this.value;
        const tipo = document.querySelector('select[name="tipo_comissao"]').value;
        const erro = validarValor(valor, tipo);
        
        if (erro) {
            this.classList.add('is-invalid');
            this.nextElementSibling.textContent = erro;
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Salvar comissão da filial
    document.getElementById('formComissaoFilial').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const valor = document.getElementById('valor_comissao_filial').value;
        const tipo = document.querySelector('select[name="tipo_comissao_filial"]').value;
        const erro = validarValor(valor, tipo);
        
        if (erro) {
            document.getElementById('valor_comissao_filial').classList.add('is-invalid');
            document.getElementById('valor_comissao_filial').nextElementSibling.textContent = erro;
            return;
        }
        
        const valorFormatado = valor.replace('.', '').replace(',', '.');
        const formData = new FormData(this);
        formData.set('valor_comissao_filial', valorFormatado);
        
        fetch('{{ route("comissoes.salvar-filial") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            alert('Erro ao salvar comissão da filial');
        });
    });

    // Salvar comissão do serviço
    document.getElementById('formComissaoServico').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const valor = document.getElementById('valor_comissao').value;
        const tipo = document.querySelector('select[name="tipo_comissao"]').value;
        const erro = validarValor(valor, tipo);
        
        if (erro) {
            document.getElementById('valor_comissao').classList.add('is-invalid');
            document.getElementById('valor_comissao').nextElementSibling.textContent = erro;
            return;
        }
        
        const valorFormatado = valor.replace('.', '').replace(',', '.');
        const formData = new FormData(this);
        formData.set('valor_comissao', valorFormatado);
        
        fetch('{{ route("comissoes.salvar-servico") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                this.reset();
                aplicarMascaraServico();
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            alert('Erro ao salvar comissão do serviço');
        });
    });
});

function removerComissaoServico(id) {
    if(confirm('Tem certeza que deseja remover esta comissão?')) {
        fetch('{{ route("comissoes.remover-servico", "") }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            alert('Erro ao remover comissão');
        });
    }
}
</script>
@endpush
@endsection
