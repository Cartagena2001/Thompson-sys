<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\User;

class PerfilController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();

        return view('perfil.configuracion.index', compact('user'));
    }

    // funcion para actualizar la informacion del usuario
    public function update(Request $request, User $user)
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();
        
        //validar los datos
        $request->validate([
            'name' => 'required|max:100',
            'dui' => 'required|unique:users,dui|min:10|max:10' . $user->id,
            'whatsapp' => 'required|min:9|max:9',
            'nrc' => 'required|unique:users,nrc|min:8|max:10' . $user->id,
            'nit' => 'required|unique:users,nit|min:17|max:17' . $user->id,
            'razon_social' => 'required|max:34',
            'direccion' => 'required|max:75',
            'municipio' => 'required|max:25',
            'departamento' => 'required|max:15',
            'giro' => 'required|max:180',
            'nombre_empresa' => 'required|max:34',
            'website' => 'required|max:34',
            'telefono' => 'required|string|min:9|max:9'
        ]);

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            $file = $request->file('imagen_perfil_src');
            $file->move(public_path() . '/assets/img/perfil-user/', $file->getClientOriginalName());
            $user->imagen_perfil_src = '/assets/img/perfil-user/' . $file->getClientOriginalName();
        }
        $user->name = $request->get('name');
        //$user->email = $request->get('email');
        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp');
        $user->nrc = $request->get('nrc');
        $user->nit = $request->get('nit');
        $user->razon_social = $request->get('razon_social');
        $user->direccion = $request->get('direccion');
        $user->municipio = $request->get('municipio');
        $user->departamento = $request->get('departamento');
        $user->giro = $request->get('giro');
        $user->nombre_empresa = $request->get('nombre_empresa');
        $user->website = $request->get('website');
        $user->telefono = $request->get('telefono');
        
        $user->update();

        //redireccionar
        return redirect()->route('perfil.index')->with('toast_success', 'Información actualizada correctamente');
    }

    public function indexInfoSent()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->User();

        if ( $user->estatus == 'aspirante' || $user->estatus == 'rechazado' ) {

            return view('aspirantes.form-inscripcion', compact('user'));
        } else {
            return view('home', compact('user'));
        }
  
    }

    // método para cargar la información del aspirante a cliente
    public function loadInfo(Request $request, User $user)
    {
        //capturar la información del usuario logeado
        $user = auth()->User();
        
        //validar los datos
        $request->validate([
            'dui' => 'required|unique:users,dui|min:10|max:10' . $user->id,
            'whatsapp' => 'required|min:9|max:9',
            'nrc' => 'required|unique:users,nrc|min:8|max:10' . $user->id,
            'nit' => 'required|unique:users,nit|min:17|max:17' . $user->id,
            'razon_social' => 'required|max:34',
            'direccion' => 'required|max:75',
            'municipio' => 'required|max:25',
            'departamento' => 'required|max:15',
            'giro' => 'required|max:180',
            'nombre_empresa' => 'required|max:34',
            'website' => 'required|max:34',
            'telefono' => 'required|min:9|max:9'     
        ]);

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            $file = $request->file('imagen_perfil_src');
            $file->move(public_path() . '/assets/img/perfil-user/', $file->getClientOriginalName());
            $user->imagen_perfil_src = '/assets/img/perfil-user/' . $file->getClientOriginalName();
        }

        $user->form_status = 'sent'; //uso de emergencia como bandera

        //$user->name = $request->get('name');
        //$user->email = $request->get('email');
        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp');
        $user->nrc = $request->get('nrc');
        $user->nit = $request->get('nit');
        $user->razon_social = $request->get('razon_social');
        $user->direccion = $request->get('direccion');
        $user->municipio = $request->get('municipio');
        $user->departamento = $request->get('departamento');
        $user->giro = $request->get('giro');
        $user->nombre_empresa = $request->get('nombre_empresa');
        $user->website = $request->get('website');
        $user->telefono = $request->get('telefono');
        
        $user->update();

        //redireccionar
        return redirect()->route('info.enviada')->with('toast_success', '¡Información enviada con éxito!');
    }

    public function ordenes()
    {
        //capturar la informacion del usuario logeado
        $user = auth()->user();
        //capturar las ordenes del usuario logeado
        $ordenes = Orden::where('user_id', $user->id)->get();
        //capturar el detalle de cada orden
        foreach ($ordenes as $orden) {
            $orden->detalle = OrdenDetalle::where('orden_id', $orden->id)->get();
            //ahora buscar el producto de cada detalle
            foreach ($orden->detalle as $item) {
                $item->producto = $item->Producto;
            }
        }
        return view('perfil.ordenes.index', compact('user', 'ordenes'));
    }

    public function ordenes_detalle($id)
    {
        $orden = Orden::find($id);
        $detalle = OrdenDetalle::where('orden_id', $id)->get();
        foreach ($detalle as $item) {
            $item->producto = $item->Producto;
        }
        return view('perfil.ordenes.detalle', compact('orden', 'detalle'));
    }
}
