@extends('layouts.app')

@section('content')

@section('title', 'Catálogo')

{{-- Marcas --}}
<div class="card mb-3">

    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    
    <div class="card-body position-relative">
        <div class="row">

            <div id="brand-list" class="col-lg-12 flex-center">
                @foreach ($marcas as $brand)
                    
                    <img src="{{ $brand->logo_src }}" alt="img-{{ $brand->nombre }}" class="img-fluid logo-hov" style="cursor: pointer; max-width: 150px; margin: 0 auto;" id="mfp-{{ $brand->id }}" onclick="filterBrandPic(this.id)" />

                @endforeach
            </div>

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
                    <input class="form-control" type="text" name="busq" id="busq" value="" maxlength="20" placeholder="Buscar por OEM...">
                                                    
                    <div style="display: none;" class="mt-2">
                        <button id="btn-filter-brand" class="btn btn-sm btn-primary" type="submit"><i class="fas fa-filter"></i> Aplicar filtro</button>
                        {{-- <a href="{{ url('/dashboard/tienda') }}" class="btn btn-sm btn-primary" type="submit"><i class="fas fa-trash-alt"></i> Limpiar filtro</a> --}}
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
                                
                                <a tabindex="-1" class="d-block" href="{{ route('tienda.show', $producto->slug) }}">
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

                                <h5 style="min-height: 55px;" class="fs--1 text-start"><a tabindex="-1" class="text-dark" href="{{ route('tienda.show', $producto->slug) }}">{{ $producto->nombre }}</a></h5>

                                <span class="rt-color-2 font-weight-bold" style="font-size: 12px;">MARCA: </span><span style="font-size: 12px;">{{ $producto->marca->nombre }}</span>
                                <br/>
                                <span class="rt-color-2 font-weight-bold" style="font-size: 14px;">OEM: </span><span style="font-size: 14px;">{{ $producto->OEM }}</span>
                                <br/>
                                <span class="rt-color-2 font-weight-bold" style="font-size: 14px;">Unidades / 📦: </span><span style="font-size: 14px;">{{ $producto->unidad_por_caja }}</span>

                                <div class="row">

                                    <div class="col-12">
                                        <p class="fs--1 mt-2 mb-2"><a class="text-500">{{ $producto->categoria->nombre }}</a></p>
                                    </div>

                                </div>

                                <p class="fs--1 mb-2">Estado: <strong class="text-success">{{ $producto->estadoProducto->estado }}</strong></p>

                            </div>

                        </div>



                        <div class="row px-0 mx-1">

                            <div class="col-12 col-md-12 px-1 flex-center">

                                <a tabindex="-1" class="btn btn-x btn-primary me-0 px-2"
                                    href="{{ route('catalogo.show', $producto->slug) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Ir a">Ver Más <i class="fas fa-search-plus"></i>
                                </a>
 
                            </div>

                        </div>


                        <div class="d-flex flex-between-center px-2 " style="display: none !important;">

                            <div class="d-flex">

                                <a tabindex="-1" class="btn btn-x btn-primary me-2"
                                    href="{{ route('tienda.show', $producto->slug) }}" data-bs-toggle="tooltip"
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

