<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Exception;
class AuthController extends Controller
{

    private $user = null;
     
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index() {
        return view('auth.login');
    }

    public function entrar (Request $request) {
       
        $validateData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        try{
            $dataUser = (object) $request->post();

            $userInstance = $this->user->firstOrNew(['email' => $dataUser->email ]);
            $authenticateUser = $userInstance->authenticateBd($dataUser->password);

            if($authenticateUser->authenticated) {
                Auth::login($userInstance);
                return redirect('/admin/clientes')->with(['type' => 'success', 'message' => 'Usuário autenticado com sucesso. Seja Bem-vindo(a)!']);
            }
        } 
        catch(Exception $e) {
            return redirect()->route('login')->with(['type' => 'error', 'message' => 'Usuário ou senha incorreto. Tente novamente.']);
        }



    } 

    public function logout() {
        auth()->logout();
        Session()->flush();
        return redirect()->route('login')->with(['type' => 'success', 'message' => 'Logout realizado com sucesso.' ]);
    }
}
