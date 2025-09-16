<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtros
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('master')) {
            $query->where('master', $request->master);
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }

        if(Auth::user()->master != 1){
            $query->where('master', false);
        }

        $users = $query->orderBy('nome')->paginate($request->get('per_page', 10));

        $totalUsers = User::count();
        $activeUsers = User::where('ativo', true)->count();
        $masterUsers = User::where('master', true)->count();
        $regularUsers = User::where('master', false)->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'masterUsers', 'regularUsers'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'senha' => 'required|string|min:6',
                'master' => 'boolean',
                'ativo' => 'boolean',
                'redefinir_senha_login' => 'boolean',
            ]);

            User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'senha' => Hash::make($request->senha),
                'master' => $request->get('master', false),
                'ativo' => $request->get('ativo', true),
                'redefinir_senha_login' => $request->get('redefinir_senha_login', false),
                'user_created' => Auth::user()->id
            ]);

            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'Usuário criado com sucesso!']);
        } catch(Exception $e) {
            return redirect()->route('users.index')->with(['type' => 'error', 'message' => 'Erro ao criar usuário: ' . $e->getMessage()]);

        }
    }
    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        try{
            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'senha' => 'nullable|string|min:6',
                'master' => 'boolean',
                'ativo' => 'boolean',
                'redefinir_senha_login' => 'boolean',
            ]);
    
            $data = [
                'nome' => $request->nome,
                'email' => $request->email,
                'master' => $request->get('master', false),
                'ativo' => $request->get('ativo', true),
                'redefinir_senha_login' => $request->get('redefinir_senha_login', false),
            ];
    
            if ($request->filled('senha')) {
                $data['senha'] = Hash::make($request->senha);
            }
    
            $user->update($data);
    
            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'Usuário atualizado com sucesso!']);
        } catch(Exception $e){
            return redirect()->route('users.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar o usuário: ' . $e->getMessage()]);

        }
    }

    public function destroy(User $user)
    {
        try{
            if ($user->master) {
                return redirect()->route('users.index')->with(['type' => 'error', 'message' => 'Não é possível excluir usuário master!']);
            }
    
            $user->delete();
    
            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'Usuário excluído com sucesso!']);
    
        } catch(Exception $e){
            return redirect()->route('users.index')->with(['type' => 'error', 'message' => 'Erro ao excluir usuário: ' . $e->getMessage()]);

        }
       
    }

    public function perfilIndex(){
        $user = Auth::user();
        
        return view('admin.perfil.index', compact('user'));
    }
}
