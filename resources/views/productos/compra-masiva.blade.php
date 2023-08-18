@extends('layouts.app')

@section('content')
@section('title', 'Catálogo para compra masiva')

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
                <h1 class="text-center">📦 Catálogo para compra masiva 📦</h1>
                <p class="mt-4 mb-4 text-center">Puedes realizar la compra de productos en lista de forma masiva en esta sección y agregarlos a tu carrito de compras para completar la órden más adelante.</p>
            </div>
        </div>
    </div>
</div>

{{-- Marcas --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12 flex-center">
                @foreach ($marcas as $marca)
                    
                    <img src="{{ $marca->logo_src }}" alt="img-{{ $marca->nombre }}" class="img-fluid" style="max-width: 150px; margin: 0 auto;" /> 

                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Tabla de productos --}}

<div class="card mb-3" style="border: ridge 1px #ff1620;">

    <div class="card-header">
        <div class="row flex-between-end">
            {{--
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Tabla de Productos</h5>
            </div>
            --}}
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive scrollbar" style="overflow-x: auto;">
            <table id="table_productos" class="table display" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        {{-- <th scope="col">Descripción</th> --}}
                        <th class="text-center" scope="col">Marca</th>
                        <th scope="col">OEM</th>
                        <th scope="col">Categoría</th>
                        <th class="text-center" style="width: 100px;" scope="col">Precio 📦</th>
                        <th class="text-center" style="width: 100px;" scope="col"># unidades en caja</th>
                        <th class="text-center" style="width: 100px;" scope="col">Agregar a 🛒</th>
                        <th class="text-center" style="width: 200px;" scope="col"># cajas a comprar</th>

                        {{-- <th class="text-center" scope="col">Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>{{ $producto->nombre }}</td>
                            {{-- <td>{{ Str::limit($producto->descripcion, 100, '...') }}</td> --}}
                            <td>{{ $producto->marca->nombre }}</td>
                            <td>{{ $producto->OEM }}</td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td class="text-center">${{ $producto->precio_1 * $producto->unidad_por_caja  }}</td>
                            <td class="text-center">{{ $producto->unidad_por_caja }}</td>
                            <td class="text-center"><input type="checkbox" value="" /></td>

                            <td class="text-center">
                                <div class="input-group" data-quantity="data-quantity">              
                                    {{-- <input type="hidden" name="producto_id" value="{{ $producto->id }}"> --}}
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="btn-menos">-</button>
                                        <input class="btn btn-outline-secondary" type="number" name="cantidad" value="1" id="cantidad" min="1" max="{{ $producto->unidad_por_caja }}" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="btn-mas">+</button>
                                    </div>
                                </div>    
                            </td>
                            
                            {{-- <td class="text-center">
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                    <a href="{{ route('productos.edit', $producto->id) }}">
                                        <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Producto"><span class="text-500 fas fa-edit"></span></button>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button class="btn p-0 ms-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Producto"><span class="text-500 fas fa-trash-alt"></span></button>
                                    
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>

    var btnMas = document.querySelector('#btn-mas');
    var btnMenos = document.querySelector('#btn-menos');
    var inputCantidad = document.querySelector('#cantidad');

    btnMas.addEventListener('click', function() {
        var valorActual = parseInt(inputCantidad.value);
        if (valorActual < parseInt(inputCantidad.max)) {
            inputCantidad.value = valorActual + 1;
        }
    });

    btnMenos.addEventListener('click', function() {
        var valorActual = parseInt(inputCantidad.value);
        if (valorActual > parseInt(inputCantidad.min)) {
            inputCantidad.value = valorActual - 1;
        }
    });

</script>

<script>

    $(document).ready(function() {
        $('#table_productos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "paging": false
        });
    });

</script>
@endsection
