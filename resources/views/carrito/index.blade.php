@extends('layouts.app')

@section('content')
@section('title', 'Carrito de compras')

<style type="text/css">

    table {
      border-collapse: collapse;
      min-width: 800px !important;
      width: 100% !important;
    }

    table {
        display: flex;
        flex-flow: column;
        min-width: 800px !important;
        width: 100% !important;
        min-height: 250px;
        
    }

    thead {
        padding-right: 13px;
        flex: 0 0 auto;
    }

    tfoot {
        padding-right: 13px;
        flex: 0 0 auto;
    }

    tbody {
        flex: 1 1 auto;
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
    }

    tr {
        min-width: 800px !important;
        width: 100% !important;
        display: table;
        table-layout: fixed;
    }        

</style>

{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">🛒 Carro de Compras 🛒</h1>
                <p class="mt-4 mb-4 text-center">Aquí encontrarás todos los productos que has agregado a
                    tu carrito desde el catálogo, también podrás editar la cantidad requerida de c/producto antes de finalizar la compra.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card card-body pt-3 col-12" style="border: ridge 1px #ff1620;">
    
    <div class="table-responsive scrollbar mb-6">
        
        <table class="table">
            <thead>
                @if (session('cart', []) == [])
                    <div class="alert alert-warning mt-4" role="alert">
                        <h4 class="alert-heading">Carrito vacio</h4>
                        <p>El carrito de compras está vacío, puedes agregar productos a tu carrito haciendo clic en el botón <b>"Agregar al carrito"</b> que se encuentra en la página de cada producto.</p>
                        <hr>
                        <p class="mb-0">Ve a la página de productos haciendo clic <a href="{{ url('/dashboard/tienda') }}">aquí</a>.</p>
                    </div>
                @endif
                <tr>
                    <th>ID</th>
                    <th>OEM</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th class="text-center"># Cajas 📦</th>
                    <th class="text-center">Precio 📦</th>
                    <th class="text-center">Subtotal Parcial</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart', []) as $item)
                    <tr>
                        <td style="font-size: 10px">{{ $item['producto_id'] }}</td>
                        <td style="font-size: 10px">{{ $item['producto_oem'] }}</td>
                        <td style="font-size: 10px">{{ $item['nombre'] }}</td>
                        <td style="font-size: 10px">{{ $item['marca'] }}</td>
                        <td style="font-size: 10px" class="flex-center">
                            <form action="{{ route('carrito.update', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="input-group" data-quantity="data-quantity">
                                        <input type="hidden" id="{{ $item['producto_id'] }}" name="producto_id" value="{{ $item['producto_id'] }}">
                                        <div class="flex-center"> {{-- input-group-append --}}
                                            
                                           {{-- <button class="btn btn-outline-secondary btn-menos" type="button">-</button> --}}
                                            
                                            <input id="cantidad_{{ $item['producto_id'] }}" class="btn btn-outline-secondary cantidad px-2" type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['existencia'] }}" {{-- onchange="udpCarrito(this.id)" --}} >
                                            
                                           {{--<button class="btn btn-outline-secondary btn-mas" type="button">+</button> --}}
                                            
                                           <button style="height: 35px; border-radius: 6px;" type="submit" class="btn btn-sm btn-primary ms-1" title="Actualizar cantidad"><i class="fas fa-sync-alt"></i></button> 
                                            
                                        </div>
                                        <br/>
                                        @error('cantidad')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td style="font-size: 10px" class="text-center">{{ number_format(($item['precio_f'] * $item['unidad_caja']), 2, '.', ','); }} $</td>
                        <td style="font-size: 10px" class="text-center">{{ number_format(($item['precio_f'] * $item['cantidad'] * $item['unidad_caja']), 2, '.', ','); }} $</td>
                        <td style="font-size: 10px" class="text-center">
                            <form action="{{ route('carrito.delete', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="producto_id" value="{{ $item['producto_id'] }}">
                                <button style="height: 35px; border-radius: 6px;" type="submit" class="btn btn-sm btn-primary" title="Quitar producto"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <div class="d-flex justify-content-between">

        <div class="col-4 col-sm-6 col-lg-6">
            <div class="col-auto px-2 px-md-3 mt-3">
                <a class="btn btn-primary" href="javascript:history.back()" style="width: 150px;">
                    <span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Seguir comprando</span>
                </a>
            </div>
            <div class="col-auto px-2 px-md-3 mt-3">
                <form action="{{ route('carrito.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 150px;"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline-block">&nbsp;Vaciar carrito</span></button>
                </form>
            </div>
        </div>

        <div class="col-8 col-sm-6 col-lg-6">
            <div class="col-auto px-2 px-md-3 mt-3">
                @php
                    $total = 0;
                    $cart = session('cart', []);
                    foreach ($cart as $item) {
                        $total += $item['precio_f'] * $item['cantidad'] * $item['unidad_caja'];
                    }
                    echo '<h3 class="text-end" style="font-size: 22px;">Subtotal:</br/> ' . number_format($total, 2, '.', ',') . ' US$</h3>';
                @endphp
                <div class="col-auto px-2 px-md-3 mt-3 text-end">
                    <form action="{{ route('carrito.validar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Finalizar compra
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>

        /*
        var btnMas = document.querySelectorAll('.btn-mas');
        var btnMenos = document.querySelectorAll('.btn-menos');
        var inputCantidad = document.querySelectorAll('.cantidad');

        for (var i = 0; i < btnMas.length; i++) {
            btnMas[i].addEventListener('click', function() {
                var valorActual = parseInt(this.previousElementSibling.value);
                if (valorActual < parseInt(this.previousElementSibling.max)) {
                    this.previousElementSibling.value = valorActual + 1;
                }
            });
        }

        for (var i = 0; i < btnMenos.length; i++) {
            btnMenos[i].addEventListener('click', function() {
                var valorActual = parseInt(this.nextElementSibling.value);
                if (valorActual > parseInt(this.nextElementSibling.min)) {
                    this.nextElementSibling.value = valorActual - 1;
                }
            });
        }
        */


        function updtCarrito(cant_id) {

            var qty = $('#'+cant_id).val();
            var prodid = cant_id.slice(cant_id.indexOf('_') + 1);
            
            //console.log(prodid);

            $.ajax({
                url: "{{ route('carrito.update',"+prodid+") }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&cantidad=" + qty + "&producto_id=" + prodid,

                success: function(response){
                    $('#successMsg').show();
                    //console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.qty);
                    $('#ErrorMsg2').text(response.responseJSON.errors.prodid);
                },
            });
            
        }

    </script>
</div>

@endsection
