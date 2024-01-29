@extends('layouts.app')

@section('content')
@section('title', 'Listado de ordenes')

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
                    <h1 class="text-center">📥 Órdenes de Compra 📥</h1>
                    <p class="mt-4 mb-4 text-center">Administración de órdenes de compra de Tienda <b>RT El Salvador.</b> <br/>Aquí podrás encontrar todas las órdenes de compra de tus clientes y podrás gestionarlas.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="row g-3 mb-3">

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes Pendientes</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes pendientes --}}
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

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes en Proceso</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes en proceso --}}
                        <?php
                        $ordenesProceso = DB::table('orden')
                            ->where('estado', 'Proceso')
                            ->get();
                        echo count($ordenesProceso);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes Preparadas</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes preparadas --}}
                        <?php
                        $ordenesPreparadas = DB::table('orden')
                            ->where('estado', 'Preparada')
                            ->get();
                        echo count($ordenesPreparadas);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes en Espera</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes en espera --}}
                        <?php
                        $ordenesEspera = DB::table('orden')
                            ->where('estado', 'Espera')
                            ->get();
                        echo count($ordenesEspera);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes Pagadas</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes pagadas --}}
                        <?php
                        $ordenesPagadas = DB::table('orden')
                            ->where('estado', 'Pagada')
                            ->get();
                        echo count($ordenesPagadas);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes Finalizadas</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes finalizadas --}}
                        <?php
                        $ordenesFinalizadas = DB::table('orden')
                            ->where('estado', 'Finalizada')
                            ->get();
                        echo count($ordenesFinalizadas);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Órdenes Canceladas</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar las órdenes canceladas --}}
                        <?php
                        $ordenesCanceladas = DB::table('orden')
                            ->where('estado', 'Cancelada')
                            ->get();
                        echo count($ordenesCanceladas);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabla de Ordenes --}}

    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">

            <div class="row flex-between-end">
                {{--
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Tabla de Órdenes</h5>
                </div>
                --}}
            </div>

            <div class="row mt-1">
                <div class="col-6 col-lg-12">
                    <label for="filtro_estado">Filtrar por estado de orden:
                    <select class="form-select" id="filtro_estado">
                        <option value="">Todos los estados</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Finalizada">Finalizada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                    </label>
                    <button style="height: 38px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar Filtro</button>
                </div>
            </div>

        </div>

        <hr/>

        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table id="table_productos" class="table display">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha/Hora de Registro</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha Envío</th>
                            <th scope="col">Fecha Despacho</th>
                            <th scope="col">Total</th>
                            <th class="text-end" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenes as $orden)

                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($orden->fecha_registro)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}</td>
                            <td>{{ $orden->user->nombre_empresa }}</td>

                            @if ($orden->estado == 'Pendiente')
                                <td class="text-warning">{{ $orden->estado }}</td>
                            @elseif($orden->estado == 'Proceso')
                                <td class="text-success">{{ $orden->estado }}</td>
                            @elseif($orden->estado == 'Finalizada')
                                <td class="text-success">{{ $orden->estado }}</td>
                            @else
                                <td class="text-danger">{{ $orden->estado }}</td>
                            @endif

                            <td>{{ \Carbon\Carbon::parse($orden->fecha_envio)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}</td>
                            <td>{{ \Carbon\Carbon::parse($orden->fecha_entrega)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}</td>
                            <td>${{ $orden->total }}</td>
                            <td class="text-end">
                                <a href="{{ route('oficina.show', $orden->id) }}">
                                    <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Ir a"><span class="text-500 fas fa-eye"></span> Ver Órden</button>
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
            var table = $('#table_productos').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });

            var filtroColumna = table.column(2);

            $('#filtro_estado').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna.search('').draw();
                } else {
                    filtroColumna.search('^' + filtro + '$', true, false).draw();
                }
            });

            $('#limpiar_filtro').on('click', function() {
                $('#filtro_estado').val('').trigger('change');
            });
        });

    </script>

@endsection
