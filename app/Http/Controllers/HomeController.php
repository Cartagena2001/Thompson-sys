<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use App\Models\CMS;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();

        $marcasAuto = $user->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        $marcas = Marca::whereIn('id', $marcasAutorizadas)->get();
        
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        if($user->estatus == "aspirante" || $user->estatus == "rechazado"){

            return view('aspirantes.form-inscripcion', compact('user'));

        }else{
            //estatus = aprobado
            return view('home',  compact('marcas', 'cat_mod', 'mant_mod') );
        }
             
    }
}
