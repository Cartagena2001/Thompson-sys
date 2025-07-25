<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

Class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){

        $clientes = User::where('estatus', 'aprobado')->paginate(1000000000);

        return view('clientes.index', compact('clientes'));
    }

    public function show($id){

        $cliente = User::findOrFail($id);
        $marcas = Marca::all();
        //$marcas = Marca::where('estado', '=', 'Activo')->get();

        return view('clientes.show', compact('cliente', 'marcas'));
    }

    //actualizar lista de precios a taller
    public function taller($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'taller';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizó la lista de precios del cliente a Taller');
    }

    //actualizar la lista de precios a distribuidor
    public function distribuidor($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'distribuidor';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizó la lista de precios del cliente a Distribuidor');
    }

    //actualizar la lista de precios a precio costo
    public function precioCosto($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'precioCosto';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizó la lista de precios del cliente a Precio Costo');
    }

    //actualizar la lista de precios a precio op
    public function precioOP($id){

        $cliente = User::find($id);
        $cliente->clasificacion = 'precioOp';
        $cliente->save();

        return redirect('/dashboard/clientes')->with('toast_success', 'Se actualizó la lista de precios del cliente a Precio OP');
    }


    public function admPermMarca(){

        $clientes = User::where('estatus', 'aprobado')->paginate(1000000000);
        $marcas = Marca::all();
        //$marcas = Marca::where('estado', '=', 'Activo')->get();

        return view('clientes.marcasAdm', compact('clientes', 'marcas'));
    }

/*
    public function updateMarcas(Request $request){


        $request->validate([
            'marca'          => 'required', 
            'cliente'         => 'required|email',
            //'mobile'        => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

        ]);

        $clienteID = trim(strstr( $request->cliente, "_" ), "_");
        $clienteUptM = User::find($clienteID);

        $marcasUDT = "";

        $marcasInput = $request->marca; 
        $marcasBD = $clienteUptM->marcas;

        if ( Str::contains($marcasBD, $marcasInput) ) {   

            $marcasUDT = str_replace($marcasInput, '', $marcasBD);

            $clienteUptM->marcas = $marcasUDT;
            $clienteUptM->update();

           return response()->json($clienteUptM->marcas);

        } else {

            $clienteUptM->marcas = $marcasBD.$marcasInput;

            $clienteUptM->update();

            return response()->json($clienteUptM->marcas);
        }

    }
*/

    public function updateMarcas(Request $request){
        //se obtiene el id del cliente y las marcas del cliente
        $clienteID = trim(strstr( $request->cliente, "_" ), "_");
        $clienteUptM = User::find($clienteID);
        $marcasCliente = $clienteUptM->marcas;
        //var_dump($marcasCliente);


        //obtener el estado de la marca si es true o false
        $marcaUpdate = $request->marcaUpdate;
        $estadoUpdate = $request->estadoUpdate;
        //var_dump($marcaUpdate . " " . $estadoUpdate);

        //si el estado es true se agrega la marca al cliente si es false se elimina
        if ($estadoUpdate == 'true') {
            $clienteUptM->marcas = $marcasCliente.$marcaUpdate;
            //verificar que no alla nigun valor repetido en el campo marcas del cliente y si lo hay eliminarlo
            $clienteUptM->marcas = implode('', array_unique(str_split($clienteUptM->marcas)));
            $clienteUptM->update();
            return response()->json($clienteUptM->marcas);
        } else {
            $clienteUptM->marcas = str_replace($marcaUpdate, '', $marcasCliente);
            $clienteUptM->marcas = implode('', array_unique(str_split($clienteUptM->marcas)));
            $clienteUptM->update();
            return response()->json($clienteUptM->marcas);
        }
    }


    public function actModCat(Request $request,  $id)
    {
        
        $user = User::find($id);

        request()->validate([
            'catMod'   => 'required|numeric',
        ]);

        $user->cat_mod = $request->catMod;

        $user->update();

        return response()->json($user->cat_mod);
    }


/*
    public function updateMarcas(Request $request){

        $clienteID = trim(strstr( $request->cliente, "_" ), "_");
        $clienteUptM = User::find($clienteID);


        //return response()->json("cliente ID inside: ".$clienteID." ");

        
        $marcasUDT = "";

        $marcasInput = $request->marca; 
        $marcasBD = $clienteUptM->marcas;
        

        //return response()->json("marca ID inside: ".$marcasInput." marcas actuales del cliente ".$clienteID.": ".$marcasBD);

        //return response()->json("str_contains(".$marcasBD.", ".$marcasInput.") = ".str_contains($marcasBD, $marcasInput));

        
        if ( str_contains($clienteUptM->marcas, $marcasInput) == 1 ) {   

            $marcasUDT = str_replace($marcasInput, '', $clienteUptM->marcas);

            $clienteUptM->marcas = $marcasUDT;
            $clienteUptM->update();

           //return response()->json($clienteUptM->marcas);
           return response()->json(

            "cliente ID inside: ".$clienteID." 

            <br/>

            marca ID inside: ".$marcasInput." marcas actuales del cliente ID ".$clienteID." : ".$marcasBD.", 

                str_contains(".$marcasBD.", ".$marcasInput.") = ".str_contains($marcasBD, $marcasInput)."

            <br/>
            
            entró al IF
            
            <br/>

            marcas finales: ".$marcasUDT );

        } else {

            $clienteUptM->marcas = $clienteUptM->marcas.$marcasInput;

            $clienteUptM->update();

            //return response()->json($clienteUptM->marcas);
            return response()->json(
            
            "cliente ID inside: ".$clienteID." 

            <br/>

            marca ID inside: ".$marcasInput.", marcas actuales del cliente ID ".$clienteID." : ".$marcasBD.",

              str_contains(".$marcasBD.", ".$marcasInput.") = ".str_contains($marcasBD, $marcasInput)."

            <br/>
            
            entró al ELSE

            <br/>

            marcas finales: ".$clienteUptM->marcas );
        }
        

    }

*/


}