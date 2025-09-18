<?php

namespace App\Http\Controllers;

use App\Models\Barbeiro;
use App\Models\Filial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BarbeiroController extends Controller
{
    public function index(Request $request)
    {
        $query = Barbeiro::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
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
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:barbeiros',
            'email' => 'required|email|unique:barbeiros',
            'telefone' => 'required|string|max:15',
            'data_nascimento' => 'nullable|date|before:today',
            'rg' => 'nullable|string|max:20',
            'endereco' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Barbeiro::create($data);

        return response()->json(['success' => true, 'message' => 'Barbeiro criado com sucesso!']);
    }

    public function show(Barbeiro $barbeiro)
    {
        return response()->json($barbeiro);
    }

    public function update(Request $request, Barbeiro $barbeiro)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'size:14', Rule::unique('barbeiros')->ignore($barbeiro->id)],
            'email' => ['required', 'email', Rule::unique('barbeiros')->ignore($barbeiro->id)],
            'telefone' => 'required|string|max:15',
            'data_nascimento' => 'nullable|date|before:today',
            'rg' => 'nullable|string|max:20',
            'endereco' => 'nullable|string'
        ]);

        $barbeiro->update($request->all());

        return response()->json(['success' => true, 'message' => 'Barbeiro atualizado com sucesso!']);
    }

    public function destroy(Barbeiro $barbeiro)
    {
        $barbeiro->delete();
        return response()->json(['success' => true, 'message' => 'Barbeiro excluído com sucesso!']);
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
