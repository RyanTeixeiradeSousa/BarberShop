<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Barbeiro;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Filial;
use App\Models\FormaPagamento;
use App\Models\Fornecedor;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Exception;
class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with(['cliente', 'produtos', 'barbeiro', 'filial']);

        
        if ($request->filled('busca') && $request->status != 'atual') {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->whereHas('cliente', function($subQ) use ($busca) {
                    $subQ->where('nome', 'like', "%{$busca}%");
                })->orWhereHas('produtos', function($subQ) use ($busca) {
                    $subQ->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        if ($request->filled('status') && $request->status != 'atual') {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio') && $request->status != 'atual') {
            $query->where('data_agendamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim') && $request->status != 'atual') {
            $query->where('data_agendamento', '<=', $request->data_fim);
        }

        if($request->filled('status') && $request->status == 'atual'){
            $query->whereDate('data_agendamento', now()->toDateString()) // só hoje
                ->whereTime('hora_inicio', '<=', now()->toTimeString()) // hora atual depois do inicio
                ->whereTime('hora_fim', '>=', now()->toTimeString());  // hora atual antes do fim
        }

        $agendamentos = $query->orderBy('data_agendamento', 'desc')
                             ->orderBy('hora_inicio', 'asc')
                             ->paginate($request->get('per_page', 10));

        $total = Agendamento::count();
        $disponiveis = Agendamento::where('status', 'disponivel')->count();
        $agendados = Agendamento::where('status', 'agendado')->count();
        $concluidos = Agendamento::where('status', 'concluido')->count();
        $cancelados = Agendamento::where('status', 'cancelado')->count();

        $clientes = Cliente::where('ativo', true)->get();
        $produtos = Produto::where('ativo', true)->where('tipo', 'servico')->get();
        $formasPagamento = FormaPagamento::where('ativo', 1)->get();
        $filialSelect = (new Filial())->getFilials();
        $barbeiros = Barbeiro::where('ativo', true)->get();

        return view('admin.agendamentos.index', compact(
            'agendamentos', 'total', 'disponiveis', 'agendados', 'concluidos', 'cancelados', 'clientes', 'produtos', 'formasPagamento',
            'filialSelect', 'barbeiros'
        ));
    }

    public function criarSlot(Request $request)
    {
        $request->validate([
            'data_agendamento' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
        ]);
    
        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento = Agendamento::create([
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'status' => 'disponivel',
            'user_created' => Auth::user()->id
        ]);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Slot criado com sucesso!');
    }

    public function associarSlot(Request $request, Agendamento $id)
    {
        try{
            $agendamento = $id;
            $validator = Validator::make($request->all(), [
                'barbeiro_id' => 'required|exists:barbeiros,id',
                'cliente_id' => 'required|exists:clientes,id',
                'servicos' => 'required|array|min:1',
                'servicos.*.produto_id' => 'required|exists:produtos,id',
                'servicos.*.quantidade' => 'required|integer|min:1',
                'observacoes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Erro ao tentar associar cliente a slot.' . $validator->errors()->first()]);

            }
    
            // Verificar se o slot está disponível
            if ($agendamento->status !== 'disponivel') {
                return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Este slot não está mais disponível!']);
            }

            $barbeiro = db::table('barbeiro_filial')
                ->where('filial_id', $agendamento->filial_id)
                ->where('barbeiro_id', $request->barbeiro_id)->first();
            
            if(!$barbeiro){
                throw new Exception("Barbeiro não está mais associado a filial.");
            }
            $agendamento->update([
                'barbeiro_id' => $request->barbeiro_id,
                'cliente_id' => $request->cliente_id,
                'status' => 'agendado',
                'observacoes' => $request->observacoes
            ]);
    
            $servicos = [];
            foreach ($request->servicos as $servico) {
                $produto = Produto::find($servico['produto_id']);
                $servicos[$servico['produto_id']] = [
                    'quantidade' => $servico['quantidade'],
                    'valor_unitario' => $produto->preco ?? 0
                ];
            }
            
            $agendamento->produtos()->sync($servicos);
            return redirect()->to(url()->previous())->with(['type' => 'success', 'message' => 'Cliente associado ao slot.']);

        } catch(Exception $e){
            return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' => 'Erro ao tentar associar cliente ou barbeiro a slot. ' . $e->getMessage()]);
        }

        
    }

    public function store(Request $request)
    {
        $request->validate([
            'filial_id' =>  'required|exists:filiais,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'servicos' => 'nullable|array',
            'servicos.*.produto_id' => 'required_with:servicos|exists:produtos,id',
            'servicos.*.quantidade' => 'required_with:servicos|integer|min:1',
            'data_agendamento' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento = Agendamento::create([
            'filial_id' => $request->filial_id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'observacoes' => $request->observacoes,
            'status' => 'disponivel',
            'user_created' => Auth::user()->id
        ]);

        // Se tem cliente e serviços, associar
        if ($request->filled('cliente_id') && $request->filled('servicos')) {
            $agendamento->associarClienteServicos(
                $request->cliente_id,
                $request->servicos,
                $request->observacoes
            );
        }

        return redirect()->route('agendamentos.index')
            ->with(['type' => 'success', 'message' => 'Agendamento criado com sucesso!']);
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servicos' => 'required|array|min:1',
            'servicos.*.produto_id' => 'required|exists:produtos,id',
            'servicos.*.quantidade' => 'required|integer|min:1',
            'data_agendamento' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'status' => 'required|in:agendado,confirmado,em_andamento,concluido,cancelado',
            'observacoes' => 'nullable|string|max:1000'
        ]);

        // Recalcular hora fim se necessário
        $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFim = $horaInicio->copy()->addMinutes($duracaoPadrao);

        $agendamento->update([
            'cliente_id' => $request->cliente_id,
            'data_agendamento' => $request->data_agendamento,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $horaFim->format('H:i'),
            'status' => $request->status,
            'observacoes' => $request->observacoes
        ]);

        // Atualizar serviços
        $agendamento->associarClienteServicos(
            $request->cliente_id,
            $request->servicos,
            $request->observacoes
        );

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento)
    {
        try{
            $agendamento->delete();
            return redirect()->route('agendamentos.index')->with(['type' => 'success', 'message' =>  'Agendamento excluído com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('agendamentos.index')->with(['type' => 'error', 'message' =>  'Erro ao excluir o agendamento. ' . $e->getMessage()]);
        }

    }

    public function gerarEmLote(Request $request)
    {
        try {
            $request->validate([
                'filial_id' =>  'required|exists:filiais,id',
                'data_inicio' => 'required|date|after_or_equal:today',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
                'dias' => 'required|array|min:1',
                'dias.*' => 'in:0,1,2,3,4,5,6', // 0=domingo, 1=segunda, etc.
                'intervalo_minutos' => 'nullable|integer|min:30|max:480'
            ]);
            

            $duracaoPadrao = Configuracao::get('duracao_servico_padrao', 60);
            $intervalo = $request->intervalo_minutos ?? $duracaoPadrao;

            $dataAtual = Carbon::parse($request->data_inicio);
            $dataFim = Carbon::parse($request->data_fim);
            $slotsGerados = 0;

            if ($dataAtual->diffInYears($dataFim) > 3) {
                return redirect()->route('agendamentos.index')
                ->with(['type' => 'error','message' => "Erro ao tentar gerar lote de agendamentos. O intervalo entre as datas não pode ser superior a 3 anos."]);
            }

            while ($dataAtual->lte($dataFim)) {
                if (in_array($dataAtual->dayOfWeek, $request->dias)) {
                    
                    $horaAtual = Carbon::createFromFormat('H:i', $request->hora_inicio);
                    $horaFimDia = Carbon::createFromFormat('H:i', $request->hora_fim);

                    while ($horaAtual->lt($horaFimDia)) {
                        $horaFimSlot = $horaAtual->copy()->addMinutes($duracaoPadrao);

                        // Verificar se já existe agendamento neste horário
                        // $existeAgendamento = Agendamento::where('data_agendamento', $dataAtual->format('Y-m-d'))
                        //     ->where('hora_inicio', $horaAtual->format('H:i'))
                        //     ->exists();

                        // if (!$existeAgendamento) {
                            Agendamento::create([
                                'filial_id' => $request->filial_id,
                                'data_agendamento' => $dataAtual->format('Y-m-d'),
                                'hora_inicio' => $horaAtual->format('H:i'),
                                'hora_fim' => $horaFimSlot->format('H:i'),
                                'status' => 'disponivel',
                                'user_created' => Auth::user()->id
                            ]);

                            $slotsGerados++;
                        // }

                        $horaAtual->addMinutes($intervalo);
                    }
                }

                $dataAtual->addDay();
            }

            return redirect()->route('agendamentos.index')
                ->with(['type' => 'success','message' => "Gerados {$slotsGerados} slots de agendamento com sucesso!"]);

        } catch(Exception $e) {
            return redirect()->route('agendamentos.index')
                ->with(['type' => 'error','message' => "Erro ao tentar gerar lote de agendamentos. " . $e->getMessage()]);
        }

    }

    public function show(Agendamento $agendamento)
    {
       
        $agendamento->load(['cliente', 'produtos', 'barbeiro', 'filial']);
        
        // Calcular valor total dos serviços
        $valorTotal = $agendamento->produtos->sum(function($produto) {
            return $produto->pivot->quantidade * $produto->pivot->valor_unitario;
        });

        // Definir cor e label do status
        $statusColors = [
            'disponivel' => 'secondary',
            'agendado' => 'primary',
            'em_andamento' => 'warning',
            'concluido' => 'success',
            'cancelado' => 'danger'
        ];

        $statusLabels = [
            'disponivel' => 'Disponível',
            'agendado' => 'Agendado',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado'
        ];

        return response()->json([
            'id' => $agendamento->id,
            'cliente' => $agendamento->cliente,
            'produtos' => $agendamento->produtos,
            'data_agendamento' => $agendamento->data_agendamento,
            'hora_inicio' => $agendamento->hora_inicio,
            'hora_fim' => $agendamento->hora_fim,
            'status' => $agendamento->status,
            'status_color' => $statusColors[$agendamento->status] ?? 'secondary',
            'status_label' => $statusLabels[$agendamento->status] ?? 'Desconhecido',
            'observacoes' => $agendamento->observacoes,
            'valor_total' => $valorTotal,
            'barbeiro' => $agendamento->barbeiro ?? '',
            'filial' => $agendamento->filial ?? '',
        ]);
    }

    public function cancelarAtendimento(Agendamento $agendamento)
    {
        if ($agendamento->status !== 'agendado') {
            return response()->json([
                'success' => false,
                'message' => 'Apenas agendamentos com status "agendado" podem ser cancelados.'
            ]);
        }

        // Desassociar cliente e serviços
        $agendamento->update([
            'barbeiro_id' => null,
            'cliente_id' => null,
            'status' => 'disponivel',
            'observacoes' => null
        ]);

        // Remover serviços associados
        $agendamento->produtos()->detach();

        return response()->json([
            'success' => true,
            'message' => 'Atendimento cancelado com sucesso!'
        ]);
    }

    public function iniciarAtendimento(Agendamento $agendamento)
    {
        if($agendamento->barbeiro_id == null || $agendamento->cliente_id == null){
            return response()->json([
                'success' => false,
                'message' => 'Não é possível iniciar o atendimento. Barbeiro ou cliente não estão associados.'
            ]);
        }

        if ($agendamento->status === 'agendado') {
             $agendamento->update([
                'status' => 'em_andamento',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Atendimento iniciado!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Atendimento precisa estar agendado.'
        ]); 
    }

    public function mudarStatus(Agendamento $agendamento)
    {
        if ($agendamento->status === 'agendado') {
            $agendamento->update(['status' => 'em_andamento']);
            
            return response()->json([
                'success' => true,
                'message' => 'Atendimento iniciado com sucesso!',
                'novo_status' => 'em_andamento'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Status não pode ser alterado.'
        ]);
    }

    public function finalizarAtendimento(Request $request, Agendamento $agendamento)
    {

        $validator = Validator::make($request->all(), [
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'valor_pago_decimal' => 'required|numeric|min:0',
            'desconto_decimal' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('agendamentos.index')->with([
                'type' => 'error',
                'message' => 'Campos inválidos na requisição',
                'errors' => $validator->errors()
            ]);
        }

        if ($agendamento->status !== 'em_andamento') {
            return redirect()->route('agendamentos.index')->with([
                'type' => 'error',
                'message' => 'Apenas atendimentos em andamento podem ser finalizados.'
            ]);
        }

        $idFornecedor = Fornecedor::where('cpf_cnpj', $agendamento->barbeiro->cpf)->value('id');

        if(!$idFornecedor){
            return redirect()->route('agendamentos.index')->with([
                'type' => 'error',
                'message' => 'Erro ao finalizar atendimento. Fornecedor do barbeiro não encontrado.'
            ]);
        }
        // Atualizar status do agendamento
        $agendamento->update(['status' => 'concluido']);

        // Criar movimentação financeira
        $movimentacao = \App\Models\MovimentacaoFinanceira::create([
            'tipo' => 'entrada',
            'descricao' => 'Atendimento - ' . $agendamento->cliente->nome,
            'valor' => $request->valor_pago_decimal,
            'data' => now()->format('Y-m-d'),
            'data_vencimento' => now()->format('Y-m-d'),
            'cliente_id' => $agendamento->cliente_id,
            'filial_id' => $agendamento->filial_id,
            'agendamento_id' => $agendamento->id,
            'situacao' => 'pago',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'data_pagamento' => now()->format('Y-m-d'),
            'desconto' => $request->desconto_decimal ?? 0,
            'valor_pago' => $request->valor_pago_decimal,
            'ativo' => true
        ]);
        
        $valorComissao = 0;
        $valorProdutosDoMovimentoParaComissao = (float) 0.00;
        $comissaoPorServico = [];
        $comissao = false;
        $observacaoComissao = "Comissão referente ao atendimento. \nBarbeiro: " . $agendamento->barbeiro->nome . " - Cliente: " . $agendamento->cliente->nome . "\n";
        // Associar produtos à movimentação financeira
        $produtos = [];
        foreach ($agendamento->produtos as $produto) {

            if($produto->tipo == 'servico'){
                $valorProdutosDoMovimentoParaComissao += ($produto->pivot->quantidade * $produto->pivot->valor_unitario);
                $comissaoServico = DB::table('barbeiro_servico_comissoes')
                ->where(
                    'barbeiro_id', $agendamento->barbeiro_id
                )->where(
                    'filial_id', $agendamento->filial_id
                )->where(
                    'produto_id', $produto->id
                )->where(
                    'valor_comissao', '!=',0
                )->select('tipo_comissao', 'valor_comissao')->first();

                if($comissaoServico){
                    array_push($comissaoPorServico, [
                         'produto_id' => $produto->id,
                         'produto_preco' => $produto->preco,
                         'quantidade' => $produto->pivot->quantidade,
                         'tipo_comissao' => $comissaoServico->tipo_comissao ?? 'percentual',
                         'valor_comissao' => $comissaoServico->valor_comissao ?? 0
                    ]);
                }
            }

            Produto::find($produto->id)->atualizarEstoque($agendamento->filial_id,$produto->pivot->quantidade, 'diminuir');
            $produtos[$produto->id] = [
                'quantidade' => $produto->pivot->quantidade,
                'valor_unitario' => $produto->pivot->valor_unitario
            ];
        }
        
        

        // Busca se tem comissão na filial porque não tem serviço específico // No Else é com base no serviço
        if(count($comissaoPorServico) <= 0){ 
            
            $comissaoFilial = DB::table('barbeiro_comissoes')
                ->where('barbeiro_id', $agendamento->barbeiro_id)
                ->where('filial_id', $agendamento->filial_id)
                ->where('valor_comissao_filial', '!=', 0)
                ->select('tipo_comissao_filial as tipo_comissao', 'valor_comissao_filial as valor_comissao')
                ->first();

                
                if($comissaoFilial){
                    $comissao = true;
                } 

                // Calcular valor da comissão se for percentual; No else é fixo
                if($comissaoFilial && $comissaoFilial->tipo_comissao == 'percentual'){
                    $valorComissao = floor(
                        (
                            (
                                ($valorProdutosDoMovimentoParaComissao)
                                * ($comissaoFilial->valor_comissao / 100)
                            )
                        ) * 100) / 100;   
                } 
                if($comissaoFilial && $comissaoFilial->tipo_comissao == 'valor_fixo'){
                    $valorComissao = $comissaoFilial->valor_comissao ?? 0;
                } 

                $observacaoComissao .= "Comissão fixa da filial. \n Tipo: " . ($comissaoFilial->tipo_comissao ?? 'percentual') . " - Valor: " . ($comissaoFilial->valor_comissao ?? 0) . "\n";
                
        } else if(count($comissaoPorServico) > 0){
                $valorComissao = 0;
                foreach($comissaoPorServico as $comissaoServico){
                    if($comissaoServico['tipo_comissao'] == 'percentual'){
                        $valorComissao += floor((($comissaoServico['quantidade'] * $comissaoServico['produto_preco']) * ($comissaoServico['valor_comissao'] / 100)) * 100) / 100;
                        $observacaoComissao .= "Comissão do serviço: " . $produto->nome . " - Tipo: Percentual - Valor: " . $comissaoServico['valor_comissao'] . "%\n" . " quantidade: " . $comissaoServico['quantidade'] . " - Valor unitário: " . $comissaoServico['produto_preco'] . "\n";
                    } else{
                        $valorComissao += $comissaoServico['valor_comissao'] * $comissaoServico['quantidade'];
                        $observacaoComissao .= "Comissão do serviço: " . $produto->nome . " - Tipo: Valor Fixo - Valor: " . $comissaoServico['valor_comissao'] . "\n" . " quantidade: " . $comissaoServico['quantidade'] . " - Valor unitário: " . $comissaoServico['produto_preco'] . "\n";
                    }
                    
                }

                $comissao = true;
        }

        // Gerar associação de produtos e serviços na movimentação
        $movimentacao->produtos()->sync($produtos);
        
        if($comissao){
            $movimentacao = \App\Models\MovimentacaoFinanceira::create([
                'tipo' => 'saida',
                'descricao' => 'Atendimento - ' . $agendamento->cliente->nome . '. Pagamento de comissão para barbeiro: ' . $agendamento->barbeiro->nome,
                'valor' => $valorComissao,
                'data' => now()->format('Y-m-d'),
                'data_vencimento' => now()->addMonth()->format('Y-m-d'),
                'agendamento_id' => $agendamento->id,
                'filial_id' => $agendamento->filial_id,
                'fornecedor_id' => $idFornecedor ?? null,
                'situacao' => 'em_aberto',
                'observacoes' => $observacaoComissao ,
                'ativo' => true
            ]);
        }
        return redirect()->to(url()->previous())->with([
            'type' => 'success',
            'message' => 'Atendimento finalizado com sucesso!'
        ]);
    }

    public function buscarBarbeirosDisponiveis(Agendamento $agendamento){
        return DB::table('barbeiros')
        ->join('barbeiro_filial', 'barbeiros.id', '=', 'barbeiro_filial.barbeiro_id')
        ->where('barbeiros.ativo', true)
        ->where('barbeiro_filial.filial_id', $agendamento->filial_id)
        ->select('barbeiros.*')
        ->get();
    }   

    public function getBarbeirosPorFilial($filialId)
    {
        // Por enquanto, retornando todos os barbeiros ativos
        // Futuramente pode ser filtrado por filial quando implementado
        $barbeiros = db::table('barbeiros')
        ->join('barbeiro_filial', 'barbeiros.id', '=', 'barbeiro_filial.barbeiro_id')
        ->where('barbeiros.ativo', true)
        ->where('barbeiro_filial.filial_id', $filialId)->select('barbeiros.*')->get();

        return response()->json([
            'barbeiros' => $barbeiros
        ]);
    }

    public function atualizarBarbeiro(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'barbeiro_id' => 'required|exists:barbeiros,id'
        ]);

        if ($agendamento->status !== 'agendado') {
            return response()->json([
                'success' => false,
                'message' => 'Apenas agendamentos com status "agendado" podem ter o barbeiro alterado.'
            ]);
        }

        // Atualizar barbeiro do agendamento
        $agendamento->update([
            'barbeiro_id' => $request->barbeiro_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barbeiro atualizado com sucesso!'
        ]);
    }
}
