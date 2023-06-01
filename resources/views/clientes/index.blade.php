@extends('layouts.app')

@section('content')
@section('title', 'Clasificacion de clientes')
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
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="row g-3 mb-3">
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Cobre</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $clientesCobre = DB::table('users')
                        ->where('clasificacion', 'Cobre')
                        ->get();
                    echo count($clientesCobre);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Plata</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $clientesPlata = DB::table('users')
                        ->where('clasificacion', 'Plata')
                        ->get();
                    echo count($clientesPlata);
                    ?> </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Platino</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesPlatino = DB::table('users')
                        ->where('clasificacion', 'Platino')
                        ->get();
                    echo count($ordenesPlatino);
                    ?> </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Diamante</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesDiamante = DB::table('users')
                        ->where('clasificacion', 'Diamante')
                        ->get();
                    echo count($ordenesDiamante);
                    ?> </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Taller</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesTaller = DB::table('users')
                        ->where('clasificacion', 'Taller')
                        ->get();
                    echo count($ordenesTaller);
                    ?> </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Clientes Tipo Distribuidor</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesDistribuidor = DB::table('users')
                        ->where('estatus', 'Distribuidor')
                        ->get();
                    echo count($ordenesDistribuidor);
                    ?> </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Tabla de clientes</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive scrollbar">
            <table id="table_productos" class="table display">
                <thead>
                    <tr>
                        <th scope="col">Nombre del cliente</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">NRC</th>
                        <th scope="col">Rango</th>
                        <th class="text-end" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->name }}</td>
                            <td>{{ $cliente->nombre_empresa }}</td>
                            <td>{{ $cliente->nrc }}</td>
                            <td class="text-success">{{ $cliente->clasificacion }}</td>
                            <td class="text-end">
                                <a href="{{ route('clientes.show', $cliente->id) }}">
                                    <button class="btn p-0" type="button" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit">
                                        <span class="text-500 fas fa-eye"></span>
                                        Modificar Clasificacion
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table_productos').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            }
        });
    });
</script>
@endsection
