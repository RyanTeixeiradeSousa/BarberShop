<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório - Perfil de Clientes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #495057;
            padding: 5px 15px 5px 0;
            width: 30%;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
            color: #212529;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stat-card {
            display: table-cell;
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: 0 5px;
            width: 25%;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }
        
        .table th {
            background: #667eea;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e9ecef;
            font-size: 11px;
        }
        
        .table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #f8f9fa;
            padding: 10px 20px;
            border-top: 1px solid #e9ecef;
            font-size: 10px;
            color: #6c757d;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório - Perfil de Clientes</h1>
        <p>Período: {{ $periodo_inicio }} a {{ $periodo_fim }}</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <h3 style="color: #667eea; margin-bottom: 10px;">Filtros Aplicados</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Período:</div>
                <div class="info-value">{{ $periodo_inicio }} a {{ $periodo_fim }}</div>
            </div>
            @if($sexo)
            <div class="info-row">
                <div class="info-label">Sexo:</div>
                <div class="info-value">{{ $sexo == 'M' ? 'Masculino' : 'Feminino' }}</div>
            </div>
            @endif
            @if($faixa_etaria)
            <div class="info-row">
                <div class="info-label">Faixa Etária:</div>
                <div class="info-value">{{ $faixa_etaria }}</div>
            </div>
            @endif
            @if($status)
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">{{ $status == '1' ? 'Ativo' : 'Inativo' }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stat-card">
                <span class="stat-number">{{ $estatisticas['total_clientes'] }}</span>
                <span class="stat-label">Total de Clientes</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $estatisticas['clientes_ativos'] }}</span>
                <span class="stat-label">Clientes Ativos</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $estatisticas['masculino'] }}</span>
                <span class="stat-label">Masculino</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $estatisticas['feminino'] }}</span>
                <span class="stat-label">Feminino</span>
            </div>
        </div>
    </div>

    <h2 class="section-title">Perfil Demográfico</h2>
    
    @if(count($faixas_etarias) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Faixa Etária</th>
                <th class="text-center">Quantidade</th>
                <th class="text-center">Percentual</th>
                <th class="text-center">Masculino</th>
                <th class="text-center">Feminino</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faixas_etarias as $faixa)
            <tr>
                <td>{{ $faixa->faixa_etaria }}</td>
                <td class="text-center">{{ $faixa->quantidade }}</td>
                <td class="text-center">{{ number_format($faixa->percentual, 1) }}%</td>
                <td class="text-center">{{ $faixa->masculino }}</td>
                <td class="text-center">{{ $faixa->feminino }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">Nenhum dado demográfico encontrado para o período selecionado.</div>
    @endif

    <h2 class="section-title">Clientes por Frequência</h2>
    
    @if(count($clientes_frequencia) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Contato</th>
                <th class="text-center">Total Agendamentos</th>
                <th class="text-center">Valor Total Gasto</th>
                <th class="text-center">Último Agendamento</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes_frequencia as $cliente)
            <tr>
                <td>
                    <strong>{{ $cliente->nome }}</strong><br>
                    <small style="color: #6c757d;">{{ $cliente->cpf }}</small>
                </td>
                <td>
                    {{ $cliente->telefone1 }}<br>
                    <small style="color: #6c757d;">{{ $cliente->email }}</small>
                </td>
                <td class="text-center">{{ $cliente->total_agendamentos }}</td>
                <td class="text-center">R$ {{ number_format($cliente->valor_total_gasto, 2, ',', '.') }}</td>
                <td class="text-center">
                    @if($cliente->ultimo_agendamento)
                        {{ date('d/m/Y', strtotime($cliente->ultimo_agendamento)) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if($cliente->ativo)
                        <span class="badge badge-success">Ativo</span>
                    @else
                        <span class="badge badge-danger">Inativo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">Nenhum cliente encontrado para o período selecionado.</div>
    @endif

    <div class="page-break"></div>

    <h2 class="section-title">Análise de Comportamento</h2>
    
    @if(count($servicos_preferidos) > 0)
    <h3 style="color: #495057; margin: 20px 0 10px 0; font-size: 14px;">Serviços Mais Procurados</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Serviço</th>
                <th class="text-center">Quantidade de Clientes</th>
                <th class="text-center">Total de Utilizações</th>
                <th class="text-center">Valor Médio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicos_preferidos as $servico)
            <tr>
                <td>{{ $servico->nome }}</td>
                <td class="text-center">{{ $servico->clientes_unicos }}</td>
                <td class="text-center">{{ $servico->total_utilizacoes }}</td>
                <td class="text-center">R$ {{ number_format($servico->valor_medio, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(count($horarios_preferidos) > 0)
    <h3 style="color: #495057; margin: 20px 0 10px 0; font-size: 14px;">Horários de Maior Procura</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Horário</th>
                <th class="text-center">Quantidade de Agendamentos</th>
                <th class="text-center">Percentual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios_preferidos as $horario)
            <tr>
                <td>{{ $horario->horario }}</td>
                <td class="text-center">{{ $horario->quantidade }}</td>
                <td class="text-center">{{ number_format($horario->percentual, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <div style="float: left;">
            <strong>{{ config('app.name', 'BarberShop') }}</strong> - Sistema de Gestão
        </div>
        <div style="float: right;">
            Página <span class="pagenum"></span>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
