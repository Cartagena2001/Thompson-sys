@extends('layouts.app')

@section('content')
@section('title', 'Productos')
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
                    <h3>🏷️ Ordenes 🏷️</h3>
                    <p class="mt-2">Administracion de ordenes <b>para Thompson.</b> Aqui podras encontrar todas las
                        ordenes, podras ver el estado de cada orden, y podras editarlas.
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
                    <h6>Ordenes Pendientes</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los productos activos de la base de datos --}}
                        <?php
                        $ordenPendientes = DB::table('orden')
                            ->where('estado', 'Pendiente')
                            ->get();
                        echo count($ordenPendientes);
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
                    <h6>Ordenes En proceso</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                        data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los productos activos de la base de datos --}}
                    <?php
                    $ordenesProceso = DB::table('orden')
                        ->where('estado', 'Proceso')
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
                    <h5 class="mb-0" data-anchor="data-anchor">Tabla de Ordenes</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive scrollbar">
                <table id="table_productos" class="table display">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de registro</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha envio</th>
                            <th scope="col">Fecha Entrega</th>
                            <th scope="col">Total</th>
                            <th class="text-end" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td>{{ $orden->fecha_registro }}</td>
                                <td>{{ $orden->user->name }}</td>
                                <td>{{ $orden->estado }}</td>
                                <td>{{ $orden->fecha_envio }}</td>
                                <td>{{ $orden->fecha_entrega }}</td>
                                <td>${{ $orden->total }}</td>
                                <td class="text-end">
                                    {{-- <form action="{{ route('productos.destroy', $orden->id) }}"
                                        method="POST">
                                        <a href="{{ route('productos.edit', $orden->id) }}">
                                            <button class="btn p-0" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><span
                                                class="text-500 fas fa-edit"></span></button></a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn p-0 ms-2" type="submit" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><span
                                                class="text-500 fas fa-trash-alt"></span></button>
                                    </form> --}}
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
                ]
            });
        });
    </script>
@endsection
