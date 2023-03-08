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
                <h3>🛒 Orden Final 🛒</h3>
                <p class="mt-2">Carrito de compras <b>para Thompson.</b> Aqui podras los productos que has agregado a
                    tu carrito de compras, podras editar la cantidad de cada producto antes de finalizar la compra.
            </div>
        </div>
    </div>
</div>

{{-- mostrar el detalle de la orden que viene del carrito --}}
<div class="card card-body pt-0 col-6">
    <div class="table-responsive scrollbar">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart', []) as $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>{{ $item['precio_1'] }}</td>
                        <td>{{ $item['cantidad'] * $item['precio_1'] }}</td>
                    </tr>
                @endforeach
                @php
                    $total = 0;
                    $cart = session('cart', []);
                    foreach ($cart as $item) {
                        $total += $item['cantidad'] * $item['precio_1'];
                    }
                @endphp
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between">
        <div class="col-2">
            <div class="col-12">
                <h4>Total: ${{ $total }}</h4>
            </div>
        </div>
        <div class="col-2">
            <form action="{{ route('orden.store') }}" method="POST">
                @csrf
                <input type="hidden" name="total" value="{{ $total }}">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-check"></i> Finalizar Orden
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
