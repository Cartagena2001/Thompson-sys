@extends('layouts.internal')

@section('content')

@section('title', 'Formulario de Inscripción')

    <section class="py-0 pb-6 mb-4 overflow-hidden light" id="banner">

    <div class="bg-holder overlay" style="background-image:url({{url('assets/img/bg/form-inscrip-bg.png')}});background-position: center bottom;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
      <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">

        <div class="col-md-12 col-lg-12 col-xl-12 pb-xl-12 text-center text-xl-start">

          <h3 class="text-white fw-light">Ofrecemos <span class="typed-text fw-bold" data-typed-text='["variedad","garantía","calidad","durabilidad"]'></span><br />a nuestros clientes:</h3>

          <p class="lead text-white opacity-75 text-justify">Vendedores de repuestos y distribuidores de una forma fácil y accesible obtienen sus productos y así llegan hasta sus clientes de forma eficaz y segura.</p>

        </div>


      </div>
    </div>
    <!-- end of .container-->

    </section>

    <div class="container mt-4 mb-4">

        <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h3>FORMULARIO DE INSCRIPCIÓN</h3>
                  <p class="mb-0 text-justify">Es requisito indispensable para el registro como nuevo cliente proporcionar la información solicitada en el formulario a continuación y por consiguiente para la adquisición de los productos que se ofrecen en este sitio, que lea y acepte nuestros <a href="{{url('/terminos-y-condiciones')}}" title="Leer" target="_blank">Términos y Condiciones de Uso</a>, así como nuestra <a href="{{url('/politica-de-privacidad')}}" title="Leer" target="_blank">Política de Privacidad</a>. El uso de nuestra tienda en línea, nuestros servicios así como la compra de nuestros productos implicará que usted ha leído y aceptado los Términos y Condiciones de Uso antes citados, así como la Política de Privacidad.
                  <br/>
                  <br/>
                  Todos los campos son obligatorios.
                  </p>
                </div>
              </div>
            </div>
        </div>

    @if ( Auth::user()->form_status == "sent" )

        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">

                    <div class="col-auto flex-center mb-3">
                        <image src="{{url('assets/img/imgs/Solicitud-enviada-con-exito.png')}}" alt="sent-img" class="img-fluid" />
                    </div>

                    <p class="mb-0 text-justify"><b>NOTA:</b> Recibirás una notificación por correo electrónico cuando tu solicitud haya sido aprobada.</p>
                </div>
            </div>
        </div>

    @else

        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">

                    <div class="col-auto align-self-center">
                        <h5 class="mb-0">Información de la Empresa</h5>
                    </div>

                    <hr/>

                    <form method="POST" action="{{-- route('forminscrip.load', $user->id) --}}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        
                        <div class="mt-3">
                            <label>Imagen de perfil/Logo empresa (200x200px | .png, .jpg, .jpeg): </label>
                            <input class="form-control" type="file" name="imagen_perfil_src" id="image_perfil_src" value="{{ $user->imagen_perfil_src }}">
                            <img class="rounded mt-2" src="{{ $user->imagen_perfil_src }}" alt="" width="200">
                        </div>

                        <div class="mt-3">
                            <label for="nombre_empresa">Nombre de la empresa (Según tarjeta de IVA): </label>
                            <input class="form-control" type="text" name="nombre_empresa" id="nombre_empresa" value="{{ $user->nombre_empresa }}" placeholder="-" maxlength="35" required>
                        </div>

                        <div class="mt-3">
                            <label for="direccion">Dirección (Según tarjeta de IVA): </label>
                            <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $user->direccion }}" placeholder="-" maxlength="70" required>
                        </div>

                        <div class="mt-3">
                            <label for="departamento">Departamento: </label>
                            <input class="form-control" type="text" name="departamento" id="departamento" value="{{ $user->departamento }}" placeholder="-" maxlength="15" required>
                        </div>

                        <div class="mt-3">
                            <label for="municipio">Municipio/Distrito: </label>
                            <input class="form-control" type="text" name="municipio" id="municipio" value="{{ $user->municipio }}" placeholder="-" maxlength="22" required>
                        </div>

                        <div class="mt-3">
                            <label for="telefono">Teléfono: </label>
                            <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $user->telefono }}" placeholder="0000-0000" maxlength="9" required>
                        </div>

                        <div class="mt-3">
                            <label for="whatsapp">WhatsApp: </label>
                            <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="{{ $user->whatsapp }}" placeholder="0000-0000" maxlength="9" required>
                        </div>

                        <div class="mt-3">
                            <label for="website">WebSite (URL): </label>
                            <input class="form-control" type="text" name="website" id="website" value="{{ $user->website }}" placeholder="-" maxlength="34" required>
                        </div>

                        <div class="mt-3">
                            <label for="nit">NIT/DUI: </label>
                            <input class="form-control" type="text" name="nit" id="nit" value="{{ $user->nit }}" placeholder="0000-000000-000-0" maxlength="18" required>
                            @error('nit')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="nrc">NRC (Nuémro de IVA): </label>
                            <input class="form-control" type="text" name="nrc" id="nrc" value="{{ $user->nrc }}" placeholder="0000000-0" maxlength="10" required>
                            @error('nrc')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 
                        <div class="mt-3">
                            <label>Nombre del Contacto: </label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                        </div>
                        <div class="mt-3">
                            <label>Correo Electrónico: </label>
                            <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}">
                        </div>
                        --}}
                        
                        <div class="mt-5">
                            <button class="btn btn-primary me-1 mb-1" type="submit"><i class="fas fa-file-import"></i> Enviar información</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    @endif

    </div>

@endsection
