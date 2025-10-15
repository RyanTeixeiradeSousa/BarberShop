<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Action;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se o usuário está autenticado

        $user = auth()->user();

        // Usuário master tem permissão total
        if ($user->master == 1) {
            return $next($request);
        }

        // Obter informações da rota atual
        $currentRoute = Route::currentRouteAction();
        
        if (!$currentRoute) {
            return $next($request);
        }

        // Extrair controller e method da rota
        // Formato: App\Http\Controllers\ClienteController@index
        $routeParts = explode('@', $currentRoute);
        
        if (count($routeParts) !== 2) {
            return $next($request);
        }

        $controllerFullPath = $routeParts[0];
        $method = $routeParts[1];

        // Extrair apenas o nome do controller (sem namespace)
        $controllerParts = explode('\\', $controllerFullPath);
        $controller = end($controllerParts);

        // Buscar a action no banco de dados
        $action = Action::where('controller', $controller)
            ->where('method', $method)
            ->where('ativo', true)
            ->first();

        // Se a action não existe no banco, permitir acesso
        // (ações não cadastradas são consideradas públicas)
        if (!$action) {
            return $next($request);
        }

        // Verificar se o usuário tem permissão para esta action
        $hasPermission = $user->actions()->where('action_id', $action->id)->exists();

        if (!$hasPermission) {
            return redirect()
                ->route('dashboard')
                ->with('message', "Você não tem permissão para: {$action->nome}")
                ->with('type', 'error');
        }

        return $next($request);
    }
}
