<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\MovimentacaoFinanceira;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        $per_page = $request->per_page ?? 15;
       
        if ($request->has('search') && $request->search && $request->search !== null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone1', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status !== null) {
            $query->where('ativo', $request->status);
        }

        $clientes = $query->orderBy('id')->paginate($per_page);

        $total = Cliente::count();
        $total_ativos = Cliente::where('ativo', 1)->count();
        $total_masculino = Cliente::where('sexo', 'M')->count();
        $total_feminino = Cliente::where('sexo', 'F')->count();

        $stats = [
            'total' => $total,
            'ativos' => $total_ativos,
            'masculino' => $total_masculino,
            'feminino' => $total_feminino
        ];

        return view('admin.clientes.index', compact('clientes', 'stats'));
    }

    public function store(Request $request)
    {
        try{
            $rules = [
                'nome' => 'required|string|max:255',
                'cpf' => 'nullable|string|size:14|unique:clientes',
                'email' => 'nullable|email|unique:clientes',
                'data_nascimento' => 'nullable',
                'sexo' => 'required|in:M,F',
                'telefone1' => 'required|string|max:15|unique:clientes',
                'telefone2' => 'nullable|string|max:15',
                'endereco' => 'nullable|string'
            ];
        
            // Mensagens personalizadas
            $messages = [
                'nome.required' => 'O nome é obrigatório.',
                'nome.string' => 'O nome deve ser um texto válido.',
                'nome.max' => 'O nome não pode ter mais que 255 caracteres.',
        
                'cpf.string' => 'O CPF deve ser um texto.',
                'cpf.size' => 'O CPF deve ter exatamente 14 caracteres (com máscara).',
                'cpf.unique' => 'Este CPF já está cadastrado.',
        
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'email.unique' => 'Este e-mail já está cadastrado.',
        
                'data_nascimento.required' => 'A data de nascimento é obrigatória.',
                'data_nascimento.date' => 'Informe uma data válida.',
                'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
        
                'sexo.required' => 'O sexo é obrigatório.',
                'sexo.in' => 'O sexo deve ser M ou F.',
        
                'telefone1.required' => 'O telefone principal é obrigatório.',
                'telefone1.string' => 'O telefone deve ser um texto.',
                'telefone1.max' => 'O telefone não pode ter mais que 15 caracteres.',
                'telefone1.unique' => 'Este telefone principal já está cadastrado.',

        
                'telefone2.string' => 'O telefone secundário deve ser um texto.',
                'telefone2.max' => 'O telefone secundário não pode ter mais que 15 caracteres.',
        
                'endereco.required' => 'O endereço é obrigatório.',
                'endereco.string' => 'O endereço deve ser um texto.'
            ];
        
            // Cria o validator
            $validator = Validator::make($request->all(), $rules, $messages);
        
            // Verifica se falhou
            if ($validator->fails()) {
                // Para uma aplicação web
                return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Campos inválidos para cadastro de Cliente: ' . $validator->errors()->first(), 'errors' => $validator->errors()]);
        
            }
            $data = $request->all();
            $data['user_created'] = Auth::user()->id;

            Cliente::create($data);
    
            return redirect()->route('clientes.index')->with(['type' => 'success' , 'message'=> 'Cliente criado com sucesso.']);

        } catch(Exception $e){
            return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Ocorreu um erro interno no servidor.', 'errors' => $e->getMessage()]);

        }
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        try{
            
            $rules = [
                'nome' => 'required|string|max:255',
                'cpf' => [
                    'nullable',
                    'string',
                    'size:14',
                    Rule::unique('clientes')->ignore($cliente->id),
                ],
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('clientes')->ignore($cliente->id),
                ],
                
                'data_nascimento' => 'nullable|date|before:today',
                'sexo' => 'required|in:M,F',
                'telefone1' => 'required|string|max:15',
                'telefone2' => 'nullable|string|max:15',
                'endereco' => 'nullable|string'
            ];
        
            // Mensagens personalizadas
            $messages = [
                'nome.required' => 'O nome é obrigatório.',
                'nome.string' => 'O nome deve ser um texto válido.',
                'nome.max' => 'O nome não pode ter mais que 255 caracteres.',
        
                'cpf.required' => 'O CPF é obrigatório.',
                'cpf.string' => 'O CPF deve ser um texto.',
                'cpf.size' => 'O CPF deve ter exatamente 14 caracteres (com máscara).',
                'cpf.unique' => 'Este CPF já está cadastrado.',
        
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'email.unique' => 'Este e-mail já está cadastrado.',
        
                'data_nascimento.required' => 'A data de nascimento é obrigatória.',
                'data_nascimento.date' => 'Informe uma data válida.',
                'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
        
                'sexo.required' => 'O sexo é obrigatório.',
                'sexo.in' => 'O sexo deve ser M ou F.',
        
                'telefone1.required' => 'O telefone principal é obrigatório.',
                'telefone1.string' => 'O telefone deve ser um texto.',
                'telefone1.max' => 'O telefone não pode ter mais que 15 caracteres.',
        
                'telefone2.string' => 'O telefone secundário deve ser um texto.',
                'telefone2.max' => 'O telefone secundário não pode ter mais que 15 caracteres.',
        
                'endereco.required' => 'O endereço é obrigatório.',
                'endereco.string' => 'O endereço deve ser um texto.'
            ];
        
            // Cria o validator
            $validator = Validator::make($request->all(), $rules, $messages);
        
            // Verifica se falhou
            if ($validator->fails()) {
                return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Campos inválidos para atualização de Cliente.', 'errors' => $validator->errors()]);
              
            }

            $data = $request->all();

            // Garante que o campo 'ativo' exista no array, se não vem no request, define 0
            $data['ativo'] = $request->has('ativo') ? $request->ativo : 0;

            $cliente->update($data);
            return redirect()->route('clientes.index')->with(['type' => 'success' , 'message'=> 'Cliente atualizado com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Ocorreu um erro interno no servidor.', 'errors' => $e->getMessage()]);

        }
    }

    public function destroy(Cliente $cliente)
    {
        try{

            if(count(MovimentacaoFinanceira::where('cliente_id', $cliente->id)->get()) > 0 ){
                return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Não foi possível excluir o cliente. Há movimentações financeiras associadas a ele.']);

            }

            if(count(Agendamento::where('cliente_id', $cliente->id)->get()) > 0 ){
                return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Não foi possível excluir o cliente. Há agendamentos associadas a ele.']);

            }
            $cliente->delete();
            return redirect()->route('clientes.index')->with(['type' => 'success' , 'message'=> 'Cliente excluido com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Ocorreu um erro interno no servidor.', 'errors' => $e->getMessage()]);

        }
    }

    public function detalhes(Cliente $cliente)
    {
        // Timeline de agendamentos
        $agendamentos = DB::table('agendamentos')
            ->join('filiais', 'agendamentos.filial_id', '=', 'filiais.id')
            ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
            ->leftJoin('agendamento_produto', 'agendamentos.id', '=', 'agendamento_produto.agendamento_id')
            ->leftJoin('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->where('agendamentos.cliente_id', $cliente->id)
            ->select(
                'agendamentos.status',
                'agendamentos.id',
                'agendamentos.data_agendamento',
                'agendamentos.hora_inicio',
                'filiais.nome as filial_nome',
                'filiais.endereco as filial_endereco',
                'barbeiros.nome as barbeiro_nome',
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN produtos.tipo = "servico" THEN produtos.nome END SEPARATOR ", ") as servicos_nomes'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN produtos.tipo = "produto" THEN produtos.nome END SEPARATOR ", ") as produtos_nomes'),
                DB::raw('COALESCE(SUM(agendamento_produto.quantidade * agendamento_produto.valor_unitario), 0) as valor_total')
            )
            ->groupBy('agendamentos.id', 'filiais.nome', 'filiais.endereco', 'barbeiros.nome')
            ->orderBy('agendamentos.data_agendamento', 'desc')
            ->orderBy('agendamentos.hora_inicio', 'desc')
            ->limit(20)
            ->get();


        // Estatísticas gerais
        $totalAgendamentos = Agendamento::where('cliente_id', $cliente->id)->count();
        $agendamentosFinalizados = Agendamento::where('cliente_id', $cliente->id)
            ->where('status', 'concluido')
            ->count();
        $agendamentosCancelados = Agendamento::where('cliente_id', $cliente->id)
            ->where('status', 'cancelado')
            ->count();

        // Produtos mais comprados
        $produtosMaisComprados = DB::table('agendamento_produto')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->where('agendamentos.cliente_id', $cliente->id)
            ->where('agendamentos.status', 'concluido')
            ->where('produtos.tipo', 'produto')
            ->select('produtos.nome', 'produtos.tipo', DB::raw('SUM(agendamento_produto.quantidade) as quantidade'), DB::raw('SUM(agendamento_produto.valor_unitario * agendamento_produto.quantidade) as total_gasto'))
            ->groupBy('produtos.id', 'produtos.nome', 'produtos.tipo')
            ->orderBy('quantidade', 'desc')
            ->limit(10)
            ->get();

        // Serviços mais utilizados
        $servicosMaisUtilizados = DB::table('agendamento_produto')
            ->join('agendamentos', 'agendamento_produto.agendamento_id', '=', 'agendamentos.id')
            ->join('produtos', 'agendamento_produto.produto_id', '=', 'produtos.id')
            ->where('agendamentos.cliente_id', $cliente->id)
            ->where('agendamentos.status', 'concluido')
            ->where('produtos.tipo', 'servico')
            ->select('produtos.nome', DB::raw('SUM(agendamento_produto.quantidade) as quantidade'), DB::raw('SUM(agendamento_produto.valor_unitario * agendamento_produto.quantidade) as total_gasto'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderBy('quantidade', 'desc')
            ->limit(10)
            ->get();

        // Valor total gasto
        $valorTotalGasto = MovimentacaoFinanceira::where('cliente_id', $cliente->id)
            ->where('tipo', 'entrada')
            ->where('situacao', 'pago')
            ->sum(DB::raw('valor - desconto'));

        // Filiais mais frequentadas
        $filiaisMaisFrequentadas = DB::table('agendamentos')
            ->join('filiais', 'agendamentos.filial_id', '=', 'filiais.id')
            ->where('agendamentos.cliente_id', $cliente->id)
            ->where('agendamentos.status', 'concluido')
            ->select('filiais.nome', 'filiais.endereco', DB::raw('COUNT(*) as quantidade'))
            ->groupBy('filiais.id', 'filiais.nome', 'filiais.endereco')
            ->orderBy('quantidade', 'desc')
            ->get();

        // Último agendamento
        $ultimoAgendamento = DB::table('agendamentos')
            ->join('filiais', 'agendamentos.filial_id', '=', 'filiais.id')
            ->join('barbeiros', 'agendamentos.barbeiro_id', '=', 'barbeiros.id')
            ->where('agendamentos.cliente_id', $cliente->id)
            ->select(
                'agendamentos.*',
                'filiais.nome as filial_nome',
                'filiais.endereco as filial_endereco',
                'barbeiros.nome as barbeiro_nome'
            )
            ->orderBy('agendamentos.data_agendamento', 'desc')
            ->orderBy('agendamentos.hora_inicio', 'desc')
            ->first();

        return view('admin.clientes.detalhes', compact(
            'cliente',
            'agendamentos',
            'totalAgendamentos',
            'agendamentosFinalizados',
            'agendamentosCancelados',
            'produtosMaisComprados',
            'servicosMaisUtilizados',
            'valorTotalGasto',
            'filiaisMaisFrequentadas',
            'ultimoAgendamento'
        ));
    }
}
