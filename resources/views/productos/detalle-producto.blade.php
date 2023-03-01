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
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <div class="card mb-3">
        <div class="col-auto px-2 px-md-3 mt-3"><a class="btn btn-sm btn-primary" href="{{ url('/dashboard/tienda') }}"><span
            class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver atras</span></a></div>
        <div class="card-body mb-8">
            <div class="row">
                <div class="col-lg-6 mb-lg-0">
                    <div class="product-slider" id="galleryTop">
                        <div class="swiper-slide h-100">
                            <div>
                                <div class="swiper mySwiper">
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
                    <h5>{{ $producto->nombre }}</h5><a class="fs--1 mb-2 d-block">{{ $producto->categoria->nombre }}</a>
                    <p>{{ $producto->descripcion }}</p>
                    <h4 class="d-flex align-items-center"><span class="text-warning me-2">$
                            {{ $producto->precio_1 }}</span><span class="me-1 fs--1 text-500">
                        </span></h4>
                    <p class="fs--1">Stock: <strong class="text-success">{{ $producto->estadoProducto->estado }}</strong>
                    </p>
                    <div class="row">
                        <div class="col-auto pe-0">
                            <div class="input-group input-group-sm" data-quantity="data-quantity">
                                <button class="btn btn-sm btn-outline-secondary border-300" data-field="input-quantity"
                                    data-type="minus">-</button>
                                <input class="form-control text-center input-quantity input-spin-none" type="number"
                                    min="0" value="0" aria-label="Amount (to the nearest dollar)"
                                    style="max-width: 50px" />
                                <button class="btn btn-sm btn-outline-secondary border-300" data-field="input-quantity"
                                    data-type="plus">+</button>
                            </div>
                        </div>
                        <div class="col-auto px-2 px-md-3"><a class="btn btn-sm btn-primary" href="#!"><span
                                    class="fas fa-cart-plus me-sm-2"></span><span class="d-none d-sm-inline-block">Agregar
                                    al carrito</span></a></div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-12">
                    <div class="overflow-hidden mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active ps-0" id="description-tab" data-bs-toggle="tab"
                                    href="#tab-description" role="tab" aria-controls="tab-description"
                                    aria-selected="true">Descripcion</a></li>
                            <li class="nav-item"><a class="nav-link px-2 px-md-3" id="specifications-tab"
                                    data-bs-toggle="tab" href="#tab-specifications" role="tab"
                                    aria-controls="tab-specifications" aria-selected="false">Especificaciones</a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="mt-3">
                                    <p>{{ $producto->descripcion }}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-specifications" role="tabpanel"
                                aria-labelledby="specifications-tab">
                                <div class="mt-3">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="row mt-3">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="mb-1"><span class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="ms-3 text-dark fw-semi-bold">Awesome support, great code 😍</span>
                                        </div>
                                        <p class="fs--1 mb-2 text-600">By Drik Smith • October 14, 2019</p>
                                        <p class="mb-0">You shouldn't need to read a review to see how nice and polished
                                            this theme is. So I'll tell you something you won't find in the demo. After the
                                            download I had a technical question, emailed the team and got a response right
                                            from the team CEO with helpful advice.</p>
                                        <hr class="my-4" />
                                        <div class="mb-1"><span class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star-half-alt text-warning star-icon fs--1"></span><span
                                                class="ms-3 text-dark fw-semi-bold">Outstanding Design, Awesome
                                                Support</span>
                                        </div>
                                        <p class="fs--1 mb-2 text-600">By Liane • December 14, 2019</p>
                                        <p class="mb-0">This really is an amazing template - from the style to the font -
                                            clean layout. SO worth the money! The demo pages show off what Bootstrap 4 can
                                            impressively do. Great template!! Support response is FAST and the team is
                                            amazing - communication is important.</p>
                                    </div>
                                    <div class="col-lg-6 ps-lg-5">
                                        <form>
                                            <h5 class="mb-3">Write your Review</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Ratting: </label>
                                                <div class="d-block" data-rater='{"starSize":32,"step":0.5}'></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupNameInput">Name:</label>
                                                <input class="form-control" id="formGroupNameInput" type="text" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupEmailInput">Email:</label>
                                                <input class="form-control" id="formGroupEmailInput" type="email" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGrouptextareaInput">Review:</label>
                                                <textarea class="form-control" id="formGrouptextareaInput" rows="3"></textarea>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
