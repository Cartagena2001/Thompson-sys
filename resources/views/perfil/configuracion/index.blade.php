@extends('layouts.app')

@section('content')
@section('title', 'Pefil de Usuario')

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">👤 Perfil de Usuario</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección puedes ver y editar la información de tu cuenta.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="card-header">
            <div class="row flex-between-end">
                
                <div class="col-auto align-self-center mb-3">
                    <h5 class="mb-0" data-anchor="data-anchor">👤 Información Personal:</h5>
                </div>

                <hr />

                <form method="POST" action="{{ route('perfil.update', $user->id) }}" role="form" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="mt-3 col-auto text-center col-4 mx-auto">
                        <label>Imagen de perfil: </label>
                        <br/>
                        <img class="rounded mt-2" src="{{ $user->imagen_perfil_src }}" alt="per" width="200">
                        <br/>
                        <br/>
                        <input class="form-control" type="file" name="imagen_perfil_src" id="image_perfil_src" value="{{ $user->imagen_perfil_src }}">  
                        <br/>
                    </div>

                    <div class="row mb-2">

                        <div class="col-6">
                            <label>Nombre: </label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                        </div>

                        <div class="col-6">
                            <label>Correo Electrónico: </label>
                            <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}">
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-6">
                            <label>DUI: </label>
                            <input class="form-control" type="text" name="dui" id="dui" value="{{ $user->dui }}" minlength="10" maxlength="10" placeholder="00000000-0">
                            @error('dui')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>                      

                        <div class="col-6">
                            <label>Celular/Núm. WhatsApp: </label>
                            <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="{{ $user->whatsapp }}">
                        </div>

                    </div>

                    <div class="col-auto align-self-center mt-5 mb-3">
                        <h4 class="mb-0" data-anchor="data-anchor">💼 Información de la Empresa/Negocio:</h4>
                    </div>

                    <hr />

                    <div class="row mb-2">

                        <div class="col-6">
                            <label>N° de registro (NRC): </label>
                            <input class="form-control" type="text" name="nrc" id="nrc" value="{{ $user->nrc }}" minlength="8" maxlength="8" placeholder="0000000-0">
                            @error('nrc')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label>NIT: </label>
                            <input class="form-control" type="text" name="nit" id="nit" value="{{ $user->nit }}" minlength="17" maxlength="17" placeholder="0000-000000-000-0">
                            @error('nit')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label>Nombre/razón ó denominación social: </label>
                            <input class="form-control" type="text" name="razon_social" id="razon_social" value="{{ $user->razon_social }}" maxlength="45" placeholder="-">
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label>Dirección: </label>
                            <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $user->direccion }}">
                        </div>

                    </div>

                    <div class="row mb-2">                      

                        <div class="col-6">
                            <label>Municipio/Distrito: </label>
                        <input class="form-control" type="text" name="municipio" id="municipio" value="{{ $user->municipio }}">
                        </div>

                        <div class="col-6">
                            <label>Departamento: </label>
                            <input class="form-control" type="text" name="departamento" id="departamento" value="{{ $user->departamento }}">
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label>Giro ó actividad económica: </label>
                            <textarea class="form-control" type="text" name="giro" id="giro" value="{{ $user->giro }}" rows="4" cols="50" maxlength="200" placeholder="-"></textarea>
                        </div>

                    </div>

                    <div class="row mb-2">  

                        <div class="col-12">
                            <label>Nombre Comercial: </label>
                            <input class="form-control" type="text" name="nombre_empresa" id="nombre_empresa" value="{{ $user->nombre_empresa }}" maxlength="45" placeholder="-">
                        </div>

                    </div>

                    <div class="row mb-2"> 

                        <div class="col-6">
                            <label>WebSite: </label>
                            <input class="form-control" type="text" name="website" id="website" value="{{ $user->website }}">
                        </div>

                        <div class="col-6">
                            <label>Teléfono: </label>
                            <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $user->telefono }}">
                        </div>

                    </div> 

                    <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                        <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Actualizar información</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
