<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Taxa de Ocupação</title>
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
            border-bottom: 2px solid #a855f7;
        }
        
        .header h1 {
            color: #7c3aed;
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
            background: #f3e8ff;
            border: 1px solid #a855f7;
        }
        
        .info-label {
            font-weight: bold;
            color: #7c3aed;
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
            border: 1px solid #a855f7;
            background: #faf5ff;
        }
        
        .summary-card h3 {
            color: #7c3aed;
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
            color: #7c3aed;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #a855f7;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #a855f7;
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
            background: #faf5ff;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .ocupacao-alta {
            background: #d1fae5;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .ocupacao-media {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .ocupacao-baixa {
            background: #fee2e2;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 3px;
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
        <h1>Relatório de Taxa de Ocupação</h1>
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
            <div class="info-label">Período do Dia:</div>
            <div class="info-value">{{ $parametros['periodo_nome'] ?? 'Todo o dia' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Dias da Semana:</div>
            <div class="info-value">{{ $parametros['dias_semana'] ?? 'Todos os dias' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total de Horários:</div>
            <div class="info-value">{{ $dados['total_horarios'] ?? 0 }}</div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>Taxa Média</h3>
            <div class="value">{{ number_format($dados['taxa_ocupacao_media'] ?? 0, 1) }}%</div>
            <div class="label">De ocupação</div>
        </div>
        <div class="summary-card">
            <h3>Horários Ocupados</h3>
            <div class="value">{{ $dados['horarios_ocupados'] ?? 0 }}</div>
            <div class="label">Total agendado</div>
        </div>
        <div class="summary-card">
            <h3>Horários Livres</h3>
            <div class="value">{{ $dados['horarios_livres'] ?? 0 }}</div>
            <div class="label">Disponíveis</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-title">Taxa de Ocupação por Barbeiro</div>
        <table>
            <thead>
                <tr>
                    <th>Barbeiro</th>
                    <th class="text-right">Horários Disponíveis</th>
                    <th class="text-right">Horários Ocupados</th>
                    <th class="text-right">Taxa de Ocupação</th>
                    <th class="text-center">Classificação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['ocupacao_por_barbeiro'] ?? [] as $barbeiro)
                <tr>
                    <td>{{ $barbeiro['nome'] }}</td>
                    <td class="text-right">{{ $barbeiro['horarios_disponiveis'] }}</td>
                    <td class="text-right">{{ $barbeiro['horarios_ocupados'] }}</td>
                    <td class="text-right">{{ number_format($barbeiro['taxa_ocupacao'], 1) }}%</td>
                    <td class="text-center">
                        @if($barbeiro['taxa_ocupacao'] >= 80)
                            <span class="ocupacao-alta">Alta</span>
                        @elseif($barbeiro['taxa_ocupacao'] >= 50)
                            <span class="ocupacao-media">Média</span>
                        @else
                            <span class="ocupacao-baixa">Baixa</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum dado encontrado para o período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($dados['ocupacao_por_periodo']))
    <div class="table-container">
        <div class="table-title">Taxa de Ocupação por Período do Dia</div>
        <table>
            <thead>
                <tr>
                    <th>Período</th>
                    <th>Horário</th>
                    <th class="text-right">Horários Disponíveis</th>
                    <th class="text-right">Horários Ocupados</th>
                    <th class="text-right">Taxa de Ocupação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados['ocupacao_por_periodo'] as $periodo)
                <tr>
                    <td>{{ $periodo['nome'] }}</td>
                    <td>{{ $periodo['horario'] }}</td>
                    <td class="text-right">{{ $periodo['horarios_disponiveis'] }}</td>
                    <td class="text-right">{{ $periodo['horarios_ocupados'] }}</td>
                    <td class="text-right">{{ number_format($periodo['taxa_ocupacao'], 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($dados['ocupacao_por_dia_semana']))
    <div class="table-container">
        <div class="table-title">Taxa de Ocupação por Dia da Semana</div>
        <table>
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th class="text-right">Horários Disponíveis</th>
                    <th class="text-right">Horários Ocupados</th>
                    <th class="text-right">Taxa de Ocupação</th>
                    <th class="text-center">Classificação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados['ocupacao_por_dia_semana'] as $dia)
                <tr>
                    <td>{{ $dia['nome'] }}</td>
                    <td class="text-right">{{ $dia['horarios_disponiveis'] }}</td>
                    <td class="text-right">{{ $dia['horarios_ocupados'] }}</td>
                    <td class="text-right">{{ number_format($dia['taxa_ocupacao'], 1) }}%</td>
                    <td class="text-center">
                        @if($dia['taxa_ocupacao'] >= 80)
                            <span class="ocupacao-alta">Alta</span>
                        @elseif($dia['taxa_ocupacao'] >= 50)
                            <span class="ocupacao-media">Média</span>
                        @else
                            <span class="ocupacao-baixa">Baixa</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        BarberShop Pro - Relatório de Taxa de Ocupação - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
