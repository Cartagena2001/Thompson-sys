@extends('layouts.app')

@section('content')
@section('title', 'Carrito de compras')
{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-8">
                <h3>🛒 Carrito de compras 🛒</h3>
                <p class="mt-2">Carrito de compras <b>para Thompson.</b> Aqui podras los productos que has agregado a
                    tu carrito de compras, podras editar la cantidad de cada producto antes de finalizar la compra.
            </div>
        </div>
    </div>
</div>
<div class="card card-body pt-0">
    <div class="table-responsive scrollbar">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart', []) as $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>
                            <form action="{{ route('carrito.update', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" name="producto_id" value="{{ $item['producto_id'] }}">
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                            min="1" max="1000" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-sync-alt"></i>Actualizar cantidad
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>{{ $item['precio_1'] }}</td>
                        <td>{{ $item['cantidad'] * $item['precio_1'] }}</td>
                        <td>
                            <form action="{{ route('carrito.delete', $item['producto_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="producto_id" value="{{ $item['producto_id'] }}">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <div class="d-flex justify-content-between">
        <div class="col-2">
            <div class="col-auto px-2 px-md-3 mt-3"><a class="btn btn-sm btn-primary"
                    href="{{ url('/dashboard/tienda') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span
                        class="d-none d-sm-inline-block">Seguir comprando!</span></a>
            </div>
            <div class="col-auto px-2 px-md-3 mt-3">
                <form action="{{ route('carrito.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-trash-alt"></i> Vaciar carrito
                    </button>
                </form>
            </div>
        </div>
        <div class="col-2">
            <div class="col-auto px-2 px-md-3 mt-3">
                @php
                    $total = 0;
                    $cart = session('cart', []);
                    foreach ($cart as $item) {
                        $total += $item['cantidad'] * $item['precio_1'];
                    }
                    echo '<h3 class="">Total: $' . $total . '</h3>';
                @endphp
                <div class="col-auto px-2 px-md-3 mt-3">
                    <form action="{{ route('carrito.validar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i> Finalizar compra
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>




</div>



@endsection
