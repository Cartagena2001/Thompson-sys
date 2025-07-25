@extends('layouts.app')

@section('content')
@section('title', 'Editar Usuario')

    <style type="text/css">
        .iti {
            width: 100%;
        }
    </style> 
    
    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url( {{ URL('assets/img/icons/spot-illustrations/corner-4.png') }} ); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">👥 Usuarios de RT 👥</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás editar la información de los usuarios registrados en el Sistema RT, así como también activarlos o desactivarlos y demás.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/configuracion/users') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="card-header">
            <div class="row flex-between-end">
                
                <div class="col-auto align-self-center mb-3">
                    <h4 class="mb-0" data-anchor="data-anchor">👤 Información General:</h4>
                </div>

                <hr />

                <form method="POST" action="{{ route('users.update', $usuario->id) }}" role="form" enctype="multipart/form-data">
                    
                    {{ method_field('PUT') }}
                    @csrf

                    <div class="mt-3 col-auto text-center col-6 mx-auto">
                        <label for="imagen_perfil_src">Imagen de perfil/Logo empresa (idealmente 200x200px | .png, .jpg, .jpeg) </label>
                        <br/>
                        <img class="rounded mt-2" src="{{ url('storage/assets/img/perfil-user/'.$usuario->imagen_perfil_src) }}" alt="per" width="200">

                        {{-- <img class="rounded mt-2" src="/file/serve/{{ $usuario->imagen_perfil_src }}" alt="per" width="200"> --}}

                        <br/>
                        <br/>
                        <input class="form-control" type="file" name="imagen_perfil_src" id="image_perfil_src" value="{{ $usuario->imagen_perfil_src }}">  
                        <br/>
                        @error('imagen_perfil_src')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-2">

                        <div class="col-4">
                            <label for="cliente_id_interno">ID Usuario (Interno): </label>
                            <input class="form-control" type="text" name="cliente_id_interno" id="cliente_id_interno" value="{{ $usuario->cliente_id_interno }}" maxlength="10" placeholder="-">
                            @error('cliente_id_interno')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="rol">Rol: *</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="">Selecione un rol</option>
                                @foreach($roles as $rol)
                                    @if ( $rol->id != 0)
                                        <option value="{{ $rol->id }}" @if ( $usuario->rol_id == $rol->id ) selected @endif >{{ $rol->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('rol')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="estado">Estado: *</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="">Selecione un estado</option>
                                <option value="activo" @if ( $usuario->estado == 'activo' ) selected @endif >Activo</option>
                                <option value="inactivo" @if ( $usuario->estado == 'inactivo' ) selected @endif >Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-4">
                            <label for="clasificacion">Lista de Precios (Clasificación): *</label>
                            <select class="form-select" id="clasificacion" name="clasificacion" required>
                                <option value="">Selecione una lista/clasificación</option>
                                <option value="taller" @if ( $usuario->clasificacion == 'taller' ) selected @endif >Taller</option>
                                <option value="distribuidor" @if ( $usuario->clasificacion == 'distribuidor' ) selected @endif >Distribuidor</option>
                                <option value="precioOp" @if ( $usuario->clasificacion == 'precioOp' ) selected @endif >Precio OP</option>
                                <option value="precioCosto" @if ( $usuario->clasificacion == 'precioCosto' ) selected @endif >Precio Costo</option>
                            </select>
                            @error('clasificacion')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="boletin">Suscrito a boletín: </label>
                            <select class="form-select" id="boletin" name="boletin">
                                <option value="1" @if ( $usuario->boletin == 1) ) selected @endif >Si</option>
                                <option value="0" @if ( $usuario->boletin == 0) ) selected @endif >No</option>
                            </select>
                            @error('boletin')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="estatus">Estatus: *</label>
                            <select class="form-select" id="estatus" name="estatus" required>
                                <option value="">Selecione un estatus</option>
                                <option value="otro" @if ( $usuario->estatus == 'otro' ) selected @endif >Otro</option>
                                <option value="aprobado" @if ( $usuario->estatus == 'aprobado' ) selected @endif >Aprobado</option>
                                <option value="aspirante" @if ( $usuario->estatus == 'aspirante' ) selected @endif >Aspirante</option>
                                <option value="rechazado" @if ( $usuario->estatus == 'rechazado' ) selected @endif >Rechazado</option>
                            </select>
                            @error('estatus')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-6">
                            <label for="name">Nombre: *</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $usuario->name }}" maxlength="100" placeholder="-" required>
                            @error('name')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="email">Correo Electrónico: *</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ $usuario->email }}" maxlength="90" placeholder="tucorreo@email.com" required>
                            @error('email')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-6">
                            <label for="dui">DUI: </label>
                            <input class="form-control" type="text" name="dui" id="dui" value="{{ $usuario->dui }}" minlength="9" maxlength="10" placeholder="00000000-0">
                            @error('dui')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>                      

                        <div class="col-6">
                            <label for="whatsapp">Celular/Núm. WhatsApp: </label>
                            <input class="form-control" type="text" name="whatsapp" id="whatsapp" data-intl-tel-input-id="0" autocomplete="off" value="{{ $usuario->whatsapp }}" placeholder="0000-0000" minlength="8" maxlength="21">
                            @error('whatsapp')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label for="notas">Notas: </label>
                            <textarea class="form-control" type="text" name="notas" id="notas" rows="4" cols="50" maxlength="280" placeholder="-">{{ $usuario->notas }}</textarea>
                            @error('notas')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="row py-4">

                        <div class="col-12 offset-sm-2 col-sm-8 offset-md-2 col-md-8">
                            <p class="text-justify mx-3"><b>NOTA:</b> La siguiente información puede o no aplicar parcial o totalmente según la naturaleza juridica del negocio del aspirante/cliente, si posee Número de Registro del Contribuyente (NRC) selecciona "negocio registrado", si no, selecciona "comerciante sin iva".</p>
                        </div>                      

                    </div>

                    <div class="mb-4">
                        <div class="text-center">
                            <label class="form-label" for="negTipo">Selecciona según convenga:
                            <br/> 
                            <br/> 
                            <input type="radio" name="negTipo" value="negocio" @if($usuario->usr_tipo == 'negocio') checked @endif /> <span style="color: #ff5722;">Negocio Registrado</span>
                            <br/> 
                            <br/> 
                            <input type="radio" name="negTipo" value="persona" @if($usuario->usr_tipo == 'persona') checked @endif /> <span style="color: #009688;">Comerciante sin IVA</span>
                            </label> 
                            @error('negTipo')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="col-auto align-self-center mt-5 mb-3">
                        <h4 class="mb-0" data-anchor="data-anchor">💼 Información de la Empresa/Negocio:</h4>
                    </div>

                    <hr />

                    <div class="row mb-2">

                        <div class="col-6">
                            <label for="nrc">N° de registro (NRC): </label>
                            <input class="form-control" type="text" name="nrc" id="nrc" value="{{ $usuario->nrc }}" minlength="8" maxlength="10" placeholder="0000000-0">
                            @error('nrc')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="nit">NIT: </label>
                            <input class="form-control" type="text" name="nit" id="nit" value="{{ $usuario->nit }}" minlength="17" maxlength="17" placeholder="0000-000000-000-0">
                            @error('nit')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label for="razon_social">Nombre/razón ó denominación social: </label>
                            <input class="form-control" type="text" name="razon_social" id="razon_social" value="{{ $usuario->razon_social }}" maxlength="34" placeholder="-">
                            @error('razon_social')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label for="direccion">Dirección: </label>
                            <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $usuario->direccion }}" maxlength="75" placeholder="-">
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
                                
                                <option value="ahu" @if ($usuario->depto_cod == 'ahu') selected  @endif >Ahuachapán</option>
                                <option value="cab" @if ($usuario->depto_cod == 'cab') selected  @endif >Cabañas</option>
                                <option value="cha" @if ($usuario->depto_cod == 'cha') selected  @endif >Chalatenango</option>
                                <option value="cus" @if ($usuario->depto_cod == 'cus') selected  @endif >Cuscatlán</option>
                                <option value="lib" @if ($usuario->depto_cod == 'lib') selected  @endif >La Libertad</option>
                                <option value="mor" @if ($usuario->depto_cod == 'mor') selected  @endif >Morazán</option>
                                <option value="paz" @if ($usuario->depto_cod == 'paz') selected  @endif >La Paz</option>
                                <option value="ana" @if ($usuario->depto_cod == 'ana') selected  @endif >Santa Ana</option>
                                <option value="mig" @if ($usuario->depto_cod == 'mig') selected  @endif >San Miguel</option>
                                <option value="ssl" @if ($usuario->depto_cod == 'ssl') selected  @endif >San Salvador</option>
                                <option value="svi" @if ($usuario->depto_cod == 'svi') selected  @endif >San Vicente</option>
                                <option value="son" @if ($usuario->depto_cod == 'son') selected  @endif >Sonsonate</option>
                                <option value="uni" @if ($usuario->depto_cod == 'uni') selected  @endif >La Unión</option>
                                <option value="usu" @if ($usuario->depto_cod == 'usu') selected  @endif >Usulután</option>

                            </select>

                            @error('departamento')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>                      

                        <div class="col-6">
                            <label for="municipio">Municipio/Distrito: </label>
                            <select class="form-select" id="municipio" name="municipio" required>
                                <option value='0'  @if ($usuario->mun_cod == '0') selected  @endif >Selecciona un municipio/distrito</option>
                                <option value="{{ $usuario->mun_cod }}" selected>{{ $usuario->municipio }}</option>
                            </select>
                            @error('municipio')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="col-12">
                            <label for="giro">Giro ó actividad económica: </label>
                            <textarea class="form-control" type="text" name="giro" id="giro" rows="4" cols="50" maxlength="180" placeholder="-">{{ $usuario->giro }}</textarea>
                            @error('giro')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">  

                        <div class="col-12">
                            <label for="nombre_empresa">Nombre Comercial: </label>
                            <input class="form-control" type="text" name="nombre_empresa" id="nombre_empresa" value="{{ $usuario->nombre_empresa }}" maxlength="34" placeholder="-">
                            @error('nombre_empresa')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2"> 

                        <div class="col-6">
                            <label for="website">WebSite: </label>
                            <input class="form-control" type="text" name="website" id="website" value="{{ $usuario->website }}" maxlength="34" placeholder="-">
                            @error('website')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="telefono">Teléfono: </label>
                            <input class="form-control" type="text" name="telefono" id="telefono" data-intl-tel-input-id="1" autocomplete="off" value="{{ $usuario->telefono }}" placeholder="0000-0000" minlength="8" maxlength="21">
                            @error('telefono')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                        <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Actualizar información</button>
                    </div>

                </form>

                <hr />

                <div class="row mb-2">

                    <h4 class="text-center mb-4">Marcas Autorizadas:</h4> 

                    <div class="col-sm-12">
                        <div class="flex-center">
                            <form id="brandscheck">
                                <div>
                                @foreach ($marcas as $marca)
                                    <label for="{{ $marca->nombre }}-{{ $marca->id }}_{{ $usuario->id }}">
                                        <input id="{{ $marca->nombre }}-{{ $marca->id }}_{{ $usuario->id }}" type="checkbox" value="{{ $marca->id }}" name="marks[]" onclick="updateMarca (this.id)" @if ( str_contains( $usuario->marcas, $marca->id ) ) checked @endif /> {{ $marca->nombre }}

                                    </label>
                                    <br/>
                                @endforeach
                                </div>
                            </form>
                        </div>
                        <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                                Marca/s autorizada/s o denegadas con éxito! 
                            </div>

                        <span class="text-danger" id="ErrorMsg1"></span>
                        <span class="text-danger" id="ErrorMsg2"></span>
                    </div>

                </div> 

                <hr />

                <form method="POST" action="{{ route('user.password.update', $usuario->id) }}" role="form" enctype="multipart/form-data">
                    @csrf

                    <div class="col-auto align-self-center mt-2 mb-3 text-center">
                        <h4 class="mb-0" data-anchor="data-anchor">🔑 Credenciales:</h4>
                    </div>

                    <div class="col-12 col-sm-4 offset-sm-4">

                        <label for="password">Nueva Contraseña: </label>
                        <div class="input-group mb-4">
                            
                            <input id="password" type="password" name="password" class="form-control" value="" maxlength="12" required>

                            <div class="input-group-append">
                                <div class="input-group-text" style="padding: 10px 10px;">
                                    <span title="Mostrar/Ocultar" onclick="revealPass()" style="color: red; cursor: pointer;" class="fas fa-eye"></span>
                                </div>
                            </div>

                            <div class="input-group-append">
                                <div class="input-group-text" style="padding: 10px 10px;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                            @if ($errors->has('password'))
                                <div class="alert alert-danger mt-1 mb-1">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <label for="password_confirmation">Confirmar Contraseña: </label>
                        <div class="input-group mb-4">
                            
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" maxlength="12" required>

                            <div class="input-group-append">
                                <div class="input-group-text" style="padding: 10px 10px;">
                                    <span title="Mostrar/Ocultar" onclick="revealPassc()" style="color: red; cursor: pointer;" class="fas fa-eye"></span>
                                </div>
                            </div>

                            <div class="input-group-append">
                                <div class="input-group-text" style="padding: 10px 10px;">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                        <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Actualizar Contraseña</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>

        function updateMarca(check_id){
            var estadoUpdate = $('#'+check_id).prop('checked');
            var clienteid = check_id;
            // console.log("estado: "+estado);

            $.ajax({
                url: "{{ route('clientes.marcaUpdate') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&marcaUpdate=" + $('#'+check_id).val() + "&cliente=" + check_id + "&estadoUpdate=" + estadoUpdate,

                success: function(response){
                    $('#successMsg').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.marcaUpdate);
                    $('#ErrorMsg2').text(response.responseJSON.errors.cliente);
                },
            })
        }


        $('#rol').on('change', function (e) {
            
            if (e.target.value == 1 || e.target.value == 3) {

                $('#estatus option[value="aprobado"]').hide();
                $('#estatus option[value="aspirante"]').hide();
                $('#estatus option[value="rechazado"]').hide();
                $('#estatus option[value="otro"]').show();

                $('#estatus option[value="otro"]').attr("selected", "selected");

            } else if (e.target.value == '') {

                $('#estatus option[value="aprobado"]').show();
                $('#estatus option[value="aspirante"]').show();
                $('#estatus option[value="rechazado"]').show();
                $('#estatus option[value="otro"]').show(); 

            } else {

                $('#estatus option[value="otro"]').hide();
                $('#estatus option[value="aprobado"]').show();
                $('#estatus option[value="aspirante"]').show();
                $('#estatus option[value="rechazado"]').show();

                $('#rol option[value=""]').attr("selected", "selected");
            }
            
        });


        $('#estatus').on('change', function (e) {
            
            if (e.target.value == 'aprobado' || e.target.value == 'aspirante' || e.target.value == 'rechazado') {
                
                $('#rol option[value="1"]').hide();
                $('#rol option[value="2"]').show();
                $('#rol option[value="3"]').hide();

                $('#rol option[value="2"]').attr("selected", "selected");
                
            } else if (e.target.value == '') {

                $('#rol option[value="1"]').show();
                $('#rol option[value="2"]').show();
                $('#rol option[value="3"]').show(); 

            } else {

                $('#rol option[value="1"]').show();
                $('#rol option[value="2"]').hide();
                $('#rol option[value="3"]').show();

                $('#rol option[value=""]').attr("selected", "selected");
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
                    
                }
                
            });
        });

        $(document).ready(function(){

            let ini_sel_value = $("input[name='negTipo']:checked").val();
            
            if (ini_sel_value == 'persona') {

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
                
            }
                
        });

    </script>

    <script type="text/javascript">

        function revealPass() {
          var x = document.getElementById("password");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }

        function revealPassc() {
          var x = document.getElementById("password_confirmation");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }

    </script>

    <script type="text/javascript">

        $('#departamento').on('change', function (e) {
            
            if (e.target.value == 'ahu') {

                //1
                var ahuM = "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                           "<option value='ahuN1' @if ($usuario->mun_cod == 'ahuN1' ) selected  @endif >Ahuachapán Norte/Atiquizaya</option>" +
                           "<option value='ahuN2' @if ($usuario->mun_cod == 'ahuN2' ) selected  @endif >Ahuachapán Norte/El Refugio</option>" +
                           "<option value='ahuN3' @if ($usuario->mun_cod == 'ahuN3' ) selected  @endif >Ahuachapán Norte/San Lorenzo</option>" +
                           "<option value='ahuN4' @if ($usuario->mun_cod == 'ahuN4' ) selected  @endif >Ahuachapán Norte/Turín</option>" +
                           "<option value='ahuC1' @if ($usuario->mun_cod == 'ahuC1' ) selected  @endif >Ahuachapán Centro/Ahuachapán</option>" +
                           "<option value='ahuC2' @if ($usuario->mun_cod == 'ahuC2' ) selected  @endif >Ahuachapán Centro/Apaneca</option>" +
                           "<option value='ahuC3' @if ($usuario->mun_cod == 'ahuC3' ) selected  @endif >Ahuachapán Centro/Concepción de Ataco</option>" +
                           "<option value='ahuC4' @if ($usuario->mun_cod == 'ahuC4' ) selected  @endif >Ahuachapán Centro/Tacuba</option>" +
                           "<option value='ahuS1' @if ($usuario->mun_cod == 'ahuS1' ) selected  @endif >Ahuachapán Sur/Guaymango</option>" +
                           "<option value='ahuS2' @if ($usuario->mun_cod == 'ahuS2' ) selected  @endif >Ahuachapán Sur/Jujutla</option>" +
                           "<option value='ahuS3' @if ($usuario->mun_cod == 'ahuS3' ) selected  @endif >Ahuachapán Sur/San Francisco Menéndez</option>" +
                           "<option value='ahuS4' @if ($usuario->mun_cod == 'ahuS4' ) selected  @endif >Ahuachapán Sur/San Pedro Puxtla</option>";

                $("#municipio").find("option").remove().end().append(ahuM);


            } else if (e.target.value == 'cab') {

                //2
                var cabM = "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                           "<option value='cabE1' @if ($usuario->mun_cod == 'cabE1' ) selected  @endif >Cabañas Este/Guacotecti</option>" +
                           "<option value='cabE2' @if ($usuario->mun_cod == 'cabE2' ) selected  @endif >Cabañas Este/San Isidro</option>" +
                           "<option value='cabE3' @if ($usuario->mun_cod == 'cabE3' ) selected  @endif >Cabañas Este/Sensuntepeque</option>" +
                           "<option value='cabE4' @if ($usuario->mun_cod == 'cabE4' ) selected  @endif >Cabañas Este/Victoria</option>" +
                           "<option value='cabE5' @if ($usuario->mun_cod == 'cabE5' ) selected  @endif >Cabañas Este/Dolores</option>" +
                           "<option value='cabO1' @if ($usuario->mun_cod == 'cabO1' ) selected  @endif >Cabañas Oeste/Cinquera</option>" +
                           "<option value='cabO2' @if ($usuario->mun_cod == 'cabO2' ) selected  @endif >Cabañas Oeste/Ilobasco</option>" +
                           "<option value='cabO3' @if ($usuario->mun_cod == 'cabO3' ) selected  @endif >Cabañas Oeste/Jutiapa</option>" +
                           "<option value='cabO4' @if ($usuario->mun_cod == 'cabO4' ) selected  @endif >Cabañas Oeste/Tejutepeque</option>";

                $("#municipio").find("option").remove().end().append(cabM); 

            } else if (e.target.value == 'cha') {

                //3
                var chaM = "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                           "<option value='chaN1' @if ($usuario->mun_cod == 'cabE1' ) selected  @endif >Chalatenango Norte/Citalá</option>" +
                           "<option value='chaN2' @if ($usuario->mun_cod == 'cabE2' ) selected  @endif >Chalatenango Norte/La Palmao</option>" +
                           "<option value='chaN3' @if ($usuario->mun_cod == 'cabE3' ) selected  @endif >Chalatenango Norte/San Ignacio</option>" +
                           "<option value='chaC1' @if ($usuario->mun_cod == 'chaC1' ) selected  @endif >Chalatenango Centro/Agua Caliente</option>" +
                           "<option value='chaC2' @if ($usuario->mun_cod == 'chaC2' ) selected  @endif >Chalatenango Centro/Dulce Nombre de María</option>" +
                           "<option value='chaC3' @if ($usuario->mun_cod == 'chaC3' ) selected  @endif >Chalatenango Centro/El Paraíso</option>" +
                           "<option value='chaC4' @if ($usuario->mun_cod == 'chaC4' ) selected  @endif >Chalatenango Centro/La Reina</option>" +
                           "<option value='chaC5' @if ($usuario->mun_cod == 'chaC5' ) selected  @endif >Chalatenango Centro/Nueva Concepción</option>" +
                           "<option value='chaC6' @if ($usuario->mun_cod == 'chaC6' ) selected  @endif >Chalatenango Centro/San Fernando</option>" +
                           "<option value='chaC7' @if ($usuario->mun_cod == 'chaC7' ) selected  @endif >Chalatenango Centro/San Francisco Morazán</option>" +
                           "<option value='chaC8' @if ($usuario->mun_cod == 'chaC8' ) selected  @endif >Chalatenango Centro/San Rafael</option>" +
                           "<option value='chaC9' @if ($usuario->mun_cod == 'chaC9' ) selected  @endif >Chalatenango Centro/Santa Rita</option>" +
                           "<option value='chaC10' @if ($usuario->mun_cod == 'chaC10' ) selected  @endif >Chalatenango Centro/Tejutla</option>" +
                           "<option value='chaS1' @if ($usuario->mun_cod == 'chaS1' ) selected  @endif >Chalatenango Sur/Arcatao</option>" +
                           "<option value='chaS2' @if ($usuario->mun_cod == 'chaS2' ) selected  @endif >Chalatenango Sur/Azacualpa</option>" +
                           "<option value='chaS3' @if ($usuario->mun_cod == 'chaS3' ) selected  @endif >Chalatenango Sur/Cancasque</option>" +
                           "<option value='chaS4' @if ($usuario->mun_cod == 'chaS4' ) selected  @endif >Chalatenango Sur/Chalatenango</option>" +
                           "<option value='chaS5' @if ($usuario->mun_cod == 'chaS5' ) selected  @endif >Chalatenango Sur/Comalapa</option>" +
                           "<option value='chaS6' @if ($usuario->mun_cod == 'chaS6' ) selected  @endif >Chalatenango Sur/Concepción Quezaltepeque</option>" +
                           "<option value='chaS7' @if ($usuario->mun_cod == 'chaS7' ) selected  @endif >Chalatenango Sur/El Carrizal</option>" +
                           "<option value='chaS8' @if ($usuario->mun_cod == 'chaS8' ) selected  @endif >Chalatenango Sur/La Laguna</option>" +
                           "<option value='chaS9' @if ($usuario->mun_cod == 'chaS9' ) selected  @endif >Chalatenango Sur/Las Vueltas</option>" +
                           "<option value='chaS10' @if ($usuario->mun_cod == 'chaS10' ) selected  @endif >Chalatenango Sur/Las Flores</option>" +
                           "<option value='chaS11' @if ($usuario->mun_cod == 'chaS11' ) selected  @endif >Chalatenango Sur/Nombre de Jesús</option>" +
                           "<option value='chaS12' @if ($usuario->mun_cod == 'chaS12' ) selected  @endif >Chalatenango Sur/Nueva Trinidad</option>" +
                           "<option value='chaS13' @if ($usuario->mun_cod == 'chaS13' ) selected  @endif >Chalatenango Sur/Ojos de Agua</option>" +
                           "<option value='chaS14' @if ($usuario->mun_cod == 'chaS14' ) selected  @endif >Chalatenango Sur/Potonico</option>" +
                           "<option value='chaS15' @if ($usuario->mun_cod == 'chaS15' ) selected  @endif >Chalatenango Sur/San Antonio de la Cruz</option>" +
                           "<option value='chaS16' @if ($usuario->mun_cod == 'chaS16' ) selected  @endif >Chalatenango Sur/San Antonio Los Ranchos</option>" +
                           "<option value='chaS17' @if ($usuario->mun_cod == 'chaS17' ) selected  @endif >Chalatenango Sur/San Francisco Lempa</option>" +
                           "<option value='chaS18' @if ($usuario->mun_cod == 'chaS18' ) selected  @endif >Chalatenango Sur/San Isidro Labrador</option>" +
                           "<option value='chaS19' @if ($usuario->mun_cod == 'chaS19' ) selected  @endif >Chalatenango Sur/San Luis del Carmen</option>" +
                           "<option value='chaS20' @if ($usuario->mun_cod == 'chaS20' ) selected  @endif >Chalatenango Sur/San Miguel de Mercedes</option>";

                $("#municipio").find("option").remove().end().append(chaM);

            } else if (e.target.value == 'cus') {

                //4
                var cusM = "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                           "<option value='cusN1' @if ($usuario->mun_cod == 'cusN1' ) selected  @endif >Cuscatlán Norte/Suchitoto</option>" +
                           "<option value='cusN2' @if ($usuario->mun_cod == 'cusN2' ) selected  @endif >Cuscatlán Norte/San José Guayabal</option>" +
                           "<option value='cusN3' @if ($usuario->mun_cod == 'cusN3' ) selected  @endif >Cuscatlán Norte/Oratorio de Concepción</option>" +
                           "<option value='cusN4' @if ($usuario->mun_cod == 'cusN4' ) selected  @endif >Cuscatlán Norte/San Bartolomé Perulapía</option>" +
                           "<option value='cusN5' @if ($usuario->mun_cod == 'cusN5' ) selected  @endif >Cuscatlán Norte/San Pedro Perulapán</option>" +
                           "<option value='cusS1' @if ($usuario->mun_cod == 'cusS1' ) selected  @endif >Cuscatlán Sur/Cojutepeque</option>" +
                           "<option value='cusS2' @if ($usuario->mun_cod == 'cusS2' ) selected  @endif >Cuscatlán Sur/Candelaria</option>" +
                           "<option value='cusS3' @if ($usuario->mun_cod == 'cusS3' ) selected  @endif >Cuscatlán Sur/El Carmen</option>" +
                           "<option value='cusS4' @if ($usuario->mun_cod == 'cusS4' ) selected  @endif >Cuscatlán Sur/El Rosario</option>" +
                           "<option value='cusS5' @if ($usuario->mun_cod == 'cusS5' ) selected  @endif >Cuscatlán Sur/Monte San Juan</option>" +
                           "<option value='cusS6' @if ($usuario->mun_cod == 'cusS6' ) selected  @endif >Cuscatlán Sur/San Cristóbal</option>" +
                           "<option value='cusS7' @if ($usuario->mun_cod == 'cusS7' ) selected  @endif >Cuscatlán Sur/San Rafael Cedros</option>" +
                           "<option value='cusS8' @if ($usuario->mun_cod == 'cusS8' ) selected  @endif >Cuscatlán Sur/San Ramón</option>" +
                           "<option value='cusS9' @if ($usuario->mun_cod == 'cusS9' ) selected  @endif >Cuscatlán Sur/Santa Cruz Analquito</option>" +
                           "<option value='cusS10' @if ($usuario->mun_cod == 'cusS10' ) selected  @endif >Cuscatlán Sur/Santa Cruz Michapa</option>" +
                           "<option value='cusS11' @if ($usuario->mun_cod == 'cusS11' ) selected  @endif >Cuscatlán Sur/Tenancingo</option>";

                $("#municipio").find("option").remove().end().append(cusM);

            } else if (e.target.value == 'lib') {

                //5
                var libM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='libN1' @if ($usuario->mun_cod == 'libN1' ) selected  @endif >La Libertad Norte/Quezaltepeque</option>" +
                            "<option value='libN2' @if ($usuario->mun_cod == 'libN2' ) selected  @endif >La Libertad Norte/San Matías</option>" +
                            "<option value='libN3' @if ($usuario->mun_cod == 'libN3' ) selected  @endif >La Libertad Norte/San Pablo Tacachico</option>" +
                            "<option value='libC1' @if ($usuario->mun_cod == 'libC1' ) selected  @endif >La Libertad Centro/San Juan Opico</option>" +
                            "<option value='libC2' @if ($usuario->mun_cod == 'libC2' ) selected  @endif >La Libertad Centro/Ciudad Arce</option>" +
                            "<option value='libO1' @if ($usuario->mun_cod == 'libO1' ) selected  @endif >La Libertad Oeste/Colón</option>" +
                            "<option value='libO2' @if ($usuario->mun_cod == 'libO2' ) selected  @endif >La Libertad Oeste/Jayaque</option>" +
                            "<option value='libO3' @if ($usuario->mun_cod == 'libO3' ) selected  @endif >La Libertad Oeste/Sacacoyo</option>" +
                            "<option value='libO4' @if ($usuario->mun_cod == 'libO4' ) selected  @endif >La Libertad Oeste/Tepecoyo</option>" +
                            "<option value='libO5' @if ($usuario->mun_cod == 'libO5' ) selected  @endif >La Libertad Oeste/Talnique</option>" +
                            "<option value='libE1' @if ($usuario->mun_cod == 'libE1' ) selected  @endif >La Libertad Este/Antiguo Cuscatlán</option>" +
                            "<option value='libE2' @if ($usuario->mun_cod == 'libE2' ) selected  @endif >La Libertad Este/Huizúcar</option>" +
                            "<option value='libE3' @if ($usuario->mun_cod == 'libE3' ) selected  @endif >La Libertad Este/Nuevo Cuscatlán</option>" +
                            "<option value='libE4' @if ($usuario->mun_cod == 'libE4' ) selected  @endif >La Libertad Este/San José Villanueva</option>" +
                            "<option value='libE5' @if ($usuario->mun_cod == 'libE5' ) selected  @endif >La Libertad Este/Zaragoza</option>" +
                            "<option value='libCt1' @if ($usuario->mun_cod == 'libCt1' ) selected  @endif >La Libertad Costa/Chiltiupán</option>" +
                            "<option value='libCt2' @if ($usuario->mun_cod == 'libCt2' ) selected  @endif >La Libertad Costa/Jicalapa</option>" +
                            "<option value='libCt3' @if ($usuario->mun_cod == 'libCt3' ) selected  @endif >La Libertad Costa/La Libertad</option>" +
                            "<option value='libCt4' @if ($usuario->mun_cod == 'libCt4' ) selected  @endif >La Libertad Costa/Tamanique</option>" +
                            "<option value='libCt5' @if ($usuario->mun_cod == 'libCt5' ) selected  @endif >La Libertad Costa/Teotepeque</option>" +
                            "<option value='libS1' @if ($usuario->mun_cod == 'libS1' ) selected  @endif >La Libertad Sur/Santa Tecla</option>" +
                            "<option value='libS2' @if ($usuario->mun_cod == 'libS2' ) selected  @endif >La Libertad Sur/Comasagua</option>";

                $("#municipio").find("option").remove().end().append(libM);
                
            } else if (e.target.value == 'mor') {

                //6
                var morM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='morN1' @if ($usuario->mun_cod == 'morN1' ) selected  @endif >Morazán Norte/Arambala</option>" +
                            "<option value='morN2' @if ($usuario->mun_cod == 'morN2' ) selected  @endif >Morazán Norte/Cacaopera</option>" +
                            "<option value='morN3' @if ($usuario->mun_cod == 'morN3' ) selected  @endif >Morazán Norte/Corinto</option>" +
                            "<option value='morN4' @if ($usuario->mun_cod == 'morN4' ) selected  @endif >Morazán Norte/El Rosario</option>" +
                            "<option value='morN5' @if ($usuario->mun_cod == 'morN5' ) selected  @endif >Morazán Norte/Joateca</option>" +
                            "<option value='morN6' @if ($usuario->mun_cod == 'morN6' ) selected  @endif >Morazán Norte/Jocoaitique</option>" +
                            "<option value='morN7' @if ($usuario->mun_cod == 'morN7' ) selected  @endif >Morazán Norte/Meanguera</option>" +
                            "<option value='morN8' @if ($usuario->mun_cod == 'morN8' ) selected  @endif >Morazán Norte/Perquín</option>" +
                            "<option value='morN9' @if ($usuario->mun_cod == 'morN9' ) selected  @endif >Morazán Norte/San Fernando</option>" +
                            "<option value='morN10' @if ($usuario->mun_cod == 'morN10' ) selected  @endif >Morazán Norte/San Isidro</option>" +
                            "<option value='morN11' @if ($usuario->mun_cod == 'morN11' ) selected  @endif >Morazán Norte/Torola</option>" +
                            "<option value='morS1' @if ($usuario->mun_cod == 'morS1' ) selected  @endif >Morazán Sur/Chilanga</option>" +
                            "<option value='morS2' @if ($usuario->mun_cod == 'morS2' ) selected  @endif >Morazán Sur/Delicias de Concepción</option>" +
                            "<option value='morS3' @if ($usuario->mun_cod == 'morS3' ) selected  @endif >Morazán Sur/El Divisadero</option>" +
                            "<option value='morS4' @if ($usuario->mun_cod == 'morS4' ) selected  @endif >Morazán Sur/Gualococti</option>" +
                            "<option value='morS5' @if ($usuario->mun_cod == 'morS5' ) selected  @endif >Morazán Sur/Guatajiagua</option>" +
                            "<option value='morS6' @if ($usuario->mun_cod == 'morS6' ) selected  @endif >Morazán Sur/Jocoro</option>" +
                            "<option value='morS7' @if ($usuario->mun_cod == 'morS7' ) selected  @endif >Morazán Sur/Lolotiquillo</option>" +
                            "<option value='morS8' @if ($usuario->mun_cod == 'morS8' ) selected  @endif >Morazán Sur/Osicala</option>" +
                            "<option value='morS9' @if ($usuario->mun_cod == 'morS9' ) selected  @endif >Morazán Sur/San Carlos</option>" +
                            "<option value='morS10' @if ($usuario->mun_cod == 'morS10' ) selected  @endif >Morazán Sur/San Francisco Gotera</option>" +
                            "<option value='morS11' @if ($usuario->mun_cod == 'morS11' ) selected  @endif >Morazán Sur/San Simón</option>" +
                            "<option value='morS12' @if ($usuario->mun_cod == 'morS12' ) selected  @endif >Morazán Sur/Sensembra</option>" +
                            "<option value='morS13' @if ($usuario->mun_cod == 'morS13' ) selected  @endif >Morazán Sur/Sociedad</option>" +
                            "<option value='morS14' @if ($usuario->mun_cod == 'morS14' ) selected  @endif >Morazán Sur/Yamabal</option>" +
                            "<option value='morS15' @if ($usuario->mun_cod == 'morS15' ) selected  @endif >Morazán Sur/Yoloaiquín</option>";

                $("#municipio").find("option").remove().end().append(morM);  

            } else if (e.target.value == 'paz') {

                //7
                var pazM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='pazO1' @if ($usuario->mun_cod == 'pazO1' ) selected  @endif >La Paz Oeste/Cuyultitán</option>" +
                            "<option value='pazO2' @if ($usuario->mun_cod == 'pazO2' ) selected  @endif >La Paz Oeste/Olocuilta</option>" +
                            "<option value='pazO3' @if ($usuario->mun_cod == 'pazO3' ) selected  @endif >La Paz Oeste/San Juan Talpa</option>" +
                            "<option value='pazO4' @if ($usuario->mun_cod == 'pazO4' ) selected  @endif >La Paz Oeste/San Luis Talpa</option>" +
                            "<option value='pazO5' @if ($usuario->mun_cod == 'pazO5' ) selected  @endif >La Paz Oeste/San Pedro Masahuat</option>" +
                            "<option value='pazO6' @if ($usuario->mun_cod == 'pazO6' ) selected  @endif >La Paz Oeste/Tapalhuaca</option>" +
                            "<option value='pazO7' @if ($usuario->mun_cod == 'pazO7' ) selected  @endif >La Paz Oeste/San Francisco Chinameca</option>" +
                            "<option value='pazC1' @if ($usuario->mun_cod == 'pazC1' ) selected  @endif >La Paz Centro/El Rosario</option>" +
                            "<option value='pazC2' @if ($usuario->mun_cod == 'pazC2' ) selected  @endif >La Paz Centro/Jerusalén</option>" +
                            "<option value='pazC3' @if ($usuario->mun_cod == 'pazC3' ) selected  @endif >La Paz Centro/Mercedes La Ceiba</option>" +
                            "<option value='pazC4' @if ($usuario->mun_cod == 'pazC4' ) selected  @endif >La Paz Centro/Paraíso de Osorio</option>" +
                            "<option value='pazC5' @if ($usuario->mun_cod == 'pazC5' ) selected  @endif >La Paz Centro/San Antonio Masahuat</option>" +
                            "<option value='pazC6' @if ($usuario->mun_cod == 'pazC6' ) selected  @endif >La Paz Centro/San Emigdio</option>" +
                            "<option value='pazC7' @if ($usuario->mun_cod == 'pazC7' ) selected  @endif >La Paz Centro/San Juan Tepezontes</option>" +
                            "<option value='pazC8' @if ($usuario->mun_cod == 'pazC8' ) selected  @endif >La Paz Centro/San Luis La Herradura</option>" +
                            "<option value='pazC9' @if ($usuario->mun_cod == 'pazC9' ) selected  @endif >La Paz Centro/San Miguel Tepezontes</option>" +
                            "<option value='pazC10' @if ($usuario->mun_cod == 'pazC10' ) selected  @endif >La Paz Centro/San Pedro Nonualco</option>" +
                            "<option value='pazC11' @if ($usuario->mun_cod == 'pazC11' ) selected  @endif >La Paz Centro/Santa María Ostuma</option>" +
                            "<option value='pazC12' @if ($usuario->mun_cod == 'pazC12' ) selected  @endif >La Paz Centro/Santiago Nonualco</option>" +
                            "<option value='pazE1' @if ($usuario->mun_cod == 'pazE1' ) selected  @endif >La Paz Este/San Juan Nonualco</option>" +
                            "<option value='pazE2' @if ($usuario->mun_cod == 'pazE2' ) selected  @endif >La Paz Este/San Rafael Obrajuelo</option>" +
                            "<option value='pazE3' @if ($usuario->mun_cod == 'pazE3' ) selected  @endif >La Paz Este/Zacatecoluca</option>";

                $("#municipio").find("option").remove().end().append(pazM);

            } else if (e.target.value == 'ana') {

                //8
                var anaM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='anaN1' @if ($usuario->mun_cod == 'anaN1' ) selected  @endif >Santa Ana Norte/Masahuat</option>" +
                            "<option value='anaN2' @if ($usuario->mun_cod == 'anaN2' ) selected  @endif >Santa Ana Norte/Metapán</option>" +
                            "<option value='anaN3' @if ($usuario->mun_cod == 'anaN3' ) selected  @endif >Santa Ana Norte/Santa Rosa Guachipilín</option>" +
                            "<option value='anaN4' @if ($usuario->mun_cod == 'anaN4' ) selected  @endif >Santa Ana Norte/Texistepeque</option>" +
                            "<option value='anaC5' @if ($usuario->mun_cod == 'anaC5' ) selected  @endif >Santa Ana Centro/Santa Ana</option>" +
                            "<option value='anaE6' @if ($usuario->mun_cod == 'anaE6' ) selected  @endif >Santa Ana Este/Coatepeque</option>" +
                            "<option value='anaE7' @if ($usuario->mun_cod == 'anaE7' ) selected  @endif >Santa Ana Este/El Congo</option>" +
                            "<option value='anaO1' @if ($usuario->mun_cod == 'anaO1' ) selected  @endif >Santa Ana Oeste/Candelaria de la Frontera</option>" +
                            "<option value='anaO2' @if ($usuario->mun_cod == 'anaO2' ) selected  @endif >Santa Ana Oeste/Chalchuapa</option>" +
                            "<option value='anaO3' @if ($usuario->mun_cod == 'anaO3' ) selected  @endif >Santa Ana Oeste/El Porvenir</option>" +
                            "<option value='anaO4' @if ($usuario->mun_cod == 'anaO4' ) selected  @endif >Santa Ana Oeste/San Antonio Pajonal</option>" +
                            "<option value='anaO5' @if ($usuario->mun_cod == 'anaO5' ) selected  @endif >Santa Ana Oeste/San Sebastián Salitrillo</option>" +
                            "<option value='anaO6' @if ($usuario->mun_cod == 'anaO6' ) selected  @endif >Santa Ana Oeste/Santiago de la Frontera</option>"; 

                $("#municipio").find("option").remove().end().append(anaM);

            } else if (e.target.value == 'mig') {

                //9
                var migM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='migN1' @if ($usuario->mun_cod == 'migN1' ) selected  @endif >San Miguel Norte/Ciudad Barrios</option>" +
                            "<option value='migN2' @if ($usuario->mun_cod == 'migN2' ) selected  @endif >San Miguel Norte/Sesori</option>" +
                            "<option value='migN3' @if ($usuario->mun_cod == 'migN3' ) selected  @endif >San Miguel Norte/Nuevo Edén de San Juan</option>" +
                            "<option value='migN4' @if ($usuario->mun_cod == 'migN4' ) selected  @endif >San Miguel Norte/San Gerardo</option>" +
                            "<option value='migN5' @if ($usuario->mun_cod == 'migN5' ) selected  @endif >San Miguel Norte/San Luis de la Reina</option>" +
                            "<option value='migN6' @if ($usuario->mun_cod == 'migN6' ) selected  @endif >San Miguel Norte/Carolina</option>" +
                            "<option value='migN7' @if ($usuario->mun_cod == 'migN7' ) selected  @endif >San Miguel Norte/San Antonio</option>" +
                            "<option value='migN8' @if ($usuario->mun_cod == 'migN8' ) selected  @endif >San Miguel Norte/Chapeltique</option>" +
                            "<option value='migC1' @if ($usuario->mun_cod == 'migC1' ) selected  @endif >San Miguel Centro/San Miguel</option>" +
                            "<option value='migC2' @if ($usuario->mun_cod == 'migC2' ) selected  @endif >San Miguel Centro/Comacarán</option>" +
                            "<option value='migC3' @if ($usuario->mun_cod == 'migC3' ) selected  @endif >San Miguel Centro/Uluazapa</option>" +
                            "<option value='migC4' @if ($usuario->mun_cod == 'migC4' ) selected  @endif >San Miguel Centro/Moncagua</option>" +
                            "<option value='migC5' @if ($usuario->mun_cod == 'migC5' ) selected  @endif >San Miguel Centro/Quelepa</option>" +
                            "<option value='migC6' @if ($usuario->mun_cod == 'migC6' ) selected  @endif >San Miguel Centro/Chirilagua</option>" +
                            "<option value='migO1' @if ($usuario->mun_cod == 'migO1' ) selected  @endif >San Miguel Oeste/Chinameca</option>" +
                            "<option value='migO2' @if ($usuario->mun_cod == 'migO2' ) selected  @endif >San Miguel Oeste/El Tránsito</option>" +
                            "<option value='migO3' @if ($usuario->mun_cod == 'migO3' ) selected  @endif >San Miguel Oeste/Lolotique</option>" +
                            "<option value='migO4' @if ($usuario->mun_cod == 'migO4' ) selected  @endif >San Miguel Oeste/Nueva Guadalupe</option>" +
                            "<option value='migO5' @if ($usuario->mun_cod == 'migO5' ) selected  @endif >San Miguel Oeste/San Jorge</option>" +
                            "<option value='migO6' @if ($usuario->mun_cod == 'migO6' ) selected  @endif >San Miguel Oeste/San Rafael Oriente</option>";

                $("#municipio").find("option").remove().end().append(migM); 

            } else if (e.target.value == 'ssl') {

                //10
                var sslM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='sslN1' @if ($usuario->mun_cod == 'sslN1' ) selected  @endif >San Salvador Norte/Aguilares</option>" +
                            "<option value='sslN2' @if ($usuario->mun_cod == 'sslN2' ) selected  @endif >San Salvador Norte/El Paisnal</option>" +
                            "<option value='sslN3' @if ($usuario->mun_cod == 'sslN3' ) selected  @endif >San Salvador Norte/Guazapan</option>" +
                            "<option value='sslO1' @if ($usuario->mun_cod == 'sslO1' ) selected  @endif >San Salvador Oeste/Apopa</option>" +
                            "<option value='sslO2' @if ($usuario->mun_cod == 'sslO2' ) selected  @endif >San Salvador Oeste/Nejapa</option>" +
                            "<option value='sslE1' @if ($usuario->mun_cod == 'sslE1' ) selected  @endif >San Salvador Este/Ilopango</option>" +
                            "<option value='sslE2' @if ($usuario->mun_cod == 'sslE2' ) selected  @endif >San Salvador Este/San Martín</option>" +
                            "<option value='sslE3' @if ($usuario->mun_cod == 'sslE3' ) selected  @endif >San Salvador Este/Soyapango</option>" +
                            "<option value='sslE4' @if ($usuario->mun_cod == 'sslE4' ) selected  @endif >San Salvador Este/Tonacatepeque</option>" +
                            "<option value='sslC1' @if ($usuario->mun_cod == 'sslC1' ) selected  @endif >San Salvador Centro/Ayutuxtepeque</option>" +
                            "<option value='sslC2' @if ($usuario->mun_cod == 'sslC2' ) selected  @endif >San Salvador Centro/Mejicanos</option>" +
                            "<option value='sslC3' @if ($usuario->mun_cod == 'sslC3' ) selected  @endif >San Salvador Centro/Cuscatancingo</option>" +
                            "<option value='sslC4' @if ($usuario->mun_cod == 'sslC4' ) selected  @endif >San Salvador Centro/Ciudad Delgado</option>" +
                            "<option value='sslC5' @if ($usuario->mun_cod == 'sslC5' ) selected  @endif >San Salvador Centro/San Salvador</option>" +
                            "<option value='sslS1' @if ($usuario->mun_cod == 'sslS1' ) selected  @endif >San Salvador Sur/San Marcos</option>" +
                            "<option value='sslS2' @if ($usuario->mun_cod == 'sslS2' ) selected  @endif >San Salvador Sur/Santo Tomás</option>" +
                            "<option value='sslS3' @if ($usuario->mun_cod == 'sslS3' ) selected  @endif >San Salvador Sur/Santiago Texacuangos</option>" +
                            "<option value='sslS4' @if ($usuario->mun_cod == 'sslS4' ) selected  @endif >San Salvador Sur/Panchimalco</option>" +
                            "<option value='sslS5' @if ($usuario->mun_cod == 'sslS5' ) selected  @endif >San Salvador Sur/Rosario de Mora</option>";

                $("#municipio").find("option").remove().end().append(sslM);

            } else if (e.target.value == 'svi') {

                //11
                var sviM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='sviN1' @if ($usuario->mun_cod == 'sviN1' ) selected  @endif >San Vicente Norte/Apastepeque</option>" +
                            "<option value='sviN2' @if ($usuario->mun_cod == 'sviN2' ) selected  @endif >San Vicente Norte/Santa Clara</option>" +
                            "<option value='sviN3' @if ($usuario->mun_cod == 'sviN3' ) selected  @endif >San Vicente Norte/San Ildefonso</option>" +
                            "<option value='sviN4' @if ($usuario->mun_cod == 'sviN4' ) selected  @endif >San Vicente Norte/San Esteban Catarina</option>" +
                            "<option value='sviN5' @if ($usuario->mun_cod == 'sviN5' ) selected  @endif >San Vicente Norte/San Sebastián</option>" +
                            "<option value='sviN6' @if ($usuario->mun_cod == 'sviN6' ) selected  @endif >San Vicente Norte/San Lorenzo</option>" +
                            "<option value='sviN7' @if ($usuario->mun_cod == 'sviN7' ) selected  @endif >San Vicente Norte/Santo Domingo</option>" +
                            "<option value='sviS1' @if ($usuario->mun_cod == 'sviS1' ) selected  @endif >San Vicente Sur/San Vicente</option>" +
                            "<option value='sviS2' @if ($usuario->mun_cod == 'sviS2' ) selected  @endif >San Vicente Sur/Guadalupe</option>" +
                            "<option value='sviS3' @if ($usuario->mun_cod == 'sviS3' ) selected  @endif >San Vicente Sur/San Cayetano Istepeque</option>" +
                            "<option value='sviS4' @if ($usuario->mun_cod == 'sviS4' ) selected  @endif >San Vicente Sur/Tecoluca</option>" +
                            "<option value='sviS5' @if ($usuario->mun_cod == 'sviS5' ) selected  @endif >San Vicente Sur/Tepetitán</option>" +
                            "<option value='sviS6' @if ($usuario->mun_cod == 'sviS6' ) selected  @endif >San Vicente Sur/Verapaz</option>";

                $("#municipio").find("option").remove().end().append(sviM);   

            } else if (e.target.value == 'son') {

                //12
                var sonM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='sonN1' @if ($usuario->mun_cod == 'sonN1' ) selected  @endif >Sonsonate Norte/Juayúa</option>" +
                            "<option value='sonN2' @if ($usuario->mun_cod == 'sonN2' ) selected  @endif >Sonsonate Norte/Nahuizalco</option>" +
                            "<option value='sonN3' @if ($usuario->mun_cod == 'sonN3' ) selected  @endif >Sonsonate Norte/Salcoatitán</option>" +
                            "<option value='sonN4' @if ($usuario->mun_cod == 'sonN4' ) selected  @endif >Sonsonate Norte/Santa Catarina Masahuat</option>" +
                            "<option value='sonC1' @if ($usuario->mun_cod == 'sonC1' ) selected  @endif >Sonsonate Centro/Sonsonate</option>" +
                            "<option value='sonC2' @if ($usuario->mun_cod == 'sonC2' ) selected  @endif >Sonsonate Centro/Sonzacate</option>" +
                            "<option value='sonC3' @if ($usuario->mun_cod == 'sonC3' ) selected  @endif >Sonsonate Centro/Nahulingo</option>" +
                            "<option value='sonC4' @if ($usuario->mun_cod == 'sonC4' ) selected  @endif >Sonsonate Centro/San Antonio del Monte</option>" +
                            "<option value='sonC5' @if ($usuario->mun_cod == 'sonC5' ) selected  @endif >Sonsonate Centro/Santo Domingo de Guzmán</option>" +
                            "<option value='sonE1' @if ($usuario->mun_cod == 'sonE1' ) selected  @endif >Sonsonate Este/Armenia</option>" +
                            "<option value='sonE2' @if ($usuario->mun_cod == 'sonE2' ) selected  @endif >Sonsonate Este/Caluco</option>" +
                            "<option value='sonE3' @if ($usuario->mun_cod == 'sonE3' ) selected  @endif >Sonsonate Este/Cuisnahuat</option>" +
                            "<option value='sonE4' @if ($usuario->mun_cod == 'sonE4' ) selected  @endif >Sonsonate Este/Izalco</option>" +
                            "<option value='sonE5' @if ($usuario->mun_cod == 'sonE5' ) selected  @endif >Sonsonate Este/San Julián</option>" +
                            "<option value='sonE6' @if ($usuario->mun_cod == 'sonE6' ) selected  @endif >Sonsonate Este/Santa Isabel Ishuatán</option>" +
                            "<option value='sonO1' @if ($usuario->mun_cod == 'sonO1' ) selected  @endif >Sonsonate Oeste/Acajutla</option>";

                $("#municipio").find("option").remove().end().append(sonM);

            } else if (e.target.value == 'uni') {

                //13
                var uniM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='uniN1' @if ($usuario->mun_cod == 'uniN1' ) selected  @endif >La Unión Norte/Anamorós</option>" +
                            "<option value='uniN2' @if ($usuario->mun_cod == 'uniN2' ) selected  @endif >La Unión Norte/Bolívar</option>" +
                            "<option value='uniN3' @if ($usuario->mun_cod == 'uniN3' ) selected  @endif >La Unión Norte/Concepción de Oriente</option>" +
                            "<option value='uniN4' @if ($usuario->mun_cod == 'uniN4' ) selected  @endif >La Unión Norte/El Sauce</option>" +
                            "<option value='uniN5' @if ($usuario->mun_cod == 'uniN5' ) selected  @endif >La Unión Norte/Lislique</option>" +
                            "<option value='uniN6' @if ($usuario->mun_cod == 'uniN6' ) selected  @endif >La Unión Norte/Nueva Esparta</option>" +
                            "<option value='uniN7' @if ($usuario->mun_cod == 'uniN7' ) selected  @endif >La Unión Norte/Pasaquina</option>" +
                            "<option value='uniN8' @if ($usuario->mun_cod == 'uniN8' ) selected  @endif >La Unión Norte/Polorós</option>" +
                            "<option value='uniN9' @if ($usuario->mun_cod == 'uniN9' ) selected  @endif >La Unión Norte/San José</option>" +
                            "<option value='uniN10' @if ($usuario->mun_cod == 'uniN10' ) selected  @endif >La Unión Norte/Santa Rosa de Lima</option>" +
                            "<option value='uniS1' @if ($usuario->mun_cod == 'uniS1' ) selected  @endif >La Unión Norte/Conchagua</option>" +
                            "<option value='uniS2' @if ($usuario->mun_cod == 'uniS2' ) selected  @endif >La Unión Sur/El Carmen</option>" +
                            "<option value='uniS3' @if ($usuario->mun_cod == 'uniS3' ) selected  @endif >La Unión Sur/Intipucá</option>" +
                            "<option value='uniS4' @if ($usuario->mun_cod == 'uniS4' ) selected  @endif >La Unión Sur/La Unión</option>" +
                            "<option value='uniS5' @if ($usuario->mun_cod == 'uniS5' ) selected  @endif >La Unión Sur/Meanguera del Golfo</option>" +
                            "<option value='uniS6' @if ($usuario->mun_cod == 'uniS6' ) selected  @endif >La Unión Sur/San Alejo</option>" +
                            "<option value='uniS7' @if ($usuario->mun_cod == 'uniS7' ) selected  @endif >La Unión Sur/Yayantique</option>" +
                            "<option value='uniS8' @if ($usuario->mun_cod == 'uniS8' ) selected  @endif >La Unión Sur/Yucuaiquín</option>";

                $("#municipio").find("option").remove().end().append(uniM);

            } else if (e.target.value == 'usu') {
                
                //14
                var usuM =  "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>" +
                            "<option value='usuN1' @if ($usuario->mun_cod == 'usuN1' ) selected  @endif >Usulután Norte/Alegría</option>" +
                            "<option value='usuN2' @if ($usuario->mun_cod == 'usuN2' ) selected  @endif >Usulután Norte/Berlín</option>" +
                            "<option value='usuN3' @if ($usuario->mun_cod == 'usuN3' ) selected  @endif >Usulután Norte/El Triunfo</option>" +
                            "<option value='usuN4' @if ($usuario->mun_cod == 'usuN4' ) selected  @endif >Usulután Norte/Estanzuelas</option>" +
                            "<option value='usuN5' @if ($usuario->mun_cod == 'usuN5' ) selected  @endif >Usulután Norte/Jucuapa</option>" +
                            "<option value='usuN6' @if ($usuario->mun_cod == 'usuN6' ) selected  @endif >Usulután Norte/Mercedes Umaña</option>" +
                            "<option value='usuN7' @if ($usuario->mun_cod == 'usuN7' ) selected  @endif >Usulután Norte/Nueva Granada</option>" +
                            "<option value='usuN8' @if ($usuario->mun_cod == 'usuN8' ) selected  @endif >Usulután Norte/San Buenaventura</option>" +
                            "<option value='usuN9' @if ($usuario->mun_cod == 'usuN9' ) selected  @endif >Usulután Norte/Santiago de María</option>" +
                            "<option value='usuC1' @if ($usuario->mun_cod == 'usuC1' ) selected  @endif >Usulután Este/California</option>" +
                            "<option value='usuC2' @if ($usuario->mun_cod == 'usuC2' ) selected  @endif >Usulután Este/Concepción Batres</option>" +
                            "<option value='usuC3' @if ($usuario->mun_cod == 'usuC3' ) selected  @endif >Usulután Este/Ereguayquín</option>" +
                            "<option value='usuC4' @if ($usuario->mun_cod == 'usuC4' ) selected  @endif >Usulután Este/Jucuarán</option>" +
                            "<option value='usuC5' @if ($usuario->mun_cod == 'usuC5' ) selected  @endif >Usulután Este/Ozatlán</option>" +
                            "<option value='usuC6' @if ($usuario->mun_cod == 'usuC6' ) selected  @endif >Usulután Este/Santa Elena</option>" +
                            "<option value='usuC7' @if ($usuario->mun_cod == 'usuC7' ) selected  @endif >Usulután Este/San Dionisio</option>" +
                            "<option value='usuC8' @if ($usuario->mun_cod == 'usuC8' ) selected  @endif >Usulután Este/Santa María</option>" +
                            "<option value='usuC9' @if ($usuario->mun_cod == 'usuC9' ) selected  @endif >Usulután Este/Tecapán</option>" +
                            "<option value='usuC10' @if ($usuario->mun_cod == 'usuC10' ) selected  @endif >Usulután Este/Usulután</option>" +
                            "<option value='usuO1' @if ($usuario->mun_cod == 'usuO1' ) selected  @endif >Usulután Oeste/Jiquilisco</option>" +
                            "<option value='usuO2' @if ($usuario->mun_cod == 'usuO2' ) selected  @endif >Usulután Oeste/Puerto El Triunfo</option>" +
                            "<option value='usuO3' @if ($usuario->mun_cod == 'usuO3' ) selected  @endif >Usulután Oeste/San Agustín</option>" +
                            "<option value='usuO4' @if ($usuario->mun_cod == 'usuO4' ) selected  @endif >Usulután Oeste/San Francisco Javier</option>";

                $("#municipio").find("option").remove().end().append(usuM);
            
            } else {

                //15
                var nada = "<option value='0' @if ($usuario->mun_cod == '0' ) selected  @endif >Selecciona un municipio/distrito</option>";

                $("#municipio").find("option").remove().end().append(nada);
            }  
            
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
              utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/utils.js",

            hiddenInput: function(telInputName) {
                return {
                  phone: "whatsapp_full",
                  country: "country_code1"
                };
            }
      });



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
              utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/utils.js",
            
            hiddenInput: function(telInputName) {
                return {
                  phone: "tel_full",
                  country: "country_code2"
                };
            }
      });

    </script>

    <script type="text/javascript">

        $(document).ready(function(){
          $('#nit').mask('0000-000000-000-0');
          $('#dui').mask('00000000-0');
        });  

    </script>

@endsection
