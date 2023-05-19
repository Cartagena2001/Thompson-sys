@extends('layouts.app')

@section('content')
@section('title', $producto->nombre)
{{-- Titulo --}}
<?php
//hacer un if para ver si el producto tiene imagen o no
if ($producto->imagen_1_src != null) {
    $imagen = "{$producto->imagen_1_src}";
} else {
    $imagen = '../../../assets/img/products/default.webp';
}

if ($producto->imagen_2_src != null) {
    $imagen2 = "{$producto->imagen_2_src}";
} else {
    $imagen2 = '../../../assets/img/products/default.webp';
}

if ($producto->imagen_3_src != null) {
    $imagen3 = "{$producto->imagen_3_src}";
} else {
    $imagen3 = '../../../assets/img/products/default.webp';
}

if ($producto->imagen_4_src != null) {
    $imagen4 = "{$producto->imagen_4_src}";
} else {
    $imagen4 = '../../../assets/img/products/default.webp';
}

//verificar si el producto tiene la etiqueta de destacado
if ($producto->etiqueta_destacado == 1) {
    $destacado = '¡Producto destacado!';
} else {
    $destacado = '';
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<div class="card mb-3">
    <div class="col-auto px-2 px-md-3 mt-3"><a class="btn btn-sm btn-primary" href="{{ url('/dashboard/tienda') }}"><span
                class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver
                atras</span></a></div>
    <div class="card-body mb-8">
        <div class="row">
            <div class="col-lg-6 mb-lg-0">
                <div class="product-slider" id="galleryTop">
                    <div class="swiper-slide h-100">
                        <div class="">
                            <div class="swiper mySwiper img-detalle-producto">
                                <div class="swiper-wrapper">
                                    <img class="swiper-slide img-fluid" src="{{ $imagen }}">
                                    <img class="swiper-slide img-fluid" src="{{ $imagen2 }}">
                                    <img class="swiper-slide img-fluid" src="{{ $imagen3 }}">
                                    <img class="swiper-slide img-fluid" src="{{ $imagen4 }}">
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100"
                                src="{{ $imagen2 }}" alt="" /></div>
                    </div>
                    <div class="col-4">
                        <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100"
                                src="{{ $imagen3 }}" alt="" /></div>
                    </div>
                    <div class="col-4">
                        <div class="swiper-slide h-100"><img class="rounded-1 fit-cover h-100 w-100"
                                src="{{ $imagen4 }}" alt="" /></div>
                    </div>
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
                <h2>{{ $producto->nombre }}</h2><a class="mb-2 d-block">
                    Categoria:
                    {{ $producto->categoria->nombre }}
                    <br>
                    Marca:
                    {{ $producto->marca->nombre }}</a>
                <span class="badge rounded-pill bg-info mt-2 mb-2 z-index-2 top-0 end-0">{{ $destacado }}</span>
                <p class="text-justify">{{ $producto->descripcion }}</p>
                <h3 class="d-flex align-items-center"><span style="color: #F3151E">$
                        {{ $producto->precio_1 }} C/Caja</span><span class="me-1 fs--1 text-500">
                    </span></h3>
                @if ($producto->unidad_por_caja == 0)
                    <h3 class="fs--1"><span style="color: #F3151E">Producto
                            agotado</span></h3>
                @else
                    <h3 class="fs--1"><span style="color: #F3151E">En Stock:
                            {{ $producto->unidad_por_caja }} Cajas</span></h3>
                @endif
                </h3>
                <span>• Unidad por caja: {{ $producto->unidad_por_caja }}</span>
                <br>
                <span>• Pais de origen: {{ $producto->origen }}</span>
                <br>
                <span>• Garantia: {{ $producto->garantia }}</span>
                <div class="row">
                    <form method="post" action="{{ route('carrito.add') }}">
                        @csrf
                        <div class="mb-2 mt-4">
                            <div class="input-group" data-quantity="data-quantity">
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-menos">-</button>
                                    <input class="btn btn-outline-secondary" type="number" name="cantidad"
                                        value="1" id="cantidad" min="1"
                                        max="{{ $producto->unidad_por_caja }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" id="btn-mas">+</button>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-x btn-primary" type="submit"> <span
                                class="fas fa-cart-plus me-sm-2"></span>Agregar al carrito</button>
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
