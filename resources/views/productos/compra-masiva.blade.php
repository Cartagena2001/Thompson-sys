@extends('layouts.app')

@section('content')
@section('title', 'Catálogo para compra masiva')

<button onclick="topFunction()" id="toTopBtn" title="Ir a arriba"><i style="" class="fa-solid fas fa-arrow-up"></i></button>

<?php
    $carrito = session('cart', []);
    $cart = session()->get('cart', []);

    $detallesSUM = session('detalle', []);

    $cantidad = 0;
    
    foreach ($carrito as $item) {
        $cantidad += $item['cantidad'];
    }

    //array of brands available
    $brandIDs = array();

    foreach ($marcas as $marca) {
        $brandIDs[] = $marca->id;
    }

?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

{{-- Titulo 
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
--}}

{{-- Marcas --}}
<div class="card mb-3" id="summary">

    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    
    <div class="card-body position-relative">
        
        <div class="row">

            <div id="brand-list" class="col-lg-8">

                <div class="glide mt-4 mb-4">

                  <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">

                    @foreach ($marcas as $brand)
                        
                        <li class="glide__slide text-center">
                            <img src="{{ url('storage/assets/img/logos/'.$brand->logo_src) }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="cursor: pointer; max-width: 180px; margin: 0 auto;" id="mfp-{{ $brand->id }}" onclick="filterBrandPic(this.id)" />
                        </li>

                    @endforeach

                    </ul>
                  </div>
                  
                  {{-- 
                  <div class="glide__arrows" data-glide-el="controls">
                    <button style="left: -20px; border-color: transparent;" class="glide__arrow glide__arrow--left" data-glide-dir="<"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-left" aria-hidden="true"></i></button>
                    <button style="right: -20px; border-color: transparent;" class="glide__arrow glide__arrow--right" data-glide-dir=">"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-right" aria-hidden="true"></i></button>
                  </div>
                  --}}
    
                </div>

            </div>

            {{-- Detalle --}}
            <div id="summ-detail" class="col-lg-4 flex-center">
                <table id="table_detalle" class="table display mb-0">
                    <thead>
                        <tr>
                            <th class="text-start p-1">Marca</th>
                            <th class="text-center p-1">Cantidad de 📦</th>
                            <th class="text-center p-1">Subtotal Parcial</th>   
                        </tr>
                    </thead>
                    <tbody>
                   
                    @foreach ($detallesSUM as $marcaDetalle)
                        <tr>
                            <td class="text-start p-1">{{ $marcaDetalle['nombre'] }}</td>
                            <td class="text-center p-1">{{ $marcaDetalle['cantidad'] }}</td>
                            <td class="text-center p-1">{{ number_format($marcaDetalle['monto'], 2, '.', ',') }} $</td>
                        </tr>  
                    @endforeach

                        <tr>
                            <td class="text-start p-1"></td>
                            <td class="text-center p-1">Subtotal:</td>
                            @php

                                $total = 0;
                                //$cart = session('cart', []);
                                
                                foreach ($cart as $item) {
                                    $total += $item['precio_f'] * $item['cantidad'] * $item['unidad_caja'];
                                }

                                echo '<td class="text-center p-1" id="st-brands">' . number_format($total, 2, '.', ',') . ' $</td>';
                           
                            @endphp
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

        </div>
    </div>

    <hr/>

    <div class="card-body pt-0">
        <div class="table-responsive scrollbar" style="overflow-x: auto;">
            <table id="table_productos" class="table display" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">ID</th>
                        <th class="text-start ms-1" scope="col">OEM</th>
                        <th scope="col">Nombre</th>
                        <th class="text-center" scope="col">Marca</th>
                        <th class="text-center" scope="col">Categoría</th>
                        <th class="text-center" style="width: 100px;" scope="col">Precio por 📦</th>
                        <th class="text-center" style="width: 100px;" scope="col"># unidades en 📦</th>
                        <th class="text-center" style="width: 100px;" scope="col">Agregar <br/> 📦 a 🛒</th>
                    </tr>
                </thead>
                <tbody>
                        <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                            Producto/s agregado/s con éxito. 
                        </div>

                    @foreach ($productos as $producto)
                        <tr>
                            <td class="text-center">{{ $producto->id }}</td>
                            <td class="text-start ms-1">{{ $producto->OEM }}</td>
                            <td><a tabindex="-1" style="color: #5e6e82;" class=""
                                    href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ver producto">{{ $producto->nombre }}</a></td>
                            <td class="text-center">{{ $producto->marca->nombre }}</td>
                            <td class="text-center">{{ $producto->categoria->nombre }}</td>
                            <td class="text-center">$ {{  number_format( $producto->precio_1 * $producto->unidad_por_caja , 2, '.', ',') }}</td>


                            <td class="text-center">{{ $producto->unidad_por_caja }}</td>

                            <td style="display: block; margin: 0 auto;">
                                <div class="input-group" data-quantity="data-quantity">              
                                    {{-- <input type="hidden" name="producto_id" value="{{ $producto->id }}"> --}}
                                    <div class="input-group-append flex-center">

                                        <input class="btn btn-outline-secondary text-center" style="width: 100px;" type="number" name="cantidad" value="{{ isset($cart[$producto->id]['cantidad']) ? $cart[$producto->id]['cantidad'] : '' }}" id="{{ $producto->id }}" min="1" max="{{ $producto->existencia }}" placeholder="0" onchange="agregarCarrito(this.id)">

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
                url: "/assets/js/Spanish.json"
            },
            
        });

        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) { //'data' contiene los datos de la fila
                
                //En la columna 3 estamos mostrando la marca del producto
                let productoMarca = data[3] || 0;
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
                //console.log(response);
                //$("#table_detalle").load(location.href + " #table_detalle");
                //$("#hcart").load(location.href + " #hcart");
                $("#table_detalle").load(' #table_detalle');
                $("#hcart").load(' #hcart');
            },
            error: function(response) {
                $('#ErrorMsg1').text(response.responseJSON.errors.qty);
                $('#ErrorMsg2').text(response.responseJSON.errors.prodid);
            },
        });
        
    }

    function filterBrand(filterid) {

        var brand = $('#'+filterid).find(":selected").val();

        $('#btn-filter').click();

    }

    function filterCat(filterid) {

        var cat = $('#'+filterid).find(":selected").val();

        $('#btn-filter').click();

    }

    function filterBrandPic(filteridpic) {

        var brandName = filteridpic.substring(4, 10000);

        $('#brandfilter option').removeAttr("selected");
        $('#brandfilter').children('option[value="'+ brandName +'"]').attr('selected', true).trigger("change");
    }

</script>

<!-- Glide JS -->           
<script src="{{ url('assets/js/glide.js') }}"></script>
<script>

    const config = {
        type: "carousel",
        perView: 4,
        focusAt: 'center',
        gap: 2,
        autoplay: 3000,
        duration: 3500,
        breakpoints: {
            800: {
              perView: 2
            },
            480: {
              perView: 1
            }
        }

    };

    new Glide(".glide", config).mount();
</script>

<script>
    // Get the button
    let mybutton = document.getElementById("toTopBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
      } else {
        mybutton.style.display = "none";
      }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
</script>

@endsection
