@extends('layouts.app')

@section('content')
@section('title', 'Aspirantes de cliente')
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
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="row g-3 mb-3">
    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"
                style="background-image:url(../../assets/img/icons/spot-illustrations/corner-1.png);">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6># Aspirantes</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                    data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $clientesAspirantes = DB::table('users')
                        ->where('estatus', 'aspirante')
                        ->get();
                    echo count($clientesAspirantes);
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
                <h6># Clientes</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesProceso = DB::table('users')
                        ->where('estatus', 'aprobado')
                        ->get();
                    echo count($ordenesProceso);
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
                <h6># Rechazados</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                    data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesProceso = DB::table('users')
                        ->where('estatus', 'rechazado')
                        ->get();
                    echo count($ordenesProceso);
                    ?> </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Tabla de aspirantes</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive scrollbar">
            <table id="table_aspirantes" class="table display">
                <thead>
                    <tr>
                        <th scope="col">Nombre del cliente</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Municipio</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">NIT</th>
                        <th scope="col">Estado</th>
                        <th class="text-end" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspirantes as $aspirante)
                        <tr>
                            <td>{{ $aspirante->name }}</td>
                            <td>{{ $aspirante->email }}</td>
                            <td>{{ $aspirante->nombre_empresa }}</td>
                            <td>{{ $aspirante->municipio }}</td>
                            <td>{{ $aspirante->departamento }}</td>
                            <td>{{ $aspirante->nit }}</td>
                            <td class="text-success">{{ $aspirante->estatus }}</td>
                            <td class="text-end">
                                <a href="{{ route('aspirantes.show', $aspirante->id) }}">
                                    <button class="btn p-0" type="button" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit">
                                        <span class="text-500 fas fa-eye"></span>
                                        Ver Cliente
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
        $('#table_aspirantes').DataTable({
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



