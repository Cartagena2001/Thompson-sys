<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\User;
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
        if ( $request->input('producto_id') != null ) {
            $product = Producto::find($request->input('producto_id'));
        } else {
            $product = Producto::find($request->producto_id); //viene de compra masiva y cat img
        }

        if ( $request->input('cantidad') != null ) {
           $cantidad = $request->input('cantidad');
        } else {
           $cantidad = $request->cantidad; //viene de compra masiva y cat img
        }
         

        $cart = session()->get('cart', []);

        $detalleFloat = session()->get('detalle', []); //creamos array para el detalle

        $brandsAvail = Marca::all(); //extraer marcas disponibles

        //validar que clasificacion tiene el cliente para poner un precio u otro
        if ($product->precio_oferta != null || $product->precio_oferta != 0 ) {
            
            $precio = $product->precio_oferta;
            //echo '<script> console.log("precio: '. $precio.' "); </script>';

        } elseif (Auth::user()->clasificacion == 'taller') {

            $precio = $product->precio_taller;

        } elseif (Auth::user()->clasificacion == 'distribuidor') {

            $precio = $product->precio_distribuidor;

        } elseif (Auth::user()->clasificacion == 'precioCosto') {

            $precio = $product->precio_1;

        } elseif (Auth::user()->clasificacion == 'precioOp') {

            $precio = $product->precio_2;
        }

        //asignamos el ID de la marca
        $marcaid = $product->marca->id;


        if ($cantidad <= 0) {

            if (isset($cart[$product->id])) {
                unset($cart[$product->id]);
            }

            session()->put('cart', $cart);

        } elseif ($product->existencia < $cantidad) {
           //validar si hay existencia del producto

            if ($product->existencia > 0) {
             
                //si no hay suficiente lo agrega igualmente al carrito pero modifica cantidad requerida según existencias
                $cantidad = $product->existencia;
                $montopm = $precio * $cantidad * $product->unidad_por_caja;


                foreach ( $brandsAvail as $brandA ) {

                    if ( $product->marca->nombre == $brandA->nombre ) {
                        
                        if (isset($detalleFloat[$marcaid])) {
                             $detalleFloat[$marcaid]['cantidad'] = $cantidad;
                             $detalleFloat[$marcaid]['monto'] = $montopm;
                        } else {
                            $detalleFloat[$marcaid] = [
                                'marca_id' => $product->marca->id,
                                'nombre' => $product->marca->nombre,
                                'cantidad' => $cantidad,
                                'monto' => $montopm,

                            ];
                        }
                    }

                }//end foreach

                if (isset($cart[$product->id])) {
                    $cart[$product->id]['cantidad'] = $cantidad;
                } else {
                    $cart[$product->id] = [
                        'producto_id' => $product->id,
                        'producto_oem' => $product->oem,
                        'nombre' => $product->nombre,
                        'marca_id' => $product->marca->id,
                        'marca' => $product->marca->nombre,
                        'cantidad' => $cantidad,
                        'precio_f' => $precio,
                        'existencia' => $product->existencia,
                        'unidad_caja' => $product->unidad_por_caja,
                    ];
                }

                session()->put('cart', $cart);
                session()->put('detalle', $detalleFloat);

                return redirect()->route('carrito.index')->with('toast_error', 'No hay existencia suficiente del producto: ' . $product->nombre . 'para cubrir dicha demanda.');

            } else {

               return redirect()->route('carrito.index')->with('toast_error', 'No hay existencias del producto: ' . $product->nombre . ''); 
            }

        } else {

            //si hay suficiente lo agrega al carrito
            $montopm = $precio * $cantidad * $product->unidad_por_caja;

            if (isset($cart[$product->id])) {
                $cart[$product->id]['cantidad'] = $cantidad;
            } else {
                $cart[$product->id] = [
                    'producto_id' => $product->id,
                    'producto_oem' => $product->oem,
                    'nombre' => $product->nombre,
                    'marca_id' => $product->marca->id,
                    'marca' => $product->marca->nombre,
                    'cantidad' => $cantidad,
                    'precio_f' => $precio,
                    'existencia' => $product->existencia,
                    'unidad_caja' => $product->unidad_por_caja,
                ];
            }

            foreach ( $brandsAvail as $brandA ) {

                if ( $product->marca->nombre == $brandA->nombre ) {
                    
                    
                    if (isset($detalleFloat[$marcaid])) {
                         $detalleFloat[$marcaid]['cantidad'] = $cantidad;
                         $detalleFloat[$marcaid]['monto'] = $montopm;
                    } else {
                        $detalleFloat[$marcaid] = [
                            'marca_id' => $product->marca->id,
                            'nombre' => $product->marca->nombre,
                            'cantidad' => $cantidad,
                            'monto' => $montopm,

                        ];
                    }
                    
               }

            }//end foreach

            session()->put('cart', $cart);
            session()->put('detalle', $detalleFloat);

            return redirect()->route('carrito.index')->with('toast_success', 'Se agregó el producto: ' . $product->nombre . '');
        }
  
    }


    //funciona para actualizar la cantidad de productos en el carrito de compras sin cambiar de vista
    public function update(Request $request)
    {
        $product = Producto::find($request->input('producto_id'));
        $cantidad = $request->input('cantidad');

        $cart = session()->get('cart', []);


        if ($cantidad > $product->existencia) {

            $cart[$product->id]['cantidad'] = $product->existencia;
      
            session()->put('cart', $cart);

            return redirect()->route('carrito.index')->with('toast_success', 'La cantidad requerida de ' . $product->nombre . 'no puede suplirse.');
        } else {

            //validar que clasificacion tiene el cliente para poner un precio u otro
            if ($product->precio_oferta != null) {
                
                $precio = $product->precio_oferta;

            } elseif (Auth::user()->clasificacion == 'taller') {

                $precio = $product->precio_taller;

            } elseif (Auth::user()->clasificacion == 'distribuidor') {

                $precio = $product->precio_distribuidor;

            } elseif (Auth::user()->clasificacion == 'precioCosto') {

                $precio = $product->precio_1;

            } elseif (Auth::user()->clasificacion == 'precioOp') {

                $precio = $product->precio_2;
            } 

            if (isset($cart[$product->id])) {

                $cart[$product->id]['cantidad'] = $cantidad;

            } else {

                $cart[$product->id] = [
                    'producto_id' => $product->id,
                    'nombre' => $product->nombre,
                    'marca_id' => $product->marca->id,
                    'marca' => $product->marca->nombre,
                    'precio_f' => $precio,
                    'cantidad' => $cantidad,
                    'existencia' => $product->existencia,
                    'unidad_caja' => $product->unidad_por_caja,
                ];
            }

            session()->put('cart', $cart);

            return redirect()->route('carrito.index')->with('toast_success', 'Se actualizó la cantidad del producto ' . $product->nombre . '');

        }
    }


    //funcion para vaciar el carrito de compras
    public function clear()
    {
        session()->forget('cart');
        session()->forget('detalle');

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
        $usuarios = User::where('estatus', '=', 'aprobado')->orWhere('estatus', '=', 'otro')->get();

/*
        $request->validate([
            'marca'          => 'required',
            'cliente'         => 'required|email',
            //'mobile'        => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

        ]);
*/
        if (count($cart) == 0) {
            return redirect()->route('carrito.index')->with('info', 'No hay productos en el carrito de compras');
        } else {

            //validar cantidades de producto requeridas respecto de la existencia
            foreach ($cart as $producto) {
                
                $producto_id = $producto['producto_id'];
                $cantidad = $producto['cantidad']; //cantidad de cajas de X producto ordenada
                $precio = $producto['precio_f'] * $producto['unidad_caja']; //precio por caja
                $descuento = 0; //registro de algùn descuento aplicado

                //Verifica si cantidad seleccionada puede cubrirse con existencia
                $productostock = Producto::find($producto['producto_id']);
                $existencia = $productostock->existencia;

                if ( $cantidad > $existencia) {

                    $cart[$producto_id]['cantidad'] = $existencia;
                    session()->put('cart', $cart);

                    return redirect()->route('carrito.index')->with('info', 'No hay existencias suficientes para cubrir tu órden de: '.'<br/><br/>'.$producto['nombre']);
                } 

            }

            return view('orden.index', compact('usuarios'));
        }
    }

//fin clase
}
