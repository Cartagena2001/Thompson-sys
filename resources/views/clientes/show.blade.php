@extends('layouts.app')

@section('content')
@section('title', 'Cliente: ' . $cliente->name)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {-- Titulo --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🥇 Información del Cliente 🥇</h1>
                    <p class="mt-4 mb-4 text-center">Administración de clientes aprobados por <b>rtelsalvador.</b> <br/>Aquí podrás cambiar la clasificación y las marcas permitidas para c/cliente.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/clientes') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3">

        <div class="card-body">

            <div class="mt-3 mb-4">
                <img class="rounded mt-2 mb-2" style="display: block; margin: 0 auto;" src="{{ $cliente->imagen_perfil_src }}" alt="per" width="200">
                <h4 class="text-center">Cliente #{{ $cliente->id}}: <br/> <span style="color: #ff161f">{{ $cliente->name }}</span> </h4>
                <h5 class="text-center">🔰 {{ $cliente->clasificacion }} 🔰</h5>
            </div>

            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">Registro: </span> <br><br>
                        <span class="font-weight-bold" style="color:#000;">DUI: </span> <br>
                        <span class="font-weight-bold" style="color:#000;">Correo Electrónico:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Dirección:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Municipio/Distrito:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Departamento:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Teléfono Fijo:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Celular/Núm. WhatsApp:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Sitio Web: </span>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        {{ $cliente->fecha_registro }} <br><br>
                        {{ $cliente->dui }} <br>
                        <a href="mailto:{{ $cliente->email }}" title="contactar" target="_blank">{{ $cliente->email }}</a><br>
                        {{ $cliente->direccion }} <br>
                        {{ $cliente->municipio }} <br>
                        {{ $cliente->departamento }} <br>
                        {{ $cliente->telefono }} <br>
                        {{ $cliente->whatsapp }} <br>
                        <a href="http://{{ $cliente->website }}" title="Ir a" target="_blank">{{ $cliente->website }}</a>
                    </p>
                </div>

            </div>
            
            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">N° de registro (NRC):</span> <br>
                        <span class="font-weight-bold" style="color:#000;">NIT:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Nombre/razón ó denominación social:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Giro ó actividad económica:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Nombre Comercial:</span>     
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        {{ $cliente->nrc }} <br>
                        {{ $cliente->nit }} <br>
                        {{ $cliente->razon_social }} <br>
                        {{ $cliente->giro }} <br>
                        {{ $cliente->nombre_empresa }}
                    </p>
                </div>

            </div>

            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">Suscrito a boletín:</span> <br>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        @if( $cliente->boletin == 1)
                            ✔️
                        @else
                            ❌
                        @endif
                        
                </div>

            </div>

            <hr/>

            <div class="row mb-4">

                <h4 class="text-center mb-4">Marcas permitidas:</h4>

                <div class="col-sm-12">
                    <div class="flex-center">
                        <form id="brandscheck">
                            <div>
                            @foreach ($marcas as $marca)
                                <label for="{{ $marca->nombre }}-{{ $marca->id }}_{{ $cliente->id }}">
                                    <input id="{{ $marca->nombre }}-{{ $marca->id }}_{{ $cliente->id }}" type="checkbox" value="{{ $marca->id }}" name="marks[]" onclick="asignarMarca (this.id)" @if ( str_contains( $cliente->marcas, $marca->id ) ) checked @endif /> {{ $marca->nombre }}
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

            <hr/>

            <div class="row mt-4 mb-4">

                <h4 class="text-center mb-4">Actualizar clasificación del cliente: </h4>

                <div class="flex-center">
                    <form class="d-inline-block" action="{{ route('clientes.cobre', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idcobr" class="btn p-2 mx-1 ccobrebg classtag {{ $cliente->clasificacion == 'Cobre' ? 'classtagsel' : ''; }}" type="submit">Cobre</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.plata', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idplat" class="btn p-2 mx-1 cplatabg classtag {{ $cliente->clasificacion == 'Plata' ? 'classtagsel' : ''; }}" type="submit">Plata</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.oro', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idoro" class="btn p-2 mx-1 corobg classtag {{ $cliente->clasificacion == 'Oro' ? 'classtagsel' : ''; }}" type="submit">Oro</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.platino', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idplati" class="btn p-2 mx-1 cplatinobg classtag {{ $cliente->clasificacion == 'Platino' ? 'classtagsel' : ''; }}" type="submit">Platino</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.diamante', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="iddiam" class="btn p-2 mx-1 cdiamantebg classtag {{ $cliente->clasificacion == 'Diamante' ? 'classtagsel' : ''; }}" type="submit">Diamante</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.taller', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="idtall" class="btn p-2 mx-1 ctallerbg classtag {{ $cliente->clasificacion == 'Taller' ? 'classtagsel' : ''; }}" type="submit">Taller</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.distribucion', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button id="iddistr" class="btn p-2 mx-1 cdistbg classtag {{ $cliente->clasificacion == 'Distribuidor' ? 'classtagsel' : ''; }}" type="submit">Distribuidor</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script type="text/javascript">

        function asignarMarca(check_id) {

            var marca = $('#'+check_id).val();
            var clienteid = check_id;

            console.log("marca id: "+marca+" cliente id: "+clienteid);
            

            $.ajax({
                url: "{{ route('clientes.marcaUpdate') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&marca=" + marca + "&cliente=" + clienteid,

                success: function(response){
                    $('#successMsg').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.marca);
                    $('#ErrorMsg2').text(response.responseJSON.errors.cliente);
                },
            });
            
        }
       
      </script>

@endsection
