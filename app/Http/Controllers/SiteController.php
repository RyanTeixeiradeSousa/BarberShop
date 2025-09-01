<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteController extends Controller
{
    public function index()
    {
        $configuracoes = $this->getConfiguracoes();
        $servicos = Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'servico')
            ->get();

        return view('site.index', compact('configuracoes', 'servicos'));
    }

    public function agendamento()
    {
        $configuracoes = $this->getConfiguracoes();
        $servicos = Produto::where('ativo', true)
            ->where('site', true)
            ->where('tipo', 'servico')
            ->get();

        // Gerar horários disponíveis para os próximos 30 dias
        $horariosDisponiveis = $this->gerarHorariosDisponiveis();

        return view('site.agendamento', compact('configuracoes', 'servicos', 'horariosDisponiveis'));
    }

    public function salvarAgendamento(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'data_agendamento' => 'required|date',
            'hora_inicio' => 'required',
            'servicos' => 'required|array|min:1',
            'servicos.*' => 'exists:produtos,id'
        ]);

        // Criar ou encontrar cliente
        $cliente = Cliente::firstOrCreate(
            ['telefone' => $request->telefone],
            [
                'nome' => $request->nome,
                'email' => $request->email,
                'sexo' => 'masculino',
                'ativo' => true
            ]
        );

        // Calcular duração total dos serviços
        $servicos = Produto::whereIn('id', $request->servicos)->get();
        $duracaoTotal = $servicos->sum('duracao') ?: 60; // fallback para 60 minutos

        $horaFim = Carbon::parse($request->data_agendamento . ' ' . $request->hora_inicio)
            ->addMinutes($duracaoTotal)
            ->format('H:i');

        // Criar agendamento
        $agendamento = Agendamento::create([
            'cliente_id' => $cliente->id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim,
            'status' => 'agendado',
            'observacoes' => $request->observacoes,
            'ativo' => true
        ]);

        // Associar serviços
        foreach ($request->servicos as $servicoId) {
            $servico = $servicos->find($servicoId);
            $agendamento->produtos()->attach($servicoId, [
                'quantidade' => 1,
                'valor_unitario' => $servico->preco
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso!',
            'agendamento_id' => $agendamento->id
        ]);
    }

    private function getConfiguracoes()
    {
        return Configuracao::pluck('valor', 'chave')->toArray();
    }

    private function gerarHorariosDisponiveis()
    {
        $horarios = [];
        $hoje = Carbon::now();

        for ($i = 0; $i < 30; $i++) {
            $data = $hoje->copy()->addDays($i);
            
            // Pular domingos
            if ($data->dayOfWeek === 0) continue;

            $horariosData = [];
            $horaInicio = $data->dayOfWeek === 6 ? 8 : 8; // Sábado inicia às 8h
            $horaFim = $data->dayOfWeek === 6 ? 16 : 18; // Sábado até 16h

            for ($hora = $horaInicio; $hora < $horaFim; $hora++) {
                for ($minuto = 0; $minuto < 60; $minuto += 30) {
                    $horario = sprintf('%02d:%02d', $hora, $minuto);
                    
                    // Verificar se horário já passou (para hoje)
                    if ($i === 0 && $data->copy()->setTimeFromTimeString($horario)->isPast()) {
                        continue;
                    }

                    // Verificar se horário está disponível
                    $ocupado = Agendamento::where('data_agendamento', $data->format('Y-m-d'))
                        ->where('hora_inicio', $horario)
                        ->where('status', '!=', 'cancelado')
                        ->exists();

                    if (!$ocupado) {
                        $horariosData[] = $horario;
                    }
                }
            }

            if (!empty($horariosData)) {
                $horarios[$data->format('Y-m-d')] = [
                    'data' => $data->format('Y-m-d'),
                    'data_formatada' => $data->format('d/m/Y'),
                    'dia_semana' => $data->locale('pt_BR')->dayName,
                    'horarios' => $horariosData
                ];
            }
        }

        return $horarios;
    }
}
