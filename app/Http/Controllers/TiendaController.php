<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\User;
use App\Models\EstadoProducto;

use App\Models\CMS;


class TiendaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //verificar el usuario en sesión
        $usr = auth()->User();

        $marcasAuto = $usr->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        //Busca y ordena productos al entrar desde el menú
        //pero 1ro valida si es un cliente
        if ( $usr->rol_id == 2) {

            $productos = Producto::whereHas('marca', function($query){
                $query->where('estado', "Activo");
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->get();
            $categorias = Categoria::all();
            //$categorias = Categoria::wherePivot('marca_id', 1)->get();

        } else {

            $productos = Producto::whereHas('marca', function($query){
                $query->where('estado', "Activo");
            })->paginate(1000000000);

            $marcas = Marca::all();
            $categorias = Categoria::all();

        }

        $cmsVars = CMS::get()->toArray();
        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        $categoriaActual = 0;
        $marcaActual = 0;

        //if ver si esta selecionado el filtro de marca
        if( $request->input('marca') > 0 && $request->input('categoria') == 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca
            
            //devuelve los productos según la marca seleccionada en filtro  
            $productos = Producto::where('marca_id', $marca_id)
                                 ->where('estado_producto_id', 1)
                                 ->whereNot('existencia', 0)
                                 ->paginate(1000000000);
            
            $marca = Marca::find($marca_id);

            //$categorias = $marca->Categoria()->get();

            $marcaActual = $request->input('marca');

            $categoriaActual = 0;

        } //if ver si esta selecionado el filtro de categoria
        elseif ( $request->input('categoria') > 0 && $request->input('marca') == 0 ){

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría
            
            //devuelve los productos según la categoria seleccionada en filtro   
            $productos = Producto::where('categoria_id', $categoria_id)
                                 ->where('estado_producto_id', 1)
                                 ->whereNot('existencia', 0)
                                 ->paginate(1000000000);

            $categoria = Categoria::find($categoria_id);

            //$marcas = $categoria->Marca()->get();

            $marcaActual = 0;
            $categoriaActual = $categoria_id; 

        } elseif ( $request->input('categoria') == 0 && $request->input('marca') == 0) {
            //$marcas = Marca::all();
            //$categorias = Categoria::all();
            $categoriaActual = 0;
            $marcaActual = 0;  
        }





        //if ver si esta selecionado el filtro busq por OEM
        if( $request->input('busq') != null || $request->input('busq') != '' ){

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('marca', function($query){
                    $query->where('estado', "Activo");
                })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

                $marcas = Marca::whereIn('id', $marcasAutorizadas)->get();
                $categorias = Categoria::all();
                //$categorias = Categoria::wherePivot('marca_id', 1)->get();

            } else {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('marca', function($query){
                    $query->where('estado', "Activo");
                })->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

                $marcas = Marca::all();
                $categorias = Categoria::all();
                $categoriaActual = 0;
                $marcaActual = 0;
            }    
        }


        $categoriaActualname = null;
        //obtener el nombre de la categoria actual para mostrarlo en el titulo de la pagina
        
        if($categoriaActual != null){
            $categoriaActualname = Categoria::find($categoriaActual);
        }else{
            $categoriaActualname = "Todas";
        }
          
        $estadoProductos = EstadoProducto::all();

        $productosDisponibles = $productos;

        return view('productos.productos-grid', compact('productos', 'productosDisponibles', 'categorias', 'marcas', 'marcaActual', 'estadoProductos', 'categoriaActual', 'categoriaActualname', 'cat_mod', 'mant_mod'));

    }


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCat(Request $request)
    {
        //verificar el usuario en sesión
        $usr = auth()->User();

        $marcasAuto = $usr->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        //Busca y ordena productos al entrar desde el menú
        //pero 1ro valida si es un cliente
        if ( $usr->rol_id == 2) {

            $productos = Producto::whereHas('marca', function($query){
                $query->where('estado', "Activo");
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->get();
            $categorias = Categoria::all();
            //$categorias = Categoria::wherePivot('marca_id', 1)->get();

        } else {

            $productos = Producto::whereHas('marca', function($query){
                $query->where('estado', "Activo");
            })->paginate(1000000000);

            $marcas = Marca::all();
            $categorias = Categoria::all();

        }

        $cmsVars = CMS::get()->toArray();
        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        $categoriaActual = 0;
        $marcaActual = 0;

        //if ver si esta selecionado el filtro de marca
        if( $request->input('marca') > 0 && $request->input('categoria') == 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca
            
            //devuelve los productos según la marca seleccionada en filtro  
            $productos = Producto::where('marca_id', $marca_id)
                                 ->where('estado_producto_id', 1)
                                 ->whereNot('existencia', 0)
                                 ->paginate(1000000000);
            
            $marca = Marca::find($marca_id);

            //$categorias = $marca->Categoria()->get();

            $marcaActual = $request->input('marca');

            $categoriaActual = 0;

        } //if ver si esta selecionado el filtro de categoria
        elseif ( $request->input('categoria') > 0 && $request->input('marca') == 0 ){

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría
            
            //devuelve los productos según la categoria seleccionada en filtro   
            $productos = Producto::where('categoria_id', $categoria_id)
                                 ->where('estado_producto_id', 1)
                                 ->whereNot('existencia', 0)
                                 ->paginate(1000000000);

            $categoria = Categoria::find($categoria_id);

            //$marcas = $categoria->Marca()->get();

            $marcaActual = 0;
            $categoriaActual = $categoria_id; 

        } elseif ( $request->input('categoria') == 0 && $request->input('marca') == 0) {
            //$marcas = Marca::all();
            //$categorias = Categoria::all();
            $categoriaActual = 0;
            $marcaActual = 0;  
        }


        $categoriaActualname = null;
        //obtener el nombre de la categoria actual para mostrarlo en el titulo de la pagina
        
        if($categoriaActual != null){
            $categoriaActualname = Categoria::find($categoriaActual);
        }else{
            $categoriaActualname = "Todas";
        }
          
        $estadoProductos = EstadoProducto::all();

        $productosDisponibles = $productos;

        return view('productos.catalogo', compact('productos', 'productosDisponibles', 'categorias', 'marcas', 'marcaActual', 'estadoProductos', 'categoriaActual', 'categoriaActualname', 'cat_mod', 'mant_mod'));
    }


    public function showByCategoria(Request $request)
    {
        $categoria_id = $request->input('categoria');

        if ($categoria_id == 0) {
            $productos = Producto::all();
        } else {
           $productos = Producto::where('categoria_id', $categoria_id)->get(); 
        }
        
        return view('productos.productos-grid')->with('productos', $productos);
    }


    public function showByMarca(Request $request)
    {
        $categoria_id = $request->input('categoria');
        $productos = Producto::where('categoria_id', $categoria_id)->get();

        return view('productos.productos-grid')->with('productos', $productos);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug) 
    {

        // $producto = Producto::find($id);
        //$producto = Producto::where('id', '=', $id)->get();
        $producto = Producto::where('id', $id)->firstOrFail();
        //$producto = Producto::where('slug', $slug)->firstOrFail();
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento
        
        return view('productos.detalle-producto', compact('producto', 'cat_mod', 'mant_mod'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProd($id, $slug)
    {
        // $producto = Producto::find($id);
        $producto = Producto::where('id', $id)->firstOrFail();
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento
        

        return view('productos.detalle-producto-cat', compact('producto', 'cat_mod', 'mant_mod'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function showCat(Request $request)
    {
        $productos = Producto::whereHas('marca', function($query){
            $query->where('estado', "activo");
        })->paginate(1000000000);

        //if ver si esta selecionado el filtro de categoria
        if($request->has('categoria')){
            $categoria_id = $request->input('categoria');
            
            $productos = Producto::where('categoria_id', $categoria_id)->paginate(1000000000);
        }

        $categoriaActual = $request->input('categoria');
        $categoriaActualname = null;
        //obtener el nombre de la categoria actual para mostrarlo en el titulo de la pagina
        
        if($categoriaActual != null){
            $categoriaActualname = Categoria::find($categoriaActual);
        }else{
            $categoriaActualname = "Todas";
        }

        $categorias = Categoria::all();
        $marcas = Marca::all();
        $estadoProductos = EstadoProducto::all();

        return view('productos.compra-masiva', compact('productos', 'categorias', 'marcas', 'estadoProductos', 'categoriaActual', 'categoriaActualname'));
    }


 
}
