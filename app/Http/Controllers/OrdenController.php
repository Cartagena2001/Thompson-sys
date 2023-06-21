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
        $orden->fecha_registro = date('Y-m-d');
        $orden->user_id = Auth::user()->id;
        $orden->estado = 'Pendiente'; //1er estado por defecto
        $orden->fecha_envio = date('Y-m-d', strtotime('+1 days'));
        $orden->fecha_entrega = date('Y-m-d', strtotime('+4 days'));
        $orden->total = 0;
        $orden->save();

        //guardar los productos de la orden detalle
        foreach ($cart as $producto) {
            $ordenDetalle = new OrdenDetalle();
            $ordenDetalle->orden_id = $orden->id;
            $ordenDetalle->producto_id = $producto['producto_id'];
            $ordenDetalle->cantidad = $producto['cantidad'];
            $ordenDetalle->precio = $producto['precio_1'];
            $ordenDetalle->descuento = 0;
            $ordenDetalle->save();

            //actualiza el stock del producto restando la cantidad comprada
            $producto = Producto::find($producto['producto_id']);
            $producto->existencia = $producto->existencia - $ordenDetalle->cantidad;
            $producto->save();
        }

        //actualizar el total de la orden
        foreach ($cart as $producto) {
            $orden->total = $orden->total + ($producto['precio_1'] * $producto['cantidad'] * $producto['unidad_caja']);
        }
        $orden->save();

        session()->forget('cart');

        return view('orden.gracias');
    }
}
