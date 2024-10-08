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
                            <th scope="col">Cliente</th>
                            <th scope="col">Empresa/Negocio</th>
                            <th class="text-center" scope="col">Lista/Precio</th>
                            <th class="text-center" scope="col">Marcas Autorizadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                            Marca/s autorizada/s o denegadas con éxito! 
                        </div>

                        @foreach ($clientes as $cliente)
                            <tr>
                                <td class="text-center">{{ $cliente->id }}</td>
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

                                <td style="display: block; margin: 0 auto;">
                                    <div>
                                @foreach ($marcas as $marca)
                                    <label for="{{ $marca->nombre }}-{{ $marca->id }}_{{ $cliente->id }}">
                                        <input id="{{ $marca->nombre }}-{{ $marca->id }}_{{ $cliente->id }}" type="checkbox" name="marks[]" value="{{ $marca->id }}" onclick="updateMarca (this.id)" @if ( str_contains( $cliente->marcas, $marca->id ) ) checked @endif /> {{ $marca->nombre }} @if ($marca->estado == 'Inactivo') <span style="color: red;">(inactiva)</span> @endif

                                    </label>
                                    <br/>
                                    <span class="text-danger" id="ErrorMsg1"></span>
                                    <span class="text-danger" id="ErrorMsg2"></span>    
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
            var table = $('#table_clientes').DataTable({
                language: {
                    url: "/assets/js/Spanish.json"
                }
            });

            var filtroColumna = table.column(3);

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

        function updateMarca(check_id){
            var estadoUpdate = $('#'+check_id).prop('checked');
            var clienteid = check_id;
            // console.log("estado: "+estado);

            $.ajax({
                url: "{{ route('clientes.marcaUpdate') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&marcaUpdate=" + $('#'+check_id).val() + "&cliente=" + check_id + "&estadoUpdate=" + estadoUpdate,

                success: function(response){
                    $('#successMsg').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.marcaUpdate);
                    $('#ErrorMsg2').text(response.responseJSON.errors.cliente);
                },
            })
        }
       
      </script>
@endsection