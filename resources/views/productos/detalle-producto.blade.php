@extends('layouts.app')

@section('content')
@section('title', $producto->nombre)

{{-- Titulo --}}

<?php
//hacer un if para ver si el producto tiene imagen o no
if ($producto->imagen_1_src != null) {
    $imagen = "{$producto->imagen_1_src}";
} else {
    $imagen = '../../../assets/img/products/demo-product-img.jpg';
}


?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>



<div class="card mb-3" style="border: ridge 1px #ff1620;">


    <div class="col-auto px-2 px-md-3 mt-3 text-center">
        <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/tienda') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
    </div>

    <hr/>

    <div class="card-body">

        <div class="row">

            <div class="col-lg-6">

                <div class="row mb-4" style="position: relative;" id="galleryTop"> {{-- product-slider --}}
                    <div class="swiper-slide">
                        <div style="position: relative;">
                            
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">

                                        <!--<a href="{{ $imagen }}" data-lightbox="image-1" data-title="p-img-1">--><img class="swiper-slide img-fluid" src="{{ $imagen }}" alt="{{ $producto->nombre }}-1"><!--</a>-->
                                    @if ($producto->imagen_2_src != null)
                                        <!--<a href="{{ $producto->imagen_2_src }}" data-lightbox="image-2" data-title="p-img-2">--><img class="swiper-slide img-fluid" src="{{ $producto->imagen_2_src }}" alt="{{ $producto->nombre }}-2"><!--</a>-->
                                    @endif
                                    @if ($producto->imagen_3_src != null)
                                        <a href="{{ $producto->imagen_3_src }}" data-lightbox="image-3" data-title="p-img-3"><img class="swiper-slide img-fluid" src="{{ $producto->imagen_3_src }}" alt="{{ $producto->nombre }}-3"></a>
                                    @endif

                                    @if ($producto->imagen_4_src != null)
                                        <a href="{{ $producto->imagen_4_src }}" data-lightbox="image-4" data-title="p-img-4"><img class="swiper-slide img-fluid" src="{{ $producto->imagen_4_src }}" alt="{{ $producto->nombre }}-4"></a>
                                    @endif

                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>

                            @if ($producto->etiqueta_destacado == 1) 
                                <image src="{{url('assets/img/imgs/destacado.svg')}}" alt="destacado-seal-img" class="producto-destacado" />
                            @endif

                            @if ($producto->precio_oferta != null) 
                                <image src="{{url('assets/img/imgs/oferta.svg')}}" alt="oferta-seal-img" class="producto-oferta" />
                            @endif 

                        </div>
                    </div>
                </div>

                <div class="row">
                    @if ($producto->imagen_2_src != null)
                        <div class="col-4">
                            <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100" src="{{ $producto->imagen_2_src }}" alt="" /></div>
                        </div>
                    @endif

                    @if ($producto->imagen_3_src != null)
                        <div class="col-4">
                            <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100" src="{{ $producto->imagen_3_src }}" alt="" /></div>
                        </div>
                    @endif
                    @if ($producto->imagen_4_src != null)
                        <div class="col-4">
                            <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100" src="{{ $producto->imagen_4_src }}" alt="" /></div>
                        </div>
                    @endif
                </div>

                <script>
                    var swiper = new Swiper(".mySwiper", {
                        loop: true,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        grabCursor: true,
                        autoplay: {
                            delay: 2500,
                            disableOnInteraction: false
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                    });
                </script>

            </div>

            <div class="col-lg-6">

                <h3>{{ $producto->nombre }}</h3>

                <hr />

                <div class="mt-3 mb-3 d-block">
                    <span class="rt-color-2 font-weight-bold">OEM: </span> <a href="#" target="_self" title="Ver">{{ $producto->OEM }}</a>
                    <br/>
                    <span class="rt-color-2 font-weight-bold">Categoría: </span> <a href="#" target="_self" title="Ver">{{ $producto->categoria->nombre }}</a>
                    <br/>
                    <span class="rt-color-2 font-weight-bold">Marca: </span> <a href="#" target="_self" title="Ver">{{ $producto->marca->nombre }}</a>
                </div>

                

                <div class="mt-3 mb-3 d-block">
                    <span class="rt-color-2 font-weight-bold">Descripción: </span>
                    <p class="text-justify mb-4 line-height: 28px;" style="white-space: pre-wrap; margin-right: 25px;">{{ $producto->descripcion }}</p>
                </div>

                @if ( $producto->caracteristicas != null && $producto->caracteristicas != ' ' )
                <div class="mt-3 mb-3 d-block">
                    <span class="rt-color-2 font-weight-bold">Características: </span>
                    <p class="text-justify mb-4 line-height: 28px;" style="white-space: pre-wrap; margin-right: 25px;">{{ $producto->caracteristicas }}</p>
                </div>
                @endif

                <div class="mt-3 mb-4 d-block">
                    @if( $producto->ficha_tecnica_href != null )
                        <span class="rt-color-2 font-weight-bold">🧾️ Ficha Técnica: <a href="{{ $producto->ficha_tecnica_href }}" title="Leer" target="_blank">ver pdf</a></span>
                        <br/> 
                    @endif

                    @if( $producto->hoja_seguridad != null )
                        <span class="rt-color-2 font-weight-bold">📋 Hoja de Seguridad: <a href="{{ $producto->hoja_seguridad }}" title="Leer" target="_blank">ver pdf</a></span>
                    @endif
                </div>

                <h3 class="d-flex align-items-center">
                    <span style="color: #F3151E">

                        @if ($producto->precio_oferta != null)                        
                            $ {{ $producto->precio_oferta * $producto->unidad_por_caja }}

                        @elseif (Auth::user()->clasificacion == 'Cobre')
                            $ {{ $producto->precio_1 * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Plata')
                            $ {{ $producto->precio_1 * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Oro')
                            $ {{ $producto->precio_2 * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Platino')
                            $ {{ $producto->precio_3 * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Diamante')
                            $ {{ $producto->precio_oferta * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Taller')
                            $ {{ $producto->precio_taller * $producto->unidad_por_caja }}
                        @elseif (Auth::user()->clasificacion == 'Reparto')
                            $ {{ $producto->precio_distribuidor * $producto->unidad_por_caja }}
                        @endif
                        <span class="rt-color-2">c/caja</span>
                    </span>
                    <span class="me-1 fs--1 text-500"></span>
                </h3>
                <span class="d-flex align-items-center mb-4">
                    <span style="color: #F3151E">

                        @if ($producto->precio_oferta != null)                        
                            $ {{ $producto->precio_oferta }}

                        @elseif (Auth::user()->clasificacion == 'Cobre')
                            $ {{ $producto->precio_1}}
                        @elseif (Auth::user()->clasificacion == 'Plata')
                            $ {{ $producto->precio_1 }}
                        @elseif (Auth::user()->clasificacion == 'Oro')
                            $ {{ $producto->precio_2}}
                        @elseif (Auth::user()->clasificacion == 'Platino')
                            $ {{ $producto->precio_3}}
                        @elseif (Auth::user()->clasificacion == 'Diamante')
                            $ {{ $producto->precio_oferta}}
                        @elseif (Auth::user()->clasificacion == 'Taller')
                            $ {{ $producto->precio_taller}}
                        @elseif (Auth::user()->clasificacion == 'Reparto')
                            $ {{ $producto->precio_distribuidor}}
                        @endif
                        <span class="rt-color-2">c/producto</span>
                    </span>
                    <span class="me-1 fs--1 text-500"></span>
                </span>

                @if ($producto->existencia == 0)
                    <h3 class="fs--1"><span style="color: #F3151E">Producto Agotado</span></h3>
                @else
                    <h3 class="fs--1"><span style="color: #F3151E">En Stock: {{ $producto->existencia }} Cajas 📦</span></h3>
                @endif

                <span><b>• Unidades por caja:</b> {{ $producto->unidad_por_caja }}</span>
                <br>
                <span><b>• País de origen:</b> <span style="text-transform: capitalize;">{{ $producto->origen }}</span></span>
                <br>
                <span><b>• Garantía:</b> {{ $producto->garantia }}</span>
                <br>

                <div class="row">
                    
                    <form method="post" action="{{ route('carrito.add') }}">
                        @csrf
                        <div class="mb-2 mt-4">
                            <span class="fs--1 text-500">Cantidad de cajas a ordenar:</span>
                            
                            <div class="input-group" data-quantity="data-quantity">              
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-menos">-</button>
                                    <input class="btn btn-outline-secondary" type="number" name="cantidad" value="1" id="cantidad" min="1" max="{{ $producto->unidad_por_caja }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" id="btn-mas">+</button>
                                </div>
                            </div>
                            
                        </div>

                        <button class="btn btn-x btn-primary" type="submit"><span class="fas fa-cart-plus me-sm-2"></span>Agregar al Carrito</button>

                    </form>

                </div>

            </div>
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

@endsection
