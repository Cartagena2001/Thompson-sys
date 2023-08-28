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
            <div class="col-lg-8 flex-center">
                @foreach ($marcas as $marca)
                    
                    <img src="{{ $marca->logo_src }}" alt="img-{{ $marca->nombre }}" class="img-fluid" style="max-width: 150px; margin: 0 auto;" /> 

                @endforeach
            </div>

            {{-- Detalle --}}
            <div class="col-lg-4 flex-center">
                <table id="table_detalle" class="table display">
                    <thead>
                        <tr>
                            <th class="text-start">Marca</th>
                            <th class="text-center">Cantidad 📦</th>
                            <th class="text-center">Subtotal Parcial</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="pb-5">
                            <td class="text-start">CTI</td>
                            <td class="text-center">0</td>
                            <td class="text-center">00.00 $</td>
                        </tr>

                        <tr class="pb-5">
                            <td class="text-start">TEMCO</td>
                            <td class="text-center">0</td>
                            <td class="text-center">00.00 $</td>
                        </tr>

                        <tr class="pb-5">
                            <td class="text-start">ECOM</td>
                            <td class="text-center">0</td>
                            <td class="text-center">00.00 $</td>
                        </tr>
 

                        @php
                            $subtotal = 0;
                            $iva = 0.13;
                            $total = 0;
                            /*
                            foreach ($detalle as $detalles) {
                                $subtotal += $detalles->cantidad * $detalles->precio;
                            }

                            $total = $subtotal + ($subtotal * $iva);
                            */
                        @endphp
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Tabla de productos --}}

<div class="card mb-3" style="border: ridge 1px #ff1620;">

    <div class="card-header">
        <div class="row flex-between-end">

            <div class="col-8 text-start" >
                <label>Filtrar por marca:
                    <select id="brandfilter" class="" onchange="filtertable()">
                            <option value="todas">Todas</option>
                        @foreach ($marcas as $marca)      
                            <option value="{{ $marca->nombre }}">{{ $marca->nombre}}</option> 
                        @endforeach
                    </select>
                </label>

                <br/>

                <label>Filtrar por categoría:
                    <select id="catfilter" class="" onchange="filtertable()">
                            <option value="todas">Todas</option>
                        @foreach ($categorias as $categoria)      
                            <option value="{{ $categoria->nombre }}">{{ $categoria->nombre}}</option> 
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="col-4 text-end">
                <a href="{{ url('/carrito') }}" title="Ver Carrito">
                    <h6 class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 28px;"></i>
                        <?php
                            $carrito = session('cart', []);

                            $cart = session()->get('cart', []);

                            $cantidad = 0;

                            foreach ($carrito as $item) {
                                $cantidad += $item['cantidad'];
                            }
                        ?>
                        <sup class="cantnoti">{{ $cantidad }}</span>
                    </h6>
                </a>
            </div>

        </div>
    </div>

    <hr/>

    <div class="card-body pt-0">
        <div class="table-responsive scrollbar" style="overflow-x: auto;">
            <table id="table_productos" class="table display" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th class="text-center" scope="col">Marca</th>
                        <th scope="col">OEM</th>
                        <th scope="col">Categoría</th>
                        <th class="text-center" style="width: 100px;" scope="col">Precio 📦</th>
                        <th class="text-center" style="width: 100px;" scope="col"># unidades en caja</th>
                        <th class="text-center" style="width: 100px;" scope="col">Agregar # <br/> 📦 a 🛒</th>
                    </tr>
                </thead>
                <tbody>
                        <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                            Producto/s agregado/s con éxito. 
                        </div>

                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td><a tabindex="-1" style="color: #5e6e82;" class=""
                                    href="{{ route('tienda.show', $producto->slug) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ver producto">{{ $producto->nombre }}</a></td>
                            <td>{{ $producto->marca->nombre }}</td>
                            <td>{{ $producto->OEM }}</td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td class="text-center">${{ $producto->precio_1 * $producto->unidad_por_caja  }}</td>
                            <td class="text-center">{{ $producto->unidad_por_caja }}</td>

                            <td class="text-center">
                                <div class="input-group" data-quantity="data-quantity">              
                                    {{-- <input type="hidden" name="producto_id" value="{{ $producto->id }}"> --}}
                                    <div class="input-group-append flex-center">

                                        <input class="btn btn-outline-secondary text-center" style="width: 100px;" type="number" name="cantidad" value="{{ isset($cart[$producto->id]['cantidad']) ? $cart[$producto->id]['cantidad'] : 0 }}" id="{{ $producto->id }}" min="1" max="{{ $producto->existencia }}" placeholder="0" onchange="agregarCarrito(this.id)">

                                        <br/>
                                        <span class="text-danger" id="ErrorMsg1"></span>
                                        <span class="text-danger" id="ErrorMsg2"></span> 

                                    </div>
                                </div>    
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- $productos->links() --}}
</div>

<script>

    $(document).ready(function() {

        $('#table_productos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            
        });

        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) { //'data' contiene los datos de la fila
                
                //En la columna 3 estamos mostrando la marca del producto
                let productoMarca = data[2] || 0;
                let productoCat = data[4] || 0;

                if (!filterByBrand(productoMarca)) {
                    return false;
                } else if (!filterByCat(productoCat)) {
                    return false;      
                } else
                return true;
            }
        );

    });

    function filtertable() {
        $('#table_productos').DataTable().draw();
    }

    function filterByBrand(productoMarca) {

        let marcaSeleccionada = $('#brandfilter').val();

        //Si la opción seleccionada es 'TODAS', devolvemos 'true' para que pinte la fila
        if (marcaSeleccionada === 'todas') {
            return true;
        }

        //La fila sólo se va a pintar si el valor de la columna coincide con el del filtro seleccionado
        return productoMarca === marcaSeleccionada;
    }

    function filterByCat(productoCat) {

        let catSeleccionada = $('#catfilter').val();

        //Si la opción seleccionada es 'TODAS', devolvemos 'true' para que pinte la fila
        if (catSeleccionada === 'todas') {
            return true;
        }

        //La fila sólo se va a pintar si el valor de la columna coincide con el del filtro seleccionado
        return productoCat === catSeleccionada;
    }

    function agregarCarrito(prod_id) {

        var qty = $('#'+prod_id).val();
        var prodid = prod_id;

        $.ajax({
            url: "{{ route('carrito.add') }}",
            type: "POST",
            data:
                "_token=" + "{{ csrf_token() }}" + "&cantidad=" + qty + "&producto_id=" + prodid,

            success: function(response){
                $('#successMsg').show();
                console.log(response);
            },
            error: function(response) {
                $('#ErrorMsg1').text(response.responseJSON.errors.qty);
                $('#ErrorMsg2').text(response.responseJSON.errors.prodid);
            },
        });
        
    }

</script>
@endsection
