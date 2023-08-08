@extends('layouts.app')

@section('content')

@section('title', 'Tienda')
<div class="card mb-3" style="border: ridge 1px #ff1620;">
    <div class="card-body">
        <div class="row flex-between-center">
            
            <div class="col-sm-auto mb-2 mb-sm-0">
                <a href="{{ url('/carrito') }}">
                    <h6 class="btn btn-sm btn-primary"><i class="fa-solid fa-cart-shopping"></i> Ver Carrito
                        <?php
                        $carrito = session('cart', []);
                        $cantidad = 0;
                        foreach ($carrito as $item) {
                            $cantidad += $item['cantidad'];
                        }
                        ?>
                        <span class=""> - ({{ $cantidad }})</span>
                    </h6>
                </a>
                <?php
                $productosDisponibles = DB::table('producto')
                    ->where('estado_producto_id', '1')
                    ->get();
                ?>
                <h6 class="mb-0">Mostrando {{ $productos->count() }} de {{ count($productosDisponibles) }} productos</h6>

            </div>

            {{-- Filtros --}}
            <div class="col-sm-auto">
                <div class="row gx-2 align-items-center">
                    <div class="col-auto">
                        
                        <form class="row gx-2">
                            <div class="col-auto"><small>Ordenar por categoría:</small></div>
                            <div class="col-auto">
                                <form action="{{ route('productos.index') }}" method="get">
                                    <select name="categoria" id="categoria" class="form-select form-select-sm" aria-label="Bulk actions">
                                        <option value="0">Todas</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                @if ($categoria->id == $categoriaActual) selected @endif>
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

        </div>
    </div>
</div>

{{-- Tienda --}}
<div class="card mb-3" style="border: ridge 1px #ff1620;">

    <h6 class="card-body">Categoría:
        {{ $categoriaActual == 0 ? 'Todas' : $categoriaActualname->nombre }}</h6>
    <div>
        @if ($productos->count() == 0)
            <div class="card-body text-center">
                <h2 class="card-body">No hay productos en esta categoría <i class="far fa-folder-open"></i></h2>
            </div>
        @endif
    </div>

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
                                <a class="d-block" href="{{ route('tienda.show', $producto->slug) }}"><img class="rounded-top" src="{{ $imagen }}" alt="img-producto-thumbnail" /></a>
                                @if ($producto->etiqueta_destacado == 1) 
                                    <image src="{{url('assets/img/imgs/destacado.svg')}}" alt="destacado-seal-img-thumb" class="producto-destacado-thumb" />
                                @endif

                                @if ($producto->precio_oferta != null) 
                                    <image src="{{url('assets/img/imgs/oferta.svg')}}" alt="oferta-seal-img-thumb" class="producto-oferta-thumb" />
                                @endif
                            </div>

                            <div class="p-3">

                                <h5 style="min-height: 55px;" class="fs--1 text-start"><a class="text-dark" href="{{ route('tienda.show', $producto->slug) }}">{{ $producto->nombre }}</a></h5>

                                <span class="rt-color-2 font-weight-bold">OEM: </span>{{ $producto->OEM }}

                                <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                
                                <h5 class="fs-md-2 text-dark d-flex align-items-center mb-2">

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

                                <p class="fs--1 mb-2">Estado: <strong class="text-success">{{ $producto->estadoProducto->estado }}</strong></p>

                            </div>

                        </div>

                        <div class="d-flex flex-between-center px-2 flex-center">
                            <div class="d-flex">
                                <a class="btn btn-x btn-primary me-2"
                                    href="{{ route('tienda.show', $producto->slug) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ver producto"><i class="fa-regular fa-eye"></i>
                                    Ver Producto
                                </a>
                                <form method="post" action="{{ route('carrito.add') }}">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                    <input type="hidden" class="form-control" type="text" name="cantidad"
                                        value="1">
                                    <button type="submit" class="btn btn-x btn-falcon-default" href="#!"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Agregar al carrito"><span class="fas fa-cart-plus"></span>
                                    </button>
                                </form>
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
@endsection
