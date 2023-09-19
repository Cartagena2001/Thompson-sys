@extends('layouts.app')

@section('content')
@section('title', $producto->nombre)

{{-- Titulo --}}

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <style>

    .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .swiper {
      width: 100%;
      height: 300px;
      margin-left: auto;
      margin-right: auto;
    }

    .swiper-slide {
      background-size: cover;
      background-position: center;
    }

    .mySwiper2 {
      height: 80%;
      width: 100%;
    }

    .mySwiper {
      height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }

    .mySwiper .swiper-slide {
      width: 25%;
      height: 100%;
      opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
      opacity: 1;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    </style>

<div class="card mb-3" style="border: ridge 1px #ff1620;">


    <div class="col-auto px-2 px-md-3 mt-3 text-center">
        <a class="btn btn-sm btn-primary" href="javascript:history.back()"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
    </div>

    <hr/>

    <div class="card-body">

        <div class="row">

            <div class="col-lg-6">

                <div class="row mb-4" style="position: relative;" id="galleryTop"> {{-- product-slider --}}
                    

                        <div style="position: relative;">
                            
                            <div class="swiper mySwiper2">

                                <div class="swiper-wrapper">

                                        <div class="swiper-slide">
                                            <div class="swiper-zoom-container">
                                                <img class="img-fluid" src="{{ $imagen }}" alt="{{ $producto->nombre }}-1">
                                            </div>
                                        </div>

                                    @if ($producto->imagen_2_src != null)
                                        <div class="swiper-slide">
                                            <div class="swiper-zoom-container">
                                                <img class="img-fluid" src="{{ $producto->imagen_2_src }}" alt="{{ $producto->nombre }}-2">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($producto->imagen_3_src != null)
                                        <div class="swiper-slide">
                                            <div class="swiper-zoom-container">
                                                <img class="img-fluid" src="{{ $producto->imagen_3_src }}" alt="{{ $producto->nombre }}-3">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($producto->imagen_4_src != null)
                                        <div class="swiper-slide">
                                            <div class="swiper-zoom-container">
                                                <img class="img-fluid" src="{{ $producto->imagen_4_src }}" alt="{{ $producto->nombre }}-4">
                                            </div>
                                        </div>
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

                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <img src="{{ $imagen }}" alt="" />
                                    </div>

                                @if ($producto->imagen_2_src != null)
                                    
                                    <div class="swiper-slide">
                                        <img src="{{ $producto->imagen_2_src }}" alt="" />
                                    </div>

                                @endif

                                @if ($producto->imagen_3_src != null)

                                    <div class="swiper-slide">
                                        <img src="{{ $producto->imagen_3_src }}" alt="" />
                                    </div>

                                @endif

                                @if ($producto->imagen_4_src != null)

                                    <div class="swiper-slide">
                                        <img src="{{ $producto->imagen_4_src }}" alt="" />
                                    </div>

                                @endif

                                </div>
                            </div> 

                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

                <script>

                    var swiper = new Swiper(".mySwiper", {
                      spaceBetween: 10,
                      slidesPerView: 4,
                      freeMode: true,
                      watchSlidesProgress: true,
                    });

                    var swiper2 = new Swiper(".mySwiper2", {
                        loop: true,
                        zoom: true,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        spaceBetween: 10,
                        grabCursor: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        thumbs: {
                            swiper: swiper,
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

                @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

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

                @elseif ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

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

                @endif



                @if ($producto->existencia == 0)
                    <h3 class="fs--1"><span style="color: #F3151E">Producto Agotado</span></h3>
                @else
                    <h3 class="fs--1"><span style="color: #000">En Stock:</span> <span style="color: green;">Disponible</span></h3>
                @endif

                <span><b>• Unidades por caja:</b> {{ $producto->unidad_por_caja }}</span>
                <br>
                <span><b>• País de origen:</b> <span style="text-transform: capitalize;"> @if ( $producto->origen != null ) {{ $producto->origen }} @else - @endif</span></span>
                <br>
                <span><b>• Garantía:</b> {{ $producto->garantia }}</span>
                <br>


                @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 ) 

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

                @elseif ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

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

                @endif



            </div>
        </div>
    </div>
</div>

    @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 ) 

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

    @elseif ( Auth::user()->rol_id == 2 && $cat_mod == 0 )

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
    
    @endif

@endsection
