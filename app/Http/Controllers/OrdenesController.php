<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\User;

class OrdenesController extends Controller
{
    public function index()
    {
        $ordenes = Orden::Paginate();
        $users = User::all();
        return view('ordenes.index' , compact('ordenes' , 'users'));
    }

    
    public function show($id){
        $orden = Orden::find($id);
        //buscar el deatalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }
        return view('ordenes.show' , compact('orden', 'detalle'));
    }

    //crear una funcion para actualizar el estado de la orden a en proceso
    public function enProceso($id){
        $orden = Orden::find($id);
        $orden->estado = 'En proceso';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizo la orden a En proceso');
    }

    //crear una funcion para actualizar el estado de la orden a finalizada
    public function finalizada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Finalizada';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizo la orden a Finalizada');
    }

    //crear una funcion para actualizar el estado de la orden a cancelada
    public function cancelada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Cancelada';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizo la orden a Cancelada');
    }

}
