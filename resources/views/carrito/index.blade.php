@extends('layouts.app')

@section('content')
@section('title', 'Carrito de compras')

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
                    <th>Producto</th>
                    <th class="text-center"># Cajas 📦</th>
                    <th class="text-center">Precio 📦</th>
                    <th class="text-center">Subtotal Parcial</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart', []) as $item)
                    <tr>
                        <td>{{ $item['producto_id'] }}</td>
                        <td>{{ $item['nombre'] }}</td>
                        <td>
                            <form action="{{ route('carrito.update', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="input-group" data-quantity="data-quantity">
                                        <input type="hidden" name="producto_id" value="{{ $item['producto_id'] }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-menos" type="button">-</button>
                                            <input class="btn btn-outline-secondary cantidad" type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['existencia'] }}" readonly>
                                            <button class="btn btn-outline-secondary btn-mas" type="button">+</button>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-sync-alt"></i> Actualizar cantidad
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td class="text-center">{{ number_format(($item['precio_f'] * $item['unidad_caja']), 2, '.', ','); }} $</td>
                        <td class="text-center">{{ number_format(($item['precio_f'] * $item['cantidad'] * $item['unidad_caja']), 2, '.', ','); }} $</td>
                        <td class="text-center">
                            <form action="{{ route('carrito.delete', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="producto_id" value="{{ $item['producto_id'] }}">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-trash-alt"></i> Eliminar producto</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <div class="d-flex justify-content-between">

        <div class="col-2">
            <div class="col-auto px-2 px-md-3 mt-3">
                <a class="btn btn-primary" href="{{ url('/dashboard/tienda') }}" style="width: 160px;">
                    <span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Seguir comprando</span>
                </a>
            </div>
            <div class="col-auto px-2 px-md-3 mt-3">
                <form action="{{ route('carrito.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 160px;"><i class="fas fa-trash-alt"></i> &nbsp;Vaciar carrito</button>
                </form>
            </div>
        </div>

        <div class="col-3">
            <div class="col-auto px-2 px-md-3 mt-3">
                @php
                    $total = 0;
                    $cart = session('cart', []);
                    foreach ($cart as $item) {
                        $total += $item['precio_f'] * $item['cantidad'] * $item['unidad_caja'];
                    }
                    echo '<h3 class="text-center">Subtotal: ' . number_format($total, 2, '.', ',') . ' $</h3>';
                @endphp
                <div class="col-auto px-2 px-md-3 mt-3 text-center">
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
    </script>
</div>

@endsection
