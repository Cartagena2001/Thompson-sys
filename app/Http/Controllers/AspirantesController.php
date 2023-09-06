<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

class AspirantesController extends Controller
{
    public function index()
    {
        $aspirantes = User::where('estatus', 'aspirante')->orWhere('estatus', 'rechazado')->paginate(1000000000);
        
        return view('aspirantes.index', compact('aspirantes'));
    }

    public function show($id)
    {
        $aspirante = User::find($id);
        $marcas = Marca::all();

        return view('aspirantes.show', compact('aspirante', 'marcas'));
    }

    public function aprobado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'aprobado';
        $aspirante->clasificacion = 'Cobre';
        $aspirante->form_status = 'none';
        $aspirante->save();

        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizó el estado del aspirante a Aprobado');
    }

    public function rechazado($id)
    {
        $aspirante = User::find($id);
        $aspirante->estatus = 'rechazado';
        $aspirante->form_status = 'pending';
        $aspirante->save();

        return redirect('/dashboard/aspirantes')->with('toast_success', 'Se actualizó el estado del aspirante a Rechazado');
    }

    public function updateMarcas(Request $request, $id){

        $request->validate([
            'marcaid' => 'required|string',
            'clienteid' => 'required|numeric',
        ]);

        $marcaID = $request->marcaid;
        $clienteID = $request->clienteid; //0,1,2,3

        $clienteUptM = User::find($id);

        $marcasUDT = "";

        if( $marcaID == '0'){

            if ( str_contains($clienteUptM->marcas, '0,') ) {
                $marcasUDT = strstr( $clienteUptM->marcas, '0,', true);
            }
            
            $clienteUptM->marcas = $marcasUDT;

            $clienteUptM->update();

            return response()->json(['success'=>'Successfully']);

        } elseif ( str_contains($clienteUptM->marcas, $marcaID) ) 
        {
            $marcasUDT = strstr( $clienteUptM->marcas, $marcaID, true);    

            $clienteUptM->marcas = $marcasUDT.",";  

            $clienteUptM->update();

            return response()->json(['success'=>'Successfully']);
        } else {

            $clienteUptM->marcas = $clienteUptM->marcas.",".$marcaID;

            $clienteUptM->update();

            return response()->json(['success'=>'Successfully']);
        }

    }

}


