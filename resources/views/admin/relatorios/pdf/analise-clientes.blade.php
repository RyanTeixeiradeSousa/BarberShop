<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Clientes</title>
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
            line-height: 1.4;
            padding: 20px 30px;
        }
        
        .header {
            background: #10b981;
            color: white;
            padding: 20px;
            margin: -20px -30px 20px -30px;
            border-bottom: 4px solid #059669;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            opacity: 0.95;
        }
        
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .summary-card {
            display: table-cell;
            width: 25%;
            padding: 15px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .summary-card:not(:last-child) {
            border-right: none;
        }
        
        .summary-card .icon {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .summary-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 4px;
        }
        
        .summary-card .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #10b981;
        }
        
        .grid-2 {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .grid-2 > div {
            display: table-cell;
            width: 50%;
            padding-right: 10px;
        }
        
        .grid-2 > div:last-child {
            padding-right: 0;
            padding-left: 10px;
        }
        
        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #10b981;
            padding: 12px;
            margin-bottom: 10px;
        }
        
        .info-box h3 {
            font-size: 11px;
            color: #059669;
            margin-bottom: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table thead {
            background: #10b981;
            color: white;
        }
        
        table th {
            padding: 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        table tbody tr:hover {
            background: #f0fdf4;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .chart-bar {
            background: #e5e7eb;
            height: 24px;
            border-radius: 6px;
            overflow: hidden;
            margin: 5px 0 3px 0;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .chart-bar-fill {
            background-color: #10b981;
            height: 100%;
            border-radius: 6px;
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
        }
        
        /* Adicionado estilo para porcentagem dentro da barra */
        .chart-bar-percentage {
            color: white;
            font-size: 9px;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .chart-info {
            font-size: 9px;
            color: #4b5563;
            margin-top: 3px;
            padding-left: 2px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .text-success {
            color: #10b981;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📊 Análise Geral de Clientes</h1>
        <p>Relatório gerado em {{ $data['data_geracao'] }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="icon">👥</div>
            <div class="value">{{ number_format($data['total_clientes'], 0, ',', '.') }}</div>
            <div class="label">Total de Clientes</div>
        </div>
        <div class="summary-card">
            <div class="icon">✅</div>
            <div class="value">{{ number_format($data['clientes_ativos'], 0, ',', '.') }}</div>
            <div class="label">Clientes Ativos</div>
        </div>
        <div class="summary-card">
            <div class="icon">💰</div>
            <div class="value">R$ {{ number_format($data['ticket_medio'], 2, ',', '.') }}</div>
            <div class="label">Ticket Médio</div>
        </div>
        <div class="summary-card">
            <div class="icon">📈</div>
            <div class="value">{{ $data['crescimento'][count($data['crescimento'])-1]['quantidade'] ?? 0 }}</div>
            <div class="label">Novos (Último Mês)</div>
        </div>
    </div>

    <!-- Distribuição por Gênero e Status -->
    <div class="grid-2">
        <div>
            <div class="info-box">
                <h3>Distribuição por Gênero</h3>
                <table>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-info">Masculino</span></td>
                            <td class="text-right font-bold">{{ number_format($data['clientes_masculinos'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ $data['total_clientes'] > 0 ? number_format(($data['clientes_masculinos'] / $data['total_clientes']) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">Feminino</span></td>
                            <td class="text-right font-bold">{{ number_format($data['clientes_femininos'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ $data['total_clientes'] > 0 ? number_format(($data['clientes_femininos'] / $data['total_clientes']) * 100, 1) : 0 }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <div class="info-box">
                <h3>Status dos Clientes</h3>
                <table>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-success">Ativos</span></td>
                            <td class="text-right font-bold">{{ number_format($data['clientes_ativos'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ $data['total_clientes'] > 0 ? number_format(($data['clientes_ativos'] / $data['total_clientes']) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td><span class="badge">Inativos</span></td>
                            <td class="text-right font-bold">{{ number_format($data['clientes_inativos'], 0, ',', '.') }}</td>
                            <td class="text-right">{{ $data['total_clientes'] > 0 ? number_format(($data['clientes_inativos'] / $data['total_clientes']) * 100, 1) : 0 }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Distribuição por Faixa Etária -->
    <div class="section">
        <h2 class="section-title">Distribuição por Faixa Etária</h2>
        @if(isset($data['faixas_etarias']) && count($data['faixas_etarias']) > 0)
            @foreach($data['faixas_etarias'] as $faixa)
                <div style="margin-bottom: 12px;">
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 100px; font-weight: bold;">{{ $faixa['faixa'] }}</div>
                        <div style="display: table-cell;">
                            <div class="chart-bar">
                                <div class="chart-bar-fill" style="width: {{ $faixa['percentual'] }}%; background-color: #10b981;">
                                    <span class="chart-bar-percentage">{{ number_format($faixa['percentual'], 1) }}%</span>
                                </div>
                            </div>
                            <div class="chart-info">
                                {{ number_format($faixa['quantidade'], 0, ',', '.') }} clientes - {{ number_format($faixa['percentual'], 1) }}% do total
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if(isset($data['clientes_sem_data_nascimento']) && $data['clientes_sem_data_nascimento'] > 0)
                <div style="margin-top: 15px; padding: 10px; background: #fef3c7; border-left: 4px solid #f59e0b;">
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 100px; font-weight: bold; color: #92400e;">Sem data</div>
                        <div style="display: table-cell;">
                            <div class="chart-bar">
                                <div class="chart-bar-fill" style="width: {{ $data['total_clientes'] > 0 ? ($data['clientes_sem_data_nascimento'] / $data['total_clientes']) * 100 : 0 }}%; background-color: #f59e0b;">
                                    <span class="chart-bar-percentage">{{ $data['total_clientes'] > 0 ? number_format(($data['clientes_sem_data_nascimento'] / $data['total_clientes']) * 100, 1) : 0 }}%</span>
                                </div>
                            </div>
                            <div class="chart-info" style="color: #92400e;">
                                {{ number_format($data['clientes_sem_data_nascimento'], 0, ',', '.') }} clientes sem data de nascimento cadastrada - {{ $data['total_clientes'] > 0 ? number_format(($data['clientes_sem_data_nascimento'] / $data['total_clientes']) * 100, 1) : 0 }}% do total
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado de faixa etária disponível</p>
        @endif
    </div>

    <!-- Top 10 Clientes Mais Frequentes -->
    <div class="section">
        <h2 class="section-title">Top 10 Clientes Mais Frequentes</h2>
        @if(isset($data['top_clientes']) && count($data['top_clientes']) > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th class="text-center">Agendamentos</th>
                        <th class="text-right">Valor Total</th>
                        <th>Último Agendamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['top_clientes'] as $index => $cliente)
                        <tr>
                            <td class="font-bold">{{ $index + 1 }}º</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->telefone1 }}</td>
                            <td class="text-center"><span class="badge badge-success">{{ $cliente->total_agendamentos }}</span></td>
                            <td class="text-right font-bold text-success">R$ {{ number_format($cliente->valor_total_gasto, 2, ',', '.') }}</td>
                            <td>{{ $cliente->ultimo_agendamento ? \Carbon\Carbon::parse($cliente->ultimo_agendamento)->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum cliente encontrado</p>
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Crescimento de Clientes (Últimos 6 Meses) -->
    <div class="section">
        <h2 class="section-title">Crescimento de Clientes (Últimos 6 Meses)</h2>
        @if(isset($data['crescimento']) && count($data['crescimento']) > 0)
            @foreach($data['crescimento'] as $mes)
                <div style="margin-bottom: 12px;">
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 80px; font-weight: bold;">{{ $mes['mes'] }}</div>
                        <div style="display: table-cell;">
                            <div class="chart-bar">
                                <div class="chart-bar-fill" style="width: {{ $mes['quantidade'] > 0 ? min(($mes['quantidade'] / max(array_column($data['crescimento'], 'quantidade'))) * 100, 100) : 0 }}%; background-color: #10b981;">
                                    <span class="chart-bar-percentage">{{ $mes['quantidade'] }}</span>
                                </div>
                            </div>
                            <div class="chart-info">
                                {{ $mes['quantidade'] }} {{ $mes['quantidade'] == 1 ? 'novo cliente cadastrado' : 'novos clientes cadastrados' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado de crescimento disponível</p>
        @endif
    </div>

    <!-- Distribuição por Filial -->
    <div class="section">
        <h2 class="section-title">Distribuição por Filial</h2>
        @if(isset($data['clientes_por_filial']) && count($data['clientes_por_filial']) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Filial</th>
                        <th class="text-center">Quantidade de Clientes</th>
                        <th class="text-center">Total de Agendamentos</th>
                        <th class="text-right">% do Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalClientesFiliais = $data['clientes_por_filial']->sum('total_clientes');
                    @endphp
                    @foreach($data['clientes_por_filial'] as $filial)
                        <tr>
                            <td class="font-bold">{{ $filial->filial_nome }}</td>
                            <td class="text-center"><span class="badge badge-info">{{ number_format($filial->total_clientes, 0, ',', '.') }} clientes</span></td>
                            <td class="text-center"><span class="badge badge-success">{{ number_format($filial->total_agendamentos, 0, ',', '.') }} agendamentos</span></td>
                            <td class="text-right font-bold">{{ $totalClientesFiliais > 0 ? number_format(($filial->total_clientes / $totalClientesFiliais) * 100, 1) : 0 }}%</td>
                        </tr>
                    @endforeach
                    <tr style="background: #f0fdf4; font-weight: bold;">
                        <td>TOTAL</td>
                        <td class="text-center">{{ number_format($totalClientesFiliais, 0, ',', '.') }} clientes</td>
                        <td class="text-center">{{ number_format($data['clientes_por_filial']->sum('total_agendamentos'), 0, ',', '.') }} agendamentos</td>
                        <td class="text-right">100%</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado de filial disponível</p>
        @endif
    </div>

    <!-- Serviços Mais Procurados -->
    <div class="section">
        <h2 class="section-title">Serviços Mais Procurados (Geral)</h2>
        @if(isset($data['servicos_preferidos']) && count($data['servicos_preferidos']) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th class="text-center">Clientes Únicos</th>
                        <th class="text-center">Total Utilizações</th>
                        <th class="text-right">Valor Médio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['servicos_preferidos'] as $servico)
                        <tr>
                            <td class="font-bold">{{ $servico->nome }}</td>
                            <td class="text-center"><span class="badge badge-success">{{ number_format($servico->clientes_unicos, 0, ',', '.') }}</span></td>
                            <td class="text-center">{{ number_format($servico->total_utilizacoes, 0, ',', '.') }}</td>
                            <td class="text-right text-success">R$ {{ number_format($servico->valor_medio, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum serviço encontrado</p>
        @endif
    </div>

    <!-- Serviços Mais Utilizados por Filial -->
    <div class="section page-break">
        <h2 class="section-title">Serviços Mais Utilizados por Filial (Top 5)</h2>
        @if(isset($data['servicos_por_filial']) && count($data['servicos_por_filial']) > 0)
            @foreach($data['servicos_por_filial'] as $filialNome => $servicos)
                <div style="margin-bottom: 20px; page-break-inside: avoid;">
                    <h3 style="font-size: 12px; color: #059669; margin-bottom: 10px; padding: 8px; background: #f0fdf4; border-left: 4px solid #10b981;">
                        📍 {{ $filialNome }}
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Serviço</th>
                                <th class="text-center">Clientes Únicos</th>
                                <th class="text-center">Total Utilizações</th>
                                <th class="text-right">Valor Médio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicos as $index => $servico)
                                <tr>
                                    <td class="font-bold">{{ $index + 1 }}º</td>
                                    <td>{{ $servico->servico_nome }}</td>
                                    <td class="text-center"><span class="badge badge-success">{{ number_format($servico->clientes_unicos, 0, ',', '.') }}</span></td>
                                    <td class="text-center">{{ number_format($servico->total_utilizacoes, 0, ',', '.') }}</td>
                                    <td class="text-right text-success">R$ {{ number_format($servico->valor_medio, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado de serviços por filial disponível</p>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Relatório de Análise de Clientes - Sistema BarberShop</p>
        <p>Gerado automaticamente em {{ $data['data_geracao'] }}</p>
    </div>
</body>
</html>
