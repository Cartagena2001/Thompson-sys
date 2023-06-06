@extends('layouts.app')

@section('content')
@section('title', 'Reportes')
{{-- Cards de informacion --}}
<div class="card mb-3 p-5">
    <div class="col-lg-8">
        <h3>📃 Reporte del sistema 📃</h3>
        <p class="mt-2">
            En esta seccion podras ver los reportes del sistema.
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
    </div>
</div>
@endsection