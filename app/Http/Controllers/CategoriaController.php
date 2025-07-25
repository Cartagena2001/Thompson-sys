<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Marca;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //paginate
        $categorias = Categoria::paginate(1000000000);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = new Categoria();
        $marcas = Marca::all();
        //$marcas = Marca::where('estado', '=', 'Activo')->get();

        $marcasAsoc = [];

        return view('categorias.create', compact('categoria', 'marcas', 'marcasAsoc'));
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
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'marcasCategoria' => 'required'
        ]);

        //almacenar datos
        $categoria = new Categoria();

        $categoria->nombre = $request->get('nombre');
        $categoria->estado = $request->get('estado');
        $marcasID = array_unique($request->get('marcasCategoria'));
        
        //dd($request->get('marcasCategoria'));
        //dd($marcasID);

        $categoria->save();
        
        foreach($marcasID as $ids) {
            $categoria->marca()->attach($ids);
        }
  
        //redireccionar
        return redirect()->route('categorias.index')->with('success', 'Categoria creada con exito');
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
        $categoria = Categoria::find($id);
        $marcas = Marca::all();
        //$marcas = Marca::where('estado', '=', 'Activo')->get();

        $marcasAsoc = $categoria->marca()->withPivot('marca_id')->get()->pluck('id')->toArray();

        return view('categorias.edit', compact('categoria', 'marcas', 'marcasAsoc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        //validar campos
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'marcasCategoria' => 'required'
        ]);

        //almacenar datos
        $categoria->nombre = $request->get('nombre');
        $categoria->estado = $request->get('estado');
        
        $marcasID = array_unique($request->get('marcasCategoria'));

        $marcasAsocAct = $categoria->marca()->withPivot('marca_id')->get()->pluck('id')->toArray();

        $categoria->update();

        //obtiene las marcas en la BD que se deseleccionaron al editar, es decir las que hay que borrar
        $marcasDel = array_diff($marcasAsocAct, $marcasID);

        foreach($marcasDel as $ids) {
            //desasocia la/s marca/s con la categoria 
            $categoria->marca()->detach($ids);
        }

    
        //obtiene las marcas que se seleccionaron al editar y no están en la BD, es decir las que hay que agregar
        $marcasUpd = array_diff($marcasID, $marcasAsocAct);

        foreach($marcasUpd as $ids) {
            //Asocia la/s marca/s con la categoria 
            $categoria->marca()->attach($ids);
             //$categoria->marca()->updateExistingPivot($ids, ['created_at' => now()]);
        }
        
        //redireccionar
        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id)->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada con exito');
    }
}
