<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Faturamento Mensal</title>
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
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }
        
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .info-item {
            display: table-cell;
            width: 25%;
            padding: 8px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }
        
        .info-label {
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #1f2937;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border: 1px solid #d1d5db;
            background: #f9fafb;
        }
        
        .summary-card h3 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #059669;
        }
        
        .summary-card .label {
            color: #6b7280;
            font-size: 11px;
            margin-top: 5px;
        }
        
        .table-container {
            margin-bottom: 30px;
        }
        
        .table-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #d1d5db;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #3b82f6;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .highlight {
            background: #fef3c7;
            padding: 2px 4px;
            border-radius: 3px;
        }
        
        .positive {
            color: #059669;
            font-weight: bold;
        }
        
        .negative {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Faturamento Mensal</h1>
        <div class="subtitle">
            Período: {{ $parametros['data_inicial'] ?? 'N/A' }} a {{ $parametros['data_final'] ?? 'N/A' }}
        </div>
        <div class="subtitle">
            Gerado em: {{ date('d/m/Y H:i:s') }}
        </div>
    </div>

    <div class="info-section">
        <div class="info-item">
            <div class="info-label">Filial:</div>
            <div class="info-value">{{ $parametros['filial_nome'] ?? 'Todas as filiais' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Forma de Pagamento:</div>
            <div class="info-value">{{ $parametros['forma_pagamento_nome'] ?? 'Todas as formas' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total de Dias:</div>
            <div class="info-value">{{ $dados['total_dias'] ?? 30 }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Atendimentos:</div>
            <div class="info-value">{{ $dados['total_atendimentos'] ?? 0 }}</div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>Faturamento Total</h3>
            <div class="value">R$ {{ number_format($dados['faturamento_total'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">No período</div>
        </div>
        <div class="summary-card">
            <h3>Ticket Médio</h3>
            <div class="value">R$ {{ number_format($dados['ticket_medio'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">Por atendimento</div>
        </div>
        <div class="summary-card">
            <h3>Faturamento Diário</h3>
            <div class="value">R$ {{ number_format($dados['faturamento_diario'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">Média diária</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-title">Faturamento por Dia</div>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Dia da Semana</th>
                    <th class="text-right">Atendimentos</th>
                    <th class="text-right">Faturamento</th>
                    <th class="text-right">Ticket Médio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['faturamento_diario_detalhado'] ?? [] as $dia)
                <tr>
                    <td>{{ $dia['data'] }}</td>
                    <td>{{ $dia['dia_semana'] }}</td>
                    <td class="text-right">{{ $dia['atendimentos'] }}</td>
                    <td class="text-right">R$ {{ number_format($dia['faturamento'], 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($dia['ticket_medio'], 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum dado encontrado para o período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($dados['faturamento_por_forma_pagamento']))
    <div class="table-container">
        <div class="table-title">Faturamento por Forma de Pagamento</div>
        <table>
            <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Percentual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados['faturamento_por_forma_pagamento'] as $forma)
                <tr>
                    <td>{{ $forma['nome'] }}</td>
                    <td class="text-right">{{ $forma['quantidade'] }}</td>
                    <td class="text-right">R$ {{ number_format($forma['valor'], 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($forma['percentual'], 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        BarberShop Pro - Relatório de Faturamento Mensal - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
