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

            <div class="card-body position-relative" style="border: ridge 1px #ff1620;">
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

    @if ( Auth::user()->form_status == "sent" || Auth::user()->form_status == "pending" )

        <div class="card mb-3" style="border: ridge 1px #ff1620;">
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

        <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
                <div class="row flex-between-end">

                    <div class="col-auto align-self-center mt-2 mb-3">
                        <h4 class="mb-0" data-anchor="data-anchor">👤 Información Personal:</h4>
                    </div>

                    <hr/>

                    <form method="POST" action="{{-- route('forminscrip.load') --}}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        <div class="mt-3 col-auto text-center col-6 mx-auto">
                            <label for="imagen_perfil_src">Imagen de perfil/Logo empresa (200x200px | .png, .jpg, .jpeg): </label>
                            <br/>
                            <img class="rounded mt-2" src="{{ url('storage/assets/img/perfil-user/'.$user->imagen_perfil_src) }}" alt="img-perfil" width="200">
                            <br/>
                            <br/>
                            <input class="form-control" type="file" name="imagen_perfil_src" id="image_perfil_src" value="{{ $user->imagen_perfil_src }}">  
                            <br/>
                            @error('imagen_perfil_src')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-2">

                            <div class="col-6">
                                <label for="name">Nombre: </label>
                                <input class="form-control" type="text" id="name" value="{{ $user->name }}" placeholder="-" readonly>
                            </div>

                            <div class="col-6">
                                <label for="email">Correo Electrónico: </label>
                                <input class="form-control" type="text" id="email" value="{{ $user->email }}" placeholder="-" readonly>
                            </div>

                        </div>

                        <div class="row mb-2">

                            <div class="col-6">
                                <label for="dui">DUI: </label>
                                <input class="form-control" type="text" name="dui" id="dui" value="{{ $user->dui }}" minlength="9" maxlength="10" placeholder="00000000-0" required>
                                @error('dui')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>                      

                            <div class="col-6">
                                <label for="whatsapp">Celular/Núm. WhatsApp: </label>
                                <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="{{ $user->whatsapp }}" placeholder="0000-0000" minlength="8" maxlength="9" required>
                                @error('whatsapp')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row py-4">

                            <div class="col-12">
                                <p class="text-justify"><b>NOTA:</b> La siguiente información puede o no aplicar parcial o totalmente según la naturaleza juridica de tu negocio, si posees Número de Registro del Contribuyente (NRC) selecciona "negocio registrado", si no, selecciona "comerciante sin iva".</p>
                            </div>                      

                        </div>

                        <div class="mb-4">
                            <div class="text-center">
                                <label class="form-label" for="negTipo">Selecciona según convenga:
                                <br/> 
                                <br/> 
                                <input type="radio" name="negTipo" value="negocio" checked> <span style="color: #ff5722;">Negocio Registrado</span>
                                <br/> 
                                <br/> 
                                <input type="radio" name="negTipo" value="persona"> <span style="color: #009688;">Comerciante sin IVA</span>
                                </label> 
                            </div>
                        </div>

                        <div class="col-auto align-self-center mt-2htm mb-3">
                            <h4 class="mb-0">💼 Información de la Empresa/Negocio:</h4>
                        </div>

                        <hr />

                        <div class="row mb-2">

                            <div class="col-6">
                                <label for="nrc">N° de registro (NRC): </label>
                                <input class="form-control" type="text" name="nrc" id="nrc" value="{{ $user->nrc }}" minlength="8" maxlength="10" placeholder="0000000-0">
                                @error('nrc')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="nit">NIT (incluyendo guiones medios): </label>
                                <input class="form-control" type="text" name="nit" id="nit" value="{{ $user->nit }}" minlength="17" maxlength="17" placeholder="0000-000000-000-0">
                                @error('nit')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">

                            <div class="col-12">
                                <label for="razon_social">Nombre/razón ó denominación social: </label>
                                <input class="form-control" type="text" name="razon_social" id="razon_social" value="{{ $user->razon_social }}" maxlength="34" placeholder="-">
                                @error('razon_social')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">

                            <div class="col-12">
                                <label for="direccion">Dirección: </label>
                                <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $user->direccion }}" placeholder="-" maxlength="75" required>
                                @error('direccion')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">                      

                            <div class="col-6">
                                <label for="municipio">Municipio/Distrito: </label>
                                <input class="form-control" type="text" name="municipio" id="municipio" value="{{ $user->municipio }}" placeholder="-" maxlength="25" required>
                                @error('municipio')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="departamento">Departamento: </label>
                                <input class="form-control" type="text" name="departamento" id="departamento" value="{{ $user->departamento }}" placeholder="-" maxlength="15" required>
                                @error('departamento')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">

                            <div class="col-12">
                                <label for="giro">Giro ó actividad económica: </label>
                                <textarea class="form-control" type="text" name="giro" id="giro" rows="4" cols="50" maxlength="180" placeholder="-" required>{{ $user->giro }}</textarea>
                                @error('giro')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">  

                            <div class="col-12">
                                <label for="nombre_empresa">Nombre Comercial: </label>
                                <input class="form-control" type="text" name="nombre_empresa" id="nombre_empresa" value="{{ $user->nombre_empresa }}" maxlength="34" placeholder="-" required>
                                @error('nombre_empresa')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2"> 

                            <div class="col-6">
                                <label for="website">WebSite: </label>
                                <input class="form-control" type="text" name="website" id="website" value="{{ $user->website }}" placeholder="-" maxlength="34" required>
                                @error('website')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="telefono">Teléfono: </label>
                                <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $user->telefono }}" placeholder="0000-0000" minlength="8" maxlength="9" required>
                                @error('telefono')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-12 pt-4">
                          <div style="display: flex; justify-content: center;">
                            {!! htmlFormSnippet() !!}
                          </div>  
                        </div> 

                        <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file-import"></i> Enviar información</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>

    @endif

    </div>

<script type="text/javascript">

    $(document).ready(function(){

        $('input[type=radio][name=negTipo]').change( function () {

            let selected_value = $("input[name='negTipo']:checked").val();
            
            if (selected_value == 'negocio') {

                //registrado
                $('#nrc').val();
                $('#nrc').attr("readonly", false);
                $('#nrc').css("background-color", "transparent");
                
                $('#nit').val();
                $('#nit').attr("readonly", false);
                $('#nit').css("background-color", "transparent");
                
                $('#razon_social').val();
                $('#razon_social').attr("readonly", false);
                $('#razon_social').css("background-color", "transparent");
                
                $('#giro').val();
                $('#giro').attr("readonly", false);
                $('#giro').css("background-color", "transparent");
                
                $('#nombre_empresa').val();
                $('#nombre_empresa').attr("readonly", false);
                $('#nombre_empresa').css("background-color", "transparent");
                
                $('#website').val();

                $('#telefono').val();

            } else {

                //no registrado
                $('#nrc').val('-');
                $('#nrc').attr("readonly", true);
                $('#nrc').css("background-color", "gainsboro");
                
                $('#nit').val('-');
                $('#nit').attr("readonly", true);
                $('#nit').css("background-color", "gainsboro");
                
                $('#razon_social').val('-');
                $('#razon_social').attr("readonly", true);
                $('#razon_social').css("background-color", "gainsboro");
                
                $('#giro').val('-');
                $('#giro').attr("readonly", true);
                $('#giro').css("background-color", "gainsboro");
                
                $('#nombre_empresa').val('-');
                $('#nombre_empresa').attr("readonly", true);
                $('#nombre_empresa').css("background-color", "gainsboro");
                
                //$('#website').val('-');

                //$('#telefono').val('-');

            }
            
        });
    });

</script>

@endsection
