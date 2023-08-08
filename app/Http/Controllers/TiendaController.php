<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\EstadoProducto;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productos = Producto::whereHas('marca', function($query){
            $query->where('estado', "Activo");
        })->paginate(12);

        //if ver si esta selecionado el filtro de categoria
        if($request->has('categoria')){
            $categoria_id = $request->input('categoria');
            
            $productos = Producto::where('categoria_id', $categoria_id)->paginate(12);
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

        return view('productos.productos-grid', compact('productos', 'categorias', 'marcas', 'estadoProductos', 'categoriaActual', 'categoriaActualname'));
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
    public function show($slug)
    {
        // $producto = Producto::find($id);
        $producto = Producto::where('slug', $slug)->firstOrFail();

        return view('productos.detalle-producto', compact('producto'));
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
}
