<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{

    public function index()
    {
        $cart = session()->get('cart', []);
        // dd($cart); 
        return view('carrito.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Producto::find($request->input('producto_id'));
        $cantidad = $request->input('cantidad');

        $cart = session()->get('cart', []);

        //validar que clasificacion tiene el cliente para poner un precio u otro
        if ($product->precio_oferta != null) {
            $precio = $product->precio_oferta;
        } elseif (Auth::user()->clasificacion == 'Cobre') {
            $precio = $product->precio_1;
        } elseif (Auth::user()->clasificacion == 'Plata') {
            $precio = $product->precio_1;
        } elseif (Auth::user()->clasificacion == 'Oro') {
            $precio = $product->precio_2;
        } elseif (Auth::user()->clasificacion == 'Platino') {
            $precio = $product->precio_3;
        } elseif (Auth::user()->clasificacion == 'Diamante') {
            $precio = $product->precio_oferta;
        } else if (Auth::user()->clasificacion == 'Taller') {
            $precio = $product->precio_taller;
        } else if (Auth::user()->clasificacion == 'Reparto') {
            $precio = $product->precio_distribuidor;
        }

        
        //validar si hay existencia del producto
        if ($product->existencia < $cantidad) {
            return redirect()->route('carrito.index')->with('toast_error', 'No hay existencia del producto ' . $product->nombre . '');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['cantidad'] += $cantidad;
        } else {
            $cart[$product->id] = [
                'producto_id' => $product->id,
                'nombre' => $product->nombre,
                'cantidad' => $cantidad,
                'precio_f' => $precio,
                'existencia' => $product->existencia,
                'unidad_caja' => $product->unidad_por_caja,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('carrito.index')->with('toast_success', 'Se agregó el producto ' . $product->nombre . '');
    }

    //funciona para actualizar la cantidad de productos en el carrito de compras sin cambiar de vista
    public function update(Request $request)
    {
        $product = Producto::find($request->input('producto_id'));
        $cantidad = $request->input('cantidad');

        $cart = session()->get('cart', []);

        //validar que clasificacion tiene el cliente para poner un precio u otro
        if ($product->precio_oferta != null) {
            $precio = $product->precio_oferta;
        } elseif (Auth::user()->clasificacion == 'Cobre') {
            $precio = $product->precio_1;
        } elseif (Auth::user()->clasificacion == 'Plata') {
            $precio = $product->precio_1;
        } elseif (Auth::user()->clasificacion == 'Oro') {
            $precio = $product->precio_2;
        } elseif (Auth::user()->clasificacion == 'Platino') {
            $precio = $product->precio_3;
        } elseif (Auth::user()->clasificacion == 'Diamante') {
            $precio = $product->precio_oferta;
        } else if (Auth::user()->clasificacion == 'Taller') {
            $precio = $product->precio_taller;
        } else if (Auth::user()->clasificacion == 'Reparto') {
            $precio = $product->precio_distribuidor;
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['cantidad'] = $cantidad;
        } else {
            $cart[$product->id] = [
                'producto_id' => $product->id,
                'nombre' => $product->nombre,
                'precio_f' => $precio,
                'cantidad' => $cantidad,
                'existencia' => $product->existencia,
                'unidad_caja' => $product->unidad_por_caja,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('carrito.index')->with('toast_success', 'Se actualizó la cantidad del producto ' . $product->nombre . '');
    }

    //funcion para vaciar el carrito de compras
    public function clear()
    {
        session()->forget('cart');
        return view('carrito.index');
    }

    //funciona para eliminar un producto del carrito de compras sin cambiar de vista
    public function delete(Request $request)
    {
        $product = Producto::find($request->input('producto_id'));

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('carrito.index')->with('toast_error', 'Se eliminó el producto ' . $product->nombre . '');
    }

    //funcion para validar el carrito de compras
    public function validar(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('carrito.index')->with('info', 'No hay productos en el carrito de compras');
        }

        return view('orden.index');
    }
}
