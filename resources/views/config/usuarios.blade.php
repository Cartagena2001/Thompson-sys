@extends('layouts.app')

@section('content')
@section('title', 'Usuarios')

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
                    <h1 class="text-center">👥 Usuarios de RT 👥</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás ver y gestionar todos los usuarios del Sistema RT.</p>
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
                    <h6># Clientes 🤝</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los clientes --}}
                        <?php
                        $clientes = DB::table('users')
                            ->where('estatus', 'aprobado')
                            ->get();
                        echo count($clientes);
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
                    <h6># Aspirantes ⏳</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los aspirantes --}}
                        <?php
                        $aspirantes = DB::table('users')
                            ->where('estatus', 'aspirante')
                            ->get();
                        echo count($aspirantes);
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
                    <h6># Administrador (Oficina) 🏢</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los admin (no bodega) --}}
                        <?php
                        $admins = DB::table('users')
                            ->where('rol_id', 1)
                            ->where('estatus', 'otro')
                            ->get();
                        echo count($admins);
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
                    <h6># Usuarios (Bodega) 🚛</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>
                        {{-- contar los admin bodega --}}
                        <?php
                        $bodega = DB::table('users')
                            ->where('rol_id', 3)
                            ->where('estatus', 'otro')
                            ->get();
                        echo count($bodega);
                        ?> 
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Agregar nuevo usuario --}}
    <div class="row mb-3 justify-content-md-center">
        <div class="col">
            <a href="{{ route('users.create') }}">
                <button class="btn btn-primary me-1 mb-1" type="button"><i class="fas fa-plus"></i> Registrar nuevo usuario</button>
            </a>
        </div>
    </div>

    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">
            
            <div class="row mt-1">

                <div class="col-12 col-lg-4">
                    <label for="filtro_rol">Filtrar por Rol:
                    <select class="form-select" id="filtro_rol" style="font-size: 12px;">
                        <option value="">Todos</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Bodega">Bodega</option>
                        <option value="Cliente">Cliente</option>
                        <option value="Aspirante">Aspirante</option>
                    </select>
                    </label>
                    <button style="height: 32px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar</button>
                </div>

                <div class="col-12 col-lg-4">
                    <label for="filtro_emp">Filtrar por Empresa:
                    <select class="form-select" id="filtro_emp" style="font-size: 12px;">
                        <option value="">Todos</option>
                        @foreach ($usuarios as $empresas)
                        <option value="{{ $empresas->nombre_empresa }}">{{ $empresas->nombre_empresa }}</option>
                        @endforeach
                    </select>
                    </label>
                    <button style="height: 32px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar</button>
                </div>

                <div class="col-12 col-lg-4">
                    <label for="filtro_est">Filtrar por Estado:
                    <select class="form-select" id="filtro_est" style="font-size: 12px;">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                    </label>
                    <button style="height: 32px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar</button>
                </div>

            </div>

        </div>

        <hr/>

        {{-- Tabla de usuarios --}}
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table id="table_usuarios" class="table display">
                    <thead>
                        <tr class="tbl-p">
                            <th scope="col">ID</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha de Registro</th>
                            <th scope="col">Notas</th>
                            <th class="text-center" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="tbl-p">
                                <td>{{ $usuario->id }}</td>
                                <td>{{ ($usuario->estatus == 'aspirante') ? 'Aspirante' : $usuario->rol->nombre }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->nombre_empresa }}</td>
                                <td>{{ $usuario->estado }}</td>
                                <td>{{ \Carbon\Carbon::parse($usuario->fecha_registro)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</td>
                                <td class="text-success">{{ $usuario->notas }}</td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $usuario->id) }}">
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
            var table = $('#table_usuarios').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });

            var filtroColumna1 = table.column(1);

            $('#filtro_rol').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna1.search('').draw();
                } else {
                    filtroColumna1.search('^' + filtro + '$', true, false).draw();
                }
            });

            var filtroColumna2 = table.column(4);

            $('#filtro_emp').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna2.search('').draw();
                } else {
                    filtroColumna2.search('^' + filtro + '$', true, false).draw();
                }
            });

            var filtroColumna3 = table.column(5);

            $('#filtro_est').on('change', function() {
                var filtro = $(this).val();

                if (filtro === '') {
                    filtroColumna3.search('').draw();
                } else {
                    filtroColumna3.search('^' + filtro + '$', true, false).draw();
                }
            });

            $('#limpiar_filtro').on('click', function() {
                $('#filtro_rol').val('').trigger('change');
                $('#filtro_emp').val('').trigger('change');
                $('#filtro_est').val('').trigger('change');
            });
        });
    </script>

@endsection
