@extends('layouts.app')

@section('content')
    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
        </div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-8">
                    <h3>📟 Marcas de productos 📟</h3>
                    <p class="mt-2">Administracion de marcas <b>para Thompson.</b> Aqui podras encontrar todas las
                        marcas que pertencen a los productos, podras ordenarlos por nombre y por cantidad.
                </div>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Actualizar marca</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('marcas.update', $marca->id) }}"  role="form" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf

                @include('marcas.form')

            </form>
        </div>
    </div>
@endsection
