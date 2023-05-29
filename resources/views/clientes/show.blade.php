@extends('layouts.app')

@section('content')
@section('title', 'Cliente: ' . $cliente->name)
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js">
</script>
{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-8">
                <h3>🥇 Clasificacion de cliente 🥇</h3>
                <p class="mt-2">
                    En esta seccion podras ver la clasificacion de los clientes que se encuentran en el sistema.
                </p>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/clientes') }}">
                    <span class="fas fa-long-arrow-alt-left me-sm-2">
                    </span>
                    <span class="d-none d-sm-inline-block">
                        Volver atras
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="card mb-3">

    <div class="card-body">
        <div class="mt-3">
            <h2>Cliente: {{ $cliente->name }} </h2>
            <h2>Clasificación: {{ $cliente->clasificacion }} </h2>
        </div>
        <div>
            <a href="mailto:{{ $cliente->email }}">Correo: {{ $cliente->email }} <br></a>
            Direccion: {{ $cliente->direccion }} <br>
            Municipio: {{ $cliente->municipio }} <br>
            Departamento: {{ $cliente->departamento }} <br>
            Telefono: {{ $cliente->telefono }} <br>
            WhatsApp: {{ $cliente->whatsapp }} <br>
            <a href="http://{{ $cliente->website }}" target="__blank">Pagina web: {{ $cliente->website }} <br></a>
        </div>
        <div class="mt-1">
            <h2>Empresa: {{ $cliente->nombre_empresa }}</h2>
            <h2>NIT: {{ $cliente->nit }}</h2>
            <h2>NIT: {{ $cliente->nrc }}</h2>
        </div>
        <div class="mt-4">
            <h4>Actualizar clasificacion del cliente</h4>
            <form class="d-inline-block" action="{{ route('clientes.cobre', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #b67740; color:black" class="btn p-2 p-0" type="submit">Cobre</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.plata', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #C3C3C3; color:black" class="btn p-2 p-0" type="submit">Plata</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.oro', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #FFD700; color:black" class="btn p-2 p-0" type="submit">Oro</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.platino', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #E5E4E2; color:black" class="btn p-2 p-0" type="submit">Platino</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.diamante', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #B9F2FF; color:black" class="btn p-2 p-0" type="submit">Diamante</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.taller', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #65bb74; color:black" class="btn p-2 p-0" type="submit">Taller</button>
            </form>
            <form class="d-inline-block" action="{{ route('clientes.distribucion', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button style="background-color: #b096e0; color:black" class="btn p-2 p-0" type="submit">Reparto</button>
            </form>
        </div>
    </div>
</div>
@endsection
