<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Comissões dos Barbeiros</title>
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
            border-bottom: 2px solid #f97316;
        }
        
        .header h1 {
            color: #ea580c;
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
            background: #fef3c7;
            border: 1px solid #f59e0b;
        }
        
        .info-label {
            font-weight: bold;
            color: #92400e;
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
            border: 1px solid #f59e0b;
            background: #fffbeb;
        }
        
        .summary-card h3 {
            color: #ea580c;
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
            color: #ea580c;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f59e0b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #f97316;
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
            background: #fffbeb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .status-pago {
            background: #d1fae5;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-pendente {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Comissões dos Barbeiros</h1>
        <div class="subtitle">
            Período: {{ $parametros['data_inicial'] ?? 'N/A' }} a {{ $parametros['data_final'] ?? 'N/A' }}
        </div>
        <div class="subtitle">
            Gerado em: {{ date('d/m/Y H:i:s') }}
        </div>
    </div>

    <div class="info-section">
        <div class="info-item">
            <div class="info-label">Barbeiro:</div>
            <div class="info-value">{{ $parametros['barbeiro_nome'] ?? 'Todos os barbeiros' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status:</div>
            <div class="info-value">{{ $parametros['status_nome'] ?? 'Todos os status' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total de Atendimentos:</div>
            <div class="info-value">{{ $dados['total_atendimentos'] ?? 0 }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Barbeiros Ativos:</div>
            <div class="info-value">{{ $dados['total_barbeiros'] ?? 0 }}</div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>Total de Comissões</h3>
            <div class="value">R$ {{ number_format($dados['total_comissoes'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">No período</div>
        </div>
        <div class="summary-card">
            <h3>Comissões Pagas</h3>
            <div class="value">R$ {{ number_format($dados['comissoes_pagas'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">Já quitadas</div>
        </div>
        <div class="summary-card">
            <h3>Comissões Pendentes</h3>
            <div class="value">R$ {{ number_format($dados['comissoes_pendentes'] ?? 0, 2, ',', '.') }}</div>
            <div class="label">A pagar</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-title">Comissões por Barbeiro</div>
        <table>
            <thead>
                <tr>
                    <th>Barbeiro</th>
                    <th class="text-right">Atendimentos</th>
                    <th class="text-right">Faturamento</th>
                    <th class="text-right">% Comissão</th>
                    <th class="text-right">Valor Comissão</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['comissoes_por_barbeiro'] ?? [] as $comissao)
                <tr>
                    <td>{{ $comissao['nome'] }}</td>
                    <td class="text-right">{{ $comissao['atendimentos'] }}</td>
                    <td class="text-right">R$ {{ number_format($comissao['faturamento'], 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($comissao['percentual_comissao'], 1) }}%</td>
                    <td class="text-right">R$ {{ number_format($comissao['valor_comissao'], 2, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status-{{ $comissao['status'] }}">
                            {{ ucfirst($comissao['status']) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum dado encontrado para o período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($dados['detalhamento_por_barbeiro']))
    <div class="page-break"></div>
    <div class="table-container">
        <div class="table-title">Detalhamento por Atendimento</div>
        @foreach($dados['detalhamento_por_barbeiro'] as $barbeiro => $atendimentos)
        <h4 style="color: #ea580c; margin: 20px 0 10px 0;">{{ $barbeiro }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Comissão</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atendimentos as $atendimento)
                <tr>
                    <td>{{ $atendimento['data'] }}</td>
                    <td>{{ $atendimento['cliente'] }}</td>
                    <td>{{ $atendimento['servico'] }}</td>
                    <td class="text-right">R$ {{ number_format($atendimento['valor'], 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($atendimento['comissao'], 2, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status-{{ $atendimento['status'] }}">
                            {{ ucfirst($atendimento['status']) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    </div>
    @endif

    <div class="footer">
        BarberShop Pro - Relatório de Comissões dos Barbeiros - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
