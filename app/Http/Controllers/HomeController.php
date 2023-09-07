<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;

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
        $marcas = Marca::all();

        if($user->estatus == "aspirante" || $user->estatus == "rechazado"){

            return view('aspirantes.form-inscripcion', compact('user'));

        }else{
            //estatus = aprobado
            return view('home',  compact('marcas'));
        }
             
    }
}
