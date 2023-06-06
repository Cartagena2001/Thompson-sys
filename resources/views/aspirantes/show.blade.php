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
            <div class="col-lg-8">
                <h3>🎯 Aspirantes a clientes 🎯</h3>
                <p class="mt-2">En esta sección se muestran los aspirantes a clientes que se han registrado en la
                    plataforma.</p>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/aspirantes') }}">
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
            <h2>Cliente: {{ $aspirante->name }} </h2>
        </div>
        <div>
            <a href="mailto:{{ $aspirante->email }}">Correo: {{ $aspirante->email }} <br></a>
            Direccion: {{ $aspirante->direccion }} <br>
            Municipio: {{ $aspirante->municipio }} <br>
            Departamento: {{ $aspirante->departamento }} <br>
            Telefono: {{ $aspirante->telefono }} <br>
            WhatsApp: {{ $aspirante->whatsapp }} <br>
            <a href="http://{{ $aspirante->website }}" target="__blank">Pagina web: {{ $aspirante->website }} <br></a>
        </div>
        <div class="mt-1">
            <h2>Empresa: {{ $aspirante->nombre_empresa }}</h2>
            <h2>NIT: {{ $aspirante->nit }}</h2>
            <h2>NIT: {{ $aspirante->nrc }}</h2>
        </div>
        <div class="mt-4">
            <h4>Actualizar estado del cliente</h1>
            @if ($aspirante->estatus == 'aspirante')
                <form action="{{ route('aspirantes.aprobado', $aspirante->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success p-2 p-0" type="submit">Aprobar cliente</button>
                </form>
            @endif
            @if ($aspirante->estatus == 'aspirante')
                <form action="{{ route('aspirantes.rechazado', $aspirante->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-primary p-2 p-0 mt-1" type="submit">Rechazar cliente</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
