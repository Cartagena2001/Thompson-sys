<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

Class UsersController extends Controller
{

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */    

    public function index() {

        $usuarios = User::whereNot('rol_id', 0)->paginate(1000000000);
        $roles = Rol::all();

        return view('config.usuarios', compact('usuarios', 'roles'));
    }


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$usuario = new User();
        $roles = Rol::whereNot('id', 0)->get();
        $marcas = Marca::All();

        //relacionar con el modelo de rol
        //$rol = Rol::pluck('nombre', 'id');

        //relacionar con el modelo de marca
        //$marcas = Marca::pluck('nombre', 'id');

        
        return view('config.create', compact('roles', 'marcas'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        //validar los datos
        $request->validate([
            'cliente_id_interno' => 'string|max:10',
            'rol' => 'required|numeric',
            'estado' => 'required|string|min:6|max:8',
            'clasificacion' => 'required|string|max:20',
            'boletin' => 'required|numeric|max:1',
            'estatus' => 'required|string|max:14',
            'name' => 'required|max:100',
            'email' => 'required|email|max:250|unique:users',
            'dui' => 'unique:users,dui|min:10|max:10',
            'whatsapp' => 'min:9|max:9',
            'notas' => 'string|max:280',
            'nrc' => 'unique:users,nrc|min:8|max:10',
            'nit' => 'unique:users,nit|min:17|max:17',
            'razon_social' => 'required|max:34',
            'direccion' => 'required|max:75',
            'municipio' => 'required|max:25',
            'departamento' => 'required|max:15',
            'giro' => 'required|max:180',
            'nombre_empresa' => 'required|max:34',
            'website' => 'required|max:34',
            'telefono' => 'required|string|min:9|max:9',
            'marcas' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        //Creamos nuevo usuario
        $user = new User();

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            $file = $request->file('imagen_perfil_src');
            $file->move(public_path() . '/assets/img/perfil-user/', $file->getClientOriginalName());
            $user->imagen_perfil_src = '/assets/img/perfil-user/' . $file->getClientOriginalName();
        }

        $user->cliente_id_interno = $request->get('cliente_id_interno');
        
        if ( $request->get('rol') == 1 || $request->get('rol') == 2 || $request->get('rol') == 3) {
            $user->rol_id = $request->get('rol');
        } else {
            $user->rol_id = 2;
        }
        
        if ( $request->get('estado') == 'Activo' || $request->get('estado') == 'Inactivo' ) {
            $user->estado = $request->get('estado');
        } else {
            $user->estado = 'Inactivo';
        }
        
        if ( $request->get('clasificacion') == 'Taller' || $request->get('clasificacion') == 'Distribuidor' || $request->get('clasificacion') == 'PrecioCosto') 
        {
            $user->clasificacion = $request->get('clasificacion');
        } else {
            $user->clasificacion = 'Cobre';
        }

        if ( $request->get('boletin') == 0 || $request->get('boletin') == 1 ) {
            $user->boletin = $request->get('boletin');
        } else {
            $user->boletin = 0;
        }

        
        if ( $request->get('estatus') == 'otro' || $request->get('estatus') == 'aprobado' || $request->get('estatus') == 'aspirante' ) 
        {
            if ( $request->get('rol') == 1 || $request->get('rol') == 3 ) {
                $user->estatus = 'otro';
            } elseif ( $request->get('rol') == 0 ) {
                $user->estatus = 'otro';
            } else {
                //rol es de cliente
                $user->estatus = $request->get('estatus'); 
            }
        } else {
            $user->estatus = 'aspirante';
        }

        $user->name = $request->get('name');

        $user->email = $request->get('email');

        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp');
        $user->notas = $request->get('notas');
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

        if(in_array('0', $request->get('marcas'))){
            $user->marcas = '0,';
        }else{
            $marcasList = implode(",", $request->get('marcas'));
            $user->marcas = $marcasList;
        }

        $user->password = bcrypt($request->get('password'));

        $user->form_status = "none"; // none, sent, pending

        $user->fecha_registro = \Carbon\Carbon::now()->addDays(4)->toDateTimeString();

        $user->visto = 'visto'; // nuevo, visto 
        

        $user->save();

        //redireccionar
        return redirect()->route('users.index')->with('success', 'usuario registrado con éxito');
    }


    /**
     * Show the form for editing a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Rol::All();
        $marcas = Marca::All();

        return view('config.edit', compact('usuario', 'roles', 'marcas'));
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
        
        $user = User::find($id);

        //validar los datos
        $request->validate([
            'cliente_id_interno' => 'string|max:10',
            'rol' => 'required|numeric',
            'estado' => 'required|string|min:6|max:8',
            'clasificacion' => 'required|string|max:20',
            'boletin' => 'required|numeric|max:1',
            'estatus' => 'required|string|max:14',
            'name' => 'required|max:100',
            //'email' => 'required|email|max:250|unique:users',
            'dui' => 'unique:users,dui|min:10|max:10,' . $user->id,
            'whatsapp' => 'min:9|max:9',
            'notas' => 'string|max:280',
            'nrc' => 'unique:users,nrc|min:8|max:10,' . $user->id,
            'nit' => 'unique:users,nit|min:17|max:17,' . $user->id,
            'razon_social' => 'required|max:34',
            'direccion' => 'required|max:75',
            'municipio' => 'required|max:25',
            'departamento' => 'required|max:15',
            'giro' => 'required|max:180',
            'nombre_empresa' => 'required|max:34',
            'website' => 'required|max:34',
            'telefono' => 'required|string|min:9|max:9',
            'marcas' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            $file = $request->file('imagen_perfil_src');
            $file->move(public_path() . '/assets/img/perfil-user/', $file->getClientOriginalName());
            $user->imagen_perfil_src = '/assets/img/perfil-user/' . $file->getClientOriginalName();
        }

        $user->cliente_id_interno = $request->get('cliente_id_interno');
        
        if ( $request->get('rol') == 1 || $request->get('rol') == 2 || $request->get('rol') == 3) {
            $user->rol_id = $request->get('rol');
        } else {
            $user->rol_id = 2;
        }
        
        if ( $request->get('estado') == 'Activo' || $request->get('estado') == 'Inactivo' ) {
            $user->estado = $request->get('estado');
        } else {
            $user->estado = 'Inactivo';
        }
        
        if ( $request->get('clasificacion') == 'Taller' || $request->get('clasificacion') == 'Distribuidor' || $request->get('clasificacion') == 'PrecioCosto') 
        {
            $user->clasificacion = $request->get('clasificacion');
        } else {
            $user->clasificacion = 'Cobre';
        }

        if ( $request->get('boletin') == 0 || $request->get('boletin') == 1 ) {
            $user->boletin = $request->get('boletin');
        } else {
            $user->boletin = 0;
        }

        
        if ( $request->get('estatus') == 'otro' || $request->get('estatus') == 'aprobado' || $request->get('estatus') == 'aspirante' ) 
        {
            if ( $request->get('rol') == 1 || $request->get('rol') == 3 ) {
                $user->estatus = 'otro';
            } elseif ( $request->get('rol') == 0 ) {
                $user->estatus = 'otro';
            } else {
                //rol es de cliente
                $user->estatus = $request->get('estatus'); 
            }
        } else {
            $user->estatus = 'aspirante';
        }

        $user->name = $request->get('name');

        //$user->email = $request->get('email');

        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp');
        $user->notas = $request->get('notas');
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

        if(in_array('0', $request->get('marcas'))){
            $user->marcas = '0,';
        }else{
            $marcasList = implode(",", $request->get('marcas'));
            $user->marcas = $marcasList;
        }

        $user->password = bcrypt($request->get('password'));

        //$user->form_status = "none"; //none, sent 

        //$user->fecha_registro = \Carbon\Carbon::now()->addDays(4)->toDateTimeString();

        //$user->visto = 'visto'; //nuevo, visto 
        

        $user->update();

        //redireccionar
        return redirect()->route('users.index')->with('success', 'usuario actualizado con éxito');
    }

}