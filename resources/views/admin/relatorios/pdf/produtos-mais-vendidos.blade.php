<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Produtos Mais Vendidos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1f2937;
            padding: 20px 30px;
        }

        .header {
            background-color: #7c3aed;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            border-bottom: 4px solid #6d28d9;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 10px;
        }

        .summary-cards {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .summary-card {
            flex: 1;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }

        .summary-card.purple {
            border-color: #7c3aed;
            background-color: #f5f3ff;
        }

        .summary-card-value {
            font-size: 20px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 4px;
        }

        .summary-card-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #7c3aed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background: white;
        }

        table thead {
            background-color: #7c3aed;
            color: white;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }

        table tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-produto {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-servico {
            background-color: #fef3c7;
            color: #92400e;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .chart-container {
            margin: 15px 0;
        }

        .chart-bar-wrapper {
            margin-bottom: 12px;
        }

        .chart-label {
            font-size: 10px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }

        .chart-bar-bg {
            background-color: #f3f4f6;
            border-radius: 6px;
            height: 24px;
            position: relative;
            overflow: hidden;
        }

        .chart-bar-fill {
            background-color: #7c3aed;
            height: 100%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
        }

        .chart-bar-percentage {
            color: white;
            font-size: 9px;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .chart-info {
            font-size: 9px;
            color: #6b7280;
            margin-top: 4px;
        }

        .filial-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .filial-title {
            font-size: 12px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
     Header 
    <div class="header">
        <h1>📦 Relatório de Produtos Mais Vendidos</h1>
        <div class="header-info">
            <div>
                <strong>Período:</strong> {{ $data['periodo_inicio'] }} a {{ $data['periodo_fim'] }}
            </div>
            @if($data['filial_nome'])
                <div>
                    <strong>Filial:</strong> {{ $data['filial_nome'] }}
                </div>
            @endif
            <div>
                <strong>Gerado em:</strong> {{ date('d/m/Y H:i') }}
            </div>
        </div>
    </div>

     Summary Cards 
    <div class="summary-cards">
        <div class="summary-card purple">
            <div class="summary-card-value">{{ number_format($data['total_quantidade'], 0, ',', '.') }}</div>
            <div class="summary-card-label">Total de Itens Vendidos</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-value">R$ {{ number_format($data['total_valor'], 2, ',', '.') }}</div>
            <div class="summary-card-label">Valor Total</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-value">{{ number_format($data['total_vendas'], 0, ',', '.') }}</div>
            <div class="summary-card-label">Total de Vendas</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-value">R$ {{ number_format($data['ticket_medio'], 2, ',', '.') }}</div>
            <div class="summary-card-label">Ticket Médio</div>
        </div>
    </div>

     Top 10 Produtos Mais Vendidos (Geral) 
    <div class="section">
        <div class="section-title">🏆 Top 10 Produtos Mais Vendidos</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 35%;">Produto</th>
                    <th style="width: 10%;">Tipo</th>
                    <th style="width: 15%;" class="text-right">Quantidade</th>
                    <th style="width: 15%;" class="text-right">Valor Total</th>
                    <th style="width: 10%;" class="text-right">Vendas</th>
                    <th style="width: 10%;" class="text-right">Valor Médio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['produtos_vendidos']->take(10) as $index => $produto)
                    <tr>
                        <td class="text-center"><strong>{{ $index + 1 }}º</strong></td>
                        <td>{{ $produto->nome }}</td>
                        <td>
                            <span class="badge badge-{{ $produto->tipo }}">
                                {{ $produto->tipo === 'produto' ? 'Produto' : 'Serviço' }}
                            </span>
                        </td>
                        <td class="text-right">{{ number_format($produto->total_quantidade, 0, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format($produto->total_valor, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($produto->total_vendas, 0, ',', '.') }}</td>
                        <td class="text-right">R$ {{ number_format($produto->valor_medio, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

     Gráfico de Produtos por Tipo 
    @if($data['produtos_por_tipo']->count() > 0)
        <div class="section">
            <div class="section-title">📊 Distribuição por Tipo</div>
            <div class="chart-container">
                @foreach($data['produtos_por_tipo'] as $tipo => $stats)
                    @php
                        $percentual = $data['total_quantidade'] > 0 ? ($stats['quantidade'] / $data['total_quantidade']) * 100 : 0;
                    @endphp
                    <div class="chart-bar-wrapper">
                        <div class="chart-label">{{ $tipo === 'produto' ? 'Produtos' : 'Serviços' }}</div>
                        <div class="chart-bar-bg">
                            <div class="chart-bar-fill" style="width: {{ $percentual }}%; background-color: {{ $tipo === 'produto' ? '#3b82f6' : '#f59e0b' }};">
                                <span class="chart-bar-percentage">{{ number_format($percentual, 1) }}%</span>
                            </div>
                        </div>
                        <div class="chart-info">
                            {{ number_format($stats['quantidade'], 0, ',', '.') }} itens - 
                            R$ {{ number_format($stats['valor'], 2, ',', '.') }} - 
                            {{ number_format($stats['vendas'], 0, ',', '.') }} vendas
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

     Produtos Mais Vendidos por Filial 
    @if($data['produtos_por_filial']->count() > 0)
        <div class="page-break"></div>
        <div class="section">
            <div class="section-title">🏢 Produtos Mais Vendidos por Filial</div>
            @foreach($data['produtos_por_filial'] as $filialNome => $produtos)
                <div class="filial-section">
                    <div class="filial-title">{{ $filialNome }}</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;">Produto</th>
                                <th style="width: 15%;">Tipo</th>
                                <th style="width: 15%;" class="text-right">Quantidade</th>
                                <th style="width: 15%;" class="text-right">Valor Total</th>
                                <th style="width: 10%;" class="text-right">Vendas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $index => $produto)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}º</td>
                                    <td>{{ $produto->produto_nome }}</td>
                                    <td>
                                        <span class="badge badge-{{ $produto->tipo }}">
                                            {{ $produto->tipo === 'produto' ? 'Produto' : 'Serviço' }}
                                        </span>
                                    </td>
                                    <td class="text-right">{{ number_format($produto->total_quantidade, 0, ',', '.') }}</td>
                                    <td class="text-right">R$ {{ number_format($produto->total_valor, 2, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($produto->total_vendas, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif

     Footer 
    <div class="footer">
        <p><strong>BarberShop Pro</strong> - Sistema de Gestão para Barbearias</p>
        <p>Relatório gerado automaticamente em {{ date('d/m/Y') }} às {{ date('H:i') }}</p>
    </div>
</body>
</html>
