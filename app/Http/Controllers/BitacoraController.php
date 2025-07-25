<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bitacora;
use App\Models\Evento;
use App\Models\User;

class BitacoraController extends Controller
{
    public function index()
    {
        $bitacora = Bitacora::orderBy('id', 'desc')->get();
        $eventos = Evento::all();
        //traer los usuarios de tipo administrador osea 1 
        $users = User::where('rol_id', 1)->get();
        
        //dd($bitacora);
        return view('bitacora.index' , compact('bitacora', 'eventos', 'users'));
    }

    public function show($id){

        $bitacora = Bitacora::find($id);
        $eventos = Evento::all();

        //buscar el detalle de la orden
        //$detalle = OrdenDetalle::where('orden_id' , $id)->get();
         
        return view('bitacora.show' , compact('bitacora', 'eventos'));
    }

}