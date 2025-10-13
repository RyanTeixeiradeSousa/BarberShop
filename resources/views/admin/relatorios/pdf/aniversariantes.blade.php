<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Aniversariantes</title>
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
            border-bottom: 2px solid #ec4899;
        }
        
        .header h1 {
            color: #be185d;
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
            background: #fce7f3;
            border: 1px solid #ec4899;
        }
        
        .info-label {
            font-weight: bold;
            color: #be185d;
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
            border: 1px solid #ec4899;
            background: #fdf2f8;
        }
        
        .summary-card h3 {
            color: #be185d;
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
            color: #be185d;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ec4899;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #ec4899;
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
            background: #fdf2f8;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .birthday-highlight {
            background: #fef3c7;
            padding: 2px 4px;
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
        <h1>Relatório de Aniversariantes</h1>
        <div class="subtitle">
            Mês: {{ $parametros['mes_nome'] ?? 'N/A' }} de {{ $parametros['ano'] ?? date('Y') }}
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
            <div class="info-label">Mês/Ano:</div>
            <div class="info-value">{{ $parametros['mes'] ?? date('m') }}/{{ $parametros['ano'] ?? date('Y') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Aniversariantes:</div>
            <div class="info-value">{{ $dados['total_aniversariantes'] ?? 0 }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Com Contato:</div>
            <div class="info-value">{{ $dados['com_contato'] ?? 0 }}</div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>Aniversariantes</h3>
            <div class="value">{{ $dados['total_aniversariantes'] ?? 0 }}</div>
            <div class="label">No mês</div>
        </div>
        <div class="summary-card">
            <h3>Com Telefone</h3>
            <div class="value">{{ $dados['com_telefone'] ?? 0 }}</div>
            <div class="label">Para contato</div>
        </div>
        <div class="summary-card">
            <h3>Com E-mail</h3>
            <div class="value">{{ $dados['com_email'] ?? 0 }}</div>
            <div class="label">Para campanhas</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-title">Lista de Aniversariantes</div>
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    @if($parametros['incluir_telefone'] ?? true)
                    <th>Telefone</th>
                    @endif
                    @if($parametros['incluir_email'] ?? true)
                    <th>E-mail</th>
                    @endif
                    @if($parametros['incluir_ultima_visita'] ?? false)
                    <th>Última Visita</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($dados['lista_aniversariantes'] ?? [] as $cliente)
                <tr>
                    <td>
                        <span class="birthday-highlight">{{ $cliente['dia'] }}</span>
                    </td>
                    <td>{{ $cliente['nome'] }}</td>
                    <td class="text-center">{{ $cliente['idade'] ?? '-' }} anos</td>
                    @if($parametros['incluir_telefone'] ?? true)
                    <td>{{ $cliente['telefone'] ?? '-' }}</td>
                    @endif
                    @if($parametros['incluir_email'] ?? true)
                    <td>{{ $cliente['email'] ?? '-' }}</td>
                    @endif
                    @if($parametros['incluir_ultima_visita'] ?? false)
                    <td>{{ $cliente['ultima_visita'] ?? 'Nunca' }}</td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ 3 + ($parametros['incluir_telefone'] ? 1 : 0) + ($parametros['incluir_email'] ? 1 : 0) + ($parametros['incluir_ultima_visita'] ? 1 : 0) }}" class="text-center">
                        Nenhum aniversariante encontrado para este mês
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($dados['aniversariantes_por_dia']))
    <div class="table-container">
        <div class="table-title">Distribuição por Dia do Mês</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">Dia</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Percentual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados['aniversariantes_por_dia'] as $dia => $quantidade)
                <tr>
                    <td class="text-center">{{ $dia }}</td>
                    <td class="text-right">{{ $quantidade }}</td>
                    <td class="text-right">{{ number_format(($quantidade / $dados['total_aniversariantes']) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        BarberShop Pro - Relatório de Aniversariantes - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
