<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone1', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('ativo', $request->status);
        }

        $clientes = $query->orderBy('nome')->paginate(10);

        return view('admin.clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:clientes',
            'email' => 'required|email|unique:clientes',
            'data_nascimento' => 'required|date|before:today',
            'sexo' => 'required|in:M,F',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'endereco' => 'required|string'
        ]);

        Cliente::create($request->all());

        return response()->json(['success' => true, 'message' => 'Cliente criado com sucesso!']);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'size:14', Rule::unique('clientes')->ignore($cliente->id)],
            'email' => ['required', 'email', Rule::unique('clientes')->ignore($cliente->id)],
            'data_nascimento' => 'required|date|before:today',
            'sexo' => 'required|in:M,F',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'endereco' => 'required|string'
        ]);

        $cliente->update($request->all());

        return response()->json(['success' => true, 'message' => 'Cliente atualizado com sucesso!']);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['success' => true, 'message' => 'Cliente excluído com sucesso!']);
    }
}
