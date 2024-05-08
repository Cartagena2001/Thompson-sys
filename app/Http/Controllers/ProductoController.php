<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\EstadoProducto;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Imports\ProductoImport;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //paginate
        $productos = Producto::paginate(1000000000);

        $categorias = Categoria::all();
        $marcas = Marca::all();
        $estadoProductos = EstadoProducto::all();

        return view('productos.index', compact('productos', 'categorias', 'marcas', 'estadoProductos'));
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();

        //relacionar con el modelo de categoria
        $categorias = Categoria::pluck('nombre', 'id');

        //relaciomar con el modelo de marca
        $marcas = Marca::pluck('nombre', 'id');

        //relacionar con el modelo de estado producto
        $estadoProductos = EstadoProducto::pluck('estado', 'id');
        
        return view('productos.create', compact('producto', 'categorias', 'marcas', 'estadoProductos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validar campos
        request()->validate([
            'OEM'   => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'marca_id' => 'required',
            'fecha_ingreso' => 'required',
            'mod_venta' => 'required|string',
            'origen' => 'required',
            'categoria_id' => 'required',
            'garantia' => 'required',
            'unidad_por_caja' => 'required',
            'existencia' => 'required|numeric',
            'existencia_limite' => 'required|numeric',
            'estado_producto_id' => 'required|numeric',
            //'volumen' => 'numeric',
            //'peso' => 'numeric',
            'precio_distribuidor' => 'required|numeric',
            //'precio_taller' => 'required|numeric',
            'hoja_seguridad' => 'mimetypes:application/pdf|max:15000',
            'ficha_tecnica_href' => 'mimetypes:application/pdf|max:15000',
            'imagen_1_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_2_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_3_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_4_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_5_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_6_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
        ]);

        //almacenar datos
        $reg = new Producto();

        // Quita espacios y los sustituye por "-" y luego quita caracteres especiales
        $reg->OEM = $request->get('OEM');
        $productoOEM = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->get('OEM'))); 

        $reg->nombre = $request->get('nombre');
        $reg->setSlugAttribute($request->get('nombre'));
        $reg->lote = $request->get('lote');
        $reg->marca_id = $request->get('marca_id');
        $reg->descripcion = $request->get('descripcion');
        $reg->origen = $request->get('origen');
        $reg->caracteristicas = $request->get('caracteristicas');
        $reg->categoria_id = $request->get('categoria_id');
        $reg->sku = $request->get('sku');

        //si no manda la fecha de ingreso se le asigna la fecha actual
        if ($request->get('fecha_ingreso') == null) {
            $reg->fecha_ingreso = Carbon::today()->toDateString();
        } else {
            $reg->fecha_ingreso = $request->get('fecha_ingreso');  
        }

        $reg->garantia = $request->get('garantia');
        $reg->unidad_por_caja = $request->get('unidad_por_caja');
        $reg->mod_venta = $request->get('mod_venta');

        //si no manda el estado del producto se le asgina 1
        if ($request->get('estado_producto_id') == null) {
            $reg->estado_producto_id = 1;
        } else {
            $reg->estado_producto_id = $request->get('estado_producto_id');
        }

        $reg->existencia = $request->get('existencia');
        $reg->existencia_limite = $request->get('existencia_limite');
        $reg->ref_1 = $request->get('ref_1');
        $reg->ref_2 = $request->get('ref_2');
        $reg->ref_3 = $request->get('ref_3');

        //si no manda la etiqueta destacado se le asigna 0
        if ($request->get('etiqueta_destacado') == null) {
            $reg->etiqueta_destacado = 0;
        } else {
            $reg->etiqueta_destacado = $request->get('etiqueta_destacado');
        }
        
        $reg->precio_distribuidor = $request->get('precio_distribuidor');
        $reg->precio_taller = $request->get('precio_taller');
        $reg->precio_1 = $request->get('precioCosto'); //precioCosto
        $reg->precio_2 = $request->get('precioop'); //precioop
        $reg->precio_3 = null; //sobra
        $reg->precio_oferta = $request->get('precio_oferta');
        
        $reg->volumen = $request->get('volumen');
        $reg->unidad_volumen = $request->get('unidad_volumen');
        $reg->peso = $request->get('peso');
        $reg->unidad_peso = $request->get('unidad_peso');
        
        //subir archivos pdf
        //subir hoja de seguridad
        if ($request->hasFile('hoja_seguridad')) {
            
            if ($request->file('hoja_seguridad')->isValid()){

                $file = $request->file('hoja_seguridad');

                $nombreHS = $productoOEM.'-hoja-de-seguridad-'.'.'.$file->extension();

                $path = $file->storeAs('/public/assets/pdf/productos/', $nombreHS);

                $reg->hoja_seguridad = $nombreHS;  

            } else {

                return redirect()->route('productos.create')->with('success', 'Ha ocurrido un error al cargar la hoja de seguridad');
            }

        }

        //subir ficha tecnica
        if ($request->hasFile('ficha_tecnica_href')) {

            if ($request->file('ficha_tecnica_href')->isValid()){

                $file = $request->file('ficha_tecnica_href');

                $nombreFT = $productoOEM.'-ficha-tecnica-'.'.'.$file->extension();

                $path = $file->storeAs('/public/assets/pdf/productos/', $nombreFT);

                $reg->ficha_tecnica_href = $nombreFT;  

            } else {

                return redirect()->route('productos.create')->with('success', 'Ha ocurrido un error al cargar la ficha técnica');
            }

        }
        
        //subir archivos imagenes

        if ($request->hasFile('imagen_1_src')) {
            
            if ($request->file('imagen_1_src')->isValid()){
                
                $file = $request->file('imagen_1_src');

                $nombreIMG1 = $productoOEM.'-img-1-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG1);

                $reg->imagen_1_src = $nombreIMG1;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-1');
            }

        }

        if ($request->hasFile('imagen_2_src')) {
            
            if ($request->file('imagen_2_src')->isValid()){
                
                $file = $request->file('imagen_2_src');

                $nombreIMG2 = $productoOEM.'-img-2-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG2);

                $reg->imagen_2_src = $nombreIMG2;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-2');
            }

        }

        if ($request->hasFile('imagen_3_src')) {
            
            if ($request->file('imagen_3_src')->isValid()){
                
                $file = $request->file('imagen_3_src');

                $nombreIMG3 = $productoOEM.'-img-3-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG3);

                $reg->imagen_3_src = $nombreIMG3;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-3');
            }

        }

        if ($request->hasFile('imagen_4_src')) {
            
            if ($request->file('imagen_4_src')->isValid()){
                
                $file = $request->file('imagen_4_src');

                $nombreIMG4 = $productoOEM.'-img-4-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG4);

                $reg->imagen_4_src = $nombreIMG4;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-4');
            }

        }

        if ($request->hasFile('imagen_5_src')) {
            
            if ($request->file('imagen_5_src')->isValid()){
                
                $file = $request->file('imagen_5_src');

                $nombreIMG5 = $productoOEM.'-img-5-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG5);

                $reg->imagen_5_src = $nombreIMG5;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-5');
            }

        }

        if ($request->hasFile('imagen_6_src')) {
            
            if ($request->file('imagen_6_src')->isValid()){
                
                $file = $request->file('imagen_6_src');

                $nombreIMG6 = $productoOEM.'-img-6-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG6);

                $reg->imagen_6_src = $nombreIMG6;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-6');
            }

        }

        $reg->save();
        
        //return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
        //return redirect()->route('tienda.show', [$reg->id, $reg->slug])->with('success', 'Producto creado exitosamente');
        return redirect()->route('productos.edit', $reg->id)->with('success', 'Producto creado exitosamente');
    }

    //funcion para importar productos
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx'
        ]);
    
        $file = $request->file('import_file');

        Excel::import(new ProductoImport, $file);

        return redirect()->route('productos.index')->with('success', 'Productos importados exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);

        $categorias = Categoria::pluck('nombre', 'id');
        $marcas = Marca::pluck('nombre', 'id');
        $estadoProductos = EstadoProducto::pluck('estado', 'id');

        return view('productos.edit', compact('producto', 'categorias', 'marcas', 'estadoProductos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        request()->validate([
            'OEM'   => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'marca_id' => 'required',
            'fecha_ingreso' => 'required',
            'mod_venta' => 'required|string',
            'origen' => 'required',
            'categoria_id' => 'required',
            'garantia' => 'required',
            'unidad_por_caja' => 'required',
            'existencia' => 'required|numeric',
            'existencia_limite' => 'required|numeric',
            'estado_producto_id' => 'required|numeric',
            //'volumen' => 'numeric',
            //'peso' => 'numeric',
            'precio_distribuidor' => 'required|numeric',
            //'precio_taller' => 'required|numeric',
            'hoja_seguridad' => 'mimetypes:application/pdf|max:15000',
            'ficha_tecnica_href' => 'mimetypes:application/pdf|max:15000',
            'imagen_1_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_2_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_3_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_4_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_5_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
            'imagen_6_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
        ]);

        //almacenar datos
        
        // Quita espacios y los sustituye por "-" y luego quita caracteres especiales
        $producto->OEM = $request->get('OEM');
        $productoOEM = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->get('OEM')));

        $producto->lote = $request->get('lote');
        $producto->nombre = $request->get('nombre');
        $producto->marca_id = $request->get('marca_id');
        $producto->descripcion = $request->get('descripcion');
        $producto->origen = $request->get('origen');
        $producto->caracteristicas = $request->get('caracteristicas');
        $producto->categoria_id = $request->get('categoria_id');
        $producto->sku = $request->get('sku');
        $producto->fecha_ingreso = $request->get('fecha_ingreso');
        $producto->garantia = $request->get('garantia'); 
        $producto->unidad_por_caja = $request->get('unidad_por_caja'); 
        $producto->mod_venta = $request->get('mod_venta'); 
        $producto->estado_producto_id = $request->get('estado_producto_id');
        $producto->existencia = $request->get('existencia');
        $producto->existencia_limite = $request->get('existencia_limite');
        $producto->ref_1 = $request->get('ref_1');
        $producto->ref_2 = $request->get('ref_2');
        $producto->ref_3 = $request->get('ref_3');
        $producto->etiqueta_destacado = $request->get('etiqueta_destacado');

        $producto->precio_distribuidor = $request->get('precio_distribuidor');
        $producto->precio_taller = $request->get('precio_taller');
        $producto->precio_1 = $request->get('precioCosto'); //precioCosto
        $producto->precio_2 = $request->get('precioop'); //precioop
        $producto->precio_3 = null; //sobrante
        $producto->precio_oferta = $request->get('precio_oferta');  

        $producto->volumen = $request->get('volumen');
        $producto->unidad_volumen = $request->get('unidad_volumen');
        $producto->peso = $request->get('peso');
        $producto->unidad_peso = $request->get('unidad_peso');


        //subir archivos pdf
        //subir hoja de seguridad
        if ($request->hasFile('hoja_seguridad')) {
            
            if ($request->file('hoja_seguridad')->isValid()){

                $file = $request->file('hoja_seguridad');

                $nombreHS = $productoOEM.'-hoja-de-seguridad-'.'.'.$file->extension();

                $path = $file->storeAs('/public/assets/pdf/productos/', $nombreHS);

                $producto->hoja_seguridad = $nombreHS;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la hoja de seguridad');
            }

        }


        //subir ficha tecnica
        if ($request->hasFile('ficha_tecnica_href')) {

            if ($request->file('ficha_tecnica_href')->isValid()){

                $file = $request->file('ficha_tecnica_href');

                $nombreFT = $productoOEM.'-ficha-tecnica-'.'.'.$file->extension();

                $path = $file->storeAs('/public/assets/pdf/productos/', $nombreFT);

                $producto->ficha_tecnica_href = $nombreFT;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la ficha técnica');
            }

        }


        //subir archivos imagenes

        if ($request->hasFile('imagen_1_src')) {
            
            if ($request->file('imagen_1_src')->isValid()){
                
                $file = $request->file('imagen_1_src');

                $nombreIMG1 = $productoOEM.'-img-1-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG1);

                $producto->imagen_1_src = $nombreIMG1;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-1');
            }

        }

        if ($request->hasFile('imagen_2_src')) {
            
            if ($request->file('imagen_2_src')->isValid()){
                
                $file = $request->file('imagen_2_src');

                $nombreIMG2 = $productoOEM.'-img-2-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG2);

                $producto->imagen_2_src = $nombreIMG2;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-2');
            }

        }

        if ($request->hasFile('imagen_3_src')) {
            
            if ($request->file('imagen_3_src')->isValid()){
                
                $file = $request->file('imagen_3_src');

                $nombreIMG3 = $productoOEM.'-img-3-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG3);

                $producto->imagen_3_src = $nombreIMG3;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-3');
            }

        }

        if ($request->hasFile('imagen_4_src')) {
            
            if ($request->file('imagen_4_src')->isValid()){
                
                $file = $request->file('imagen_4_src');

                $nombreIMG4 = $productoOEM.'-img-4-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG4);

                $producto->imagen_4_src = $nombreIMG4;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-4');
            }

        }

        if ($request->hasFile('imagen_5_src')) {
            
            if ($request->file('imagen_5_src')->isValid()){
                
                $file = $request->file('imagen_5_src');

                $nombreIMG5 = $productoOEM.'-img-5-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG5);

                $producto->imagen_5_src = $nombreIMG5;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-5');
            }

        }

        if ($request->hasFile('imagen_6_src')) {
            
            if ($request->file('imagen_6_src')->isValid()){
                
                $file = $request->file('imagen_6_src');

                $nombreIMG6 = $productoOEM.'-img-6-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/products/', $nombreIMG6);

                $producto->imagen_6_src = $nombreIMG6;  

            } else {

                return redirect()->route('productos.edit')->with('success', 'Ha ocurrido un error al cargar la img-6');
            }

        }

        $producto->update();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }



    public function updateUbiBO(Request $request)
    {
        request()->validate([
            'ubicacionBod'   => 'required|string',
            'producto_id' => 'required|string',
        ]);

        $productoID = trim(strstr( $request->producto_id, "_" ), "_");
        
        $producto = Producto::find($productoID);

        //almacenar datos
        $producto->ubicacion_bodega = $request->ubicacionBod;

        $producto->update();

        //return view('ordenes.show')->with('success');
    }

    public function updateUbiOF(Request $request)
    {
        request()->validate([
            'ubicacionOf'   => 'required|string',
            'producto_id' => 'required|string',
        ]);

        $productoID = trim(strstr( $request->producto_id, "_" ), "_");

        $producto = Producto::find($productoID);

        //almacenar datos
        $producto->ubicacion_oficina = $request->ubicacionOf;

        $producto->update();

        //return view('ordenes.show')->with('success');
    }

    public function updateCantD(Request $request)
    {
        request()->validate([
            'cantidad_despachada'   => 'required|string',
            'producto_id' => 'required|string',
            'ordend_id' => 'required|string',
        ]);

        $productoID = trim(strstr( $request->producto_id, "_" ), "_");

        $ordenDID = trim(strstr( $request->ordend_id, "_" ), "_");

        //return response()->json("producto ID: ".$productoID." orden ID: ".$ordenDID);

        $ordenDet = OrdenDetalle::find($ordenDID);

        $prodOrdd = OrdenDetalle::where('orden_id', $ordenDet->orden_id)->get();
        
        $orden =  Orden::find($ordenDet->orden_id);

        $cantidadDespachada = 0;

        //return response()->json("cantidad_despachada: ".$ordenDet->cantidad_despachada);

        //validar la cantidad despachada
        if ( $request->cantidad_despachada < 0 ) {

            $cantidadDespachada = 0;
            $ordenDet->cantidad_despachada = $cantidadDespachada;
            $ordenDet->update();

        } elseif ( $request->cantidad_despachada > $ordenDet->cantidad) {
            
            $cantidadDespachada = $ordenDet->cantidad;
            $ordenDet->cantidad_despachada = $cantidadDespachada;
            $ordenDet->update();

        } else {

            $ordenDet->cantidad_despachada = $request->cantidad_despachada;
            $ordenDet->update();

        }

        $totalN = 0;

        //actualizar el total de la orden
        foreach ($prodOrdd as $producto) {
            
            if ( is_null($producto->cantidad_despachada) ) {
                $totalN = $totalN + ($producto->cantidad_despachada * $producto->precio);
            } else {
                $totalN = $totalN + ($producto->cantidad * $producto->precio);
            }
            
        }

        //$orden->total = $totalN;
        //$orden->update(); 

        return response()->json($ordenDet->cantidad_despachada);
    }

    public function updateNb(Request $request)
    {
        request()->validate([
            'n_bulto'   => 'required|string',
            'producto_id' => 'required|string',
            'ordend_id' => 'required|string',
        ]);

        $productoID = trim(strstr( $request->producto_id, "_" ), "_");

        $ordenDID = trim(strstr( $request->ordend_id, "_" ), "_");

        $ordenDet = OrdenDetalle::find($ordenDID);

        //almacenar datos
        $ordenDet->n_bulto = $request->n_bulto;

        $ordenDet->update();

        return response()->json($ordenDet->n_bulto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $producto = Producto::find($id)->delete();
        //buscar imagenes del producto por su id para eliminarlas
        // $filename = public_path() . $producto->imagen_1_src;
        // File::delete($filename);
        // $filename = public_path() . $producto->imagen_2_src;
        // File::delete($filename);
        // $filename = public_path() . $producto->imagen_3_src;
        // File::delete($filename);
        // $filename = public_path() . $producto->imagen_4_src;
        // File::delete($filename);
        // $filename = public_path() . $producto->ficha_tecnica_herf;
        // File::delete($filename);
        $producto = Producto::findOrfail($id);

        $path = 'assets/pdf/productos/'.$producto->hoja_seguridad;
        
        if (File::exists($path)) {
            File::delete($path);
        }

        $path = 'assets/pdf/productos/'.$producto->ficha_tecnica_href;
        
        if (File::exists($path)) {
            File::delete($path);
        }
        
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
