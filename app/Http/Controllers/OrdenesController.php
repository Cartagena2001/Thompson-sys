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
        $ordenes = Orden::Paginate(1000000000);
        $users = User::all();

        return view('ordenes.index' , compact('ordenes' , 'users'));
    }

    
    public function show($id){

        $orden = Orden::find($id);

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        $orden->visto = 'visto';
        $orden->update();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show' , compact('orden', 'detalle'));
    }

    public function upload(Request $request, $id){

        //validar los datos
        $request->validate([

            'corr' => 'string|min:1|max:24',
            'notas' => 'string|max:250',
            'ubicacion' => 'string|max:19'

        ]);

        $orden = Orden::find($id);

        //almacenar datos
        if ($request->hasFile('factura_href')) {
            $file = $request->file('factura_href');
            $file->move(public_path() . '/assets/img/cifs/', $file->getClientOriginalName());
            $orden->factura_href = '/assets/img/cifs/' . $file->getClientOriginalName();
        }

        $orden->corr = $request->get('corr');
        $orden->notas = $request->get('notas');
        $orden->ubicacion = $request->get('ubicacion');
        
        $orden->update();

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        //$orden->save();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show' , compact('orden', 'detalle'));
    }

    public function uploadBod(Request $request, $id){

        //validar los datos
        $request->validate([

            'notas_bodega' => 'string|max:250',
            'bulto' => 'string|max:9',
            'paleta' => 'string|max:9',

        ]);

        $orden = Orden::find($id);

        //almacenar datos
        if ($request->hasFile('hoja_salida_href')) {
            $file = $request->file('hoja_salida_href');
            $file->move(public_path() . '/assets/img/hojas_sal/', $file->getClientOriginalName());
            $orden->hoja_salida_href = '/assets/img/hojas_sal/' . $file->getClientOriginalName();
        }

        $orden->notas_bodega = $request->get('notas_bodega');
        $orden->bulto = $request->get('bulto');
        $orden->paleta = $request->get('paleta');
        
        $orden->update();

        //buscar el detalle de la orden
        $detalle = OrdenDetalle::where('orden_id' , $id)->get();

        //$orden->save();
        
        //ahora buscar el producto de cada detalle
        foreach($detalle as $item){
            $item->producto = $item->Producto;
        }

        return view('ordenes.show' , compact('orden', 'detalle'));
    }

    //crear una funcion para actualizar el estado de la orden a en proceso
    public function enProceso($id){

        $orden = Orden::find($id);
        $orden->estado = 'Proceso';
        $orden->save();

        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la órden a En Proceso');
    }

    //crear una funcion para actualizar el estado de la orden a preparada
    public function preparada($id){
        
        $orden = Orden::find($id);
        $orden->estado = 'Preparada';
        $orden->save();

        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la órden a Preparada');
    }

    //crear una funcion para actualizar el estado de la orden a en espera
    public function enEspera($id){
        
        $orden = Orden::find($id);
        $orden->estado = 'Espera';
        $orden->save();

        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la órden a En Espera');
    }

    //crear una funcion para actualizar el estado de la orden a pagada
    public function pagada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Pagada';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la órden a Pagada');
    }

    //crear una funcion para actualizar el estado de la orden a finalizada
    public function finalizada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Finalizada';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la órden a Finalizada');
    }

    //crear una funcion para actualizar el estado de la orden a cancelada
    public function cancelada($id){
        $orden = Orden::find($id);
        $orden->estado = 'Cancelada';
        $orden->save();
        return redirect('/dashboard/ordenes')->with('toast_success', 'Se actualizó el estado de la orden a Cancelada');
    }

}
