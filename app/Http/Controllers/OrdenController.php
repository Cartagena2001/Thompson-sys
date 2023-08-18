<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    public function index()
    {
        return view('orden.index');
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $orden = new Orden();

        if ( $request->get('cliente_id_compra') != " " ) { 

            $orden->user_id = $request->get('cliente_id_compra');  //se asigna la orden al usuario seleccionado por el admin
        } else {
            $orden->user_id = Auth::user()->id; //se asigna la orden al usuario en sesión
        }

        $orden->fecha_registro = \Carbon\Carbon::now()->toDateTimeString();
        $orden->estado = 'Pendiente'; //1er estado por defecto
        $orden->visto = 'nuevo'; //1er estado, antes de ser vista en el menú
        $orden->fecha_envio = \Carbon\Carbon::now()->addDays(1)->toDateTimeString();
        $orden->fecha_entrega = \Carbon\Carbon::now()->addDays(4)->toDateTimeString();
        $orden->total = 0;

        $orden->save();

        //guardar los productos de la orden detalle
        foreach ($cart as $producto) {
            
            $ordenDetalle = new OrdenDetalle();

            $ordenDetalle->orden_id = $orden->id;
            $ordenDetalle->producto_id = $producto['producto_id'];
            $ordenDetalle->cantidad = $producto['cantidad']; //cantidad de cajas de X producto ordenada
            $ordenDetalle->precio = $producto['precio_f'] * $producto['unidad_caja']; //guardar precio por caja
            $ordenDetalle->descuento = 0; //registro de algùn descuento aplicado

            $ordenDetalle->save();

            //actualiza el stock del producto restando la cantidad comprada
            $productostock = Producto::find($producto['producto_id']);
            $productostock->existencia = $productostock->existencia - $ordenDetalle->cantidad;

            $productostock->save();
        }

        //actualizar el total de la orden
        foreach ($cart as $producto) {
            $orden->total = $orden->total + ($producto['precio_f'] * $producto['cantidad'] * $producto['unidad_caja']);
        }
        
        $orden->save();

        session()->forget('cart');

        return view('orden.gracias');
    }
}
