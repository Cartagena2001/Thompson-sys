@extends('layouts.app')

@section('content')

@section('title', 'Gracias por su compra')

{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">🤝 Tu órden ha sido recibida 🤝</h1>
                <div class="col-auto flex-center mb-3">
                    <image src="{{url('assets/img/imgs/truck-cargo.gif')}}" alt="sent-img" class="img-fluid" style="width: 400px;" />
                </div>
                <p class="mt-4 mb-4 text-center">Tu órden será procesada en breve, puedes consultar el estado de la misma en la sección "Mis Órdenes", también recibirás actualizaciones de su proceso por correo electrónico.
                </p>
                <a class="btn btn-sm btn-primary" style="width: 200px; display: block; margin: 0 auto;" href="{{ route('tienda.index') }}">Seguir comprando 🛒</a>
            </div>
        </div>
    </div>
</div>

@endsection
