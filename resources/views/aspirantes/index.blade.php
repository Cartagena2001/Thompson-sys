@extends('layouts.app')

@section('content')
@section('title', 'Aspirantes a Clientes')

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
                    <h1 class="text-center">🎯 Aspirantes a Clientes 🎯</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección se muestran los aspirantes a clientes que se han registrado en la plataforma.</p>
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
                    <h6># Aspirantes</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los usuarios aspirantes --}}
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
                <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6># Clientes</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los usuarios aprobados como clientes --}}
                        <?php
                        $ordenesProceso = DB::table('users')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($ordenesProceso);
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
                    <h6># Rechazados</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-danger" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los usuarios rechazados --}}
                        <?php
                        $ordenesProceso = DB::table('users')
                            ->where('estatus', 'rechazado')
                            ->get();
                        echo count($ordenesProceso);
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
                    <label for="filtro_estado">Filtrar por Estado:
                    <select class="form-select" id="filtro_estado">
                        <option value="">Todos los aspirantes</option>
                        <option value="aspirante">Aspirante</option>
                        <option value="rechazado">Rechazado</option>
                        {{-- <option value="aprobado">Aprobado</option> --}}
                    </select>
                    </label>
                    <button style="height: 38px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar Filtro</button>
                </div>
            </div>

        </div>

        <hr/>

        <div class="card-body pt-3">
            <div class="table-responsive scrollbar">
                
                <table id="table_aspirantes" class="table display pb-4 pt-4" >
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre del cliente</th>
                            <th scope="col">Correo Electrónico</th>
                            <th scope="col">Empresa</th>
                            <th scope="col" class="text-center">Municipio</th>
                            <th scope="col" class="text-center">Departamento</th>
                            <th scope="col" class="text-center">NIT</th>
                            <th scope="col" class="text-center">Estado</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aspirantes as $aspirante)
                            <tr>
                                <td>{{ $aspirante->id }}</td>
                                <td>{{ $aspirante->name }}</td>
                                <td>{{ $aspirante->email }}</td>
                                <td>{{ $aspirante->nombre_empresa }}</td>
                                <td class="text-center">{{ $aspirante->municipio }}</td>
                                <td class="text-center">{{ $aspirante->departamento }}</td>
                                <td class="text-center">{{ $aspirante->nit }}</td>
                                <td @if( $aspirante->estatus == 'aprobado' ) 
                                        class="text-center text-success"
                                    @elseif( $aspirante->estatus == 'aspirante' )
                                        class="text-center text-warning"
                                    @elseif( $aspirante->estatus == 'rechazado' )
                                        class="text-center text-danger" 
                                    @else
                                        class="text-center" 
                                    @endif
                                   
                                    style="font-weight:bold;" >{{ $aspirante->estatus }}
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('aspirantes.show', $aspirante->id) }}">
                                        <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-search"></span> Ver Detalle </button>
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
            var table = $('#table_aspirantes').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });

            var filtroColumna = table.column(7);

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



