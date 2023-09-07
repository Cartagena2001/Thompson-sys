@extends('layouts.app')

@section('content')

@section('title', 'Mis órdenes')

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
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">📑 Mis Órdenes 📑</h1>
                <p class="mt-4 mb-4 text-center">Aquí podrás ver el listado de las órdenes de compra que has realizado.
                </p>
            </div>
        </div>
    </div>
</div>




<div class="row g-3 mb-3">
    @if (count($ordenes) > 0)
        @foreach ($ordenes as $orden)

            <div class="card pt-3 col-4" style="border: ridge 1px #ff1620;">
                <div class="card-header">
                    <div class="col flex-between-end">
                        <div class="col-auto align-self-center mb-2">
                            <h5 class="mb-0" data-anchor="data-anchor">Orden # {{ $orden->id }}</h5>
                        </div>
                        <hr/>
                        <div class="col-auto align-self-center">
                            <strong>Fecha de órden:</strong> {{ \Carbon\Carbon::parse($orden->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')  }} <br>
                            <strong>Estado de órden:</strong><span class="">{{ $orden->estado }} </span><br>
                            <strong>Total:</strong> ${{ $orden->total }} <br>
                        </div>
                    </div>
                    <hr/>
                    <div class="col-lg-4 mt-2" style="margin: 0 auto;">
                        <div style="display: block;">
                        <a href="{{ route('perfil.orden.detalle', $orden->id) }}" class="btn btn-primary text-center">Ver detalle</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card mb-3">
            <div class="card-body position-relative mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>No tienes órdenes de compra.</h3>
                        <p class="mt-2">
                            Aún no tienes órdenes registradas.
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
