<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Novos Clientes</title>
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
            width: 33.33%;
            padding: 8px;
            background: #dbeafe;
            border: 1px solid #3b82f6;
        }
        
        .info-label {
            font-weight: bold;
            color: #1e40af;
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
            border: 1px solid #3b82f6;
            background: #f0f9ff;
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
            border-bottom: 1px solid #3b82f6;
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
            background: #f0f9ff;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .status-ativo {
            background: #d1fae5;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-inativo {
            background: #fee2e2;
            color: #991b1b;
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
        <h1>Relatório de Novos Clientes</h1>
        <div class="subtitle">
            Período: {{ $parametros['data_inicial'] ?? 'N/A' }} a {{ $parametros['data_final'] ?? 'N/A' }}
        </div>
        <div class="subtitle">
            Gerado em: {{ date('d/m/Y H:i:s') }}
        </div>
    </div>

    <div class="info-section">
        <div class="info-item">
            <div class="info-label">Status:</div>
            <div class="info-value">{{ $parametros['status_nome'] ?? 'Todos os status' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total de Clientes:</div>
            <div class="info-value">{{ $dados['total_clientes'] ?? 0 }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Período (dias):</div>
            <div class="info-value">{{ $dados['total_dias'] ?? 0 }}</div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>Novos Clientes</h3>
            <div class="value">{{ $dados['total_novos_clientes'] ?? 0 }}</div>
            <div class="label">No período</div>
        </div>
        <div class="summary-card">
            <h3>Clientes Ativos</h3>
            <div class="value">{{ $dados['clientes_ativos'] ?? 0 }}</div>
            <div class="label">Com status ativo</div>
        </div>
        <div class="summary-card">
            <h3>Média Diária</h3>
            <div class="value">{{ number_format($dados['media_diaria'] ?? 0, 1) }}</div>
            <div class="label">Novos por dia</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-title">Lista de Novos Clientes</div>
        <table>
            <thead>
                <tr>
                    <th>Data Cadastro</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th class="text-center">Status</th>
                    <th>Primeira Visita</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['lista_clientes'] ?? [] as $cliente)
                <tr>
                    <td>{{ $cliente['data_cadastro'] }}</td>
                    <td>{{ $cliente['nome'] }}</td>
                    <td>{{ $cliente['telefone'] ?? '-' }}</td>
                    <td>{{ $cliente['email'] ?? '-' }}</td>
                    <td class="text-center">
                        <span class="status-{{ $cliente['status'] }}">
                            {{ ucfirst($cliente['status']) }}
                        </span>
                    </td>
                    <td>{{ $cliente['primeira_visita'] ?? 'Não agendou' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum cliente encontrado para o período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($dados['estatisticas_por_dia']))
    <div class="table-container">
        <div class="table-title">Cadastros por Dia</div>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Dia da Semana</th>
                    <th class="text-right">Novos Cadastros</th>
                    <th class="text-right">Primeira Visita</th>
                    <th class="text-right">Taxa Conversão</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados['estatisticas_por_dia'] as $dia)
                <tr>
                    <td>{{ $dia['data'] }}</td>
                    <td>{{ $dia['dia_semana'] }}</td>
                    <td class="text-right">{{ $dia['cadastros'] }}</td>
                    <td class="text-right">{{ $dia['primeira_visita'] }}</td>
                    <td class="text-right">{{ number_format($dia['taxa_conversao'], 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        BarberShop Pro - Relatório de Novos Clientes - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
