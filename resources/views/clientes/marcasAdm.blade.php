@extends('layouts.app')

@section('content')
@section('title', 'Marcas permitidas por Clientes')

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
                    <h1 class="text-center">🚩 Gestión de marcas autorizadas 🚩</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás ver el listado de clientes y las marcas asociadas autorizadas.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <div class="card-header">
        
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
                            <th scope="col">Cliente</th>s
                            <th scope="col">Empresa/Negocio</th>
                            <th scope="col">Lista/Precio</th>
                            <th class="text-center" scope="col">Marcas Autorizadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->name }}</td>
                                <td>{{ $cliente->nombre_empresa }}</td>
                                <td class="text-success">{{ $cliente->clasificacion }}</td>
                                <td class="flex-center">
                                    <div class="text-start">
                                @foreach ($marcas as $marca)
                                    <label for="marca-{{ $marca->nombre }}">
                                        <input id="marca-{{ $marca->nombre }}" type="checkbox" value="{{ $marca->id }}" /> {{ $marca->nombre }}
                                    </label>
                                    <br/>
                                @endforeach
                                    </div>
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
