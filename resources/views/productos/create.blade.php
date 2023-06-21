@extends('layouts.app')

@section('content')
@section('title', 'Crear Producto')

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🏷️ Productos 🏷️</h1>
                    <p class="mt-4 mb-4 text-center">Administración de productos para Tienda <b>rtelsalvador.</b> Aquí podrás encontrar todos los
                    productos disponibles y gestionar las existencias, editar,
                    agregar y desactivar productos.
                    </p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/productos') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-default" style="border: ridge 1px #ff1620;">

        <div class="card-header">
            <h2 class="text-center" style="color:#ff161f;">Agregar Producto</h2>
            <p class="mt-4 mb-4 text-center">Los campos que contengan un <b class="text-danger">*</b> son obligatorios.</p>
            <hr/>
        </div>

        {{-- formuarlio --}}
        <div class="card-body">
            <form method="POST" action="{{ route('productos.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                @include('productos.form')
            </form>
        </div>

    </div>

@endsection
