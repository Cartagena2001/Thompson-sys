@extends('layouts.app')

@section('content')
@section('title', 'Registrar Usuario')

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">👥 Usuarios de RT 👥</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección podrás registrar nuevos usuarios del Sistema RT.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/configuracion/users') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-default" style="border: ridge 1px #ff1620;">

        <div class="card-header">
            <h2 class="text-center" style="color:#ff161f;">Registrar Usuario</h2>
            <p class="mt-4 mb-4 text-center">Los campos que contengan un <b class="text-danger">*</b> son obligatorios.</p>
            <hr/>
        </div>

        {{-- formuarlio --}}
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}" role="form" enctype="multipart/form-data">
                @csrf
               {{-- @include('config.form') --}} 
            </form>
        </div>

    </div>

@endsection
