@extends('layouts.app')

@section('content')
@section('title', 'Cliente: ' . $aspirante->name)
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
            <div class="col-lg-12">
                <h1 class="text-center">🎯 Aspirantes a Clientes 🎯</h1>
                <p class="mt-4 mb-4 text-center">En esta sección se muestran los aspirantes a clientes que se han registrado en la
                    plataforma.</p>
            </div>
            <div class="text-center mb-4">
                <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/aspirantes') }}">
                    <span class="fas fa-long-arrow-alt-left me-sm-2">
                    </span>
                    <span class="d-none d-sm-inline-block">
                        Volver Atrás
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="card mb-3">

    <div class="card-body">

        <div class="mt-3 mb-4">
            <h4 class="text-center">Nombre del contacto: <br/> <span style="color: #ff161f">{{ $aspirante->name }}</span> </h4>
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
                    <a href="mailto:{{ $aspirante->email }}" title="contactar" target="_blank">{{ $aspirante->email }}</a><br>
                    {{ $aspirante->direccion }} <br>
                    {{ $aspirante->municipio }} <br>
                    {{ $aspirante->departamento }} <br>
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
                    <span class="font-weight-bold" style="color:#000;">Empresa:</span> <br>
                    <span class="font-weight-bold" style="color:#000;">NIT:</span> <br>
                    <span class="font-weight-bold" style="color:#000;">NRC:</span> <br>
                </p>
            </div>
            <div class="col-sm-6">
                <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                    {{ $aspirante->nombre_empresa }} <br>
                    {{ $aspirante->nit }} <br>
                    {{ $aspirante->nrc }} <br>
                </p>
            </div>
        </div>

        <hr/>

        <div class="row mb-4">

            <h4 class="text-center mb-4">Actualizar Estado:</h4>

            <div class="col-sm-6">
                <div class="text-end">
            @if ($aspirante->estatus == 'aspirante')
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

</div>
@endsection
