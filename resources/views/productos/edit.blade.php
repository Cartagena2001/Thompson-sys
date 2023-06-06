@extends('layouts.app')

@section('content')
@section('title', 'Edtirar Producto')
    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
        </div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🏷️ Productos 🏷️</h1>
                    <p class="mt-4 mb-4 text-center">Administracion de productos <b>para Thompson.</b> Aqui podras encontrar todas los
                        productos, y tener un control como cuantos productos hay en stock, cuandos falta de stock, editar,
                        agregar e eliminar.
                        <br>
                        <br>
                        Los campos que contengan un <b class="text-danger">*</b> son obligatorios.
                </div>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h2 class="text-center" style="color:#ff161f;">Actualizar Producto</h2>
            <hr/>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('productos.update', $producto->id) }}"  role="form" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf

                @include('productos.form')

            </form>
        </div>
    </div>
@endsection
