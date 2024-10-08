<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Route;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($_SERVER['REQUEST_METHOD']!='OPTIONS') {

            $response = $next($request);

            $user = $request->user();
            $action = $request->route()->getActionMethod();

            $routeName = Route::currentRouteName();
            $routeAction = Route::currentRouteAction();
            $routeUri = $request->path();

            $routeInfo = "Ruta: $routeName ($routeAction) - $routeUri";

            if (!$user || !in_array($user->rol_id, [0, 1])) {
                return $response;
            }

            bitacora::create([
                'user_id' => $user->id,
                'accion' => $action . ' - ' . $routeUri,
                'hora_fecha' => now(),
                'descripcion' => "El usuario {$user->name} realizó la acción {$action}. $routeInfo",
            ]);
        }
        return $next($request);
        
    }

}
