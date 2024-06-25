@extends('layouts.app')

@section('content')
@section('title', 'Editar Usuario') 
    
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
                        <label for="imagen_perfil_src">Imagen de perfil/Logo empresa (200x200px | .png, .jpg, .jpeg) </label>
                        <br/>
                        <img class="rounded mt-2" src="/file/serve/{{ $usuario->imagen_perfil_src }}" alt="per" width="200">
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
                            <input class="form-control" type="text" name="dui" id="dui" value="{{ $usuario->dui }}" minlength="10" maxlength="10" placeholder="00000000-0">
                            @error('dui')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>                      

                        <div class="col-6">
                            <label for="whatsapp">Celular/Núm. WhatsApp: </label>
                            <input class="form-control" type="text" name="whatsapp" id="whatsapp" value="{{ $usuario->whatsapp }}" minlength="8" maxlength="9" placeholder="0000-0000">
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
                            <label for="municipio">Municipio/Distrito: </label>
                            <input class="form-control" type="text" name="municipio" id="municipio" value="{{ $usuario->municipio }}" maxlength="25" placeholder="-">
                            @error('municipio')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="departamento">Departamento: </label>
                            <input class="form-control" type="text" name="departamento" id="departamento" value="{{ $usuario->departamento }}" maxlength="15" placeholder="-">
                            @error('departamento')
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
                            <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $usuario->telefono }}" minlength="8" maxlength="9" placeholder="0000-0000">
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

        // function asignarMarca(check_id) {

        //     var marca = $('#'+check_id).val();
        //     var clienteid = check_id;

        //     //console.log("marca id: "+marca+" cliente id: "+clienteid);
            
        //     $.ajax({
        //         url: "{{ route('clientes.marcaUpdate') }}",
        //         type: "POST",
        //         data:
        //             "_token=" + "{{ csrf_token() }}" + "&marca=" + marca + "&cliente=" + clienteid,

        //         success: function(response){
        //             $('#successMsg').show();
        //             console.log(response);
        //         },
        //         error: function(response) {
        //             $('#ErrorMsg1').text(response.responseJSON.errors.marca);
        //             $('#ErrorMsg2').text(response.responseJSON.errors.cliente);
        //         },
        //     });
            
        // }

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

@endsection
