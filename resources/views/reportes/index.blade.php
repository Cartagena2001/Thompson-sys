@extends('layouts.app')

@section('content')
@section('title', 'Reportes')


{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">🗃 Reportes del Sistema 🗃</h1>
                <p class="mt-4 mb-4 text-center">En esta seccion podras ver los reportes del sistema.</p>
            </div>
        </div>
    </div>
</div>




{{-- Cards de informacion --}}
<div class="card mb-3 p-5">

    <div class="col-lg-8">
        <p class="mt-2">⚠️ ℹ️ En esta seccion podras ver los reportes del sistema.</p>
    </div>

    <div class="row g-3 mb-3 gap-5 mt-2">
        <div class="card mb-3 col-3">
            <div class="card-body">
                <div class="mt-1">
                    <h5>Reportes de Productos</h5>
                    <span>Obten los reporte de tus productos en formato Excel</span>
                </div>
                <div class="mt-1">
                    <a href="{{ url('/dashboard/reportes/productos') }}" class="btn btn-primary">Generar reporte</a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col-6">
            <div class="mt-1 card-body">
                <h5>Reporte de Clientes</h5>
                <span>Obtén los reportes de tus clientes, aspirantes o clientes rechazados, en formato Excel</span>
                <form action="{{ url('/dashboard/reportes/clientes') }}" method="GET">
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="aprobado">Clientes</option>
                            <option value="aspirante">Aspirantes</option>
                            <option value="rechazado">Rechazado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Generar reporte</button>
                </form>
            </div>
        </div>
        <div class="card mb-3 col-3">
            <div class="card-body">
                <div class="mt-1">
                    <h5>Reportes de marcas</h5>
                    <span>Obten los reporte de tus marcas que estan registradas en tu sistema en formato Excel</span>
                </div>
                <div class="mt-1">
                    <a href="{{ url('/dashboard/reportes/marcas') }}" class="btn btn-primary">Generar reporte</a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col-3">
            <div class="card-body">
                <div class="mt-1">
                    <h5>Reportes de categorias</h5>
                    <span>Obten los reporte de tus categorias que estan registradas en tu sistema en formato
                        Excel</span>
                </div>
                <div class="mt-1">
                    <a href="{{ url('/dashboard/reportes/categorias') }}" class="btn btn-primary">Generar reporte</a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col-4">
            <div class="card-body">
                <h5>Reportes de ordenes</h5>
                <span>Obten los reporte de tus ordenes que estan registradas en tu sistema en formato Excel</span>
                <form action="{{ url('/dashboard/reportes/ordenes') }}" method="GET">
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estadoOrden" id="estadoOrden" class="form-control">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">Progreso</option>
                            <option value="Finalizada">Finazliada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Generar reporte</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
