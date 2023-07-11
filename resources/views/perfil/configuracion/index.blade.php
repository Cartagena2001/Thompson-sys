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

    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Información personal</h5>
                </div>

                <form method="POST" action="{{ route('perfil.update', $user->id) }}" role="form" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="mt-3">
                        <label>Imagen de perfil: </label>
                        <input class="form-control" type="file" name="imagen_perfil_src" id="image_perfil_src" value="{{ $user->imagen_perfil_src }}">
                        <img class="rounded mt-2" src="{{ $user->imagen_perfil_src }}" alt="" width="200">
                    </div>

                    <div class="mt-3">
                        <label>Nombre: </label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    </div>

                    <div class="mt-3">
                        <label>Correo Electrónico: </label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}">
                    </div>
                    <div class="mt-3">
                        <label>Teléfono: </label>
                        <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $user->telefono }}">
                    </div>
                    <div class="mt-3">
                        <label>Municipio: </label>
                        <input class="form-control" type="text" name="municipio" id="municipio" value="{{ $user->municipio }}">
                    </div>
                    <div class="mt-3">
                        <label>Departamento: </label>
                        <input class="form-control" type="text" name="departamento" id="departamento" value="{{ $user->departamento }}">
                    </div>

                    <div class="mt-3">
                        <label>Dirección: </label>
                        <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $user->direccion }}">
                    </div>


                    <div class="col-auto align-self-center mt-5">
                        <h5 class="mb-0" data-anchor="data-anchor">Información de la empresa</h5>
                    </div>

                    <div>
                        <label>Nombre: </label>
                        <input class="form-control" type="text" name="nombre_empresa" id="nombre_empresa" value="{{ $user->nombre_empresa }}" maxlength="45" placeholder="-">
                    </div>
                    <div>
                        <label>WebSite: </label>
                        <input class="form-control" type="text" name="website" id="website" value="{{ $user->website }}">
                    </div>
                    <div>
                        <label>NIT: </label>
                        <input class="form-control" type="text" name="nit" id="nit" value="{{ $user->nit }}" minlength="17" maxlength="17" placeholder="0000-000000-000-0">
                        @error('nit')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label>NRC: </label>
                        <input class="form-control" type="text" name="nrc" id="nrc" value="{{ $user->nrc }}" minlength="8" maxlength="8" placeholder="0000000-0">
                        @error('nrc')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label>WhatsApp: </label>
                        <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="{{ $user->whatsapp }}">
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" href="" class="btn btn-outline-primary btn-sm">Actualizar información</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
