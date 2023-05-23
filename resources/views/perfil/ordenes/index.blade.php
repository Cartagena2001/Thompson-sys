@extends('layouts.app')

@section('content')
@section('title', 'Mis ordenes')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js">
</script>
{{-- Titulo --}}
<div class="card mb-3 row">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-8">
                <h3>Informacion de tus ordenes</h3>
                <p class="mt-2">
                    Aqui podras ver el detalle de tus ordenes
            </div>
        </div>
    </div>
</div>
<div class="row gap-2">
    @if (count($ordenes) > 0)
        @foreach ($ordenes as $orden)
            <div class="card mb-3 col-4">
                <div class="card-header">
                    <div class="col flex-between-end">
                        <div class="col-auto align-self-center">
                            <h5 class="mb-0" data-anchor="data-anchor">Orden # {{ $orden->id }}</h5>
                        </div>
                        <div class="col-auto align-self-center">
                            <strong>Fecha de orden:</strong> {{ $orden->created_at }} <br>
                            <strong>Estado de orden:</strong> {{ $orden->estado }} <br>
                            <strong>Envio:</strong> ${{ $orden->fecha_envio }} <br>
                            <strong>Total:</strong> ${{ $orden->total }} <br>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('perfil.orden.detalle', $orden->id) }}" class="btn btn-primary">Ver
                            detalle</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card mb-3">
            <div class="card-body position-relative mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>No tienes ordenes</h3>
                        <p class="mt-2">
                            Aun no tienes ordenes registradas
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
