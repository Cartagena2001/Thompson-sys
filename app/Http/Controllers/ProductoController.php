<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\EstadoProducto;
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
        ]);

        //almacenar datos
        $reg = new Producto();

        $reg->OEM = $request->get('OEM');
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
        if ($request->hasFile('hoja_seguridad')) {
            $file = $request->file('hoja_seguridad');
            $file->move(public_path() . '/assets/pdf/productos/', $file->getClientOriginalName());
            $reg->hoja_seguridad = '/assets/pdf/productos/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('ficha_tecnica_href')) {
            $file = $request->file('ficha_tecnica_href');
            $file->move(public_path() . '/assets/pdf/productos/', $file->getClientOriginalName());
            $reg->ficha_tecnica_href = '/assets/pdf/productos/' . $file->getClientOriginalName();
        }
        
        //subir archivos imagenes
        if ($request->hasFile('imagen_1_src')) {
            $file = $request->file('imagen_1_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_1_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_2_src')) {
            $file = $request->file('imagen_2_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_2_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_3_src')) {
            $file = $request->file('imagen_3_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_3_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_4_src')) {
            $file = $request->file('imagen_4_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_4_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_5_src')) {
            $file = $request->file('imagen_5_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_5_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_6_src')) {
            $file = $request->file('imagen_6_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $reg->imagen_6_src = '/assets/img/products/' . $file->getClientOriginalName();
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
        ]);

        //almacenar datos
        $producto->OEM = $request->get('OEM');
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
        if ($request->hasFile('hoja_seguridad')) {
            $file = $request->file('hoja_seguridad');
            $file->move(public_path() . '/assets/pdf/productos/', $file->getClientOriginalName());
            $producto->hoja_seguridad = '/assets/pdf/productos/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('ficha_tecnica_href')) {
            $file = $request->file('ficha_tecnica_href');
            $file->move(public_path() . '/assets/pdf/productos/', $file->getClientOriginalName());
            $producto->ficha_tecnica_href = '/assets/pdf/productos/' . $file->getClientOriginalName();
        }

        //subir archivos imagenes
        if ($request->hasFile('imagen_1_src')) {
            $file = $request->file('imagen_1_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_1_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_2_src')) {
            $file = $request->file('imagen_2_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_2_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_3_src')) {
            $file = $request->file('imagen_3_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_3_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_4_src')) {
            $file = $request->file('imagen_4_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_4_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_5_src')) {
            $file = $request->file('imagen_5_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_5_src = '/assets/img/products/' . $file->getClientOriginalName();
        }
        if ($request->hasFile('imagen_6_src')) {
            $file = $request->file('imagen_6_src');
            $file->move(public_path() . '/assets/img/products/', $file->getClientOriginalName());
            $producto->imagen_6_src = '/assets/img/products/' . $file->getClientOriginalName();
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
