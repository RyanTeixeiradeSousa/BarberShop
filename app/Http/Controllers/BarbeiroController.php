<?php

namespace App\Http\Controllers;

use App\Models\Barbeiro;
use App\Models\Filial;
use App\Models\Fornecedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BarbeiroController extends Controller
{
    public function index(Request $request)
    {
        $query = Barbeiro::query();

        if ($request->has('search') && $request->search && $request->search != null ) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '' && $request->status != null) {
            $query->where('ativo', $request->status);
        }

        $perPage = $request->get('per_page', 15);
        $barbeiros = $query->orderBy('nome')->paginate($perPage);

        // Estatísticas
        $stats = [
            'total' => Barbeiro::count(),
            'ativos' => Barbeiro::where('ativo', true)->count(),
            'inativos' => Barbeiro::where('ativo', false)->count(),
            'este_mes' => Barbeiro::whereMonth('created_at', now()->month)->count()
        ];

        return view('admin.barbeiros.index', compact('barbeiros', 'stats'));
    }

    public function store(Request $request)
    {
        
        try{
            $validator = Validator::make($request->all(), [
                'nome'            => 'required|string|max:255',
                'cpf'             => 'required|string|size:14|unique:barbeiros',
                'email'           => 'required|email|unique:barbeiros',
                'telefone'        => 'required|string|max:15',
                'data_nascimento' => 'nullable|date|before:today',
                'rg'              => 'nullable|string|max:20',
                'endereco'        => 'required|string',
            ], [
                'nome.required'            => 'O campo nome é obrigatório.',
                'cpf.required'             => 'O CPF é obrigatório.',
                'cpf.unique'               => 'Este CPF já está cadastrado.',
                'email.required'           => 'O e-mail é obrigatório.',
                'email.unique'             => 'Este e-mail já está cadastrado.',
                'telefone.required'        => 'O telefone é obrigatório.',
                'data_nascimento.before'   => 'A data de nascimento deve ser anterior a hoje.',
                'endereco.required'   => 'O endereço é obrigatório.',
            ]);
            
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
            
    
            $data = $request->all();
            $data['user_created'] = Auth::user()->id;
            $data['user_id'] = null;
            $data['ativo'] = isset($request->ativo);
            $barbeiro = Barbeiro::create($data);
    
            if(!Fornecedor::where('cpf_cnpj', preg_replace('/\D/', '', $barbeiro->cpf))->value('id')){
                Fornecedor::create([
                    'nome' => $request->nome,
                    'cpf_cnpj' => $request->cpf,
                    'email' => $request->email,
                    'telefone' => $request->telefone,
                    'endereco' => $request->endereco,
                    'pessoa_fisica_juridica' => 'F',
                    'ativo' => true,
                    'user_created' => Auth::user()->id,
                ]);
            }

            return redirect()->route('barbeiros.index')->with(['type' => 'success', 'message' => 'Barbeiro criado com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('barbeiros.index')->with(['type' => 'error', 'message' => 'Erro ao criar barbeiro: ' . $e->getMessage()]);
        }
    }

    public function show(Barbeiro $barbeiro)
    {
        return response()->json($barbeiro);
    }

    public function update(Request $request, Barbeiro $barbeiro)
    {
        try{

            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => [
                    'required',
                    'string',
                    'size:14',
                    Rule::unique('barbeiros')->ignore($barbeiro->id)
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('barbeiros')->ignore($barbeiro->id)
                ],
                'telefone'        => 'required|string|max:15',
                'data_nascimento' => 'nullable|date|before:today',
                'rg'              => 'nullable|string|max:20',
                'endereco'        => 'nullable|string',
            ], [
                'nome.required'          => 'O campo nome é obrigatório.',
                'cpf.required'           => 'O CPF é obrigatório.',
                'cpf.size'               => 'O CPF deve ter exatamente 14 caracteres.',
                'cpf.unique'             => 'Este CPF já está cadastrado.',
                'email.required'         => 'O e-mail é obrigatório.',
                'email.email'            => 'Informe um e-mail válido.',
                'email.unique'           => 'Este e-mail já está cadastrado.',
                'telefone.required'      => 'O telefone é obrigatório.',
                'data_nascimento.date'   => 'A data de nascimento deve ser uma data válida.',
                'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            ]);
        
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
        

            $data = $request->all();
            $data['ativo'] = isset($request->ativo);
    
            $barbeiro->update($data);
    
            return redirect()->route('barbeiros.index')->with(['type' => 'success', 'message' => 'Barbeiro atualizado com sucesso!']);
        } catch(\Exception $e){
            return redirect()->route('barbeiros.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar barbeiro: ' . $e->getMessage()]);
        }
    }

    public function destroy(Barbeiro $barbeiro)
    {
        try{
            $barbeiro->delete();
            return redirect()->route('barbeiros.index')->with(['type' => 'success', 'message' => 'Barbeiro excluído com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('barbeiros.index')->with(['type' => 'error', 'message' => 'Erro ao excluir barbeiro: ' . $e->getMessage()]);

        }
    }

    public function getFiliais(Barbeiro $barbeiro)
    {
        $filiais = Filial::where('ativo', true)->get();
        $filiaisVinculadas = $barbeiro->filiais->pluck('id')->toArray();
        
        return response()->json([
            'filiais' => $filiais,
            'vinculadas' => $filiaisVinculadas
        ]);
    }

    public function vincularFilial(Request $request, Barbeiro $barbeiro)
    {
        $request->validate([
            'filial_id' => 'required|exists:filiais,id'
        ]);

        $barbeiro->filiais()->syncWithoutDetaching([$request->filial_id]);

        return response()->json(['success' => true, 'message' => 'Filial vinculada com sucesso!']);
    }

    public function desvincularFilial(Request $request, Barbeiro $barbeiro)
    {
        $request->validate([
            'filial_id' => 'required|exists:filiais,id'
        ]);


        db::table('barbeiro_comissoes')->where('barbeiro_id', $barbeiro->id)->where('filial_id', $request->filial_id)->delete();
        db::table('barbeiro_servico_comissoes')->where('barbeiro_id', $barbeiro->id)->where('filial_id', $request->filial_id)->delete();

        $barbeiro->filiais()->detach($request->filial_id);

        return response()->json(['success' => true, 'message' => 'Filial desvinculada com sucesso!']);
    }
}
