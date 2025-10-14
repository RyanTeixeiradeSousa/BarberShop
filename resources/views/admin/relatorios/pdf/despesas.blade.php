<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.5;
            background: #f9fafb;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 15px;
        }

        /* Header melhorado com gradiente mais suave */
        .header {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #ef4444 100%);
            color: white;
            padding: 25px 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
        }

        .header h1 {
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 13px;
            opacity: 0.95;
            font-weight: 300;
        }

        /* Info section com melhor hierarquia visual */
        .info-section {
            background: linear-gradient(to right, #fef2f2, #ffffff);
            border-left: 5px solid #dc2626;
            padding: 15px 18px;
            margin-bottom: 25px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 700;
            color: #991b1b;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            color: #374151;
            font-size: 11px;
            font-weight: 500;
        }

        /* Cards de resumo com design mais moderno */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            border: 2px solid #fee2e2;
            border-radius: 10px;
            padding: 16px 14px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .summary-card.highlight {
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
            border-color: #dc2626;
            border-width: 3px;
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.15);
        }

        .summary-card .icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .summary-card .label {
            font-size: 9px;
            color: #991b1b;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .summary-card .value {
            font-size: 18px;
            font-weight: 800;
            color: #dc2626;
            margin-bottom: 4px;
        }

        .summary-card .subvalue {
            font-size: 8px;
            color: #6b7280;
            font-weight: 500;
        }

        /* Section title com melhor destaque */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #991b1b;
            margin: 25px 0 15px 0;
            padding: 10px 15px;
            background: linear-gradient(to right, #fef2f2, transparent);
            border-left: 5px solid #dc2626;
            border-radius: 4px;
        }

        /* Tabelas com design mais limpo e profissional */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 25px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        table thead {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            color: white;
        }

        table th {
            padding: 12px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #fee2e2;
            font-size: 10px;
            color: #374151;
        }

        table tbody tr:nth-child(even) {
            background: #fef2f2;
        }

        table tbody tr:hover {
            background: #fee2e2;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges com cores mais vibrantes */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 14px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-pago {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-pendente {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-cancelado {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Footer com melhor design */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to right, #fef2f2, #ffffff);
            border-top: 3px solid #dc2626;
            padding: 12px 20px;
            font-size: 8px;
            color: #6b7280;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        /* Chart container com melhor visual */
        .chart-container {
            background: white;
            border: 2px solid #fee2e2;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .chart-bar {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px;
            background: #fef2f2;
            border-radius: 6px;
        }

        .chart-label {
            width: 140px;
            font-size: 10px;
            font-weight: 700;
            color: #991b1b;
        }

        .chart-bar-wrapper {
            flex: 1;
            background: #fee2e2;
            border-radius: 6px;
            height: 28px;
            position: relative;
            overflow: hidden;
        }

        .chart-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #b91c1c, #dc2626, #ef4444);
            border-radius: 6px;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .chart-value {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 9px;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        /* Grid para melhor organização */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border: 2px solid #fee2e2;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 12px;
            font-weight: 700;
            color: #991b1b;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #fee2e2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Relatório de Despesas</h1>
            <p>Análise completa e detalhada das despesas do período</p>
        </div>

        <div class="info-section">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">📅 Período</span>
                    <span class="info-value">{{ $data['periodo_inicio'] }} a {{ $data['periodo_fim'] }}</span>
                </div>
                @if($data['categoria_id'])
                    <div class="info-item">
                        <span class="info-label">🏷️ Categoria</span>
                        <span class="info-value">{{ $data['categoria_nome'] }}</span>
                    </div>
                @endif
                <div class="info-item">
                    <span class="info-label">📆 Data de Geração</span>
                    <span class="info-value">{{ date('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">⏱️ Período Analisado</span>
                    <span class="info-value">{{ $data['dias_periodo'] }} dias</span>
                </div>
            </div>
        </div>

        <div class="summary-cards">
            <div class="summary-card highlight">
                <div class="icon">💰</div>
                <div class="label">Total de Despesas</div>
                <div class="value">R$ {{ number_format($data['total_despesas'], 2, ',', '.') }}</div>
                <div class="subvalue">{{ $data['total_transacoes'] }} transações</div>
            </div>
            <div class="summary-card">
                <div class="icon">✅</div>
                <div class="label">Despesas Pagas</div>
                <div class="value">R$ {{ number_format($data['despesas_pagas'], 2, ',', '.') }}</div>
                <div class="subvalue">{{ $data['transacoes_pagas'] }} transações</div>
            </div>
            <div class="summary-card">
                <div class="icon">⏳</div>
                <div class="label">Despesas Pendentes</div>
                <div class="value">R$ {{ number_format($data['despesas_pendentes'], 2, ',', '.') }}</div>
                <div class="subvalue">{{ $data['transacoes_pendentes'] }} transações</div>
            </div>
            <div class="summary-card">
                <div class="icon">📊</div>
                <div class="label">Média por Dia</div>
                <div class="value">R$ {{ number_format($data['media_por_dia'], 2, ',', '.') }}</div>
                <div class="subvalue">{{ $data['dias_periodo'] }} dias</div>
            </div>
        </div>

        @if(isset($data['despesas_por_categoria']) && $data['despesas_por_categoria']->count() > 0)
            <div class="section-title">📋 Despesas por Categoria</div>
            <div class="chart-container">
                @foreach($data['despesas_por_categoria'] as $categoria)
                    <div class="chart-bar">
                        <div class="chart-label">{{ $categoria['categoria'] }}</div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar-fill" style="width: {{ $data['total_despesas'] > 0 ? ($categoria['valor'] / $data['total_despesas']) * 100 : 0 }}%;">
                                <span class="chart-value">R$ {{ number_format($categoria['valor'], 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Nova seção de despesas por filial --}}
        @if(isset($data['despesas_por_filial']) && $data['despesas_por_filial']->count() > 0)
            <div class="section-title">🏢 Despesas por Filial</div>
            <table>
                <thead>
                    <tr>
                        <th>Filial</th>
                        <th class="text-right">Valor Total</th>
                        <th class="text-center">Transações</th>
                        <th class="text-center">Pagas</th>
                        <th class="text-center">Pendentes</th>
                        <th class="text-right">% do Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['despesas_por_filial'] as $filial)
                        <tr>
                            <td><strong>{{ $filial['filial'] }}</strong></td>
                            <td class="text-right"><strong>R$ {{ number_format($filial['valor'], 2, ',', '.') }}</strong></td>
                            <td class="text-center">{{ $filial['transacoes'] }}</td>
                            <td class="text-center"><span class="badge badge-pago">{{ $filial['pagas'] }}</span></td>
                            <td class="text-center"><span class="badge badge-pendente">{{ $filial['pendentes'] }}</span></td>
                            <td class="text-right">{{ $data['total_despesas'] > 0 ? number_format(($filial['valor'] / $data['total_despesas']) * 100, 1) : 0 }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="grid-2">
            @if(isset($data['despesas_por_forma_pagamento']) && $data['despesas_por_forma_pagamento']->count() > 0)
                <div class="card">
                    <div class="card-title">💳 Por Forma de Pagamento</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Forma</th>
                                <th class="text-right">Valor</th>
                                <th class="text-center">Qtd</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['despesas_por_forma_pagamento'] as $forma)
                                <tr>
                                    <td>{{ $forma['forma_pagamento'] }}</td>
                                    <td class="text-right">R$ {{ number_format($forma['valor'], 2, ',', '.') }}</td>
                                    <td class="text-center">{{ $forma['transacoes'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(isset($data['despesas_por_dia']) && $data['despesas_por_dia']->count() > 0)
                <div class="card">
                    <div class="card-title">📅 Por Dia</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th class="text-right">Valor</th>
                                <th class="text-center">Qtd</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['despesas_por_dia']->take(10) as $dia)
                                <tr>
                                    <td>{{ $dia['data'] }}</td>
                                    <td class="text-right">R$ {{ number_format($dia['valor'], 2, ',', '.') }}</td>
                                    <td class="text-center">{{ $dia['transacoes'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="page-break"></div>

        <div class="section-title">📝 Detalhamento Completo das Despesas</div>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Filial</th>
                    <th>Forma Pgto</th>
                    <th class="text-right">Valor</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['movimentacoes'] as $movimentacao)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($movimentacao->data_pagamento)->format('d/m/Y') }}</td>
                        <td><strong>{{ $movimentacao->descricao }}</strong></td>
                        <td>{{ $movimentacao->categoriaFinanceira->nome ?? 'Sem categoria' }}</td>
                        <td>{{ $movimentacao->filial->nome ?? '-' }}</td>
                        <td>{{ $movimentacao->formaPagamento->nome ?? '-' }}</td>
                        <td class="text-right"><strong>R$ {{ number_format($movimentacao->valor_pago ?? $movimentacao->valor, 2, ',', '.') }}</strong></td>
                        <td class="text-center">
                            @if($movimentacao->situacao === 'pago')
                                <span class="badge badge-pago">Pago</span>
                            @elseif($movimentacao->situacao === 'em_aberto')
                                <span class="badge badge-pendente">Pendente</span>
                            @else
                                <span class="badge badge-cancelado">Cancelado</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 30px; color: #6b7280;">
                            ℹ️ Nenhuma despesa encontrada para o período selecionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p><strong>BarberShop Pro</strong> - Sistema de Gestão | Relatório gerado em {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
