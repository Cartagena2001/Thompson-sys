@extends('layouts.app')

@section('content')
@section('title', 'Clasificación de los Clientes')

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🥇 Nuestros Clientes 🥇</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás ver el listado de clientes aprobados registrados en el sistema.</p>
                </div>
            </div>
        </div>
    </div>


    {{-- Cards de informacion --}}
    <div class="row g-3 mb-3">

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Cobre <span class="text-500 fas fa-certificate ccobre"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes cobre --}}
                        <?php
                        $clientesCobre = DB::table('users')
                            ->where('clasificacion', 'Cobre')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesCobre);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Plata <span class="text-500 fas fa-certificate cplata"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes plata --}}
                        <?php
                        $clientesPlata = DB::table('users')
                            ->where('clasificacion', 'Plata')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesPlata);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Platino <span class="text-500 fas fa-certificate cplatino"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes platino --}}
                        <?php
                        $ordenesPlatino = DB::table('users')
                            ->where('clasificacion', 'Platino')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($ordenesPlatino);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Diamante <span class="text-500 fas fa-certificate cdiamante"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes diamante --}}
                        <?php
                        $ordenesDiamante = DB::table('users')
                            ->where('clasificacion', 'Diamante')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($ordenesDiamante);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Taller <span class="text-500 fas fa-certificate ctaller"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes taller --}}
                        <?php
                        $ordenesTaller = DB::table('users')
                            ->where('clasificacion', 'Taller')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($ordenesTaller);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | Distribuidor <span class="text-500 fas fa-certificate cdist"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes distribuidores --}}
                        <?php
                        $ordenesDistribuidor = DB::table('users')
                            ->where('estatus', 'Distribuidor')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($ordenesDistribuidor);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">
            
            <div class="row flex-between-end">
                {{--
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Tabla de clientes</h5>
                </div>
                --}}
            </div>

            <div class="row mt-1">
                <div class="col-6 col-lg-12">
                    <label for="filtro_rango">Filtrar por clasificación de cliente:
                    <select class="form-select" id="filtro_rango">
                        <option value="">Todos los clientes</option>
                        <option value="cobre">Cobre</option>
                        <option value="plata">Plata</option>
                        <option value="oro">Oro</option>
                        <option value="platino">Platino</option>
                        <option value="diamante">Diamante</option>
                        <option value="taller">Taller</option>
                        <option value="reparto">Distribucion</option>
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
                            <th scope="col">Nombre del cliente</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">NRC</th>
                            <th scope="col">Rango</th>
                            <th class="text-center" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->name }}</td>
                                <td>{{ $cliente->nombre_empresa }}</td>
                                <td>{{ $cliente->nrc }}</td>
                                <td class="text-success">{{ $cliente->clasificacion }}</td>
                                <td class="text-center">
                                    <a href="{{ route('clientes.show', $cliente->id) }}">
                                        <button class="btn p-0" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Ir a">
                                            <span class="text-500 fas fa-pencil"></span>
                                            Editar
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
            var table = $('#table_productos').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });

            var filtroColumna = table.column(3);

            $('#filtro_rango').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna.search('').draw();
                } else {
                    filtroColumna.search('^' + filtro + '$', true, false).draw();
                }
            });

            $('#limpiar_filtro').on('click', function() {
                $('#filtro_rango').val('').trigger('change');
            });
        });
    </script>

@endsection
