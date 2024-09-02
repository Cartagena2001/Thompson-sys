@extends('layouts.app')

@section('content')
@section('title', 'Bitácora del Sistema')

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
                    <h1 class="text-center">🕵 Bitácora del Sistema 🕵</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás encontrar el listado de eventos en los cuales ha participado un usuario administrador del sistema o usuario de bodega.</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">

            <div class="row mt-1">
                <div class="col-6 col-lg-12">
                    <label for="filtro_usr">Filtrar por usuario:
                    <select class="form-select" id="filtro_usr">
                        <option value="">Todos los usuarios</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    </label>
                    <button style="height: 38px; position: relative; bottom: 2px;" class="btn btn-primary" id="limpiar_filtro">Limpiar Filtro</button>
                </div>
            </div>

        </div>

        <hr/>

        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table id="table_eventos" class="table display">
                    <thead>
                        <tr>
                            <th scope="col">Usuario</th>
                            <th scope="col">Evento</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha/Hora</th>
                            {{-- <th class="text-end" scope="col">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($bitacora as $registro)
                            <tr>
                                <td>{{ $registro->user->name }}</td>
                                <td>{{ $registro->accion }}</td>
                                <td>{{ $registro->descripcion }}</td>
                                <td>{{ \Carbon\Carbon::parse($registro->hora_fecha)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}</td>

                                {{-- 
                                <td class="text-end">
                                    <form action="{{ route('bitacora.show', $registro->id) }}" method="POST">
                                        @csrf
                                        <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Ir a"><span class="text-500 fas fa-eye"></span> Ver</button>
                                    </form>
                                </td>
                                --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            var table = $('#table_eventos').DataTable({
                language: {
                    url: "/assets/js/Spanish.json"
                }
            });

            var filtroColumna = table.column(0);

            $('#filtro_usr').on('change', function() {
                var filtro = $(this).val();
                console.log(filtro);

                if (filtro === '') {
                    filtroColumna.search('').draw();
                } else {
                    filtroColumna.search('^' + filtro + '$', true, false).draw();
                }
            });

            $('#limpiar_filtro').on('click', function() {
                $('#filtro_usr').val('').trigger('change');
            });
        });
    </script>

@endsection
