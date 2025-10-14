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
        
        /* Ajustando margens do body e trocando rosa por azul */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #1f2937;
            background: #ffffff;
            padding: 20px 30px;
        }
        
        .header {
            background: #3b82f6;
            color: white;
            padding: 30px 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
            border-bottom: 5px solid #1d4ed8;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .header .subtitle {
            font-size: 14px;
            opacity: 0.95;
            margin-top: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 10px;
        }
        
        .info-item {
            display: table-cell;
            width: 25%;
            padding: 15px;
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            border-radius: 6px;
        }
        
        .info-label {
            font-weight: 600;
            color: #1d4ed8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 14px;
            font-weight: bold;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 15px;
        }
        
        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            text-align: center;
            background: #eff6ff;
            border-radius: 8px;
            border: 2px solid #3b82f6;
        }
        
        .summary-card .icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .summary-card h3 {
            color: #1d4ed8;
            font-size: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .summary-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #1d4ed8;
            margin-bottom: 5px;
        }
        
        .summary-card .label {
            color: #6b7280;
            font-size: 11px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1d4ed8;
            margin: 30px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 3px solid #3b82f6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Corrigindo th para usar cor sólida ao invés de gradiente */
        th {
            background: #3b82f6;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
            color: #374151;
        }
        
        tr:nth-child(even) {
            background: #eff6ff;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Corrigindo badges para usar cores sólidas */
        .birthday-badge {
            background: #fbbf24;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }
        
        .age-badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 3px 8px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 10px;
        }
        
        .gender-badge {
            padding: 3px 8px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 10px;
        }
        
        .gender-m {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .gender-f {
            background: #fce7f3;
            color: #be185d;
        }
        
        .contact-info {
            font-size: 10px;
            color: #6b7280;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 2px solid #f3f4f6;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-style: italic;
        }
        
        /* Corrigindo barra de progresso para usar cor sólida */
        .progress-bar {
            background: #dbeafe;
            height: 20px;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            background: #3b82f6;
            height: 100%;
        }
    </style>
</head>
<body>
    <!-- Atualizando header para usar dados corretos do controller -->
    <div class="header">
        <h1>🎂 Relatório de Aniversariantes</h1>
        <div class="subtitle">
            Mês: {{ $data['mes_nome'] }} {{ isset($data['sexo']) ? '- ' . ($data['sexo'] == 'M' ? 'Masculino' : 'Feminino') : '' }}
        </div>
        <div class="subtitle">
            Gerado em: {{ date('d/m/Y H:i:s') }}
        </div>
    </div>

    <!-- Atualizando info-grid para usar dados corretos -->
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Mês</div>
            <div class="info-value">{{ $data['mes_nome'] }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total</div>
            <div class="info-value">{{ $data['total_aniversariantes'] }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Masculino</div>
            <div class="info-value">{{ $data['masculino'] }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Feminino</div>
            <div class="info-value">{{ $data['feminino'] }}</div>
        </div>
    </div>

    <!-- Atualizando summary cards com dados corretos -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="icon">🎉</div>
            <h3>Total</h3>
            <div class="value">{{ $data['total_aniversariantes'] }}</div>
            <div class="label">Aniversariantes</div>
        </div>
        <div class="summary-card">
            <div class="icon">👨</div>
            <h3>Masculino</h3>
            <div class="value">{{ $data['masculino'] }}</div>
            <div class="label">{{ $data['total_aniversariantes'] > 0 ? number_format(($data['masculino'] / $data['total_aniversariantes']) * 100, 1) : 0 }}%</div>
        </div>
        <div class="summary-card">
            <div class="icon">👩</div>
            <h3>Feminino</h3>
            <div class="value">{{ $data['feminino'] }}</div>
            <div class="label">{{ $data['total_aniversariantes'] > 0 ? number_format(($data['feminino'] / $data['total_aniversariantes']) * 100, 1) : 0 }}%</div>
        </div>
    </div>

    <!-- Atualizando tabela para usar dados corretos do controller -->
    <div class="section-title">📋 Lista de Aniversariantes</div>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Dia</th>
                <th style="width: 30%;">Nome</th>
                <th style="width: 10%;" class="text-center">Idade</th>
                <th style="width: 10%;" class="text-center">Sexo</th>
                <th style="width: 20%;">Telefone</th>
                <th style="width: 20%;">E-mail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['aniversariantes'] as $cliente)
            <tr>
                <td class="text-center">
                    <span class="birthday-badge">{{ $cliente->dia_aniversario }}</span>
                </td>
                <td><strong>{{ $cliente->nome }}</strong></td>
                <td class="text-center">
                    <span class="age-badge">{{ $cliente->idade }} anos</span>
                </td>
                <td class="text-center">
                    <span class="gender-badge {{ $cliente->sexo == 'M' ? 'gender-m' : 'gender-f' }}">
                        {{ $cliente->sexo == 'M' ? 'M' : 'F' }}
                    </span>
                </td>
                <td class="contact-info">{{ $cliente->telefone ?? '-' }}</td>
                <td class="contact-info">{{ $cliente->email ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-data">
                    Nenhum aniversariante encontrado para este mês
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Adicionando seção de distribuição por dia -->
    @if($data['aniversariantes']->count() > 0)
    <div class="section-title">📊 Distribuição por Dia do Mês</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">Dia</th>
                <th class="text-right">Quantidade</th>
                <th class="text-right">Percentual</th>
                <th style="width: 50%;">Gráfico</th>
            </tr>
        </thead>
        <tbody>
            @php
                $aniversariantesPorDia = $data['aniversariantes']->groupBy('dia_aniversario')->map(function($group) {
                    return $group->count();
                })->sortKeys();
            @endphp
            @foreach($aniversariantesPorDia as $dia => $quantidade)
            <tr>
                <td class="text-center"><strong>{{ $dia }}</strong></td>
                <td class="text-right">{{ $quantidade }}</td>
                <td class="text-right">{{ number_format(($quantidade / $data['total_aniversariantes']) * 100, 1) }}%</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ ($quantidade / $data['total_aniversariantes']) * 100 }}%;"></div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        BarberShop - Relatório de Aniversariantes - Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
