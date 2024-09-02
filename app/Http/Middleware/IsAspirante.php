<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAspirante
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //verificar si ha iniciado sesión y es un usuario cliente
        if (Auth::user() && Auth::user()->rol_id == 2) {
            
            //si si es un cliente verifica que este no sea aspirante ni sea un rechazado
            if (Auth::user()->estatus == 'aspirante' || Auth::user()->estatus == 'rechazado') {
                
                return redirect()->route('home');
            
            } else {
                //si es un usuario cliente y está aprobado
                return $next($request);
            }

        } elseif(Auth::user() && Auth::user()->rol_id == 3) {
            
            //si es un usuario bodega
            return redirect()->route('home')->with('error','La ruta que has solicitado no existe.');
        
        } else {

            //si es un superAdmin o Admin
             return $next($request);
        }
  
    }


}
