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
            font-size: 11px;
            line-height: 1.5;
            color: #1f2937;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
            color: black;
            border-radius: 8px;
        }
        
        .header h1 {
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .header .subtitle {
            font-size: 13px;
            opacity: 0.95;
            margin-top: 5px;
        }
        
        .info-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-item {
            display: table-cell;
            padding: 8px 12px;
            width: 50%;
        }
        
        .info-label {
            font-weight: 600;
            color: #475569;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #1e293b;
            font-size: 12px;
            font-weight: 500;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 10px 0;
        }
        
        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 18px;
            text-align: center;
            border: 2px solid #e2e8f0;
            background: #ffffff;
            border-radius: 8px;
        }
        
        .summary-card.primary {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        
        .summary-card h3 {
            color: #64748b;
            font-size: 11px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        
        .summary-card .value {
            font-size: 22px;
            font-weight: bold;
            color: #059669;
            margin-bottom: 5px;
        }
        
        .summary-card.primary .value {
            color: #1e40af;
            font-size: 26px;
        }
        
        .summary-card .label {
            color: #94a3b8;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #3b82f6;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: #3b82f6;
            margin-right: 10px;
            border-radius: 2px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        th {
            background: #1e40af;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            color: #334155;
        }
        
        tr:nth-child(even) {
            background: #f8fafc;
        }
        
        tr:hover {
            background: #f1f5f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
        
        .footer strong {
            color: #475569;
        }
        
        .highlight-row {
            background: #fef3c7 !important;
            font-weight: 600;
        }
        
        .total-row {
            background: #e0f2fe !important;
            font-weight: bold;
            color: #0c4a6e;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
            font-style: italic;
        }
        
        .chart-bar {
            height: 20px;
            background: #3b82f6;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Relatório de Faturamento Mensal</h1>
        <div class="subtitle">
            Período: {{ $data['periodo_inicio'] }} a {{ $data['periodo_fim'] }}
        </div>
        <div class="subtitle">
            Gerado em: {{ date('d/m/Y H:i:s') }}
        </div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-item">
                <div class="info-label">Filial</div>
                <div class="info-value">{{ $data['filial_id'] ? 'Filial #' . $data['filial_id'] : 'Todas as filiais' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total de Transações</div>
                <div class="info-value">{{ number_format($data['total_transacoes'], 0, ',', '.') }} transações</div>
            </div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card primary">
            <h3>Faturamento Total</h3>
            <div class="value">R$ {{ number_format($data['total_faturamento'], 2, ',', '.') }}</div>
            <div class="label">No período selecionado</div>
        </div>
        <div class="summary-card">
            <h3>Ticket Médio</h3>
            <div class="value">R$ {{ $data['total_transacoes'] > 0 ? number_format($data['total_faturamento'] / $data['total_transacoes'], 2, ',', '.') : '0,00' }}</div>
            <div class="label">Por transação</div>
        </div>
        <div class="summary-card">
            <h3>Total de Dias</h3>
            <div class="value">{{ $data['faturamento_por_dia']->count() }}</div>
            <div class="label">Com movimentação</div>
        </div>
    </div>

    <div class="section-title">Faturamento por Dia</div>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th class="text-right">Transações</th>
                <th class="text-right">Valor Total</th>
                <th class="text-right">Ticket Médio</th>
                <th class="text-right">% do Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['faturamento_por_dia'] as $dia)
            <tr>
                <td>
                    <span class="badge badge-info">{{ $dia['data'] }}</span>
                </td>
                <td class="text-right">{{ number_format($dia['transacoes'], 0, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($dia['valor'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ $dia['transacoes'] > 0 ? number_format($dia['valor'] / $dia['transacoes'], 2, ',', '.') : '0,00' }}</td>
                <td class="text-right">{{ $data['total_faturamento'] > 0 ? number_format(($dia['valor'] / $data['total_faturamento']) * 100, 1) : '0' }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-state">
                    Nenhuma movimentação encontrada para o período selecionado
                </td>
            </tr>
            @endforelse
            
            @if($data['faturamento_por_dia']->count() > 0)
            <tr class="total-row">
                <td><strong>TOTAL GERAL</strong></td>
                <td class="text-right"><strong>{{ number_format($data['total_transacoes'], 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>R$ {{ number_format($data['total_faturamento'], 2, ',', '.') }}</strong></td>
                <td class="text-right"><strong>R$ {{ number_format($data['total_faturamento'] / $data['total_transacoes'], 2, ',', '.') }}</strong></td>
                <td class="text-right"><strong>100%</strong></td>
            </tr>
            @endif
        </tbody>
    </table>

    @if($data['faturamento_por_forma_pagamento']->count() > 0)
    <div class="section-title">Faturamento por Forma de Pagamento</div>
    <table>
        <thead>
            <tr>
                <th>Forma de Pagamento</th>
                <th class="text-right">Transações</th>
                <th class="text-right">Valor Total</th>
                <th class="text-right">Ticket Médio</th>
                <th class="text-right">% do Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['faturamento_por_forma_pagamento'] as $forma)
            <tr>
                <td>
                    <span class="badge badge-success">{{ $forma['forma_pagamento'] }}</span>
                </td>
                <td class="text-right">{{ number_format($forma['transacoes'], 0, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($forma['valor'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ $forma['transacoes'] > 0 ? number_format($forma['valor'] / $forma['transacoes'], 2, ',', '.') : '0,00' }}</td>
                <td class="text-right">{{ $data['total_faturamento'] > 0 ? number_format(($forma['valor'] / $data['total_faturamento']) * 100, 1) : '0' }}%</td>
            </tr>
            @endforeach
            
            <tr class="total-row">
                <td><strong>TOTAL GERAL</strong></td>
                <td class="text-right"><strong>{{ number_format($data['total_transacoes'], 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>R$ {{ number_format($data['total_faturamento'], 2, ',', '.') }}</strong></td>
                <td class="text-right"><strong>R$ {{ number_format($data['total_faturamento'] / $data['total_transacoes'], 2, ',', '.') }}</strong></td>
                <td class="text-right"><strong>100%</strong></td>
            </tr>
        </tbody>
    </table>
    @endif

    <div class="section-title">Detalhamento de Movimentações</div>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Forma Pagamento</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['movimentacoes'] as $mov)
            <tr>
                <td>{{ \Carbon\Carbon::parse($mov->data_pagamento)->format('d/m/Y') }}</td>
                <td>{{ $mov->descricao ?? 'Movimentação financeira' }}</td>
                <td>{{ $mov->formaPagamento->nome ?? 'N/A' }}</td>
                <td class="text-right">R$ {{ number_format($mov->valor_pago, 2, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="empty-state">
                    Nenhuma movimentação encontrada
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>BarberShop</strong> - Relatório de Faturamento Mensal - Gerado em {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
