<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Fornecedor::with('userCreated');
        $per_page = $request->per_page ?? 15;

        if ($request->has('search') && $request->search && $request->search !== null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('nome_fantasia', 'like', "%{$search}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('ativo', $request->status);
        }

        if ($request->has('tipo') && $request->tipo !== '' && $request->tipo !== null) {
            $query->where('pessoa_fisica_juridica', $request->tipo);
        }

        $fornecedores = $query->orderBy('id')->paginate($per_page);

        // Estatísticas
        $stats = [
            'total' => Fornecedor::count(),
            'ativos' => Fornecedor::where('ativo', true)->count(),
            'pessoa_fisica' => Fornecedor::where('pessoa_fisica_juridica', 'F')->count(),
            'pessoa_juridica' => Fornecedor::where('pessoa_fisica_juridica', 'J')->count()
        ];

        return view('admin.fornecedores.index', compact('fornecedores', 'stats'));
    }

    public function store(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'nome' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['nullable', 'string', 'max:255'],
                'cpf_cnpj' => ['required', 'string', 'max:18', 'unique:fornecedores'],
                'endereco' => ['required', 'string'],
                'pessoa_fisica_juridica' => ['required', 'in:F,J'],
            ], [
                'nome.required' => 'O campo nome é obrigatório.',
                'nome.string' => 'O campo nome deve ser um texto.',
                'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',
            
                'nome_fantasia.string' => 'O campo nome fantasia deve ser um texto.',
                'nome_fantasia.max' => 'O campo nome fantasia não pode ter mais que 255 caracteres.',
            
                'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
                'cpf_cnpj.string' => 'O campo CPF/CNPJ deve ser um texto.',
                'cpf_cnpj.max' => 'O campo CPF/CNPJ não pode ter mais que 18 caracteres.',
                'cpf_cnpj.unique' => 'O CPF/CNPJ informado já está em uso.',
            
                'endereco.required' => 'O campo endereço é obrigatório.',
                'endereco.string' => 'O campo endereço deve ser um texto.',
            
                'pessoa_fisica_juridica.required' => 'O campo pessoa física/jurídica é obrigatório.',
                'pessoa_fisica_juridica.in' => 'O campo pessoa física/jurídica deve ser F (física) ou J (jurídica).',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('fornecedores.index')->with(['type' => 'error', 'message' => 'Erro ao cadastrar fornecedor: '. $validator->errors()->first()]);
            }
    
            $data = $request->all();
            $data['user_created'] = Auth::id();
            $data['ativo'] = $request->has('ativo') ? 1 : 0;
    
            Fornecedor::create($data);
    
            return redirect()->route('fornecedores.index')->with(['type' => 'success', 'message' => 'Fornecedor criado com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('fornecedores.index')->with(['type' => 'error', 'message' => 'Erro ao cadastrar fornecedor: '. $e->getMessage()]);

        }
    }

    public function show(Fornecedor $fornecedor)
    {
        $fornecedor->load('userCreated');
        return response()->json($fornecedor);
    }

    public function update(Request $request, Fornecedor $fornecedor)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nome' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['nullable', 'string', 'max:255'],
                'cpf_cnpj' => [
                    'required',
                    'string',
                    'max:18',
                    Rule::unique('fornecedores')->ignore($fornecedor->id)
                ],
                'endereco' => ['required', 'string'],
                'pessoa_fisica_juridica' => ['required', 'in:F,J'],
            ], [
                'nome.required' => 'O campo nome é obrigatório.',
                'nome.string' => 'O campo nome deve ser um texto.',
                'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',
            
                'nome_fantasia.string' => 'O campo nome fantasia deve ser um texto.',
                'nome_fantasia.max' => 'O campo nome fantasia não pode ter mais que 255 caracteres.',
            
                'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
                'cpf_cnpj.string' => 'O campo CPF/CNPJ deve ser um texto.',
                'cpf_cnpj.max' => 'O campo CPF/CNPJ não pode ter mais que 18 caracteres.',
                'cpf_cnpj.unique' => 'O CPF/CNPJ informado já está em uso.',
            
                'endereco.required' => 'O campo endereço é obrigatório.',
                'endereco.string' => 'O campo endereço deve ser um texto.',
            
                'pessoa_fisica_juridica.required' => 'O campo pessoa física/jurídica é obrigatório.',
                'pessoa_fisica_juridica.in' => 'O campo pessoa física/jurídica deve ser F (física) ou J (jurídica).',
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('fornecedores.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar fornecedor: '. $validator->errors()->first()]);
    
            }
    
            $data = $request->all();
            $data['ativo'] = $request->has('ativo') ? 1 : 0;
    
            $fornecedor->update($data);
    
            return redirect()->route('fornecedores.index')->with(['type' => 'success', 'message' => 'Fornecedor atualizado com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('fornecedores.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar fornecedor: '. $e->getMessage()]);

        }
    }

    public function destroy(Fornecedor $fornecedor)
    {
        try{
            $fornecedor->delete();
            return redirect()->route('fornecedores.index')->with(['type' => 'success', 'message' => 'Fornecedor excluído com sucesso!']);

        } catch(Exception $e){
            return redirect()->route('fornecedores.index')->with(['type' => 'error', 'message' => 'Erro ao excluir fornecedor: '. $e->getMessage()]);

        }
    }
}
