<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

Class ClientesController extends Controller{

    public function index(){

        $clientes = User::where('estatus', 'aprobado')->paginate();

        return view('clientes.index', compact('clientes'));
    }

    public function show($id){

        $cliente = User::findOrFail($id);
        $marcas = Marca::all();

        return view('clientes.show', compact('cliente', 'marcas'));
    }

    //actualizar clasiicacion a cobre
    public function cobre($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Cobre';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Cobre');
    }

    //actualizar clasiicacion a plata
    public function plata($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Plata';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Plata');
    }

    //actualizar clasiicacion a oro
    public function oro($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Oro';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Oro');
    }

    //actualizar clasiicacion a platino
    public function platino($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Platino';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Platino');
    }

    //actualizar clasiicacion a diamante
    public function diamante($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Diamante';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Diamante');
    }

    //actualizar clasiicacion a taller
    public function taller($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Taller';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Taller');
    }

    //actualizar clasiicacion a distribucion
    public function distribucion($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'Reparto';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizo el estado del cliente a Reparto');
    }

    public function admPermMarca(){

        $clientes = User::where('estatus', 'aprobado')->paginate();
        $marcas = Marca::all();

        return view('clientes.marcasAdm', compact('clientes', 'marcas'));
    }


    public function updateMarcas(Request $request){

/*
        $request->validate([
            'marca'          => 'required',
            'cliente'         => 'required|email',
            //'mobile'        => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

        ]);
*/


        $clienteID = trim(strstr( $request->cliente, "_" ), "_");
        $clienteUptM = User::find($clienteID);

        $marcasUDT = ""; 

        if ( str_contains($clienteUptM->marcas, $request->marca) ) {

           $marcasUDT = strstr( $clienteUptM->marcas, $request->marca, true);

            $clienteUptM->marcas = $marcasUDT;

            $clienteUptM->save();

           return response()->json($clienteUptM->marcas);

        } else {

            $clienteUptM->marcas = $clienteUptM->marcas.$request->marca;

            $clienteUptM->save();

            return response()->json($clienteUptM->marcas);
        }

    }



}