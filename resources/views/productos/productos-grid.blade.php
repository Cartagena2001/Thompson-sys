@extends('layouts.app')

@section('content')

@section('title', 'Tienda')


<div style="display: none;">            
    <a style="float: right; z-index: 1000000; position: fixed; right: 50px; bottom: 200px;" href="{{ url('/carrito') }}">

        <h6 class="btn btn-sm btn-primary p-2">
            
            <?php
                $carrito = session('cart', []);
                $cart = session()->get('cart', []);

                $detallesSUM = session('detalle', []);

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
        ->where('estado_producto_id', 1)
        ->whereNot('existencia', 0)
        ->get();
    ?>

{{-- Marcas --}}
<div class="card mb-3" 

    @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 ) 

        id="summary">

    @elseif ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

        id="summary">

    @else

        ><span style="display: none;"  id="summary"><spam id="brand-list"><spam id="summ-detail"></spam></spam></span>

    @endif

    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    
    <div class="card-body position-relative">
        <div class="row">

        @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

            <div id="brand-list" class="col-lg-8 flex-center">
                @foreach ($marcas as $brand)
                    
                    <img src="{{ $brand->logo_src }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="cursor: pointer; max-width: 150px; margin: 0 auto;" id="mfp-{{ $brand->id }}" onclick="filterBrandPic(this.id)" />

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
                   
                    @foreach ($detallesSUM as $marcaDetalle)
                        <tr>
                            <td class="text-start p-1">{{ $marcaDetalle['nombre'] }}</td>
                            <td class="text-center p-1">{{ $marcaDetalle['cantidad'] }}</td>
                            <td class="text-center p-1">{{ $marcaDetalle['monto'] }}</td>
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

        @elseif ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

            <div id="brand-list" class="col-lg-8 flex-center">
                @foreach ($marcas as $brand)
                    
                    <img src="{{ $brand->logo_src }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="cursor: pointer; max-width: 150px; margin: 0 auto;" id="mfp-{{ $brand->id }}" onclick="filterBrandPic(this.id)" />

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
                   
                    @foreach ($detallesSUM as $marcaDetalle)
                        <tr>
                            <td class="text-start p-1">{{ $marcaDetalle['nombre'] }}</td>
                            <td class="text-center p-1">{{ $marcaDetalle['cantidad'] }}</td>
                            <td class="text-center p-1">{{ $marcaDetalle['monto'] }}</td>
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

        @else

            <div id="brand-list" class="col-lg-12 flex-center">
                @foreach ($marcas as $brand)
                    
                    <img src="{{ $brand->logo_src }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="cursor: pointer; max-width: 150px; margin: 0 auto;" id="mfp-{{ $brand->id }}" onclick="filterBrandPic(this.id)" />

                @endforeach
            </div>

        @endif


        </div>
    </div>
</div>


{{-- Tienda --}}
<div class="card mb-3" style="border: ridge 1px #ff1620;">

    {{-- Filtros --}}
    <div class="ps-3 pt-4 pb-2">

        <div class="row gx-2">

            <div class="col-6 col-md-6">
                   
               <form action="" method="get">

                    <label for="marca">Ordenar por marca:</label>
                    <select style="height: 36px; border-radius: 5px;" id="marca-filter" name="marca" class="form-select form-select-sm" aria-label="Bulk actions" onchange="filterBrand(this.id)" >

                        <option value="0"  @if ($marcaActual == 0) selected @endif >Todas</option>

                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}" @if ($marca->id == $marcaActual) selected @endif >{{ $marca->nombre }}</option>
                        @endforeach

                    </select>

                    <br/>

                    <label for="categoria">Ordenar por categoría:</label>
                    <select style="height: 36px; border-radius: 5px;" id="categoria-filter" name="categoria" class="form-select form-select-sm" aria-label="Bulk actions" onchange="filterCat(this.id)" >

                        <option value="0" @if ($categoriaActual == 0) selected @endif >Todas</option>

                        @foreach ($categorias as $cat)

                        @php
                        
                        var_dump($cat->pivot);

                        @endphp
                            <option style="text-transform: lowercase;" 

                                    value="@if( isset($cat->pivot) ){{ $cat->pivot->categoria_id }}@else{{ $cat->id }}@endif"


                                    @if ( isset($cat->pivot) )
                                        @if ( $cat->pivot->categoria_id == $categoriaActual ) 
                                            selected
                                        @endif 
                                    @else
                                        @if ( $cat->id == $categoriaActual ) 
                                            selected
                                        @endif
                                    @endif >{{ $cat->nombre }}</option>
                        @endforeach

                    </select>

                    <div style="display:none;" class="mt-2">
                        <button id="btn-filter" class="btn btn-sm btn-primary" type="submit"><i class="fas fa-filter"></i> Aplicar filtro</button>
                    </div>

                </form>

            </div>

            <div class="col-6 col-md-6">

                <form action="" method="get">

                    <label for="busq">Búsqueda: </label>
                    <div style="display: flex;">    
                        <input class="form-control" type="text" name="busq" id="busq" value="" maxlength="20" placeholder="Buscar por OEM..." style="vertical-align: middle;"><button id="btn-filter-brand" class="btn btn-sm btn-primary" type="submit" style="vertical-align: middle;"><i class="fas fa-search"></i></button>
                    </div>                           
                </form>

            </div>

        </div>

    </div>

    <hr/>

    <h6 class="card-body mb-0 py-1">Categoría: {{ $categoriaActual == 0 ? 'Todas' : $categoriaActualname->nombre }}</h6>
    <div>
        @if ($productos->count() == 0)
            <div class="card-body text-center">
                <h2 class="card-body">No hay productos en esta categoría <i class="far fa-folder-open"></i></h2>
            </div>
        @endif
    </div>

    <h6 class="card-body mb-0 py-1">Mostrando {{ $productos->count() }} de {{ count($productosDisponibles) }} productos</h6>

    <div id="catalogo-grid" class="card-body">

        <div class="row">

            @foreach ($productos as $producto)

                <?php
                        //hacer un if para ver si el producto tiene imagen o no
                        if ($producto->imagen_1_src != null) {

                            $imagen = "{$producto->imagen_1_src}";

                        } elseif ($producto->marca->nombre == 'TEMCO') {

                            $imagen = '../../../assets/img/logos/temco-surplus-logo.png';
                        
                        } elseif ($producto->marca->nombre == 'CTI') {
                            
                            $imagen = '../../../assets/img/logos/cti.jpg';
                        
                        } elseif ($producto->marca->nombre == 'ECOM') { 
                            
                            $imagen = '../../../assets/img/logos/ecom.jpg';
                        
                        } else {

                            $imagen = '../../../assets/img/products/demo-product-img.jpg';

                        }  
                ?>

                <div class="mb-4 col-md-12 col-lg-3">

                    <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                        <div class="overflow-hidden">

                            <div class="position-relative rounded-top overflow-hidden div-tienda" style="position: relative;">
                                
                                <a tabindex="-1" class="d-block" href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}">
                                    <img class="rounded-top" src="{{ $imagen }}" alt="img-producto-thumbnail" />
                                </a>

                                @if ($producto->etiqueta_destacado == 1) 
                                    <image src="{{url('assets/img/imgs/destacado.svg')}}" alt="destacado-seal-img-thumb" class="producto-destacado-thumb" />
                                @endif

                                @if ($producto->precio_oferta != null) 
                                    <image src="{{url('assets/img/imgs/oferta.svg')}}" alt="oferta-seal-img-thumb" class="producto-oferta-thumb" />
                                @endif

                            </div>

                            <div class="p-2">

                                <h5 style="min-height: 55px;" class="fs--1 text-start"><a tabindex="-1" class="text-dark" href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}">{{ $producto->nombre }}</a></h5>

                                @if ($producto->marca->nombre == 'TEMCO')
                                    <span class="rt-color-2 font-weight-bold" style="font-size: 12px;"></span><span style="font-size: 12px;">{{ $producto->descripcion }}</span>
                                    <br/>
                                @endif

                                <span class="rt-color-2 font-weight-bold" style="font-size: 12px;">MARCA: </span><span style="font-size: 12px;">{{ $producto->marca->nombre }}</span>
                                <br/>
                                <span class="rt-color-2 font-weight-bold" style="font-size: 14px;">OEM: </span><span style="font-size: 14px;">{{ $producto->OEM }}</span>
                                <br/>
                                <span class="rt-color-2 font-weight-bold" style="font-size: 14px;">Unidades / 📦: </span><span style="font-size: 14px;">{{ $producto->unidad_por_caja }}</span>

                                <div class="row">

                                @if ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

                                    <div class="col-7">
                                        <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                    </div>

                                    <div class="col-5">
                                        <p class="text-center"># 📦</p>
                                    </div>

                                @elseif ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

                                    <div class="col-7">
                                        <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                    </div>

                                    <div class="col-5">
                                        <p class="text-center"># 📦</p>
                                    </div>

                                @else

                                    <div class="col-12">
                                        <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                    </div>

                                @endif

                                </div>

                                
                                <div class="row">

                                @if ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

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
                                            @elseif (Auth::user()->clasificacion == "Distribuidor")
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
                                                @elseif (Auth::user()->clasificacion == "Distribuidor")
                                                    $ {{ $producto->precio_distribuidor }}
                                                @endif

                                             <?php } ?>
                                            
                                            </del>  
                                        </h5>
                                    </div>

                                    <div class="col-5 text-center">
                                        <input class="prod-grid-qty" type="number" id="{{ $producto->id }}" name="cantidad" value="{{ isset($cart[$producto->id]['cantidad']) ? $cart[$producto->id]['cantidad'] : 0 }}" min="1" max="{{ $producto->existencia }}" placeholder="0" onchange="agregarCarrito(this.id)"/>
                                        <br/>
                                        <span class="text-danger" id="ErrorMsg1"></span>
                                        <span class="text-danger" id="ErrorMsg2"></span>

                                        <input type="hidden" id="{{ $producto->id }}-brand" value="{{ $producto->marca_id }}">
                                        <input type="hidden" id="{{ $producto->id }}-ex" value="{{ $producto->existencia }}">
                                        <input type="hidden" id="{{ $producto->existencia }}-uc" value="{{ $producto->unidad_por_caja }}">
                                    </div>

                                @elseif ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

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
                                            @elseif (Auth::user()->clasificacion == "Distribuidor")
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
                                                @elseif (Auth::user()->clasificacion == "Distribuidor")
                                                    $ {{ $producto->precio_distribuidor }}
                                                @endif

                                             <?php } ?>
                                            
                                            </del>  
                                        </h5>
                                    </div>

                                    <div class="col-5 text-center">
                                        <input class="prod-grid-qty" type="number" id="{{ $producto->id }}" name="cantidad" value="{{ isset($cart[$producto->id]['cantidad']) ? $cart[$producto->id]['cantidad'] : 0 }}" min="1" max="{{ $producto->existencia }}" placeholder="0" onchange="agregarCarrito(this.id)"/>
                                        <br/>
                                        <span class="text-danger" id="ErrorMsg1"></span>
                                        <span class="text-danger" id="ErrorMsg2"></span>

                                        <input type="hidden" id="{{ $producto->id }}-brand" value="{{ $producto->marca_id }}">
                                        <input type="hidden" id="{{ $producto->id }}-ex" value="{{ $producto->existencia }}">
                                        <input type="hidden" id="{{ $producto->existencia }}-uc" value="{{ $producto->unidad_por_caja }}">
                                    </div>   

                                @endif

                                </div>

                                

                                <p class="fs--1 mb-2">Estado: <strong class="text-success">{{ $producto->estadoProducto->estado }}</strong></p>

                            </div>

                        </div>



                        <div class="row px-0 mx-1">

                        @if ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

                            <div class="col-6 col-md-6 px-1 flex-center">

                                <a tabindex="-1" class="btn btn-x btn-primary me-0 px-2"
                                    href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ir a">Ver Más <i class="fas fa-search-plus"></i>
                                </a>
 
                            </div>

                            <div class="col-6 col-md-6 px-1">

                                <p class="me-0 mb-0 text-center"><span style="font-size: 14px;">Subtotal:</span> <br/> <span style="font-weight: bold; font-size: 20px;">{{ isset($cart[$producto->id]['cantidad']) ? number_format(($cart[$producto->id]['precio_f'] * $cart[$producto->id]['cantidad'] * $cart[$producto->id]['unidad_caja']), 2, '.', ',') : number_format(0, 2, '.', ',') }} $</span></p> 

                            </div>

                        @elseif ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

                            <div class="col-6 col-md-6 px-1 flex-center">

                                <a tabindex="-1" class="btn btn-x btn-primary me-0 px-2"
                                    href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ir a">Ver Más <i class="fas fa-search-plus"></i>
                                </a>
 
                            </div>

                            <div class="col-6 col-md-6 px-1">

                                <p class="me-0 mb-0 text-center"><span style="font-size: 14px;">Subtotal:</span> <br/> <span style="font-weight: bold; font-size: 20px;">{{ isset($cart[$producto->id]['cantidad']) ? number_format(($cart[$producto->id]['precio_f'] * $cart[$producto->id]['cantidad'] * $cart[$producto->id]['unidad_caja']), 2, '.', ',') : number_format(0, 2, '.', ',') }} $</span></p> 

                            </div>

                        @else

                            <div class="col-12 col-md-12 px-1 flex-center">

                                <a tabindex="-1" class="btn btn-x btn-primary me-0 px-2"
                                    href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ir a">Ver Más <i class="fas fa-search-plus"></i>
                                </a>
 
                            </div>

                        @endif

                        </div>


                        <div class="d-flex flex-between-center px-2 " style="display: none !important;">

                            <div class="d-flex">

                                <a tabindex="-1" class="btn btn-x btn-primary me-2"
                                    href="{{ route('tienda.show', [$producto->id, $producto->slug]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ver producto"><i class="fa-regular fa-eye"></i>
                                    Ver Producto
                                </a>

                                <p>Sbt.:  $</p>
                                
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

    function filterBrand(filterid) {

        var brand = $('#'+filterid).find(":selected").val();

        $('#btn-filter').click();

    }

    function filterCat(filterid) {

        var cat = $('#'+filterid).find(":selected").val();

        $('#btn-filter').click();

    }

    function filterBrandPic(filteridpic) {

        var brandID = filteridpic.substring(4, 10000); 

        //obtener la opcion 
        var $option = $('#marca-filter').children('option[value="'+ brandID +'"]');
        //y ahora seteamos la opcion requerida
        $option.attr('selected', true);

        $('#btn-filter').click();

    }



</script>

@endsection

