@extends('layouts.app')

@section('content')
@section('title', 'Cliente: ' . $aspirante->name)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🎯 Aspirantes a Clientes 🎯</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección se muestran los aspirantes a clientes que se han registrado en el sistema.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/aspirantes') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3">

        <div class="card-body">

            <div class="mt-3 mb-4">
                <img class="rounded mt-2 mb-2" style="display: block; margin: 0 auto;" src="{{ url('storage/assets/img/perfil-user/'.$aspirante->imagen_perfil_src) }}" alt="per" width="200">
                <h4 class="text-center">Nombre del usuario: <br/> <span style="color: #ff161f">{{ $aspirante->name }}</span> </h4>
                <br/>
                <p class="text-center" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;"><b>Tipo de Cliente:</b>
                        @if ($aspirante->usr_tipo == 'persona') 
                            persona natural sin NRC 
                        @else
                            empresa o persona natural con NRC 
                        @endif
                        </span>
                </p>
            </div>

            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">ID Usuario:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Correo Electrónico:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Dirección:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Teléfono:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Celular/Núm. WhatsApp:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">WebSite: </span>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        {{ $aspirante->id }} <br>
                        <a href="mailto:{{ $aspirante->email }}" title="contactar" target="_blank">{{ $aspirante->email }}</a><br>
                        {{ $aspirante->direccion }}, {{ $aspirante->municipio }}, {{ $aspirante->departamento }}  <br>
                        {{ $aspirante->telefono }} <br>
                        {{ $aspirante->whatsapp }} <br>
                        <a href="http://{{ $aspirante->website }}" title="Ir a" target="_blank">{{ $aspirante->website }} <br></a>
                    </p>
                </div>

            </div>
            
            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">N° de registro (NRC):</span> <br>
                        <span class="font-weight-bold" style="color:#000;">NIT:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">DUI:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Nombre Comercial:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Nombre/razón ó denominación social:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Giro ó actividad económica:</span> <br>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        {{ $aspirante->nrc }} <br>
                        {{ $aspirante->nit }} <br>
                        {{ $aspirante->dui }} <br>
                        {{ $aspirante->nombre_empresa }} <br>
                        {{ $aspirante->razon_social }} <br>
                        {{ $aspirante->giro }} <br> 
                    </p>
                </div>

            </div>

            <hr/>

        @if ( $aspirante->form_status != 'none' )

            <div class="row my-3">

                <h4 class="text-center mb-4">Marcas disponibles:</h4>

                <div class="col-sm-12 flex-center">
                    <div class="text-start">
 
                    @foreach ($marcas as $marca)
                        <label for="marca-{{ $marca->nombre }}">
                            <input id="marca-{{ $marca->nombre }}" type="checkbox" name="marks[]" value="{{ $marca->id }}" onclick="updateMarca (this.id)" @if ( str_contains( $aspirante->marcas, $marca->id ) ) checked @endif /> {{ $marca->nombre }} @if ($marca->estado == 'Inactivo') <span style="color: red;">(inactiva)</span> @endif

                        </label>
                        <br/>
                    @endforeach

                    <input type="hidden" id="aspid" name="aspid" value="{{ $aspirante->id }}">
                    
                    <div class="alert alert-success mb-2" role="alert" id="successMsg" style="display: none" >
                        Marca/s autorizada/s o denegadas con éxito! 
                    </div>

                    <span class="text-danger" id="ErrorMsg1"></span>
                    <span class="text-danger" id="ErrorMsg2"></span>
                    </div> 
                </div>

            </div>        

            <hr/>

            <div class="row my-4">

                <h4 class="text-center mb-4">Asignar una lista de precios: </h4>

                <div class="flex-center">
       
                    <form class="d-inline-block" action="{{ route('aspirantes.taller', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idtall" class="btn p-2 mx-1 ctallerbg classtag {{ $aspirante->clasificacion == 'taller' ? 'classtagsel' : ''; }}" type="submit">Taller</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('aspirantes.distribuidor', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="iddistr" class="btn p-2 mx-1 cdistbg classtag {{ $aspirante->clasificacion == 'distribuidor' ? 'classtagsel' : ''; }}" type="submit">Distribuidor</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('aspirantes.pcosto', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idprec" class="btn p-2 mx-1 cpreciocostobg classtag {{ $aspirante->clasificacion == 'precioCosto' ? 'classtagsel' : ''; }}" type="submit">Precio Costo</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('aspirantes.pop', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idpreo" class="btn p-2 mx-1 cprecioopbg classtag {{ $aspirante->clasificacion == 'precioOp' ? 'classtagsel' : ''; }}" type="submit">Precio OP</button>
                    </form>

                </div>

            </div>        

            <hr/>

            <div class="row mt-4 mb-2">

                <h4 class="text-center mb-4">Activar modo catálogo individual: </h4>

                <div class="flex-center">
       
                    <div class="mb-4">
                        <div class="text-center">
                            <input type="radio" name="catMod" value="1" @if($aspirante->cat_mod == 1) checked @endif > <span style="color: red; font-weight: bold;">Activar modo catálogo</span>
                            <br/> 
                            <br/> 
                            <input type="radio" name="catMod" value="0" @if($aspirante->cat_mod == 0) checked @endif > <span style="color: #000; font-weight: bold;">Desactivar modo catálogo</span>
                            </label> 
                        </div>
                    </div>

                </div>

                <div class="alert alert-success mb-2 text-center" role="alert" id="successMsg5" style="display: none; width:100%; max-width: 400px; margin: 0 auto;" >
                   Modo catálogo activado/desactivado con éxito! 
                </div>

                <span class="text-danger" id="ErrorMsg5"></span>

            </div>        

            <hr/>

            <div class="row my-3">

                <h4 class="text-center mb-4">Actualizar Estado:</h4>

                <div class="col-sm-6">
                    <div class="text-end">
                @if ($aspirante->estatus == 'aspirante' || $aspirante->estatus == 'rechazado')
                    <form action="{{ route('aspirantes.aprobado', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success p-2 p-0" type="submit">Aprobar Cliente</button>
                    </form>
                @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="text-start">
                @if ($aspirante->estatus == 'aspirante')
                    <form action="{{ route('aspirantes.rechazado', $aspirante->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary p-2 p-0" type="submit">Rechazar Cliente</button>
                    </form>
                @endif
                    </div>
                </div>
            </div>

        @else

            <h4 class="text-center mt-5 mb-4">A la espera que el aspirante complete el formulario de inscripción.</h4>

        @endif


        </div>
    </div>


    <script type="text/javascript">
/*
        function asignarMarca(check_id) {

            var marca = $('#'+check_id).val();
            var clienteid = $('#aspid').val();

            console.log("marca id: "+marca+" cliente id: "+clienteid);
            
            $.ajax({
                url: "{{ route('aspirante.updmarcas', $aspirante->id) }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&marca=" + marca + "&cliente=" + clienteid,

                success: function(response){
                    $('#successMsg').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.marcaid);
                    $('#ErrorMsg2').text(response.responseJSON.errors.clienteid);
                },
            });
            
        }
*/

        function updateMarca(check_id){
            
            var estadoUpdate = $('#'+check_id).prop('checked');
            var clienteid = check_id;
            // console.log("estado: "+estado);

            $.ajax({
                url: "{{ route('aspirante.updmarcas', $aspirante->id) }}",
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

        $('input[type=radio][name=catMod]').change(function() {

            var catMod = this.value;

            $.ajax({
                url: "{{ route('aspirante.actModCat', $aspirante->id) }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&catMod=" + catMod,

                success: function(response){
                    $('#successMsg5').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg5').text(response.responseJSON.errors.catMod);
                },
            })

        });   

      </script>



@endsection
