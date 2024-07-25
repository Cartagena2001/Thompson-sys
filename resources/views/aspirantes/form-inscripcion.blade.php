@extends('layouts.internal')

@section('content')

@section('title', 'Formulario de Inscripción')
    
    <style type="text/css">
        .iti {
            width: 100%;
        }
    </style>

    <section class="disp-sm-none disp-md-none py-0 pb-6 mb-4 overflow-hidden light" id="banner">

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
                <div class="col-lg-12">
                  <h3>FORMULARIO DE INSCRIPCIÓN</h3>
                  <p class="mb-0 text-justify">Es requisito indispensable para el registro como nuevo cliente proporcionar la información solicitada en el formulario a continuación y por consiguiente para la adquisición de los productos que se ofrecen en este sitio, que lea y acepte nuestros <a href="{{url('/terminos-y-condiciones')}}" title="Leer" target="_blank">Términos y Condiciones de Uso</a>, así como nuestra <a href="{{url('/politica-de-privacidad')}}" title="Leer" target="_blank">Política de Privacidad</a>. El uso de nuestra tienda en línea, nuestros servicios así como la compra de nuestros productos implicará que usted ha leído y aceptado los Términos y Condiciones de Uso antes citados, así como la Política de Privacidad.
                  <br/>
                  <br/>
                  Todos los campos son obligatorios (si aplica).
                  <br/>
                  <br/>
                  </p>
                  <p class="mb-0 text-center fw-semi-bold dark">Completar formulario <br/></p>
                  <p class="text-center pulso" style="font-size: 20px;"><a href="#formM" title="Ir a" target="_self" style="text-decoration: none;">🔻</a></p>
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
                            <label for="imagen_perfil_src">Imagen de perfil/Logo empresa (idealmente 200x200px | .png, .jpg, .jpeg): </label>
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
                                <label for="whatsapp">Celular/Núm. WhatsApp: </label><br/>
                                <input class="form-control" type="tel" name="whatsapp" id="whatsapp" data-intl-tel-input-id="0" autocomplete="off" value="{{ $user->whatsapp }}" placeholder="0000-0000" minlength="8" maxlength="19" required>
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

                        <div id="formM" class="mb-4">
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
                                <label for="departamento">Departamento: </label>
                                <select class="form-select" id="departamento" name="departamento" required>
                                    <option value="0">Selecione un departamento</option>
                                    
                                    <option value="ahu" {{ old('departamento') == 'ahu' ? 'selected' : '' }} >Ahuachapán</option>
                                    <option value="cab" {{ old('departamento') == 'cab' ? 'selected' : '' }} >Cabañas</option>
                                    <option value="cha" {{ old('departamento') == 'cha' ? 'selected' : '' }} >Chalatenango</option>
                                    <option value="cus" {{ old('departamento') == 'cus' ? 'selected' : '' }} >Cuscatlán</option>
                                    <option value="lib" {{ old('departamento') == 'lib' ? 'selected' : '' }} >La Libertad</option>
                                    <option value="mor" {{ old('departamento') == 'mor' ? 'selected' : '' }} >Morazán</option>
                                    <option value="paz" {{ old('departamento') == 'paz' ? 'selected' : '' }} >La Paz</option>
                                    <option value="ana" {{ old('departamento') == 'ana' ? 'selected' : '' }} >Santa Ana</option>
                                    <option value="mig" {{ old('departamento') == 'mig' ? 'selected' : '' }} >San Miguel</option>
                                    <option value="ssl" {{ old('departamento') == 'ssl' ? 'selected' : '' }} >San Salvador</option>
                                    <option value="svi" {{ old('departamento') == 'svi' ? 'selected' : '' }} >San Vicente</option>
                                    <option value="son" {{ old('departamento') == 'son' ? 'selected' : '' }} >Sonsonate</option>
                                    <option value="uni" {{ old('departamento') == 'uni' ? 'selected' : '' }} >La Unión</option>
                                    <option value="usu" {{ old('departamento') == 'usu' ? 'selected' : '' }} >Usulután</option>
      
                                </select>

                                @error('departamento')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                   

                            <div class="col-6">
                                <label for="municipio">Municipio/Distrito: </label>
                                <select class="form-select" id="municipio" name="municipio" required>
                                    <option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>
                                </select>
                                @error('municipio')
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
                                <input class="form-control" type="tel" name="telefono" id="telefono" data-intl-tel-input-id="1" autocomplete="off" value="{{ $user->telefono }}" placeholder="0000-0000" minlength="8" maxlength="19" required>
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

    $('#departamento').on('change', function (e) {
        
        if (e.target.value == 'ahu') {

            //1
            var ahuM = "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                       "<option value='ahuN1' {{ old('municipio') == 'ahuN1' ? 'selected' : '' }} >Ahuachapán Norte/Atiquizaya</option>" +
                       "<option value='ahuN2' {{ old('municipio') == 'ahuN2' ? 'selected' : '' }} >Ahuachapán Norte/El Refugio</option>" +
                       "<option value='ahuN3' {{ old('municipio') == 'ahuN3' ? 'selected' : '' }} >Ahuachapán Norte/San Lorenzo</option>" +
                       "<option value='ahuN4' {{ old('municipio') == 'ahuN4' ? 'selected' : '' }} >Ahuachapán Norte/Turín</option>" +
                       "<option value='ahuC1' {{ old('municipio') == 'ahuC1' ? 'selected' : '' }} >Ahuachapán Centro/Ahuachapán</option>" +
                       "<option value='ahuC2' {{ old('municipio') == 'ahuC2' ? 'selected' : '' }} >Ahuachapán Centro/Apaneca</option>" +
                       "<option value='ahuC3' {{ old('municipio') == 'ahuC3' ? 'selected' : '' }} >Ahuachapán Centro/Concepción de Ataco</option>" +
                       "<option value='ahuC4' {{ old('municipio') == 'ahuC4' ? 'selected' : '' }} >Ahuachapán Centro/Tacuba</option>" +
                       "<option value='ahuS1' {{ old('municipio') == 'ahuS1' ? 'selected' : '' }} >Ahuachapán Sur/Guaymango</option>" +
                       "<option value='ahuS2' {{ old('municipio') == 'ahuS2' ? 'selected' : '' }} >Ahuachapán Sur/Jujutla</option>" +
                       "<option value='ahuS3' {{ old('municipio') == 'ahuS3' ? 'selected' : '' }} >Ahuachapán Sur/San Francisco Menéndez</option>" +
                       "<option value='ahuS4' {{ old('municipio') == 'ahuS4' ? 'selected' : '' }} >Ahuachapán Sur/San Pedro Puxtla</option>";

            $("#municipio").find("option").remove().end().append(ahuM);


        } else if (e.target.value == 'cab') {

            //2
            var cabM = "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                       "<option value='cabE1' {{ old('municipio') == 'cabE1' ? 'selected' : '' }} >Cabañas Este/Guacotecti</option>" +
                       "<option value='cabE2' {{ old('municipio') == 'cabE2' ? 'selected' : '' }} >Cabañas Este/San Isidro</option>" +
                       "<option value='cabE3' {{ old('municipio') == 'cabE3' ? 'selected' : '' }} >Cabañas Este/Sensuntepeque</option>" +
                       "<option value='cabE4' {{ old('municipio') == 'cabE4' ? 'selected' : '' }} >Cabañas Este/Victoria</option>" +
                       "<option value='cabE5' {{ old('municipio') == 'cabE5' ? 'selected' : '' }} >Cabañas Este/Dolores</option>" +
                       "<option value='cabO1' {{ old('municipio') == 'cabO1' ? 'selected' : '' }} >Cabañas Oeste/Cinquera</option>" +
                       "<option value='cabO2' {{ old('municipio') == 'cabO2' ? 'selected' : '' }} >Cabañas Oeste/Ilobasco</option>" +
                       "<option value='cabO3' {{ old('municipio') == 'cabO3' ? 'selected' : '' }} >Cabañas Oeste/Jutiapa</option>" +
                       "<option value='cabO4' {{ old('municipio') == 'cabO4' ? 'selected' : '' }} >Cabañas Oeste/Tejutepeque</option>";

            $("#municipio").find("option").remove().end().append(cabM); 

        } else if (e.target.value == 'cha') {

            //3
            var chaM = "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                       "<option value='chaN1' {{ old('municipio') == 'cabE1' ? 'selected' : '' }} >Chalatenango Norte/Citalá</option>" +
                       "<option value='chaN2' {{ old('municipio') == 'cabE2' ? 'selected' : '' }} >Chalatenango Norte/La Palmao</option>" +
                       "<option value='chaN3' {{ old('municipio') == 'cabE3' ? 'selected' : '' }} >Chalatenango Norte/San Ignacio</option>" +
                       "<option value='chaC1' {{ old('municipio') == 'chaC1' ? 'selected' : '' }} >Chalatenango Centro/Agua Caliente</option>" +
                       "<option value='chaC2' {{ old('municipio') == 'chaC2' ? 'selected' : '' }} >Chalatenango Centro/Dulce Nombre de María</option>" +
                       "<option value='chaC3' {{ old('municipio') == 'chaC3' ? 'selected' : '' }} >Chalatenango Centro/El Paraíso</option>" +
                       "<option value='chaC4' {{ old('municipio') == 'chaC4' ? 'selected' : '' }} >Chalatenango Centro/La Reina</option>" +
                       "<option value='chaC5' {{ old('municipio') == 'chaC5' ? 'selected' : '' }} >Chalatenango Centro/Nueva Concepción</option>" +
                       "<option value='chaC6' {{ old('municipio') == 'chaC6' ? 'selected' : '' }} >Chalatenango Centro/San Fernando</option>" +
                       "<option value='chaC7' {{ old('municipio') == 'chaC7' ? 'selected' : '' }} >Chalatenango Centro/San Francisco Morazán</option>" +
                       "<option value='chaC8' {{ old('municipio') == 'chaC8' ? 'selected' : '' }} >Chalatenango Centro/San Rafael</option>" +
                       "<option value='chaC9' {{ old('municipio') == 'chaC9' ? 'selected' : '' }} >Chalatenango Centro/Santa Rita</option>" +
                       "<option value='chaC10' {{ old('municipio') == 'chaC10' ? 'selected' : '' }} >Chalatenango Centro/Tejutla</option>" +
                       "<option value='chaS1' {{ old('municipio') == 'chaS1' ? 'selected' : '' }} >Chalatenango Sur/Arcatao</option>" +
                       "<option value='chaS2' {{ old('municipio') == 'chaS2' ? 'selected' : '' }} >Chalatenango Sur/Azacualpa</option>" +
                       "<option value='chaS3' {{ old('municipio') == 'chaS3' ? 'selected' : '' }} >Chalatenango Sur/Cancasque</option>" +
                       "<option value='chaS4' {{ old('municipio') == 'chaS4' ? 'selected' : '' }} >Chalatenango Sur/Chalatenango</option>" +
                       "<option value='chaS5' {{ old('municipio') == 'chaS5' ? 'selected' : '' }} >Chalatenango Sur/Comalapa</option>" +
                       "<option value='chaS6' {{ old('municipio') == 'chaS6' ? 'selected' : '' }} >Chalatenango Sur/Concepción Quezaltepeque</option>" +
                       "<option value='chaS7' {{ old('municipio') == 'chaS7' ? 'selected' : '' }} >Chalatenango Sur/El Carrizal</option>" +
                       "<option value='chaS8' {{ old('municipio') == 'chaS8' ? 'selected' : '' }} >Chalatenango Sur/La Laguna</option>" +
                       "<option value='chaS9' {{ old('municipio') == 'chaS9' ? 'selected' : '' }} >Chalatenango Sur/Las Vueltas</option>" +
                       "<option value='chaS10' {{ old('municipio') == 'chaS10' ? 'selected' : '' }} >Chalatenango Sur/Las Flores</option>" +
                       "<option value='chaS11' {{ old('municipio') == 'chaS11' ? 'selected' : '' }} >Chalatenango Sur/Nombre de Jesús</option>" +
                       "<option value='chaS12' {{ old('municipio') == 'chaS12' ? 'selected' : '' }} >Chalatenango Sur/Nueva Trinidad</option>" +
                       "<option value='chaS13' {{ old('municipio') == 'chaS13' ? 'selected' : '' }} >Chalatenango Sur/Ojos de Agua</option>" +
                       "<option value='chaS14' {{ old('municipio') == 'chaS14' ? 'selected' : '' }} >Chalatenango Sur/Potonico</option>" +
                       "<option value='chaS15' {{ old('municipio') == 'chaS15' ? 'selected' : '' }} >Chalatenango Sur/San Antonio de la Cruz</option>" +
                       "<option value='chaS16' {{ old('municipio') == 'chaS16' ? 'selected' : '' }} >Chalatenango Sur/San Antonio Los Ranchos</option>" +
                       "<option value='chaS17' {{ old('municipio') == 'chaS17' ? 'selected' : '' }} >Chalatenango Sur/San Francisco Lempa</option>" +
                       "<option value='chaS18' {{ old('municipio') == 'chaS18' ? 'selected' : '' }} >Chalatenango Sur/San Isidro Labrador</option>" +
                       "<option value='chaS19' {{ old('municipio') == 'chaS19' ? 'selected' : '' }} >Chalatenango Sur/San Luis del Carmen</option>" +
                       "<option value='chaS20' {{ old('municipio') == 'chaS20' ? 'selected' : '' }} >Chalatenango Sur/San Miguel de Mercedes</option>";

            $("#municipio").find("option").remove().end().append(chaM);

        } else if (e.target.value == 'cus') {

            //4
            var cusM = "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                       "<option value='cusN1' {{ old('municipio') == 'cusN1' ? 'selected' : '' }} >Cuscatlán Norte/Suchitoto</option>" +
                       "<option value='cusN2' {{ old('municipio') == 'cusN2' ? 'selected' : '' }} >Cuscatlán Norte/San José Guayabal</option>" +
                       "<option value='cusN3' {{ old('municipio') == 'cusN3' ? 'selected' : '' }} >Cuscatlán Norte/Oratorio de Concepción</option>" +
                       "<option value='cusN4' {{ old('municipio') == 'cusN4' ? 'selected' : '' }} >Cuscatlán Norte/San Bartolomé Perulapía</option>" +
                       "<option value='cusN5' {{ old('municipio') == 'cusN5' ? 'selected' : '' }} >Cuscatlán Norte/San Pedro Perulapán</option>" +
                       "<option value='cusS1' {{ old('municipio') == 'cusS1' ? 'selected' : '' }} >Cuscatlán Sur/Cojutepeque</option>" +
                       "<option value='cusS2' {{ old('municipio') == 'cusS2' ? 'selected' : '' }} >Cuscatlán Sur/Candelaria</option>" +
                       "<option value='cusS3' {{ old('municipio') == 'cusS3' ? 'selected' : '' }} >Cuscatlán Sur/El Carmen</option>" +
                       "<option value='cusS4' {{ old('municipio') == 'cusS4' ? 'selected' : '' }} >Cuscatlán Sur/El Rosario</option>" +
                       "<option value='cusS5' {{ old('municipio') == 'cusS5' ? 'selected' : '' }} >Cuscatlán Sur/Monte San Juan</option>" +
                       "<option value='cusS6' {{ old('municipio') == 'cusS6' ? 'selected' : '' }} >Cuscatlán Sur/San Cristóbal</option>" +
                       "<option value='cusS7' {{ old('municipio') == 'cusS7' ? 'selected' : '' }} >Cuscatlán Sur/San Rafael Cedros</option>" +
                       "<option value='cusS8' {{ old('municipio') == 'cusS8' ? 'selected' : '' }} >Cuscatlán Sur/San Ramón</option>" +
                       "<option value='cusS9' {{ old('municipio') == 'cusS9' ? 'selected' : '' }} >Cuscatlán Sur/Santa Cruz Analquito</option>" +
                       "<option value='cusS10' {{ old('municipio') == 'cusS10' ? 'selected' : '' }} >Cuscatlán Sur/Santa Cruz Michapa</option>" +
                       "<option value='cusS11' {{ old('municipio') == 'cusS11' ? 'selected' : '' }} >Cuscatlán Sur/Tenancingo</option>";

            $("#municipio").find("option").remove().end().append(cusM);

        } else if (e.target.value == 'lib') {

            //5
            var libM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='libN1' {{ old('municipio') == 'libN1' ? 'selected' : '' }} >La Libertad Norte/Quezaltepeque</option>" +
                        "<option value='libN2' {{ old('municipio') == 'libN2' ? 'selected' : '' }} >La Libertad Norte/San Matías</option>" +
                        "<option value='libN3' {{ old('municipio') == 'libN3' ? 'selected' : '' }} >La Libertad Norte/San Pablo Tacachico</option>" +
                        "<option value='libC1' {{ old('municipio') == 'libC1' ? 'selected' : '' }} >La Libertad Centro/San Juan Opico</option>" +
                        "<option value='libC2' {{ old('municipio') == 'libC2' ? 'selected' : '' }} >La Libertad Centro/Ciudad Arce</option>" +
                        "<option value='libO1' {{ old('municipio') == 'libO1' ? 'selected' : '' }} >La Libertad Oeste/Colón</option>" +
                        "<option value='libO2' {{ old('municipio') == 'libO2' ? 'selected' : '' }} >La Libertad Oeste/Jayaque</option>" +
                        "<option value='libO3' {{ old('municipio') == 'libO3' ? 'selected' : '' }} >La Libertad Oeste/Sacacoyo</option>" +
                        "<option value='libO4' {{ old('municipio') == 'libO4' ? 'selected' : '' }} >La Libertad Oeste/Tepecoyo</option>" +
                        "<option value='libO5' {{ old('municipio') == 'libO5' ? 'selected' : '' }} >La Libertad Oeste/Talnique</option>" +
                        "<option value='libE1' {{ old('municipio') == 'libE1' ? 'selected' : '' }} >La Libertad Este/Antiguo Cuscatlán</option>" +
                        "<option value='libE2' {{ old('municipio') == 'libE2' ? 'selected' : '' }} >La Libertad Este/Huizúcar</option>" +
                        "<option value='libE3' {{ old('municipio') == 'libE3' ? 'selected' : '' }} >La Libertad Este/Nuevo Cuscatlán</option>" +
                        "<option value='libE4' {{ old('municipio') == 'libE4' ? 'selected' : '' }} >La Libertad Este/San José Villanueva</option>" +
                        "<option value='libE5' {{ old('municipio') == 'libE5' ? 'selected' : '' }} >La Libertad Este/Zaragoza</option>" +
                        "<option value='libCt1' {{ old('municipio') == 'libCt1' ? 'selected' : '' }} >La Libertad Costa/Chiltiupán</option>" +
                        "<option value='libCt2' {{ old('municipio') == 'libCt2' ? 'selected' : '' }} >La Libertad Costa/Jicalapa</option>" +
                        "<option value='libCt3' {{ old('municipio') == 'libCt3' ? 'selected' : '' }} >La Libertad Costa/La Libertad</option>" +
                        "<option value='libCt4' {{ old('municipio') == 'libCt4' ? 'selected' : '' }} >La Libertad Costa/Tamanique</option>" +
                        "<option value='libCt5' {{ old('municipio') == 'libCt5' ? 'selected' : '' }} >La Libertad Costa/Teotepeque</option>" +
                        "<option value='libS1' {{ old('municipio') == 'libS1' ? 'selected' : '' }} >La Libertad Sur/Santa Tecla</option>" +
                        "<option value='libS2' {{ old('municipio') == 'libS2' ? 'selected' : '' }} >La Libertad Sur/Comasagua</option>";

            $("#municipio").find("option").remove().end().append(libM);
            
        } else if (e.target.value == 'mor') {

            //6
            var morM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='morN1' {{ old('municipio') == 'morN1' ? 'selected' : '' }} >Morazán Norte/Arambala</option>" +
                        "<option value='morN2' {{ old('municipio') == 'morN2' ? 'selected' : '' }} >Morazán Norte/Cacaopera</option>" +
                        "<option value='morN3' {{ old('municipio') == 'morN3' ? 'selected' : '' }} >Morazán Norte/Corinto</option>" +
                        "<option value='morN4' {{ old('municipio') == 'morN4' ? 'selected' : '' }} >Morazán Norte/El Rosario</option>" +
                        "<option value='morN5' {{ old('municipio') == 'morN5' ? 'selected' : '' }} >Morazán Norte/Joateca</option>" +
                        "<option value='morN6' {{ old('municipio') == 'morN6' ? 'selected' : '' }} >Morazán Norte/Jocoaitique</option>" +
                        "<option value='morN7' {{ old('municipio') == 'morN7' ? 'selected' : '' }} >Morazán Norte/Meanguera</option>" +
                        "<option value='morN8' {{ old('municipio') == 'morN8' ? 'selected' : '' }} >Morazán Norte/Perquín</option>" +
                        "<option value='morN9' {{ old('municipio') == 'morN9' ? 'selected' : '' }} >Morazán Norte/San Fernando</option>" +
                        "<option value='morN10' {{ old('municipio') == 'morN10' ? 'selected' : '' }} >Morazán Norte/San Isidro</option>" +
                        "<option value='morN11' {{ old('municipio') == 'morN11' ? 'selected' : '' }} >Morazán Norte/Torola</option>" +
                        "<option value='morS1' {{ old('municipio') == 'morS1' ? 'selected' : '' }} >Morazán Sur/Chilanga</option>" +
                        "<option value='morS2' {{ old('municipio') == 'morS2' ? 'selected' : '' }} >Morazán Sur/Delicias de Concepción</option>" +
                        "<option value='morS3' {{ old('municipio') == 'morS3' ? 'selected' : '' }} >Morazán Sur/El Divisadero</option>" +
                        "<option value='morS4' {{ old('municipio') == 'morS4' ? 'selected' : '' }} >Morazán Sur/Gualococti</option>" +
                        "<option value='morS5' {{ old('municipio') == 'morS5' ? 'selected' : '' }} >Morazán Sur/Guatajiagua</option>" +
                        "<option value='morS6' {{ old('municipio') == 'morS6' ? 'selected' : '' }} >Morazán Sur/Jocoro</option>" +
                        "<option value='morS7' {{ old('municipio') == 'morS7' ? 'selected' : '' }} >Morazán Sur/Lolotiquillo</option>" +
                        "<option value='morS8' {{ old('municipio') == 'morS8' ? 'selected' : '' }} >Morazán Sur/Osicala</option>" +
                        "<option value='morS9' {{ old('municipio') == 'morS9' ? 'selected' : '' }} >Morazán Sur/San Carlos</option>" +
                        "<option value='morS10' {{ old('municipio') == 'morS10' ? 'selected' : '' }} >Morazán Sur/San Francisco Gotera</option>" +
                        "<option value='morS11' {{ old('municipio') == 'morS11' ? 'selected' : '' }} >Morazán Sur/San Simón</option>" +
                        "<option value='morS12' {{ old('municipio') == 'morS12' ? 'selected' : '' }} >Morazán Sur/Sensembra</option>" +
                        "<option value='morS13' {{ old('municipio') == 'morS13' ? 'selected' : '' }} >Morazán Sur/Sociedad</option>" +
                        "<option value='morS14' {{ old('municipio') == 'morS14' ? 'selected' : '' }} >Morazán Sur/Yamabal</option>" +
                        "<option value='morS15' {{ old('municipio') == 'morS15' ? 'selected' : '' }} >Morazán Sur/Yoloaiquín</option>";

            $("#municipio").find("option").remove().end().append(morM);  

        } else if (e.target.value == 'paz') {

            //7
            var pazM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='pazO1' {{ old('municipio') == 'pazO1' ? 'selected' : '' }} >La Paz Oeste/Cuyultitán</option>" +
                        "<option value='pazO2' {{ old('municipio') == 'pazO2' ? 'selected' : '' }} >La Paz Oeste/Olocuilta</option>" +
                        "<option value='pazO3' {{ old('municipio') == 'pazO3' ? 'selected' : '' }} >La Paz Oeste/San Juan Talpa</option>" +
                        "<option value='pazO4' {{ old('municipio') == 'pazO4' ? 'selected' : '' }} >La Paz Oeste/San Luis Talpa</option>" +
                        "<option value='pazO5' {{ old('municipio') == 'pazO5' ? 'selected' : '' }} >La Paz Oeste/San Pedro Masahuat</option>" +
                        "<option value='pazO6' {{ old('municipio') == 'pazO6' ? 'selected' : '' }} >La Paz Oeste/Tapalhuaca</option>" +
                        "<option value='pazO7' {{ old('municipio') == 'pazO7' ? 'selected' : '' }} >La Paz Oeste/San Francisco Chinameca</option>" +
                        "<option value='pazC1' {{ old('municipio') == 'pazC1' ? 'selected' : '' }} >La Paz Centro/El Rosario</option>" +
                        "<option value='pazC2' {{ old('municipio') == 'pazC2' ? 'selected' : '' }} >La Paz Centro/Jerusalén</option>" +
                        "<option value='pazC3' {{ old('municipio') == 'pazC3' ? 'selected' : '' }} >La Paz Centro/Mercedes La Ceiba</option>" +
                        "<option value='pazC4' {{ old('municipio') == 'pazC4' ? 'selected' : '' }} >La Paz Centro/Paraíso de Osorio</option>" +
                        "<option value='pazC5' {{ old('municipio') == 'pazC5' ? 'selected' : '' }} >La Paz Centro/San Antonio Masahuat</option>" +
                        "<option value='pazC6' {{ old('municipio') == 'pazC6' ? 'selected' : '' }} >La Paz Centro/San Emigdio</option>" +
                        "<option value='pazC7' {{ old('municipio') == 'pazC7' ? 'selected' : '' }} >La Paz Centro/San Juan Tepezontes</option>" +
                        "<option value='pazC8' {{ old('municipio') == 'pazC8' ? 'selected' : '' }} >La Paz Centro/San Luis La Herradura</option>" +
                        "<option value='pazC9' {{ old('municipio') == 'pazC9' ? 'selected' : '' }} >La Paz Centro/San Miguel Tepezontes</option>" +
                        "<option value='pazC10' {{ old('municipio') == 'pazC10' ? 'selected' : '' }} >La Paz Centro/San Pedro Nonualco</option>" +
                        "<option value='pazC11' {{ old('municipio') == 'pazC11' ? 'selected' : '' }} >La Paz Centro/Santa María Ostuma</option>" +
                        "<option value='pazC12' {{ old('municipio') == 'pazC12' ? 'selected' : '' }} >La Paz Centro/Santiago Nonualco</option>" +
                        "<option value='pazE1' {{ old('municipio') == 'pazE1' ? 'selected' : '' }} >La Paz Este/San Juan Nonualco</option>" +
                        "<option value='pazE2' {{ old('municipio') == 'pazE2' ? 'selected' : '' }} >La Paz Este/San Rafael Obrajuelo</option>" +
                        "<option value='pazE3' {{ old('municipio') == 'pazE3' ? 'selected' : '' }} >La Paz Este/Zacatecoluca</option>";

            $("#municipio").find("option").remove().end().append(pazM);

        } else if (e.target.value == 'ana') {

            //8
            var anaM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='anaN1' {{ old('municipio') == 'anaN1' ? 'selected' : '' }} >Santa Ana Norte/Masahuat</option>" +
                        "<option value='anaN2' {{ old('municipio') == 'anaN2' ? 'selected' : '' }} >Santa Ana Norte/Metapán</option>" +
                        "<option value='anaN3' {{ old('municipio') == 'anaN3' ? 'selected' : '' }} >Santa Ana Norte/Santa Rosa Guachipilín</option>" +
                        "<option value='anaN4' {{ old('municipio') == 'anaN4' ? 'selected' : '' }} >Santa Ana Norte/Texistepeque</option>" +
                        "<option value='anaC5' {{ old('municipio') == 'anaC5' ? 'selected' : '' }} >Santa Ana Centro/Santa Ana</option>" +
                        "<option value='anaE6' {{ old('municipio') == 'anaE6' ? 'selected' : '' }} >Santa Ana Este/Coatepeque</option>" +
                        "<option value='anaE7' {{ old('municipio') == 'anaE7' ? 'selected' : '' }} >Santa Ana Este/El Congo</option>" +
                        "<option value='anaO1' {{ old('municipio') == 'anaO1' ? 'selected' : '' }} >Santa Ana Oeste/Candelaria de la Frontera</option>" +
                        "<option value='anaO2' {{ old('municipio') == 'anaO2' ? 'selected' : '' }} >Santa Ana Oeste/Chalchuapa</option>" +
                        "<option value='anaO3' {{ old('municipio') == 'anaO3' ? 'selected' : '' }} >Santa Ana Oeste/El Porvenir</option>" +
                        "<option value='anaO4' {{ old('municipio') == 'anaO4' ? 'selected' : '' }} >Santa Ana Oeste/San Antonio Pajonal</option>" +
                        "<option value='anaO5' {{ old('municipio') == 'anaO5' ? 'selected' : '' }} >Santa Ana Oeste/San Sebastián Salitrillo</option>" +
                        "<option value='anaO6' {{ old('municipio') == 'anaO6' ? 'selected' : '' }} >Santa Ana Oeste/Santiago de la Frontera</option>"; 

            $("#municipio").find("option").remove().end().append(anaM);

        } else if (e.target.value == 'mig') {

            //9
            var migM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='migN1' {{ old('municipio') == 'migN1' ? 'selected' : '' }} >San Miguel Norte/Ciudad Barrios</option>" +
                        "<option value='migN2' {{ old('municipio') == 'migN2' ? 'selected' : '' }} >San Miguel Norte/Sesori</option>" +
                        "<option value='migN3' {{ old('municipio') == 'migN3' ? 'selected' : '' }} >San Miguel Norte/Nuevo Edén de San Juan</option>" +
                        "<option value='migN4' {{ old('municipio') == 'migN4' ? 'selected' : '' }} >San Miguel Norte/San Gerardo</option>" +
                        "<option value='migN5' {{ old('municipio') == 'migN5' ? 'selected' : '' }} >San Miguel Norte/San Luis de la Reina</option>" +
                        "<option value='migN6' {{ old('municipio') == 'migN6' ? 'selected' : '' }} >San Miguel Norte/Carolina</option>" +
                        "<option value='migN7' {{ old('municipio') == 'migN7' ? 'selected' : '' }} >San Miguel Norte/San Antonio</option>" +
                        "<option value='migN8' {{ old('municipio') == 'migN8' ? 'selected' : '' }} >San Miguel Norte/Chapeltique</option>" +
                        "<option value='migC1' {{ old('municipio') == 'migC1' ? 'selected' : '' }} >San Miguel Centro/San Miguel</option>" +
                        "<option value='migC2' {{ old('municipio') == 'migC2' ? 'selected' : '' }} >San Miguel Centro/Comacarán</option>" +
                        "<option value='migC3' {{ old('municipio') == 'migC3' ? 'selected' : '' }} >San Miguel Centro/Uluazapa</option>" +
                        "<option value='migC4' {{ old('municipio') == 'migC4' ? 'selected' : '' }} >San Miguel Centro/Moncagua</option>" +
                        "<option value='migC5' {{ old('municipio') == 'migC5' ? 'selected' : '' }} >San Miguel Centro/Quelepa</option>" +
                        "<option value='migC6' {{ old('municipio') == 'migC6' ? 'selected' : '' }} >San Miguel Centro/Chirilagua</option>" +
                        "<option value='migO1' {{ old('municipio') == 'migO1' ? 'selected' : '' }} >San Miguel Oeste/Chinameca</option>" +
                        "<option value='migO2' {{ old('municipio') == 'migO2' ? 'selected' : '' }} >San Miguel Oeste/El Tránsito</option>" +
                        "<option value='migO3' {{ old('municipio') == 'migO3' ? 'selected' : '' }} >San Miguel Oeste/Lolotique</option>" +
                        "<option value='migO4' {{ old('municipio') == 'migO4' ? 'selected' : '' }} >San Miguel Oeste/Nueva Guadalupe</option>" +
                        "<option value='migO5' {{ old('municipio') == 'migO5' ? 'selected' : '' }} >San Miguel Oeste/San Jorge</option>" +
                        "<option value='migO6' {{ old('municipio') == 'migO6' ? 'selected' : '' }} >San Miguel Oeste/San Rafael Oriente</option>";

            $("#municipio").find("option").remove().end().append(migM); 

        } else if (e.target.value == 'ssl') {

            //10
            var sslM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='sslN1' {{ old('municipio') == 'sslN1' ? 'selected' : '' }} >San Salvador Norte/Aguilares</option>" +
                        "<option value='sslN2' {{ old('municipio') == 'sslN2' ? 'selected' : '' }} >San Salvador Norte/El Paisnal</option>" +
                        "<option value='sslN3' {{ old('municipio') == 'sslN3' ? 'selected' : '' }} >San Salvador Norte/Guazapan</option>" +
                        "<option value='sslO1' {{ old('municipio') == 'sslO1' ? 'selected' : '' }} >San Salvador Oeste/Apopa</option>" +
                        "<option value='sslO2' {{ old('municipio') == 'sslO2' ? 'selected' : '' }} >San Salvador Oeste/Nejapa</option>" +
                        "<option value='sslE1' {{ old('municipio') == 'sslE1' ? 'selected' : '' }} >San Salvador Este/Ilopango</option>" +
                        "<option value='sslE2' {{ old('municipio') == 'sslE2' ? 'selected' : '' }} >San Salvador Este/San Martín</option>" +
                        "<option value='sslE3' {{ old('municipio') == 'sslE3' ? 'selected' : '' }} >San Salvador Este/Soyapango</option>" +
                        "<option value='sslE4' {{ old('municipio') == 'sslE4' ? 'selected' : '' }} >San Salvador Este/Tonacatepeque</option>" +
                        "<option value='sslC1' {{ old('municipio') == 'sslC1' ? 'selected' : '' }} >San Salvador Centro/Ayutuxtepeque</option>" +
                        "<option value='sslC2' {{ old('municipio') == 'sslC2' ? 'selected' : '' }} >San Salvador Centro/Mejicanos</option>" +
                        "<option value='sslC3' {{ old('municipio') == 'sslC3' ? 'selected' : '' }} >San Salvador Centro/Cuscatancingo</option>" +
                        "<option value='sslC4' {{ old('municipio') == 'sslC4' ? 'selected' : '' }} >San Salvador Centro/Ciudad Delgado</option>" +
                        "<option value='sslC5' {{ old('municipio') == 'sslC5' ? 'selected' : '' }} >San Salvador Centro/San Salvador</option>" +
                        "<option value='sslS1' {{ old('municipio') == 'sslS1' ? 'selected' : '' }} >San Salvador Sur/San Marcos</option>" +
                        "<option value='sslS2' {{ old('municipio') == 'sslS2' ? 'selected' : '' }} >San Salvador Sur/Santo Tomás</option>" +
                        "<option value='sslS3' {{ old('municipio') == 'sslS3' ? 'selected' : '' }} >San Salvador Sur/Santiago Texacuangos</option>" +
                        "<option value='sslS4' {{ old('municipio') == 'sslS4' ? 'selected' : '' }} >San Salvador Sur/Panchimalco</option>" +
                        "<option value='sslS5' {{ old('municipio') == 'sslS5' ? 'selected' : '' }} >San Salvador Sur/Rosario de Mora</option>";

            $("#municipio").find("option").remove().end().append(sslM);

        } else if (e.target.value == 'svi') {

            //11
            var sviM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='sviN1' {{ old('municipio') == 'sviN1' ? 'selected' : '' }} >San Vicente Norte/Apastepeque</option>" +
                        "<option value='sviN2' {{ old('municipio') == 'sviN2' ? 'selected' : '' }} >San Vicente Norte/Santa Clara</option>" +
                        "<option value='sviN3' {{ old('municipio') == 'sviN3' ? 'selected' : '' }} >San Vicente Norte/San Ildefonso</option>" +
                        "<option value='sviN4' {{ old('municipio') == 'sviN4' ? 'selected' : '' }} >San Vicente Norte/San Esteban Catarina</option>" +
                        "<option value='sviN5' {{ old('municipio') == 'sviN5' ? 'selected' : '' }} >San Vicente Norte/San Sebastián</option>" +
                        "<option value='sviN6' {{ old('municipio') == 'sviN6' ? 'selected' : '' }} >San Vicente Norte/San Lorenzo</option>" +
                        "<option value='sviN7' {{ old('municipio') == 'sviN7' ? 'selected' : '' }} >San Vicente Norte/Santo Domingo</option>" +
                        "<option value='sviS1' {{ old('municipio') == 'sviS1' ? 'selected' : '' }} >San Vicente Sur/San Vicente</option>" +
                        "<option value='sviS2' {{ old('municipio') == 'sviS2' ? 'selected' : '' }} >San Vicente Sur/Guadalupe</option>" +
                        "<option value='sviS3' {{ old('municipio') == 'sviS3' ? 'selected' : '' }} >San Vicente Sur/San Cayetano Istepeque</option>" +
                        "<option value='sviS4' {{ old('municipio') == 'sviS4' ? 'selected' : '' }} >San Vicente Sur/Tecoluca</option>" +
                        "<option value='sviS5' {{ old('municipio') == 'sviS5' ? 'selected' : '' }} >San Vicente Sur/Tepetitán</option>" +
                        "<option value='sviS6' {{ old('municipio') == 'sviS6' ? 'selected' : '' }} >San Vicente Sur/Verapaz</option>";

            $("#municipio").find("option").remove().end().append(sviM);   

        } else if (e.target.value == 'son') {

            //12
            var sonM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='sonN1' {{ old('municipio') == 'sonN1' ? 'selected' : '' }} >Sonsonate Norte/Juayúa</option>" +
                        "<option value='sonN2' {{ old('municipio') == 'sonN2' ? 'selected' : '' }} >Sonsonate Norte/Nahuizalco</option>" +
                        "<option value='sonN3' {{ old('municipio') == 'sonN3' ? 'selected' : '' }} >Sonsonate Norte/Salcoatitán</option>" +
                        "<option value='sonN4' {{ old('municipio') == 'sonN4' ? 'selected' : '' }} >Sonsonate Norte/Santa Catarina Masahuat</option>" +
                        "<option value='sonC1' {{ old('municipio') == 'sonC1' ? 'selected' : '' }} >Sonsonate Centro/Sonsonate</option>" +
                        "<option value='sonC2' {{ old('municipio') == 'sonC2' ? 'selected' : '' }} >Sonsonate Centro/Sonzacate</option>" +
                        "<option value='sonC3' {{ old('municipio') == 'sonC3' ? 'selected' : '' }} >Sonsonate Centro/Nahulingo</option>" +
                        "<option value='sonC4' {{ old('municipio') == 'sonC4' ? 'selected' : '' }} >Sonsonate Centro/San Antonio del Monte</option>" +
                        "<option value='sonC5' {{ old('municipio') == 'sonC5' ? 'selected' : '' }} >Sonsonate Centro/Santo Domingo de Guzmán</option>" +
                        "<option value='sonE1' {{ old('municipio') == 'sonE1' ? 'selected' : '' }} >Sonsonate Este/Armenia</option>" +
                        "<option value='sonE2' {{ old('municipio') == 'sonE2' ? 'selected' : '' }} >Sonsonate Este/Caluco</option>" +
                        "<option value='sonE3' {{ old('municipio') == 'sonE3' ? 'selected' : '' }} >Sonsonate Este/Cuisnahuat</option>" +
                        "<option value='sonE4' {{ old('municipio') == 'sonE4' ? 'selected' : '' }} >Sonsonate Este/Izalco</option>" +
                        "<option value='sonE5' {{ old('municipio') == 'sonE5' ? 'selected' : '' }} >Sonsonate Este/San Julián</option>" +
                        "<option value='sonE6' {{ old('municipio') == 'sonE6' ? 'selected' : '' }} >Sonsonate Este/Santa Isabel Ishuatán</option>" +
                        "<option value='sonO1' {{ old('municipio') == 'sonO1' ? 'selected' : '' }} >Sonsonate Oeste/Acajutla</option>";

            $("#municipio").find("option").remove().end().append(sonM);

        } else if (e.target.value == 'uni') {

            //13
            var uniM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='uniN1' {{ old('municipio') == 'uniN1' ? 'selected' : '' }} >La Unión Norte/Anamorós</option>" +
                        "<option value='uniN2' {{ old('municipio') == 'uniN2' ? 'selected' : '' }} >La Unión Norte/Bolívar</option>" +
                        "<option value='uniN3' {{ old('municipio') == 'uniN3' ? 'selected' : '' }} >La Unión Norte/Concepción de Oriente</option>" +
                        "<option value='uniN4' {{ old('municipio') == 'uniN4' ? 'selected' : '' }} >La Unión Norte/El Sauce</option>" +
                        "<option value='uniN5' {{ old('municipio') == 'uniN5' ? 'selected' : '' }} >La Unión Norte/Lislique</option>" +
                        "<option value='uniN6' {{ old('municipio') == 'uniN6' ? 'selected' : '' }} >La Unión Norte/Nueva Esparta</option>" +
                        "<option value='uniN7' {{ old('municipio') == 'uniN7' ? 'selected' : '' }} >La Unión Norte/Pasaquina</option>" +
                        "<option value='uniN8' {{ old('municipio') == 'uniN8' ? 'selected' : '' }} >La Unión Norte/Polorós</option>" +
                        "<option value='uniN9' {{ old('municipio') == 'uniN9' ? 'selected' : '' }} >La Unión Norte/San José</option>" +
                        "<option value='uniN10' {{ old('municipio') == 'uniN10' ? 'selected' : '' }} >La Unión Norte/Santa Rosa de Lima</option>" +
                        "<option value='uniS1' {{ old('municipio') == 'uniS1' ? 'selected' : '' }} >La Unión Norte/Conchagua</option>" +
                        "<option value='uniS2' {{ old('municipio') == 'uniS2' ? 'selected' : '' }} >La Unión Sur/El Carmen</option>" +
                        "<option value='uniS3' {{ old('municipio') == 'uniS3' ? 'selected' : '' }} >La Unión Sur/Intipucá</option>" +
                        "<option value='uniS4' {{ old('municipio') == 'uniS4' ? 'selected' : '' }} >La Unión Sur/La Unión</option>" +
                        "<option value='uniS5' {{ old('municipio') == 'uniS5' ? 'selected' : '' }} >La Unión Sur/Meanguera del Golfo</option>" +
                        "<option value='uniS6' {{ old('municipio') == 'uniS6' ? 'selected' : '' }} >La Unión Sur/San Alejo</option>" +
                        "<option value='uniS7' {{ old('municipio') == 'uniS7' ? 'selected' : '' }} >La Unión Sur/Yayantique</option>" +
                        "<option value='uniS8' {{ old('municipio') == 'uniS8' ? 'selected' : '' }} >La Unión Sur/Yucuaiquín</option>";

            $("#municipio").find("option").remove().end().append(uniM);

        } else if (e.target.value == 'usu') {
            
            //14
            var usuM =  "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>" +
                        "<option value='usuN1' {{ old('municipio') == 'usuN1' ? 'selected' : '' }} >Usulután Norte/Alegría</option>" +
                        "<option value='usuN2' {{ old('municipio') == 'usuN2' ? 'selected' : '' }} >Usulután Norte/Berlín</option>" +
                        "<option value='usuN3' {{ old('municipio') == 'usuN3' ? 'selected' : '' }} >Usulután Norte/El Triunfo</option>" +
                        "<option value='usuN4' {{ old('municipio') == 'usuN4' ? 'selected' : '' }} >Usulután Norte/Estanzuelas</option>" +
                        "<option value='usuN5' {{ old('municipio') == 'usuN5' ? 'selected' : '' }} >Usulután Norte/Jucuapa</option>" +
                        "<option value='usuN6' {{ old('municipio') == 'usuN6' ? 'selected' : '' }} >Usulután Norte/Mercedes Umaña</option>" +
                        "<option value='usuN7' {{ old('municipio') == 'usuN7' ? 'selected' : '' }} >Usulután Norte/Nueva Granada</option>" +
                        "<option value='usuN8' {{ old('municipio') == 'usuN8' ? 'selected' : '' }} >Usulután Norte/San Buenaventura</option>" +
                        "<option value='usuN9' {{ old('municipio') == 'usuN9' ? 'selected' : '' }} >Usulután Norte/Santiago de María</option>" +
                        "<option value='usuC1' {{ old('municipio') == 'usuC1' ? 'selected' : '' }} >Usulután Este/California</option>" +
                        "<option value='usuC2' {{ old('municipio') == 'usuC2' ? 'selected' : '' }} >Usulután Este/Concepción Batres</option>" +
                        "<option value='usuC3' {{ old('municipio') == 'usuC3' ? 'selected' : '' }} >Usulután Este/Ereguayquín</option>" +
                        "<option value='usuC4' {{ old('municipio') == 'usuC4' ? 'selected' : '' }} >Usulután Este/Jucuarán</option>" +
                        "<option value='usuC5' {{ old('municipio') == 'usuC5' ? 'selected' : '' }} >Usulután Este/Ozatlán</option>" +
                        "<option value='usuC6' {{ old('municipio') == 'usuC6' ? 'selected' : '' }} >Usulután Este/Santa Elena</option>" +
                        "<option value='usuC7' {{ old('municipio') == 'usuC7' ? 'selected' : '' }} >Usulután Este/San Dionisio</option>" +
                        "<option value='usuC8' {{ old('municipio') == 'usuC8' ? 'selected' : '' }} >Usulután Este/Santa María</option>" +
                        "<option value='usuC9' {{ old('municipio') == 'usuC9' ? 'selected' : '' }} >Usulután Este/Tecapán</option>" +
                        "<option value='usuC10' {{ old('municipio') == 'usuC10' ? 'selected' : '' }} >Usulután Este/Usulután</option>" +
                        "<option value='usuO1' {{ old('municipio') == 'usuO1' ? 'selected' : '' }} >Usulután Oeste/Jiquilisco</option>" +
                        "<option value='usuO2' {{ old('municipio') == 'usuO2' ? 'selected' : '' }} >Usulután Oeste/Puerto El Triunfo</option>" +
                        "<option value='usuO3' {{ old('municipio') == 'usuO3' ? 'selected' : '' }} >Usulután Oeste/San Agustín</option>" +
                        "<option value='usuO4' {{ old('municipio') == 'usuO4' ? 'selected' : '' }} >Usulután Oeste/San Francisco Javier</option>";

            $("#municipio").find("option").remove().end().append(usuM);
        
        } else {

            //15
            var nada = "<option value='0' {{ old('municipio') == '0' ? 'selected' : '' }} >Selecciona un municipio/distrito</option>";

            $("#municipio").find("option").remove().end().append(nada);
        }  
        
    });

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

<script>
  const input1 = document.querySelector("#whatsapp");
  const input2 = document.querySelector("#telefono");

  window.intlTelInput(input1, {
    
    initialCountry: 'sv',
    separateDialCode: true,
    i18n: {
            // Aria label for the selected country element
            selectedCountryAriaLabel: "País Seleccionado",
            // Screen reader text for when no country is selected
            noCountrySelected: "Ningún país seleccionado",
            // Aria label for the country list element
            countryListAriaLabel: "Lista de países",
            // Placeholder for the search input in the dropdown
            searchPlaceholder: "Buscar",
            // Screen reader text for when the search produces no results
            zeroSearchResults: "Sin resultados",
            // Screen reader text for when the search produces 1 result
            oneSearchResult: "1 resultado",
            // Screen reader text for when the search produces multiple results, where ${count} will be replaced by the count
            multipleSearchResults: "${count} resultados",

            // Country names
            ad: "Andorra",
            ae: "Emiratos Árabes Unidos",
            af: "Afganistán",
            ag: "Antigua y Barbuda",
            ai: "Anguila",
            al: "Albania",
            am: "Armenia",
            ao: "Angola",
            aq: "Antártida",
            ar: "Argentina",
            as: "Samoa Americana",
            at: "Austria",
            au: "Australia",
            aw: "Aruba",
            ax: "Islas Åland",
            az: "Azerbaiyán",
            ba: "Bosnia y Herzegovina",
            bb: "Barbados",
            bd: "Bangladés",
            be: "Bélgica",
            bf: "Burkina Faso",
            bg: "Bulgaria",
            bh: "Baréin",
            bi: "Burundi",
            bj: "Benín",
            bl: "San Bartolomé",
            bm: "Bermudas",
            bn: "Brunéi",
            bo: "Bolivia",
            bq: "Caribe neerlandés",
            br: "Brasil",
            bs: "Bahamas",
            bt: "Bután",
            bv: "Isla Bouvet",
            bw: "Botsuana",
            by: "Bielorrusia",
            bz: "Belice",
            ca: "Canadá",
            cc: "Islas Cocos",
            cd: "República Democrática del Congo",
            cf: "República Centroafricana",
            cg: "Congo",
            ch: "Suiza",
            ci: "Côte d’Ivoire",
            ck: "Islas Cook",
            cl: "Chile",
            cm: "Camerún",
            cn: "China",
            co: "Colombia",
            cr: "Costa Rica",
            cu: "Cuba",
            cv: "Cabo Verde",
            cw: "Curazao",
            cx: "Isla de Navidad",
            cy: "Chipre",
            cz: "Chequia",
            de: "Alemania",
            dj: "Yibuti",
            dk: "Dinamarca",
            dm: "Dominica",
            do: "República Dominicana",
            dz: "Argelia",
            ec: "Ecuador",
            ee: "Estonia",
            eg: "Egipto",
            eh: "Sáhara Occidental",
            er: "Eritrea",
            es: "España",
            et: "Etiopía",
            fi: "Finlandia",
            fj: "Fiyi",
            fk: "Islas Malvinas",
            fm: "Micronesia",
            fo: "Islas Feroe",
            fr: "Francia",
            ga: "Gabón",
            gb: "Reino Unido",
            gd: "Granada",
            ge: "Georgia",
            gf: "Guayana Francesa",
            gg: "Guernsey",
            gh: "Ghana",
            gi: "Gibraltar",
            gl: "Groenlandia",
            gm: "Gambia",
            gn: "Guinea",
            gp: "Guadalupe",
            gq: "Guinea Ecuatorial",
            gr: "Grecia",
            gs: "Islas Georgia del Sur y Sandwich del Sur",
            gt: "Guatemala",
            gu: "Guam",
            gw: "Guinea-Bisáu",
            gy: "Guyana",
            hk: "RAE de Hong Kong (China)",
            hm: "Islas Heard y McDonald",
            hn: "Honduras",
            hr: "Croacia",
            ht: "Haití",
            hu: "Hungría",
            id: "Indonesia",
            ie: "Irlanda",
            il: "Israel",
            im: "Isla de Man",
            in: "India",
            io: "Territorio Británico del Océano Índico",
            iq: "Irak",
            ir: "Irán",
            is: "Islandia",
            it: "Italia",
            je: "Jersey",
            jm: "Jamaica",
            jo: "Jordania",
            jp: "Japón",
            ke: "Kenia",
            kg: "Kirguistán",
            kh: "Camboya",
            ki: "Kiribati",
            km: "Comoras",
            kn: "San Cristóbal y Nieves",
            kp: "Corea del Norte",
            kr: "Corea del Sur",
            kw: "Kuwait",
            ky: "Islas Caimán",
            kz: "Kazajistán",
            la: "Laos",
            lb: "Líbano",
            lc: "Santa Lucía",
            li: "Liechtenstein",
            lk: "Sri Lanka",
            lr: "Liberia",
            ls: "Lesoto",
            lt: "Lituania",
            lu: "Luxemburgo",
            lv: "Letonia",
            ly: "Libia",
            ma: "Marruecos",
            mc: "Mónaco",
            md: "Moldavia",
            me: "Montenegro",
            mf: "San Martín",
            mg: "Madagascar",
            mh: "Islas Marshall",
            mk: "Macedonia del Norte",
            ml: "Mali",
            mm: "Myanmar (Birmania)",
            mn: "Mongolia",
            mo: "RAE de Macao (China)",
            mp: "Islas Marianas del Norte",
            mq: "Martinica",
            mr: "Mauritania",
            ms: "Montserrat",
            mt: "Malta",
            mu: "Mauricio",
            mv: "Maldivas",
            mw: "Malaui",
            mx: "México",
            my: "Malasia",
            mz: "Mozambique",
            na: "Namibia",
            nc: "Nueva Caledonia",
            ne: "Níger",
            nf: "Isla Norfolk",
            ng: "Nigeria",
            ni: "Nicaragua",
            nl: "Países Bajos",
            no: "Noruega",
            np: "Nepal",
            nr: "Nauru",
            nu: "Niue",
            nz: "Nueva Zelanda",
            om: "Omán",
            pa: "Panamá",
            pe: "Perú",
            pf: "Polinesia Francesa",
            pg: "Papúa Nueva Guinea",
            ph: "Filipinas",
            pk: "Pakistán",
            pl: "Polonia",
            pm: "San Pedro y Miquelón",
            pn: "Islas Pitcairn",
            pr: "Puerto Rico",
            ps: "Territorios Palestinos",
            pt: "Portugal",
            pw: "Palaos",
            py: "Paraguay",
            qa: "Catar",
            re: "Reunión",
            ro: "Rumanía",
            rs: "Serbia",
            ru: "Rusia",
            rw: "Ruanda",
            sa: "Arabia Saudí",
            sb: "Islas Salomón",
            sc: "Seychelles",
            sd: "Sudán",
            se: "Suecia",
            sg: "Singapur",
            sh: "Santa Elena",
            si: "Eslovenia",
            sj: "Svalbard y Jan Mayen",
            sk: "Eslovaquia",
            sl: "Sierra Leona",
            sm: "San Marino",
            sn: "Senegal",
            so: "Somalia",
            sr: "Surinam",
            ss: "Sudán del Sur",
            st: "Santo Tomé y Príncipe",
            sv: "El Salvador",
            sx: "Sint Maarten",
            sy: "Siria",
            sz: "Esuatini",
            tc: "Islas Turcas y Caicos",
            td: "Chad",
            tf: "Territorios Australes Franceses",
            tg: "Togo",
            th: "Tailandia",
            tj: "Tayikistán",
            tk: "Tokelau",
            tl: "Timor-Leste",
            tm: "Turkmenistán",
            tn: "Túnez",
            to: "Tonga",
            tr: "Turquía",
            tt: "Trinidad y Tobago",
            tv: "Tuvalu",
            tw: "Taiwán",
            tz: "Tanzania",
            ua: "Ucrania",
            ug: "Uganda",
            um: "Islas menores alejadas de EE. UU.",
            us: "Estados Unidos",
            uy: "Uruguay",
            uz: "Uzbekistán",
            va: "Ciudad del Vaticano",
            vc: "San Vicente y las Granadinas",
            ve: "Venezuela",
            vg: "Islas Vírgenes Británicas",
            vi: "Islas Vírgenes de EE. UU.",
            vn: "Vietnam",
            vu: "Vanuatu",
            wf: "Wallis y Futuna",
            ws: "Samoa",
            ye: "Yemen",
            yt: "Mayotte",
            za: "Sudáfrica",
            zm: "Zambia",
            zw: "Zimbabue",
          },
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/utils.js"
  });

/*
    window.intlTelInput(input1, {

        hiddenInput: function(telInputName) {
        return {
          phone: "whatsapp_full",
          country: "country_code1"
        };
      }

    });
*/


  window.intlTelInput(input2, {
    initialCountry: 'sv',
    separateDialCode: true,
    i18n: {
            // Aria label for the selected country element
            selectedCountryAriaLabel: "País Seleccionado",
            // Screen reader text for when no country is selected
            noCountrySelected: "Ningún país seleccionado",
            // Aria label for the country list element
            countryListAriaLabel: "Lista de países",
            // Placeholder for the search input in the dropdown
            searchPlaceholder: "Buscar",
            // Screen reader text for when the search produces no results
            zeroSearchResults: "Sin resultados",
            // Screen reader text for when the search produces 1 result
            oneSearchResult: "1 resultado",
            // Screen reader text for when the search produces multiple results, where ${count} will be replaced by the count
            multipleSearchResults: "${count} resultados",

            // Country names
            ad: "Andorra",
            ae: "Emiratos Árabes Unidos",
            af: "Afganistán",
            ag: "Antigua y Barbuda",
            ai: "Anguila",
            al: "Albania",
            am: "Armenia",
            ao: "Angola",
            aq: "Antártida",
            ar: "Argentina",
            as: "Samoa Americana",
            at: "Austria",
            au: "Australia",
            aw: "Aruba",
            ax: "Islas Åland",
            az: "Azerbaiyán",
            ba: "Bosnia y Herzegovina",
            bb: "Barbados",
            bd: "Bangladés",
            be: "Bélgica",
            bf: "Burkina Faso",
            bg: "Bulgaria",
            bh: "Baréin",
            bi: "Burundi",
            bj: "Benín",
            bl: "San Bartolomé",
            bm: "Bermudas",
            bn: "Brunéi",
            bo: "Bolivia",
            bq: "Caribe neerlandés",
            br: "Brasil",
            bs: "Bahamas",
            bt: "Bután",
            bv: "Isla Bouvet",
            bw: "Botsuana",
            by: "Bielorrusia",
            bz: "Belice",
            ca: "Canadá",
            cc: "Islas Cocos",
            cd: "República Democrática del Congo",
            cf: "República Centroafricana",
            cg: "Congo",
            ch: "Suiza",
            ci: "Côte d’Ivoire",
            ck: "Islas Cook",
            cl: "Chile",
            cm: "Camerún",
            cn: "China",
            co: "Colombia",
            cr: "Costa Rica",
            cu: "Cuba",
            cv: "Cabo Verde",
            cw: "Curazao",
            cx: "Isla de Navidad",
            cy: "Chipre",
            cz: "Chequia",
            de: "Alemania",
            dj: "Yibuti",
            dk: "Dinamarca",
            dm: "Dominica",
            do: "República Dominicana",
            dz: "Argelia",
            ec: "Ecuador",
            ee: "Estonia",
            eg: "Egipto",
            eh: "Sáhara Occidental",
            er: "Eritrea",
            es: "España",
            et: "Etiopía",
            fi: "Finlandia",
            fj: "Fiyi",
            fk: "Islas Malvinas",
            fm: "Micronesia",
            fo: "Islas Feroe",
            fr: "Francia",
            ga: "Gabón",
            gb: "Reino Unido",
            gd: "Granada",
            ge: "Georgia",
            gf: "Guayana Francesa",
            gg: "Guernsey",
            gh: "Ghana",
            gi: "Gibraltar",
            gl: "Groenlandia",
            gm: "Gambia",
            gn: "Guinea",
            gp: "Guadalupe",
            gq: "Guinea Ecuatorial",
            gr: "Grecia",
            gs: "Islas Georgia del Sur y Sandwich del Sur",
            gt: "Guatemala",
            gu: "Guam",
            gw: "Guinea-Bisáu",
            gy: "Guyana",
            hk: "RAE de Hong Kong (China)",
            hm: "Islas Heard y McDonald",
            hn: "Honduras",
            hr: "Croacia",
            ht: "Haití",
            hu: "Hungría",
            id: "Indonesia",
            ie: "Irlanda",
            il: "Israel",
            im: "Isla de Man",
            in: "India",
            io: "Territorio Británico del Océano Índico",
            iq: "Irak",
            ir: "Irán",
            is: "Islandia",
            it: "Italia",
            je: "Jersey",
            jm: "Jamaica",
            jo: "Jordania",
            jp: "Japón",
            ke: "Kenia",
            kg: "Kirguistán",
            kh: "Camboya",
            ki: "Kiribati",
            km: "Comoras",
            kn: "San Cristóbal y Nieves",
            kp: "Corea del Norte",
            kr: "Corea del Sur",
            kw: "Kuwait",
            ky: "Islas Caimán",
            kz: "Kazajistán",
            la: "Laos",
            lb: "Líbano",
            lc: "Santa Lucía",
            li: "Liechtenstein",
            lk: "Sri Lanka",
            lr: "Liberia",
            ls: "Lesoto",
            lt: "Lituania",
            lu: "Luxemburgo",
            lv: "Letonia",
            ly: "Libia",
            ma: "Marruecos",
            mc: "Mónaco",
            md: "Moldavia",
            me: "Montenegro",
            mf: "San Martín",
            mg: "Madagascar",
            mh: "Islas Marshall",
            mk: "Macedonia del Norte",
            ml: "Mali",
            mm: "Myanmar (Birmania)",
            mn: "Mongolia",
            mo: "RAE de Macao (China)",
            mp: "Islas Marianas del Norte",
            mq: "Martinica",
            mr: "Mauritania",
            ms: "Montserrat",
            mt: "Malta",
            mu: "Mauricio",
            mv: "Maldivas",
            mw: "Malaui",
            mx: "México",
            my: "Malasia",
            mz: "Mozambique",
            na: "Namibia",
            nc: "Nueva Caledonia",
            ne: "Níger",
            nf: "Isla Norfolk",
            ng: "Nigeria",
            ni: "Nicaragua",
            nl: "Países Bajos",
            no: "Noruega",
            np: "Nepal",
            nr: "Nauru",
            nu: "Niue",
            nz: "Nueva Zelanda",
            om: "Omán",
            pa: "Panamá",
            pe: "Perú",
            pf: "Polinesia Francesa",
            pg: "Papúa Nueva Guinea",
            ph: "Filipinas",
            pk: "Pakistán",
            pl: "Polonia",
            pm: "San Pedro y Miquelón",
            pn: "Islas Pitcairn",
            pr: "Puerto Rico",
            ps: "Territorios Palestinos",
            pt: "Portugal",
            pw: "Palaos",
            py: "Paraguay",
            qa: "Catar",
            re: "Reunión",
            ro: "Rumanía",
            rs: "Serbia",
            ru: "Rusia",
            rw: "Ruanda",
            sa: "Arabia Saudí",
            sb: "Islas Salomón",
            sc: "Seychelles",
            sd: "Sudán",
            se: "Suecia",
            sg: "Singapur",
            sh: "Santa Elena",
            si: "Eslovenia",
            sj: "Svalbard y Jan Mayen",
            sk: "Eslovaquia",
            sl: "Sierra Leona",
            sm: "San Marino",
            sn: "Senegal",
            so: "Somalia",
            sr: "Surinam",
            ss: "Sudán del Sur",
            st: "Santo Tomé y Príncipe",
            sv: "El Salvador",
            sx: "Sint Maarten",
            sy: "Siria",
            sz: "Esuatini",
            tc: "Islas Turcas y Caicos",
            td: "Chad",
            tf: "Territorios Australes Franceses",
            tg: "Togo",
            th: "Tailandia",
            tj: "Tayikistán",
            tk: "Tokelau",
            tl: "Timor-Leste",
            tm: "Turkmenistán",
            tn: "Túnez",
            to: "Tonga",
            tr: "Turquía",
            tt: "Trinidad y Tobago",
            tv: "Tuvalu",
            tw: "Taiwán",
            tz: "Tanzania",
            ua: "Ucrania",
            ug: "Uganda",
            um: "Islas menores alejadas de EE. UU.",
            us: "Estados Unidos",
            uy: "Uruguay",
            uz: "Uzbekistán",
            va: "Ciudad del Vaticano",
            vc: "San Vicente y las Granadinas",
            ve: "Venezuela",
            vg: "Islas Vírgenes Británicas",
            vi: "Islas Vírgenes de EE. UU.",
            vn: "Vietnam",
            vu: "Vanuatu",
            wf: "Wallis y Futuna",
            ws: "Samoa",
            ye: "Yemen",
            yt: "Mayotte",
            za: "Sudáfrica",
            zm: "Zambia",
            zw: "Zimbabue",
          },
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/utils.js"
  });

</script>

@endsection
