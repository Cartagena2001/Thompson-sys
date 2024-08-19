@extends('layouts.app')

@section('content')
@section('title', 'Crear Marca')

    {{-- Titulo --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">📟 Marcas de Productos 📟</h1>
                    <p class="mt-4 mb-4 text-center">Administración de las marcas de productos en venta en la Tienda <b>rtelsalvador.</b> Aquí podrás encontrar todas las marcas disponibles y gestionarlas.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/marcas') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default" style="border: ridge 1px #ff1620;">

        <div class="card-header pb-0">
            <h2 class="text-center" style="color:#ff161f;">Agregar Marca</h2>
            <p class="mt-4 text-center">Los campos que contengan un <b class="text-danger">*</b> son obligatorios.</p>
        </div>
      
        {{-- formuarlio --}}
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('marcas.store') }}" role="form" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf
                
                @include('marcas.form')
            </form>
        </div>

    </div>

@endsection
