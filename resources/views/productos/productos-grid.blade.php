@extends('layouts.app')

@section('content')

@section('title', 'Tienda')


<div style="display: none;">            
    <a style="float: right; z-index: 1000000; position: fixed; right: 50px; bottom: 200px;" href="{{ url('/carrito') }}">

        <h6 class="btn btn-sm btn-primary p-2">
            
            <?php
                $carrito = session('cart', []);
                $cart = session()->get('cart', []);

                $cantidad = 0;
                
                foreach ($carrito as $item) {
                    $cantidad += $item['cantidad'];
                }
            ?>

            <i style="font-size: 50px;" class="fa-solid fa-cart-shopping"></i><span style="position: absolute; top: 3px; right: 8px; font-size: 25px;">{{ $cantidad }}</span>
            <br/>
            <br/>
            Procesar Órden 
        </h6>

    </a>


</div>



    <?php
    $productosDisponibles = DB::table('producto')
        ->where('estado_producto_id', '1')
        ->get();
    ?>

{{-- Marcas --}}
<div class="card mb-3" id="summary">

    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    
    <div class="card-body position-relative">
        <div class="row">
            <div id="brand-list" class="col-lg-8 flex-center">
                @foreach ($marcas as $marca)
                    
                    <img src="{{ $marca->logo_src }}" alt="img-{{ $marca->nombre }}" class="img-fluid" style="max-width: 150px; margin: 0 auto;" /> 

                @endforeach
            </div>

            {{-- Detalle --}}
            <div id="summ-detail" class="col-lg-4 flex-center">
                <table id="table_detalle" class="table display mb-0">
                    <thead>
                        <tr>
                            <th class="text-start p-1">Marca</th>
                            <th class="text-center p-1">Cantidad 📦</th>
                            <th class="text-center p-1">Subtotal Parcial</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($carrito as $item)

                            @if ( $item['marca'] == 'ECOM' )
                            <tr>
                                <td class="text-start p-1" id="{{ $item['marca_id'] }}">{{ $item['marca'] }}</td>           
                                <td class="text-center p-1" id="{{ $item['marca_id'] }}-qty">
                                @php 

                                    $CantMarca = 0;

                                    $CantMarca += $item['cantidad'];
                                    
                                    echo $CantMarca;

                                @endphp
                                </td>
                                <td class="text-center p-1" id="{{ $item['marca'] }}-st">
                                @php
                                
                                    $totalMarca = 0;
                                    
                                    $totalMarca += number_format(($item['precio_f'] * $item['cantidad'] * $item['unidad_caja']), 2, '.', ',');
                                    
                                    echo $totalMarca;

                                @endphp
                                $</td>
                            </tr>
                            @endif
                        @endforeach

                            <tr>
                                <td class="text-start p-1"></td>
                                <td class="text-center p-1">Subtotal:</td>
                                @php

                                    $total = 0;
                                    $cart = session('cart', []);
                                    
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


{{-- Tienda --}}
<div class="card mb-3" style="border: ridge 1px #ff1620;">

    {{-- Filtros --}}
    <div class="col-sm-auto ps-3 pt-4">    
        <div class="row gx-2 align-items-center">

            <div class="col-auto">
            
                <form class="row gx-2">
                    <div class="col-auto"><h6>Ordenar por marca:</h6></div>
                    <div class="col-auto">
                        <form action="{{ route('productos.index') }}" method="get">
                            <select name="marca" id="marca" class="form-select form-select-sm" aria-label="Bulk actions">
                                <option value="0">Todas</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}"
                                        @if ($marca->id == $marcaActual) selected @endif>
                                        {{ $marca->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-filter"></i> Aplicar filtro</button>
                                <a href="{{ url('/dashboard/tienda') }}" class="btn btn-sm btn-primary" type="submit"><i class="fas fa-trash-alt"></i> Limpiar filtro</a>
                            </div>
                        </form>
                    </div>
                </form>

            </div>

            <div class="col-auto">
            
                <form class="row gx-2">
                    <div class="col-auto"><h6>Ordenar por categoría:</h6></div>
                    <div class="col-auto">
                        <form action="{{ route('productos.index') }}" method="get">
                            <select name="categoria" id="categoria" class="form-select form-select-sm" aria-label="Bulk actions">
                                <option value="0">Todas</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->categoria_id }}"
                                        @if ($categoria->categoria_id == $categoriaActual) selected @endif>
                                        {{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-filter"></i> Aplicar filtro</button>
                                <a href="{{ url('/dashboard/tienda') }}" class="btn btn-sm btn-primary" type="submit"><i class="fas fa-trash-alt"></i> Limpiar filtro</a>
                            </div>
                        </form>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <h6 class="card-body">Categoría: {{ $categoriaActual == 0 ? 'Todas' : $categoriaActualname->nombre }}</h6>
    <div>
        @if ($productos->count() == 0)
            <div class="card-body text-center">
                <h2 class="card-body">No hay productos en esta categoría <i class="far fa-folder-open"></i></h2>
            </div>
        @endif
    </div>
    <h6 class="mb-0">Mostrando {{ $productos->count() }} de {{ count($productosDisponibles) }} productos</h6>

    <div class="card-body">

        <div class="row">

            @foreach ($productos as $producto)
                <?php
                //hacer un if para ver si el producto tiene imagen o no
                if ($producto->imagen_1_src != null) {
                    $imagen = "{$producto->imagen_1_src}";
                } else {
                    $imagen = '../../../assets/img/products/demo-product-img.jpg';
                }
                ?>

                <div class="mb-4 col-md-12 col-lg-3">

                    <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                        <div class="overflow-hidden">

                            <div class="position-relative rounded-top overflow-hidden div-tienda" style="position: relative;">
                                <a tabindex="-1" class="d-block" href="{{ route('tienda.show', $producto->slug) }}"><img class="rounded-top" src="{{ $imagen }}" alt="img-producto-thumbnail" /></a>
                                @if ($producto->etiqueta_destacado == 1) 
                                    <image src="{{url('assets/img/imgs/destacado.svg')}}" alt="destacado-seal-img-thumb" class="producto-destacado-thumb" />
                                @endif

                                @if ($producto->precio_oferta != null) 
                                    <image src="{{url('assets/img/imgs/oferta.svg')}}" alt="oferta-seal-img-thumb" class="producto-oferta-thumb" />
                                @endif
                            </div>

                            <div class="p-2">

                                <h5 style="min-height: 55px;" class="fs--1 text-start"><a tabindex="-1" class="text-dark" href="{{ route('tienda.show', $producto->slug) }}">{{ $producto->nombre }}</a></h5>

                                <span class="rt-color-2 font-weight-bold" style="font-size: 14px;">OEM: </span><span style="font-size: 14px;">{{ $producto->OEM }}</span>

                                <div class="row">

                                    <div class="col-7">
                                        <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                    </div>

                                    <div class="col-5">
                                        <p class="text-center"># 📦</p>
                                    </div>

                                </div>

                                
                                <div class="row">

                                    <div class="col-7">
                                
                                        <h5 class="fs-md-1 text-dark d-flex align-items-center mb-2">

                                            @if ($producto->precio_oferta != null)                        
                                                $ {{ $producto->precio_oferta }}

                                            @elseif (Auth::user()->clasificacion == "Cobre")
                                                $ {{ $producto->precio_1 }}
                                            @elseif (Auth::user()->clasificacion == "Plata")
                                                $ {{ $producto->precio_1 }}
                                            @elseif (Auth::user()->clasificacion == "Oro")
                                                $ {{ $producto->precio_2 }}
                                            @elseif (Auth::user()->clasificacion == "Platino")
                                                $ {{ $producto->precio_3 }}
                                            @elseif (Auth::user()->clasificacion == "Diamante")
                                                $ {{ $producto->precio_oferta }}
                                            @elseif (Auth::user()->clasificacion == "Taller")
                                                $ {{ $producto->precio_taller }}
                                            @elseif (Auth::user()->clasificacion == "Reparto")
                                                $ {{ $producto->precio_distribuidor }}
                                            @endif

                                            {{-- Precio antes de descuento --}}
                                            <del class="ms-2 fs--1 text-500">
                                            <?php if ($producto->precio_oferta != null) { ?>
                                            
                                               
                                                @if (Auth::user()->clasificacion == "Cobre")
                                                    $ {{ $producto->precio_1 }}
                                                @elseif (Auth::user()->clasificacion == "Plata")
                                                    $ {{ $producto->precio_1 }}
                                                @elseif (Auth::user()->clasificacion == "Oro")
                                                    $ {{ $producto->precio_2 }}
                                                @elseif (Auth::user()->clasificacion == "Platino")
                                                    $ {{ $producto->precio_3 }}
                                                @elseif (Auth::user()->clasificacion == "Diamante")
                                                    $ {{ $producto->precio_oferta }}
                                                @elseif (Auth::user()->clasificacion == "Taller")
                                                    $ {{ $producto->precio_taller }}
                                                @elseif (Auth::user()->clasificacion == "Reparto")
                                                    $ {{ $producto->precio_distribuidor }}
                                                @endif

                                             <?php } ?>
                                            
                                            </del>  
                                        </h5>
                                    </div>

                                    <div class="col-5 text-end">
                                        <input class="prod-grid-qty" type="number" id="{{ $producto->id }}" name="cantidad" value="{{ isset($cart[$producto->id]['cantidad']) ? $cart[$producto->id]['cantidad'] : 0 }}" min="1" max="{{ $producto->existencia }}" placeholder="0" onchange="agregarCarrito(this.id)"/>
                                        <br/>
                                        <span class="text-danger" id="ErrorMsg1"></span>
                                        <span class="text-danger" id="ErrorMsg2"></span>

                                        <input type="hidden" id="{{ $producto->id }}-brand" value="{{ $producto->marca_id }}">
                                        <input type="hidden" id="{{ $producto->id }}-ex" value="{{ $producto->existencia }}">
                                        <input type="hidden" id="{{ $producto->existencia }}-uc" value="{{ $producto->unidad_por_caja }}">
                                    </div>

                                </div>

                                

                                <p class="fs--1 mb-2">Estado: <strong class="text-success">{{ $producto->estadoProducto->estado }}</strong></p>

                            </div>

                        </div>

                        <div class="d-flex flex-between-center px-2 flex-center">
                            <div class="d-flex">
                                <a tabindex="-1" class="btn btn-x btn-primary me-2"
                                    href="{{ route('tienda.show', $producto->slug) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ver producto"><i class="fa-regular fa-eye"></i>
                                    Ver Producto
                                </a>
                                
                                {{--
                                <form method="post" action="{{ route('carrito.add') }}">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                    <input type="hidden" class="form-control" type="text" name="cantidad"
                                        value="1">
                                    <button tabindex="-1" type="submit" class="btn btn-x btn-falcon-default" href="#!"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Agregar al carrito"><span class="fas fa-cart-plus"></span>
                                    </button>
                                </form>
                                --}}
                                
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
    @if ($productos->count() > 0)
        <div class="card-footer pb-5 d-flex justify-content-center">
            <hr/>
            {{ $productos->links('pagination::simple-bootstrap-4') }}
            <hr/>
        </div>
    @endif
</div>

<script type="text/javascript">

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


        var marca_id = $('#'+prod_id+'-brand').val();

        var cantt = $('#'+marca_id+'-qty').text();

        var canttupd = parseInt(cantt) + parseInt(qty);

        $('#'+marca_id+'-qty').text(canttupd);
        
    }

</script>

<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("summary");
var brandsl = document.getElementById("brand-list");
var sumdet = document.getElementById("summ-detail");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky-pos");
    brandsl.classList.add("no-show");
    sumdet.classList.remove("col-lg-4");
    sumdet.classList.add("col-lg-12");
  } else {
    header.classList.remove("sticky-pos");
    brandsl.classList.remove("no-show");
    sumdet.classList.remove("col-lg-12");
    sumdet.classList.add("col-lg-4");
  }
}
</script>

@endsection

