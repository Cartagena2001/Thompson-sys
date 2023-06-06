@extends('layouts.app')

@section('content')
@section('title', 'Crear Producto')
{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">🏷️ Productos 🏷️</h1>
                <p class="mt-4 mb-4 text-center">Administracion de productos <b>para Thompson.</b> Aquí podrás encontrar todos los
                    productos y tener un control de cuantos productos hay en stock, cuanto falta de stock, editar,
                    agregar y eliminar.
                    <br>
                    <br>
                    Los campos que contengan un <b class="text-danger">*</b> son obligatorios.
            </div>

            <div class="text-center mb-4">
                <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/productos') }}">
                    <span class="fas fa-long-arrow-alt-left me-sm-2">
                    </span>
                    <span class="d-none d-sm-inline-block">
                        Volver Atrás
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- formuarlio --}}
<div class="card mb-3">
    <div class="mb-4 card-body">
            <h2 class="text-center" style="color:#ff161f;">Agregar Producto</h2>
            <hr/>
        <form method="POST" action="{{ route('productos.store') }}" role="form" enctype="multipart/form-data">
            @csrf
            @include('productos.form')
        </form>
    </div>
</div>
@endsection
