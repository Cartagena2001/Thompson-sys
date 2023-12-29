<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\bitacora;
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

        $response = $next($request);

        $user = $request->user();
        $action = $request->route()->getActionMethod();

        $routeName = Route::currentRouteName();
        $routeAction = Route::currentRouteAction();
        $routeUri = $request->path();

        $routeInfo = "Ruta: $routeName ($routeAction) - $routeUri";

        if (!$user) {
            return $response;
        }

        bitacora::create([
            'user_id' => $user->id,
            'accion' => $action . ' - ' . $routeUri,
            'hora_fecha' => now(),
            'descripcion' => "El usuario {$user->name} realizó la acción {$action}. $routeInfo",
        ]);

        return $next($request);
    }
}
