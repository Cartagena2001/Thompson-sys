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

        //Creamos nuevo usuario
        $user = new User();

        if ( $request->get('negTipo') == 'persona') {
            //persona natural no inscrita en CNR
            //validar los datos
            $request->validate([
                'cliente_id_interno' => 'nullable|string|max:10',
                'rol' => 'required|numeric',
                'estado' => 'required|string|min:6|max:8',
                'clasificacion' => 'required|string|max:20', 
                'boletin' => 'required|numeric|max:1',
                'estatus' => 'required|string|max:14',
                'name' => 'required|max:100',
                'email' => 'required|email|max:250|unique:users',
                'dui' => 'unique:users,dui|min:9|max:10',
                'whatsapp' => 'required|min:8|max:19',
                'notas' => 'nullable|string|max:280',
                'direccion' => 'required|string|max:75',
                'municipio' => 'required|string|max:25',
                'departamento' => 'required|string|max:15',
                'website' => 'nullable|string|max:34',
                'telefono' => 'nullable|string|min:8|max:19',
                'marcas' => 'required',
                'password' => 'required|confirmed|min:6'   
            ]);

            $user->nrc = null;
            $user->nit = null;
            $user->razon_social = null;
            $user->giro = null;
            $user->nombre_empresa = null;

        } else {
            //negocio/empresa inscrita en CNR
            //validar los datos
            $request->validate([
                'cliente_id_interno' => 'nullable|string|max:10',
                'rol' => 'required|numeric',
                'estado' => 'required|string|min:6|max:8',
                'clasificacion' => 'required|string|max:20', 
                'boletin' => 'required|numeric|max:1',
                'estatus' => 'required|string|max:14',
                'name' => 'required|max:100',
                'email' => 'required|email|max:250|unique:users',
                'dui' => 'unique:users,dui|min:9|max:10',
                'whatsapp' => 'required|min:8|max:19',
                'notas' => 'nullable|string|max:280',
                'nrc' => 'unique:users,nrc|min:8|max:10',
                'nit' => 'unique:users,nit|min:17|max:17',
                'razon_social' => 'required|string|max:34',
                'direccion' => 'required|string|max:75',
                'municipio' => 'required|string|max:25',
                'departamento' => 'required|string|max:15',
                'giro' => 'required|string|max:180',
                'nombre_empresa' => 'required|string|max:34',
                'website' => 'nullable|string|max:34',
                'telefono' => 'nullable|string|min:8|max:19',
                'marcas' => 'required',
                'password' => 'required|confirmed|min:6'    
            ]);

            $user->nrc = $request->get('nrc');
            $user->nit = $request->get('nit');
            $user->razon_social = $request->get('razon_social');
            $user->giro = $request->get('giro');
            $user->nombre_empresa = $request->get('nombre_empresa');
        }

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            
            if ($request->file('imagen_perfil_src')->isValid()){
                
                $file = $request->file('imagen_perfil_src');

                $nombreIMGP = $request->get('name').'-'.$request->get('dui').'_img-perfil_'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/perfil-user/', $nombreIMGP);

                //$path = $file->storeAs('/private/perfil-user/', $nombreIMGP);

                $user->imagen_perfil_src = $nombreIMGP;  

            } else {

                return redirect()->route('users.index')->with('success', 'Ha ocurrido un error al cargar la imagen de perfil');
            }

        }

        $user->cliente_id_interno = $request->get('cliente_id_interno');
        
        if ( $request->get('rol') == 1 || $request->get('rol') == 2 || $request->get('rol') == 3) {
            $user->rol_id = $request->get('rol');
        } else {
            $user->rol_id = 2;
        }
        
        if ( $request->get('estado') == 'activo' || $request->get('estado') == 'inactivo' ) {
            $user->estado = $request->get('estado');
        } else {
            $user->estado = 'inactivo';
        }
        
        if ( $request->get('clasificacion') == 'taller' || $request->get('clasificacion') == 'distribuidor' || $request->get('clasificacion') == 'precioCosto' || $request->get('clasificacion') == 'precioOp') 
        {
            $user->clasificacion = $request->get('clasificacion');
        } else {
            $user->clasificacion = 'precioCosto';
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
        $user->direccion = $request->get('direccion');
        $user->municipio = $request->get('municipio');
        $user->departamento = $request->get('departamento');
        $user->website = $request->get('website');
        $user->telefono = $request->get('telefono');

        /*
        if(in_array('0', $request->get('marcas'))){
            $user->marcas = '0';
        }else{
            $marcasList = implode(",", $request->get('marcas'));
            $user->marcas = $marcasList;
        }
        */

        $marcasList = implode("", $request->get('marcas'));
        $user->marcas = $marcasList;

        $user->password = bcrypt($request->get('password'));

        $user->form_status = "none"; // none, sent, pending

        $user->fecha_registro = \Carbon\Carbon::now()->toDateTimeString();

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

        if ( $request->get('negTipo') == 'persona') {
            //persona natural no inscrita en CNR
            //validar los datos
            $request->validate([
                'cliente_id_interno' => 'nullable|string|max:10',
                'rol' => 'required|numeric',
                'estado' => 'required|string|min:6|max:8',
                'clasificacion' => 'required|string|max:20', 
                'boletin' => 'required|numeric|max:1',
                'estatus' => 'required|string|max:14',
                'name' => 'required|max:100',
                'email' => 'required|email|max:100|unique:users,email,'.$user->id,
                'dui' => 'required|unique:users,dui,'.$user->id.'|min:9|max:10',
                'whatsapp' => 'nullable|string|min:8|max:22',
                'whatsapp_full' => 'nullable|string|min:8|max:22',
                'country_code1' => 'nullable|string|max:4',
                'notas' => 'nullable|string|max:280',
                'direccion' => 'required|string|max:75',
                'departamento' => 'required|in:ahu,cab,cha,cus,lib,mor,paz,ana,mig,ssl,svi,son,uni,usu',
                'municipio' => 'required|not_in:0',
                'website' => 'nullable|string|max:34',
                'telefono' => 'nullable|string|min:8|max:22',
                'tel_full' => 'nullable|string|min:8|max:22',
                'imagen_perfil_src' => 'nullable|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=150,min_height=150,max_width=250,max_height=250',
                'country_code2' => 'nullable|string|max:4',
                'negTipo' => 'required|string|min:7|max:8' 
                //'marcas' => 'required',   
            ]);

            $user->nrc = null;
            $user->nit = null;
            $user->razon_social = "-";
            $user->giro = "-";
            $user->nombre_empresa = "-";

        } else {
            //negocio/empresa inscrita en CNR
            //validar los datos
            $request->validate([
                'cliente_id_interno' => 'nullable|string|max:10',
                'rol' => 'required|numeric',
                'estado' => 'required|string|min:6|max:8',
                'clasificacion' => 'required|string|max:20', 
                'boletin' => 'required|numeric|max:1',
                'estatus' => 'required|string|max:14',
                'name' => 'required|max:100',
                'email' => 'required|email|max:100|unique:users,email,'.$user->id,
                'dui' => 'required|unique:users,dui,'.$user->id.'|min:9|max:10',
                'whatsapp' => 'nullable|string|min:8|max:22',
                'whatsapp_full' => 'nullable|string|min:8|max:22',
                'country_code1' => 'nullable|string|max:4',
                'notas' => 'nullable|string|max:280',
                'nrc' => 'required|unique:users,nrc,'.$user->id.'|min:8|max:10',
                'nit' => 'required|unique:users,nit,'.$user->id.'|min:17|max:17',
                'razon_social' => 'required|string|max:34',
                'direccion' => 'required|string|max:75',
                'departamento' => 'required|in:ahu,cab,cha,cus,lib,mor,paz,ana,mig,ssl,svi,son,uni,usu',
                'municipio' => 'required|not_in:0',
                'giro' => 'required|string|max:180',
                'nombre_empresa' => 'required|string|max:34',
                'website' => 'nullable|string|max:34',
                'telefono' => 'nullable|string|min:8|max:22',
                'tel_full' => 'nullable|string|min:8|max:22',
                'imagen_perfil_src' => 'nullable|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=150,min_height=150,max_width=250,max_height=250',
                'country_code2' => 'nullable|string|max:4',
                'negTipo' => 'required|string|min:7|max:8'  
                //'marcas' => 'required',    
            ]);

            $user->nrc = $request->get('nrc');
            $user->nit = $request->get('nit');
            $user->razon_social = $request->get('razon_social');
            $user->giro = $request->get('giro');
            $user->nombre_empresa = $request->get('nombre_empresa');
        }

        //almacenar datos
        if ($request->hasFile('imagen_perfil_src')) {
            
            if ($request->file('imagen_perfil_src')->isValid()){
                
                $file = $request->file('imagen_perfil_src');

                $nombreIMGP = $request->get('name').'-'.$request->get('dui').'_img-perfil_'.\Carbon\Carbon::today()->toDateString().'.'.$file->extension();   
                
                $path = $file->storeAs('/public/assets/img/perfil-user/', $nombreIMGP);

                //$path = $file->storeAs('/private/perfil-user/', $nombreIMGP);

                $user->imagen_perfil_src = $nombreIMGP;  

            } else {

                return redirect()->route('users.index')->with('success', 'Ha ocurrido un error al cargar la imagen de perfil');
            }

        }

        $user->cliente_id_interno = $request->get('cliente_id_interno');
        
        if ( $request->get('rol') == 1 || $request->get('rol') == 2 || $request->get('rol') == 3) {
            $user->rol_id = $request->get('rol');
        } else {
            $user->rol_id = 2;
        }
        
        if ( $request->get('estado') == 'activo' || $request->get('estado') == 'inactivo' ) {
            $user->estado = $request->get('estado');
        } else {
            $user->estado = 'inactivo';
        }
        
        if ( $request->get('clasificacion') == 'taller' || $request->get('clasificacion') == 'distribuidor' || $request->get('clasificacion') == 'precioCosto' || $request->get('clasificacion') == 'precioOp') 
        {
            $user->clasificacion = $request->get('clasificacion');
        } else {
            $user->clasificacion = 'precioCosto';
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
        $user->usr_tipo = $request->get('negTipo');
        $user->dui = $request->get('dui');
        $user->whatsapp = $request->get('whatsapp_full');
        $user->notas = $request->get('notas');
        $user->direccion = $request->get('direccion');
        
        $user->depto_cod = $request->get('departamento');
            $depto = $request->get('departamento');

            switch ($depto) {

                case 'ahu':
                    $depto = 'Ahuachapán';
                    break;
                case 'cab':
                    $depto = 'Cabañas';
                    break;
                case 'cha':
                    $depto = 'Chalatenango';
                    break;
                case 'cus':
                    $depto = 'Cuscatlán';
                    break;
                case 'lib':
                    $depto = 'La Libertad';
                    break;
                case 'mor':
                    $depto = 'Morazán';
                    break;
                case 'paz':
                    $depto = 'La Paz';
                    break;
                case 'ana':
                    $depto = 'Santa Ana';
                    break;
                case 'mig':
                    $depto = 'San Miguel';
                    break;
                case 'ssl':
                    $depto = 'San Salvador';
                    break;
                case 'svi':
                    $depto = 'San Vicente';
                    break;
                case 'son':
                    $depto = 'Sonsonate';
                    break;
                case 'uni':
                    $depto = 'La Unión';
                    break;
                case 'usu':
                    $depto = 'Usulután';
                    break;
            
                default:
                    $depto = '-';
                    break;
            }
            $user->departamento = $depto;

            $user->mun_cod = $request->get('municipio');
            $municipio = $request->get('municipio');

            switch ($municipio) {

                case 'ahuN1':
                    $municipio = 'Ahuachapán Norte/Atiquizaya';
                    break;
                case 'ahuN2':
                    $municipio = 'Ahuachapán Norte/El Refugio';
                    break;
                case 'ahuN3':
                    $municipio = 'Ahuachapán Norte/San Lorenzo';
                    break;
                case 'ahuN4':
                    $municipio = 'Ahuachapán Norte/Turín';
                    break;
                case 'ahuC1':
                    $municipio = 'Ahuachapán Centro/Ahuachapán';
                    break;
                case 'ahuC2':
                    $municipio = 'Ahuachapán Centro/Apaneca';
                    break;
                case 'ahuC3':
                    $municipio = 'Ahuachapán Centro/Concepción de Ataco';
                    break;
                case 'ahuC4':
                    $municipio = 'Ahuachapán Centro/Tacuba';
                    break;
                case 'ahuS1':
                    $municipio = 'Ahuachapán Sur/Guaymango';
                    break;
                case 'ahuS2':
                    $municipio = 'Ahuachapán Sur/Jujutla';
                    break;
                case 'ahuS3':
                    $municipio = 'Ahuachapán Sur/San Francisco Menéndez';
                    break;
                case 'ahuS4':
                    $municipio = 'Ahuachapán Sur/San Pedro Puxtla';
                    break;
                case 'cabE1':
                    $municipio = 'Cabañas Este/Guacotecti';
                    break;
                case 'cabE2':
                    $municipio = 'Cabañas Este/San Isidro';
                    break;
                case 'cabE3':
                    $municipio = 'Cabañas Este/Sensuntepeque';
                    break;
                case 'cabE4':
                    $municipio = 'Cabañas Este/Victoria';
                    break;
                case 'cabE5':
                    $municipio = 'Cabañas Este/Dolores';
                    break;
                case 'cabO1':
                    $municipio = 'Cabañas Oeste/Cinquera';
                    break;
                case 'cabO2':
                    $municipio = 'Cabañas Oeste/Ilobasco';
                    break;
                case 'cabO3':
                    $municipio = 'Cabañas Oeste/Jutiapa';
                    break;
                case 'cabO4':
                    $municipio = 'Cabañas Oeste/Tejutepeque';
                    break;
                case 'chaN1':
                    $municipio = 'Chalatenango Norte/Citalá';
                    break;
                case 'chaN2':
                    $municipio = 'Chalatenango Norte/La Palmao';
                    break;
                case 'chaN3':
                    $municipio = 'Chalatenango Norte/San Ignacio';
                    break;
                case 'chaC1':
                    $municipio = 'Chalatenango Centro/Agua Caliente';
                    break;
                case 'chaC2':
                    $municipio = 'Chalatenango Centro/Dulce Nombre de María';
                    break;
                case 'chaC3':
                    $municipio = 'Chalatenango Centro/El Paraíso';
                    break;
                case 'chaC4':
                    $municipio = 'Chalatenango Centro/La Reina';
                    break;
                case 'chaC5':
                    $municipio = 'Chalatenango Centro/Nueva Concepción';
                    break;
                case 'chaC6':
                    $municipio = 'Chalatenango Centro/San Fernando';
                    break;
                case 'chaC7':
                    $municipio = 'Chalatenango Centro/San Francisco Morazán';
                    break;
                case 'chaC8':
                    $municipio = 'Chalatenango Centro/San Rafael';
                    break;
                case 'chaC9':
                    $municipio = 'Chalatenango Centro/Santa Rita';
                    break;
                case 'chaC10':
                    $municipio = 'Chalatenango Centro/Tejutla';
                    break;
                case 'chaS1':
                    $municipio = 'Chalatenango Sur/Arcatao';
                    break;
                case 'chaS2':
                    $municipio = 'Chalatenango Sur/Azacualpa';
                    break;
                case 'chaS3':
                    $municipio = 'Chalatenango Sur/Cancasque';
                    break;
                case 'chaS4':
                    $municipio = 'Chalatenango Sur/Chalatenango';
                    break;
                case 'chaS5':
                    $municipio = 'Chalatenango Sur/Comalapa';
                    break;
                case 'chaS6':
                    $municipio = 'Chalatenango Sur/Concepción Quezaltepeque';
                    break;
                case 'chaS7':
                    $municipio = 'Chalatenango Sur/El Carrizal';
                    break;
                case 'chaS8':
                    $municipio = 'Chalatenango Sur/La Laguna';
                    break;
                case 'chaS9':
                    $municipio = 'Chalatenango Sur/Las Vueltas';
                    break;
                case 'chaS10':
                    $municipio = 'Chalatenango Sur/Las Flores';
                    break;
                case 'chaS11':
                    $municipio = 'Chalatenango Sur/Nombre de Jesús';
                    break;
                case 'chaS12':
                    $municipio = 'Chalatenango Sur/Nueva Trinidad';
                    break;
                case 'chaS13':
                    $municipio = 'Chalatenango Sur/Ojos de Agua';
                    break;
                case 'chaS14':
                    $municipio = 'Chalatenango Sur/Potonico';
                    break;
                case 'chaS15':
                    $municipio = 'Chalatenango Sur/San Antonio de la Cruz';
                    break;
                case 'chaS16':
                    $municipio = 'Chalatenango Sur/San Antonio Los Ranchos';
                    break;
                case 'chaS17':
                    $municipio = 'Chalatenango Sur/San Francisco Lempa';
                    break;
                case 'chaS18':
                    $municipio = 'Chalatenango Sur/San Isidro Labrador';
                    break;
                case 'chaS19':
                    $municipio = 'Chalatenango Sur/San Luis del Carmen';
                    break;
                case 'chaS20':
                    $municipio = 'Chalatenango Sur/San Miguel de Mercedes';
                    break;
                case 'cusN1':
                    $municipio = 'Cuscatlán Norte/Suchitoto';
                    break;
                case 'cusN2':
                    $municipio = 'Cuscatlán Norte/San José Guayabal';
                    break;
                case 'cusN3':
                    $municipio = 'Cuscatlán Norte/Oratorio de Concepción';
                    break;
                case 'cusN4':
                    $municipio = 'Cuscatlán Norte/San Bartolomé Perulapía';
                    break;
                case 'cusN5':
                    $municipio = 'Cuscatlán Norte/San Pedro Perulapán';
                    break;
                case 'cusS1':
                    $municipio = 'Cuscatlán Sur/Cojutepeque';
                    break;
                case 'cusS2':
                    $municipio = 'Cuscatlán Sur/Candelaria';
                    break;
                case 'cusS3':
                    $municipio = 'Cuscatlán Sur/El Carmen';
                    break;
                case 'cusS4':
                    $municipio = 'Cuscatlán Sur/El Rosario';
                    break;
                case 'cusS5':
                    $municipio = 'Cuscatlán Sur/Monte San Juan';
                    break;
                case 'cusS6':
                    $municipio = 'Cuscatlán Sur/San Cristóbal';
                    break;
                case 'cusS7':
                    $municipio = 'Cuscatlán Sur/San Rafael Cedros';
                    break;
                case 'cusS8':
                    $municipio = 'Cuscatlán Sur/San Ramón';
                    break;
                case 'cusS9':
                    $municipio = 'Cuscatlán Sur/Santa Cruz Analquito';
                    break;
                case 'cusS10':
                    $municipio = 'Cuscatlán Sur/Santa Cruz Michapa';
                    break;
                case 'cusS11':
                    $municipio = 'Cuscatlán Sur/Tenancingo';
                    break;
                case 'libN1':
                    $municipio = 'La Libertad Norte/Quezaltepeque';
                    break;
                case 'libN2':
                    $municipio = 'La Libertad Norte/San Matías';
                    break;
                case 'libN3':
                    $municipio = 'La Libertad Norte/San Pablo Tacachico';
                    break;
                case 'libC1':
                    $municipio = 'La Libertad Centro/San Juan Opico';
                    break;
                case 'libC2':
                    $municipio = 'La Libertad Centro/Ciudad Arce';
                    break;
                case 'libO1':
                    $municipio = 'La Libertad Oeste/Colón';
                    break;
                case 'libO2':
                    $municipio = 'La Libertad Oeste/Jayaque';
                    break;
                case 'libO3':
                    $municipio = 'La Libertad Oeste/Sacacoyo';
                    break;
                case 'libO4':
                    $municipio = 'La Libertad Oeste/Tepecoyo';
                    break;
                case 'libO5':
                    $municipio = 'La Libertad Oeste/Talnique';
                    break;
                case 'libE1':
                    $municipio = 'La Libertad Este/Antiguo Cuscatlán';
                    break;
                case 'libE2':
                    $municipio = 'La Libertad Este/Huizúcar';
                    break;
                case 'libE3':
                    $municipio = 'La Libertad Este/Nuevo Cuscatlán';
                    break;
                case 'libE4':
                    $municipio = 'La Libertad Este/San José Villanueva';
                    break;
                case 'libE5':
                    $municipio = 'La Libertad Este/Zaragoza';
                    break;
                case 'libCt1':
                    $municipio = 'La Libertad Costa/Chiltiupán';
                    break;
                case 'libCt2':
                    $municipio = 'La Libertad Costa/Jicalapa';
                    break;
                case 'libCt3':
                    $municipio = 'La Libertad Costa/La Libertad';
                    break;
                case 'libCt4':
                    $municipio = 'La Libertad Costa/Tamanique';
                    break;
                case 'libCt5':
                    $municipio = 'La Libertad Costa/Teotepeque';
                    break;
                case 'libS1':
                    $municipio = 'La Libertad Sur/Santa Tecla';
                    break;
                case 'libS2':
                    $municipio = 'La Libertad Sur/Comasagua';
                    break;
                case 'morN1':
                    $municipio = 'Morazán Norte/Arambala';
                    break;
                case 'morN2':
                    $municipio = 'Morazán Norte/Cacaopera';
                    break;
                case 'morN3':
                    $municipio = 'Morazán Norte/Corinto';
                    break;
                case 'morN4':
                    $municipio = 'Morazán Norte/El Rosario';
                    break;
                case 'morN5':
                    $municipio = 'Morazán Norte/Joateca';
                    break;
                case 'morN6':
                    $municipio = 'Morazán Norte/Jocoaitique';
                    break;
                case 'morN7':
                    $municipio = 'Morazán Norte/Meanguera';
                    break;
                case 'morN8':
                    $municipio = 'Morazán Norte/Perquín';
                    break;
                case 'morN9':
                    $municipio = 'Morazán Norte/San Fernando';
                    break;
                case 'morN10':
                    $municipio = 'Morazán Norte/San Isidro';
                    break;
                case 'morN11':
                    $municipio = 'Morazán Norte/Torola';
                    break;
                case 'morS1':
                    $municipio = 'Morazán Sur/Chilanga';
                    break;
                case 'morS2':
                    $municipio = 'Morazán Sur/Delicias de Concepción';
                    break;
                case 'morS3':
                    $municipio = '>Morazán Sur/El Divisadero';
                    break;
                case 'morS4':
                    $municipio = 'Morazán Sur/Gualococti';
                    break;
                case 'morS5':
                    $municipio = '>Morazán Sur/Guatajiagua';
                    break;
                case 'morS6':
                    $municipio = 'Morazán Sur/Jocoro';
                    break;
                case 'morS7':
                    $municipio = 'Morazán Sur/Lolotiquillo';
                    break;
                case 'morS8':
                    $municipio = 'Morazán Sur/Osicala';
                    break;
                case 'morS9':
                    $municipio = 'Morazán Sur/San Carlos';
                    break;
                case 'morS10':
                    $municipio = 'Morazán Sur/San Francisco Gotera';
                    break;
                case 'morS11':
                    $municipio = 'Morazán Sur/San Simón';
                    break;
                case 'morS12':
                    $municipio = 'Morazán Sur/Sensembra';
                    break;
                case 'morS13':
                    $municipio = 'Morazán Sur/Sociedad';
                    break;
                case 'morS14':
                    $municipio = 'Morazán Sur/Yamabal';
                    break;
                case 'morS15':
                    $municipio = 'Morazán Sur/Yoloaiquín';
                    break;
                case 'pazO1':
                    $municipio = 'La Paz Oeste/Cuyultitán';
                    break;
                case 'pazO2':
                    $municipio = 'La Paz Oeste/Olocuilta';
                    break;
                case 'pazO3':
                    $municipio = 'La Paz Oeste/San Juan Talpa';
                    break;
                case 'pazO4':
                    $municipio = 'La Paz Oeste/San Luis Talpa';
                    break;
                case 'pazO5':
                    $municipio = 'La Paz Oeste/San Pedro Masahuat';
                    break;
                case 'pazO6':
                    $municipio = 'La Paz Oeste/Tapalhuaca';
                    break;
                case 'pazO7':
                    $municipio = 'La Paz Oeste/San Francisco Chinameca';
                    break;
                case 'pazC1':
                    $municipio = 'La Paz Centro/El Rosario';
                    break;
                case 'pazC2':
                    $municipio = 'La Paz Centro/Jerusalén';
                    break;
                case 'pazC3':
                    $municipio = 'La Paz Centro/Mercedes La Ceiba';
                    break;
                case 'pazC4':
                    $municipio = 'La Paz Centro/Paraíso de Osorio';
                    break;
                case 'pazC5':
                    $municipio = 'La Paz Centro/San Antonio Masahuat';
                    break;
                case 'pazC6':
                    $municipio = 'La Paz Centro/San Emigdio';
                    break;
                case 'pazC7':
                    $municipio = 'La Paz Centro/San Juan Tepezontes';
                    break;
                case 'pazC8':
                    $municipio = 'La Paz Centro/San Luis La Herradura';
                    break;
                case 'pazC9':
                    $municipio = 'La Paz Centro/San Miguel Tepezontes';
                    break;
                case 'pazC10':
                    $municipio = 'La Paz Centro/San Pedro Nonualco';
                    break;
                case 'pazC11':
                    $municipio = 'La Paz Centro/Santa María Ostuma';
                    break;
                case 'pazC12':
                    $municipio = 'La Paz Centro/Santiago Nonualco';
                    break;
                case 'pazE1':
                    $municipio = 'La Paz Este/San Juan Nonualco';
                    break;
                case 'pazE2':
                    $municipio = 'La Paz Este/San Rafael Obrajuelo';
                    break;
                case 'pazE3':
                    $municipio = 'La Paz Este/Zacatecoluca';
                    break;
                case 'anaN1':
                    $municipio = 'Santa Ana Norte/Masahuat';
                    break;
                case 'anaN2':
                    $municipio = 'Santa Ana Norte/Metapán';
                    break;
                case 'anaN3':
                    $municipio = 'Santa Ana Norte/Santa Rosa Guachipilín';
                    break;
                case 'anaN4':
                    $municipio = 'Santa Ana Norte/Texistepeque';
                    break;
                case 'anaC5':
                    $municipio = 'Santa Ana Centro/Santa Ana';
                    break;
                case 'anaE6':
                    $municipio = 'Santa Ana Este/Coatepeque';
                    break;
                case 'anaE7':
                    $municipio = 'Santa Ana Este/El Congo';
                    break;
                case 'anaO1':
                    $municipio = 'Santa Ana Oeste/Candelaria de la Frontera';
                    break;
                case 'anaO2':
                    $municipio = 'Santa Ana Oeste/Chalchuapa';
                    break;
                case 'anaO3':
                    $municipio = 'Santa Ana Oeste/El Porvenir';
                    break;
                case 'anaO4':
                    $municipio = 'Santa Ana Oeste/San Antonio Pajonal';
                    break;
                case 'anaO5':
                    $municipio = 'Santa Ana Oeste/San Sebastián Salitrillo';
                    break;
                case 'anaO6':
                    $municipio = 'Santa Ana Oeste/Santiago de la Frontera';
                    break;
                case 'migN1':
                    $municipio = 'San Miguel Norte/Ciudad Barrios';
                    break;
                case 'migN2':
                    $municipio = 'San Miguel Norte/Sesori';
                    break;
                case 'migN3':
                    $municipio = 'San Miguel Norte/Nuevo Edén de San Juan';
                    break;
                case 'migN4':
                    $municipio = 'San Miguel Norte/San Gerardo';
                    break;
                case 'migN5':
                    $municipio = '>San Miguel Norte/San Luis de la Reina';
                    break;
                case 'migN6':
                    $municipio = 'San Miguel Norte/Carolina';
                    break;
                case 'migN7':
                    $municipio = 'San Miguel Norte/San Antonio';
                    break;
                case 'migN8':
                    $municipio = 'San Miguel Norte/Chapeltique';
                    break;
                case 'migC1':
                    $municipio = 'San Miguel Centro/San Miguel';
                    break;
                case 'migC2':
                    $municipio = 'San Miguel Centro/Comacarán';
                    break;
                case 'migC3':
                    $municipio = 'San Miguel Centro/Uluazapa';
                    break;
                case 'migC4':
                    $municipio = 'San Miguel Centro/Moncagua';
                    break;
                case 'migC5':
                    $municipio = 'San Miguel Centro/Quelepa';
                    break;
                case 'migC6':
                    $municipio = 'San Miguel Centro/Chirilagua';
                    break;
                case 'migO1':
                    $municipio = 'San Miguel Oeste/Chinameca';
                    break;
                case 'migO2':
                    $municipio = 'San Miguel Oeste/El Tránsito';
                    break;
                case 'migO3':
                    $municipio = 'San Miguel Oeste/Lolotique';
                    break;
                case 'migO4':
                    $municipio = 'San Miguel Oeste/Nueva Guadalupe';
                    break;
                case 'migO5':
                    $municipio = 'San Miguel Oeste/San Jorge';
                    break;
                case 'migO6':
                    $municipio = 'San Miguel Oeste/San Rafael Oriente';
                    break;
                case 'sslN1':
                    $municipio = 'San Salvador Norte/Aguilares';
                    break;
                case 'sslN2':
                    $municipio = 'San Salvador Norte/El Paisnal';
                    break;
                case 'sslN3':
                    $municipio = 'San Salvador Norte/Guazapan';
                    break;
                case 'sslO1':
                    $municipio = 'San Salvador Oeste/Apopa';
                    break;
                case 'sslO2':
                    $municipio = 'San Salvador Oeste/Nejapa';
                    break;
                case 'sslE1':
                    $municipio = 'San Salvador Este/Ilopango';
                    break;
                case 'sslE2':
                    $municipio = 'San Salvador Este/San Martín';
                    break;
                case 'sslE3':
                    $municipio = 'San Salvador Este/Soyapango';
                    break;
                case 'sslE4':
                    $municipio = 'San Salvador Este/Tonacatepeque';
                    break;
                case 'sslC1':
                    $municipio = 'San Salvador Centro/Ayutuxtepeque';
                    break;
                case 'sslC2':
                    $municipio = 'San Salvador Centro/Mejicanos';
                    break;
                case 'sslC3':
                    $municipio = 'San Salvador Centro/Cuscatancingo';
                    break;
                case 'sslC4':
                    $municipio = 'San Salvador Centro/Ciudad Delgado';
                    break;
                case 'sslC5':
                    $municipio = 'San Salvador Centro/San Salvador';
                    break;
                case 'sslS1':
                    $municipio = 'San Salvador Sur/San Marcos';
                    break;
                case 'sslS2':
                    $municipio = 'San Salvador Sur/Santo Tomás';
                    break;
                case 'sslS3':
                    $municipio = 'San Salvador Sur/Santiago Texacuangos';
                    break;
                case 'sslS4':
                    $municipio = 'San Salvador Sur/Panchimalco';
                    break;
                case 'sslS5':
                    $municipio = 'San Salvador Sur/Rosario de Mora';
                    break;
                 case 'sviN1':
                    $municipio = 'San Vicente Norte/Apastepeque';
                    break;
                case 'sviN2':
                    $municipio = 'San Vicente Norte/Santa Clara';
                    break;
                case 'sviN3':
                    $municipio = 'San Vicente Norte/San Ildefonso';
                    break;
                case 'sviN4':
                    $municipio = 'San Vicente Norte/San Esteban Catarina';
                    break;
                case 'sviN5':
                    $municipio = 'San Vicente Norte/San Sebastián';
                    break;
                 case 'sviN6':
                    $municipio = 'San Vicente Norte/San Lorenzo';
                    break;
                case 'sviN7':
                    $municipio = 'San Vicente Norte/Santo Domingo';
                    break;
                case 'sviS1':
                    $municipio = 'San Vicente Sur/San Vicente';
                    break;
                case 'sviS2':
                    $municipio = 'San Vicente Sur/Guadalupe';
                    break;
                case 'sviS3':
                    $municipio = 'San Vicente Sur/San Cayetano Istepeque';
                    break;
                 case 'sviS4':
                    $municipio = 'San Vicente Sur/Tecoluca';
                    break;
                case 'sviS5':
                    $municipio = 'San Vicente Sur/Tepetitán';
                    break;
                case 'sviS6':
                    $municipio = 'San Vicente Sur/Verapaz';
                    break;  
                case 'sonN1':
                    $municipio = 'Sonsonate Norte/Juayúa';
                    break;
                case 'sonN2':
                    $municipio = 'Sonsonate Norte/Nahuizalco';
                    break;
                case 'sonN3':
                    $municipio = 'Sonsonate Norte/Salcoatitán';
                    break;
                case 'sonN4':
                    $municipio = 'Sonsonate Norte/Santa Catarina Masahuat';
                    break;
                case 'sonC1':
                    $municipio = 'Sonsonate Centro/Sonsonate';
                    break;
                case 'sonC2':
                    $municipio = 'Sonsonate Centro/Sonzacate';
                    break;
                case 'sonC3':
                    $municipio = 'Sonsonate Centro/Nahulingo';
                    break;
                case 'sonC4':
                    $municipio = 'Sonsonate Centro/San Antonio del Monte';
                    break;
                case 'sonC5':
                    $municipio = 'Sonsonate Centro/Santo Domingo de Guzmán';
                    break;
                case 'sonE1':
                    $municipio = 'Sonsonate Este/Armenia';
                    break;
                case 'sonE2':
                    $municipio = 'Sonsonate Este/Caluco';
                    break;
                case 'sonE3':
                    $municipio = 'Sonsonate Este/Cuisnahuat';
                    break;
                case 'sonE4':
                    $municipio = 'Sonsonate Este/Izalco';
                    break;
                case 'sonE5':
                    $municipio = 'Sonsonate Este/San Julián';
                    break;
                case 'sonE6':
                    $municipio = 'Sonsonate Este/Santa Isabel Ishuatán';
                    break;
                case 'sonO1':
                    $municipio = 'Sonsonate Oeste/Acajutla';
                    break;    
                case 'uniN1':
                    $municipio = 'La Unión Norte/Anamorós';
                    break;
                case 'uniN2':
                    $municipio = 'La Unión Norte/Bolívar';
                    break;
                case 'uniN3':
                    $municipio = 'La Unión Norte/Concepción de Oriente';
                    break;
                case 'uniN4':
                    $municipio = 'La Unión Norte/El Sauce';
                    break;
                case 'uniN5':
                    $municipio = 'La Unión Norte/Lislique';
                    break;
                case 'uniN6':
                    $municipio = 'La Unión Norte/Nueva Esparta';
                    break;
                case 'uniN7':
                    $municipio = 'La Unión Norte/Pasaquina';
                    break;
                case 'uniN8':
                    $municipio = 'La Unión Norte/Polorós';
                    break;
                case 'uniN9':
                    $municipio = 'La Unión Norte/San José';
                    break;
                case 'uniN10':
                    $municipio = 'La Unión Norte/Santa Rosa de Lima';
                    break;
                case 'uniS1':
                    $municipio = 'La Unión Norte/Conchagua';
                    break;
                case 'uniS2':
                    $municipio = 'La Unión Sur/El Carmen';
                    break;
                case 'uniS3':
                    $municipio = 'La Unión Sur/Intipucá';
                    break;
                case 'uniS4':
                    $municipio = 'La Unión Sur/La Unión';
                    break;
                case 'uniS5':
                    $municipio = 'La Unión Sur/Meanguera del Golfo';
                    break;
                case 'uniS6':
                    $municipio = 'La Unión Sur/San Alejo';
                    break;
                case 'uniS7':
                    $municipio = 'La Unión Sur/Yayantique';
                    break;
                case 'uniS8':
                    $municipio = 'La Unión Sur/Yucuaiquín';
                    break;
                case 'usuN1':
                    $municipio = 'Usulután Norte/Alegría';
                    break;
                case 'usuN2':
                    $municipio = 'Usulután Norte/Berlín';
                    break;
                case 'usuN3':
                    $municipio = 'Usulután Norte/El Triunfo';
                    break;
                case 'usuN4':
                    $municipio = 'Usulután Norte/Estanzuelas';
                    break;
                case 'usuN5':
                    $municipio = 'Usulután Norte/Jucuapa';
                    break;
                case 'usuN6':
                    $municipio = 'Usulután Norte/Mercedes Umaña';
                    break;
                case 'usuN7':
                    $municipio = 'Usulután Norte/Nueva Granada';
                    break;
                case 'usuN8':
                    $municipio = 'Usulután Norte/San Buenaventura';
                    break;
                case 'usuN9':
                    $municipio = 'Usulután Norte/Santiago de María';
                    break;
                case 'usuC1':
                    $municipio = 'Usulután Este/California';
                    break;
                case 'usuC2':
                    $municipio = 'Usulután Este/Concepción Batres';
                    break;
                case 'usuC3':
                    $municipio = 'Usulután Este/Ereguayquín';
                    break;
                case 'usuC4':
                    $municipio = 'Usulután Este/Jucuarán';
                    break;
                case 'usuC5':
                    $municipio = 'Usulután Este/Ozatlán';
                    break;
                case 'usuC6':
                    $municipio = 'Usulután Este/Santa Elena';
                    break;
                case 'usuC7':
                    $municipio = 'Usulután Este/San Dionisio';
                    break;
                case 'usuC8':
                    $municipio = 'Usulután Este/Santa María';
                    break;
                case 'usuC9':
                    $municipio = 'Usulután Este/Tecapán';
                    break;
                case 'usuC10':
                    $municipio = 'Usulután Este/Usulután';
                    break;
                case 'usuO1':
                    $municipio = 'Usulután Oeste/Jiquilisco';
                    break;
                case 'usuO2':
                    $municipio = 'Usulután Oeste/Puerto El Triunfo';
                    break;
                case 'usuO3':
                    $municipio = 'Usulután Oeste/San Agustín';
                    break;
                case 'usuO4':
                    $municipio = 'Usulután Oeste/San Francisco Javier';
                    break;
                default:
                    $municipio = '-';
                    break;
            }
            $user->municipio = $municipio;
        
        $user->website = $request->get('website');
        $user->telefono = $request->get('tel_full');

        //$user->form_status = "none"; //none, sent 

        //$user->fecha_registro = \Carbon\Carbon::now()->addDays(4)->toDateTimeString();

        //$user->visto = 'visto'; //nuevo, visto 
        

        $user->update();

        //redireccionar
        return redirect()->route('users.index')->with('success', 'Datos de usuario actualizados con éxito');
    }


    // funcion para actualizar la contraseña del usuario
    public function passwordUpdate(Request $request, $id)
    {

        $user = User::find($id);

        //validar contraseña
        $this->validate($request, [
            'password' => 'required|confirmed|min:6'
        ]);
        
        $user->password = bcrypt($request->get('password'));
        $user->save();

        //$user->password = bcrypt($request->get('password'));
        //$user->update();

        //redireccionar
        return redirect()->route('users.index')->with('success', 'Contraseña actualizada correctamente');
    }

    public function actModCat(Request $request,  $id)
    {
        
        $user = User::find($id);

        request()->validate([
            'catMod'   => 'required|numeric',
        ]);

        $user->cat_mod = $request->catMod;

        $user->update();

        return response()->json($user->cat_mod);
    }


}