<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Serviços Realizados por Filial</title>
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
            background-color: #8b5cf6;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-bottom: 4px solid #7c3aed;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .header .periodo {
            font-size: 12px;
            opacity: 0.95;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .summary-card {
            display: table-cell;
            width: 20%;
            padding: 12px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .summary-card .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 4px;
            font-weight: 600;
        }
        
        .summary-card .value {
            font-size: 16px;
            font-weight: bold;
            color: #8b5cf6;
        }
        
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #8b5cf6;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table thead {
            background-color: #8b5cf6;
            color: white;
        }
        
        table th {
            padding: 8px;
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
        
        table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        table tbody tr:hover {
            background-color: #f3f4f6;
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
        }
        
        .badge-purple {
            background-color: #ede9fe;
            color: #7c3aed;
        }
        
        .chart-container {
            margin: 15px 0;
        }
        
        .chart-bar-wrapper {
            margin-bottom: 10px;
        }
        
        .chart-label {
            font-size: 10px;
            color: #374151;
            margin-bottom: 4px;
            font-weight: 600;
        }
        
        .chart-bar {
            width: 100%;
            height: 24px;
            background-color: #f3f4f6;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .chart-bar-fill {
            height: 100%;
            background-color: #8b5cf6;
            border-radius: 6px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
        }
        
        .chart-bar-percentage {
            color: white;
            font-size: 10px;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .chart-info {
            font-size: 9px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .filial-section {
            background-color: #f9fafb;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #8b5cf6;
            border-radius: 4px;
        }
        
        .filial-title {
            font-size: 13px;
            font-weight: bold;
            color: #8b5cf6;
            margin-bottom: 10px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
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
    <div class="header">
        <h1>📊 Relatório de Serviços Realizados por Filial</h1>
        <div class="periodo">Período: {{ $data['periodo_inicio'] }} a {{ $data['periodo_fim'] }}</div>
    </div>

    <!-- Cards de Resumo -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="label">Total Serviços</div>
            <div class="value">{{ number_format($data['total_servicos'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Valor Total</div>
            <div class="value">R$ {{ number_format($data['total_valor'], 2, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Atendimentos</div>
            <div class="value">{{ number_format($data['total_atendimentos'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Clientes Únicos</div>
            <div class="value">{{ number_format($data['clientes_unicos'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Ticket Médio</div>
            <div class="value">R$ {{ number_format($data['ticket_medio'], 2, ',', '.') }}</div>
        </div>
    </div>

    <!-- Resumo por Filial -->
    <div class="section">
        <div class="section-title">Resumo por Filial</div>
        <table>
            <thead>
                <tr>
                    <th>Filial</th>
                    <th class="text-center">Serviços</th>
                    <th class="text-right">Valor Total</th>
                    <th class="text-center">Atendimentos</th>
                    <th class="text-center">Clientes</th>
                    <th class="text-right">Ticket Médio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['servicos_por_filial'] as $filial)
                <tr>
                    <td><strong>{{ $filial['filial_nome'] }}</strong></td>
                    <td class="text-center">{{ number_format($filial['total_servicos'], 0, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($filial['total_valor'], 2, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($filial['total_atendimentos'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($filial['clientes_unicos'], 0, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($filial['ticket_medio'], 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum serviço realizado no período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top 10 Serviços Mais Realizados -->
    <div class="section">
        <div class="section-title">Top 10 Serviços Mais Realizados (Geral)</div>
        <table>
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Serviço</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-center">Atendimentos</th>
                    <th class="text-right">Valor Total</th>
                    <th class="text-right">Valor Médio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['top_servicos'] as $index => $servico)
                <tr>
                    <td class="text-center"><span class="badge badge-purple">#{{ (int)$index + (int)1 }}</span></td>
                    <td><strong>{{ $servico['servico_nome'] }}</strong></td>
                    <td class="text-center">{{ number_format($servico['quantidade'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($servico['atendimentos'], 0, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($servico['valor_total'], 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($servico['valor_medio'], 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum serviço encontrado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Serviços por Dia da Semana -->
    <div class="section">
        <div class="section-title">Distribuição por Dia da Semana</div>
        <div class="chart-container">
            @php
                $maxValor = $data['servicos_por_dia_semana']->max('valor');
            @endphp
            @foreach($data['servicos_por_dia_semana'] as $dia)
                @php
                    $percentual = $maxValor > 0 ? ($dia['valor'] / $maxValor) * 100 : 0;
                @endphp
                <div class="chart-bar-wrapper">
                    <div class="chart-label">{{ $dia['dia_semana'] }}</div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="width: {{ $percentual }}%; background-color: #8b5cf6;">
                            <span class="chart-bar-percentage">{{ number_format($percentual, 1) }}%</span>
                        </div>
                    </div>
                    <div class="chart-info">
                        {{ number_format($dia['quantidade'], 0, ',', '.') }} serviços - 
                        R$ {{ number_format($dia['valor'], 2, ',', '.') }} - 
                        {{ number_format($dia['atendimentos'], 0, ',', '.') }} atendimentos
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top 10 Barbeiros Mais Produtivos -->
    <div class="section">
        <div class="section-title">Top 10 Barbeiros Mais Produtivos</div>
        <table>
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Barbeiro</th>
                    <th class="text-center">Serviços</th>
                    <th class="text-center">Atendimentos</th>
                    <th class="text-center">Clientes</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['barbeiros_produtivos'] as $index => $barbeiro)
                <tr>
                    <td class="text-center"><span class="badge badge-purple">#{{ (int)$index + (int)1  }}</span></td>
                    <td><strong>{{ $barbeiro['barbeiro_nome'] }}</strong></td>
                    <td class="text-center">{{ number_format($barbeiro['total_servicos'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($barbeiro['atendimentos'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($barbeiro['clientes_unicos'], 0, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($barbeiro['total_valor'], 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum barbeiro encontrado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Serviços Detalhados por Filial -->
    <div class="section">
        <div class="section-title">Top 5 Serviços por Filial</div>
        @foreach($data['servicos_detalhados_por_filial'] as $filialNome => $servicos)
            <div class="filial-section">
                <div class="filial-title">{{ $filialNome }}</div>
                <table>
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-center">Atendimentos</th>
                            <th class="text-right">Valor Total</th>
                            <th class="text-right">Valor Médio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicos as $servico)
                        <tr>
                            <td>{{ $servico['servico_nome'] }}</td>
                            <td class="text-center">{{ number_format($servico['quantidade'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($servico['atendimentos'], 0, ',', '.') }}</td>
                            <td class="text-right">R$ {{ number_format($servico['valor_total'], 2, ',', '.') }}</td>
                            <td class="text-right">R$ {{ number_format($servico['valor_medio'], 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum serviço realizado nesta filial</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Relatório gerado em {{ date('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestão - BarberShop</p>
    </div>
</body>
</html>
