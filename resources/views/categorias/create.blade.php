@extends('layouts.app')

@section('content')
@section('title', 'Crear Categoria')

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">🗂️ Categorias de Productos 🗂️</h1>
                    <p class="mt-4 mb-4 text-center">Administración de las categorías de productos para Tienda <b>rtelsalvador.</b> Aquí podrás encontrar todas las categorías disponibles y gestionarlas.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/categorias') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default" style="border: ridge 1px #ff1620;">

        <div class="card-header pb-0">
            <h2 class="text-center" style="color:#ff161f;">Agregar Categoría</h2>
            <p class="mt-4 text-center">Los campos que contengan un <b class="text-danger">*</b> son obligatorios.</p>
        </div>
      
        {{-- formuarlio --}}
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('categorias.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                @include('categorias.form')
            </form>
        </div>

    </div>

@endsection
