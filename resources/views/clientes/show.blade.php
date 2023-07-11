@extends('layouts.app')

@section('content')
@section('title', 'Cliente: ' . $cliente->name)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🥇 Clasificación del Cliente 🥇</h1>
                    <p class="mt-4 mb-4 text-center">Administración de órdenes de compra de productos en venta en la Tienda <b>rtelsalvador.</b> <br/>Aquí podrás encontrar todas las ordenes de compra de tus clientes y podrás gestionarlas.</p>
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
                <h4 class="text-center">Cliente: <br/> <span style="color: #ff161f">{{ $cliente->name }}</span> </h4>
                <h5 class="text-center">🔰 {{ $cliente->clasificacion }} 🔰</h5>
            </div>

            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">Correo Electrónico:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Dirección:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Municipio:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Departamento:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Teléfono:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">WhatsApp:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Sitio Web: </span>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        <a href="mailto:{{ $cliente->email }}" title="contactar" target="_blank">{{ $cliente->email }}</a><br>
                        {{ $cliente->direccion }} <br>
                        {{ $cliente->municipio }} <br>
                        {{ $cliente->departamento }} <br>
                        {{ $cliente->telefono }} <br>
                        {{ $cliente->whatsapp }} <br>
                        <a href="http://{{ $cliente->website }}" title="Ir a" target="_blank">{{ $cliente->website }} <br></a>
                    </p>
                </div>

            </div>
            
            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">Empresa:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">NIT:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">NRC:</span> <br>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        {{ $cliente->nombre_empresa }} <br>
                        {{ $cliente->nit }} <br>
                        {{ $cliente->nrc }} <br>
                    </p>
                </div>

            </div>

            <hr/>

            <div class="row mb-4">

                <h4 class="text-center mb-4">Marcas permitidas:</h4>

                <div class="col-sm-12">
                    <div class="text-center">
                @foreach ($marcas as $marca)
                    <label for="marca-{{ $marca->nombre }}"><input id="marca-{{ $marca->nombre }}" type="checkbox" value="{{ $marca->id }}" /> {{ $marca->nombre }}</label>
                    <br/>
                @endforeach
                    </div>
                </div>

            </div> 

            <hr/>

            <div class="row mt-4 mb-4">

                <h4 class="text-center mb-4">Actualizar clasificación del cliente</h4>

                <div class="flex-center">
                    <form class="d-inline-block" action="{{ route('clientes.cobre', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 ccobrebg" type="submit">Cobre</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.plata', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 cplatabg" type="submit">Plata</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.oro', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 corobg" type="submit">Oro</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.platino', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 cplatinobg" type="submit">Platino</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.diamante', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 cdiamantebg" type="submit">Diamante</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.taller', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 ctallerbg" type="submit">Taller</button>
                    </form>

                    <form class="d-inline-block" action="{{ route('clientes.distribucion', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button style="color:black" class="btn p-2 mx-1 cdistbg" type="submit">Distribuidor</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

@endsection
