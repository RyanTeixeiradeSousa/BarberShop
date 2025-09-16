<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FilialController extends Controller
{
    public function index(Request $request)
    {
        $query = Filial::query();

        if ($request->has('search') && $request->search && $request->search !== null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('nome_fantasia', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cnpj', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('ativo', $request->status);
        }

        $filiais = $query->orderBy('id')->paginate($request->get('per_page', 15));

        // Estatísticas
        $stats = [
            'total' => Filial::count(),
            'ativas' => Filial::where('ativo', true)->count(),
            'inativas' => Filial::where('ativo', false)->count(),
            'com_cnpj' => Filial::whereNotNull('cnpj')->where('cnpj', '!=', '')->count(),
        ];

        return view('admin.filiais.index', compact('filiais', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|size:18|unique:filiais',
            'endereco' => 'required|string',
            'telefone' => 'nullable|string|max:15',
            'email' => 'required|email|unique:filiais',
        ]);

        Filial::create($request->all());

        return response()->json(['success' => true, 'message' => 'Filial criada com sucesso!']);
    }

    public function show(Filial $filial)
    {
        return response()->json($filial);
    }

    public function update(Request $request, Filial $filial)
    {

        try{
            $validator = Validator::make($request->all(), [
                'endereco' => ['required', 'string'],
                'telefone' => ['nullable', 'string', 'max:15'],
                'email' => ['required', 'email', Rule::unique('filiais')->ignore($filial->id)],
            ], [
                'endereco.required' => 'O campo endereço é obrigatório.',
                'endereco.string' => 'O campo endereço deve ser um texto.',
            
                'telefone.string' => 'O campo telefone deve ser um texto.',
                'telefone.max' => 'O campo telefone não pode ter mais que 15 caracteres.',
            
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um email válido.',
                'email.unique' => 'O email informado já está em uso.',

            ]);
            
            // Verifica se houve erro
            if ($validator->fails()) {
                return redirect()->route('filiais.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar filial: '. $validator->errors()->first()]);
            }

            $data = $request->all();
            $data['disponivel_site'] =  $request->disponivel_site ?? 0;

            $filial->update($data);
    
            return redirect()->route('filiais.index')->with(['type' => 'success', 'message' => 'Filial atualizada com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('filiais.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar filial: '. $e->getMessage()]);

        }
    }

    public function destroy(Filial $filial)
    {
        $filial->delete();
        return response()->json(['success' => true, 'message' => 'Filial excluída com sucesso!']);
    }
}
