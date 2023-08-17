@extends('layouts.app')

@section('content')
@section('title', 'Carrito de compras')

{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">📑 Detalle de Órden de Compra 📑</h1>
                <p class="mt-4 mb-4 text-center">Aquí podrás ver el detalle de tu órden de compra y el monto total a pagar antes del despacho.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- mostrar el detalle de la orden que viene del carrito --}}
<div class="card card-body pt-3 col-12" style="border: ridge 1px #ff1620;">

    <div class="table-responsive scrollbar">

        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Producto</th>
                    <th class="text-center"># Cajas 📦</th>
                    <th class="text-center">Precio 📦</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">Subtotal Parcial</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart', []) as $item)
                    <tr>
                        <td class="text-center">{{ $item['producto_id'] }}</td>
                        <td>{{ $item['nombre'] }}</td>
                        <td class="text-center">{{ $item['cantidad'] }}</td>
                        <td class="text-center">{{ number_format(($item['precio_f'] * $item['unidad_caja']), 2, '.', ','); }} $</td> 
                        <td class="text-center">{{ number_format($item['precio_f'], 2, '.', ','); }} $</td> 
                        <td class="text-center">{{ number_format(($item['precio_f'] * $item['cantidad'] * $item['unidad_caja']), 2, '.', ','); }} $</td> 
                    </tr>
                @endforeach
                @php
                    $subtotal = 0;
                    $iva = 0.13;
                    $total = 0;

                    $cart = session('cart', []);
                    foreach ($cart as $item) {
                        $subtotal += $item['precio_f'] * $item['cantidad'] * $item['unidad_caja'];
                    }

                    $total = $subtotal + ($subtotal * $iva);
                @endphp
                    <tr class="mt-3" style="border-top: solid 2px #ff161f;">
                        <td class="text-center"></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td> 
                        <td class="text-start" style="font-weight: 600;">Subtotal:</td> 
                        <td class="text-end">{{ number_format($subtotal, 2, '.', ',');  }} $</td> 
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td> 
                        <td class="text-start" style="font-weight: 600;">IVA (13%):</td> 
                        <td class="text-end">{{ number_format(($subtotal * $iva), 2, '.', ',');  }} $</td> 
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td> 
                        <td class="text-start" style="font-weight: 600;">Total:</td> 
                        <td class="text-end">{{ number_format($total, 2, '.', ',');  }} $</td> 
                    </tr>
            </tbody>
        </table>

    </div>

    <br/>
    <br/>

    <div class="d-flex justify-content-between">

        {{-- 
        <div class="col-2">
            <div class="col-12">
                <h4>Total: ${{ $total }}</h4>
            </div>
        </div>
        --}}

        <div class="col-2 offset-10">
            <form action="{{ route('orden.store') }}" method="POST">
                @csrf
                <input type="hidden" name="total" value="{{ $total }}">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-check"></i> Finalizar Órden
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
