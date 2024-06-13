@extends('layouts.app')

@section('content')
@section('title', 'Clientes')

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

        <div class="col-sm-6 col-md-6">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | L. Taller <span class="text-500 fas fa-certificate ctaller"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes con lista taller --}}
                        <?php
                        $clientesListaTaller = DB::table('users')
                            ->where('clasificacion', 'taller')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesListaTaller);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | L. Distribuidor <span class="text-500 fas fa-certificate cdist"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes con lista distribuidor --}}
                        <?php
                        $clientesListaDist = DB::table('users')
                            ->where('clasificacion', 'distribuidor')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesListaDist);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | L. Precio Costo <span class="text-500 fas fa-certificate cpreciocosto"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes con lista Precio Costo --}}
                        <?php
                        $clientesListaPC = DB::table('users')
                            ->where('clasificacion', 'precioCosto')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesListaPC);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes | L. Precio Op. <span class="text-500 fas fa-certificate cprecioop"></span></h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes con lista Precio Opcional --}}
                        <?php
                        $clientesListaPOP = DB::table('users')
                            ->where('clasificacion', 'precioOP')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientesListaPOP);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">
            
            <div class="row mt-1">
                <div class="col-6 col-lg-12">
                    <label for="filtro_lprecios">Filtrar por Lista de Precios:
                    <select class="form-select" id="filtro_lprecios">
                        <option value="">Todos los clientes</option>
                        <option value="taller">Taller</option>
                        <option value="distribuidor">Distribuidor</option>
                        <option value="precioCosto">Precio Costo</option>
                        <option value="precioOP">Precio Opcional</option>
                    </select>
                    </label>
                    <button style="height: 38px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar Filtro</button>
                </div>
            </div>

        </div>

        <hr/>

        <div class="card-body pt-3">
            <div class="table-responsive scrollbar">

                <table id="table_clientes" class="table display pb-4 pt-4">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">ID</th>
                            <th class="text-center" scope="col">NRC</th>
                            <th scope="col">Nombre del cliente</th>
                            <th scope="col">Empresa</th>
                            <th class="text-center" scope="col">Lista de Precios</th>
                            <th class="text-center" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td class="text-center">{{ $cliente->id }}</td>
                                <td class="text-center">{{ $cliente->nrc }}</td>
                                <td>{{ $cliente->name }}</td>
                                <td>{{ $cliente->nombre_empresa }}</td>
                                <td class="text-center">
                                <?php
                                    
                                    $classPList = '';

                                    if ($cliente->clasificacion == 'taller') {
                                        $classPList = 'ctaller';
                                    } elseif ($cliente->clasificacion == 'distribuidor') {
                                        $classPList = 'cdist';
                                    } elseif ($cliente->clasificacion == 'precioCosto') {
                                        $classPList = 'cpreciocosto';
                                    } elseif ($cliente->clasificacion == 'precioOp') {
                                        $classPList = 'cprecioop';
                                    } else {
                                        $classPList = ''; 
                                    }

                                ?>  
                                    <span class="<?php echo $classPList; ?>">
                                        {{ $cliente->clasificacion }}
                                    </span>
                                </td>

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
            var table = $('#table_clientes').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });

            var filtroColumna = table.column(4);

            $('#filtro_lprecios').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna.search('').draw();
                } else {
                    filtroColumna.search('^' + filtro + '$', true, false).draw();
                }
            });

            $('#limpiar_filtro').on('click', function() {
                $('#filtro_lprecios').val('').trigger('change');
            });
        });

    </script>

@endsection
