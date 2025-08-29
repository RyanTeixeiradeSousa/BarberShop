<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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

        return view('admin.clientes.index', compact('clientes', 'total', 'total_ativos', 'total_masculino', 'total_feminino'));
    }

    public function store(Request $request)
    {
        try{
            $rules = [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|size:14|unique:clientes',
                'email' => 'email|unique:clientes',
                'data_nascimento' => 'nullable|date|before:today',
                'sexo' => 'required|in:M,F',
                'telefone1' => 'nullable|string|max:15',
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
                // Para uma aplicação web
                
                return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Campos inválidos para cadastro de Cliente.', 'errors' => $validator->errors()]);
        
                // Para uma API JSON, você poderia usar:
                // return response()->json(['errors' => $validator->errors()], 422);
            }
            Cliente::create($request->all());
    
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
                    'required',
                    'string',
                    'size:14',
                    Rule::unique('clientes')->ignore($cliente->id),
                ],
                'email' => [
                    'email',
                    Rule::unique('clientes')->ignore($cliente->id),
                ],
                
                'data_nascimento' => 'nullable|date|before:today',
                'sexo' => 'required|in:M,F',
                'telefone1' => 'nullable|string|max:15',
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

            $cliente->delete();
            return redirect()->route('clientes.index')->with(['type' => 'success' , 'message'=> 'Cliente excluido com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('clientes.index')->with(['type' => 'error' , 'message'=> 'Ocorreu um erro interno no servidor.', 'errors' => $e->getMessage()]);

        }
    }
}
