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
        $bitacora = Bitacora::Paginate(1000000000);
        $eventos = Evento::all();
        $users = User::all();

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