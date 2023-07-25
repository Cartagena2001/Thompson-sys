@extends('layouts.app')

@section('content')

@section('title', 'Gracias por su compra')

{{-- Titulo --}}
<div class="m-0 vh-100 row justify-center align-items-center text-center">
    <div class="col-12">
        <h3>🛒 Gracias por su compra 🛒</h3>
        <p class="mt-2">Gracias por su compra en<b> Thompson.</b> Tu orden esta siendo procesada, puedes ver el estado de tu orden en la seccion de ordenes.
        </p>
        <a class="btn btn-sm btn-primary" href="{{ route('tienda.index') }}">Volver a la tienda!</a>
    </div>
</div>
@endsection
