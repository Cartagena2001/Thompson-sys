<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;
use RealRashid\SweetAlert\Facades\Alert;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //paginate
        $marcas = Marca::paginate(1000000000);

        return view('marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //paginate
        $marca = new Marca();
        
        return view('marcas.create', compact('marca'));
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
            'descripcion' => 'required',
            'estado' => 'required',
            'logo_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
        ]);

        //almacenar datos
        $reg = new Marca();
        $reg->nombre = $request->get('nombre');
        $reg->descripcion = $request->get('descripcion');
        $reg->estado = $request->get('estado');
        
        //subir logo
        if ($request->hasFile('logo_src')) {
            
            if ($request->file('logo_src')->isValid()){
                
                $file = $request->file('logo_src');

                $nombreMarca = $reg->nombre.'-logo-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/logos/', $nombreMarca);

                $reg->logo_src = $nombreMarca;  

            } else {

                return redirect()->route('marcas.edit')->with('success', 'Ha ocurrido un error al cargar el logo');
            }

        }

        $reg->save();
      
        //redireccionar
        return redirect()->route('marcas.index')->with('success', 'Marca ha sido creada con éxito');
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
        //paginate
        $marca = Marca::find($id);
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        //validar campos
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'logo_src' => 'image|mimes:jpeg,png,gif,jpg|max:5000',
        ]);

        //almacenar datos
        $marca->nombre = $request->get('nombre');
        $marca->descripcion = $request->get('descripcion');
        $marca->estado = $request->get('estado');

        //subir logo
        if ($request->hasFile('logo_src')) {
            
            if ($request->file('logo_src')->isValid()){
                
                $file = $request->file('logo_src');

                $nombreMarca = $marca->nombre.'-logo-'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/logos/', $nombreMarca);

                $marca->logo_src = $nombreMarca;  

            } else {

                return redirect()->route('marcas.edit')->with('success', 'Ha ocurrido un error al cargar el logo');
            }

        }

        $marca->update();

        //redireccionar
        return redirect()->route('marcas.index')->with('success', 'Marca ha sido editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = Marca::find($id);
        if ($marca->logo_src){
            if (file_exists('/assets/img/logos/'.$marca->logo_src)){
                unlink('/assets/img/logos/'.$marca->logo_src);
            }
        }
        $marca->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca ha sido eliminada con éxito');
    }
}
