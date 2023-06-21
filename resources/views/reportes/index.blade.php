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
                    <p class="mt-4 mb-4 text-center">En esta sección podrás ver y exportas los diferentes reportes de las actividades en el sistema.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3 p-5">

        <div class="col-lg-12">
            <p class="mt-2">🖨 Reportes del sistema:</p>
        </div>

        <div class="row mb-3 mt-2">

            <div class="card mb-3 col-12">
                <div class="card-body">
                    <div class="mt-1 mb-3 text-center">
                        <h5 class="mb-2">🚛 Reportes de Productos</h5>
                        <span>Obtén el reporte de tus productos en formato Excel.</span>
                    </div>
                    <div class="mt-1 text-center">
                        <a href="{{ url('/dashboard/reportes/productos') }}" class="btn btn-primary">Generar reporte</a>
                    </div>
                </div>
            </div>

            <div class="card mb-3 col-12">
                <div class="mt-1 card-body text-center">
                    
                    <h5 class="mb-2">🗃 Reporte por Clientes</h5>
                    <span class="mb-3">Obtén los reportes de tus clientes, aspirantes o clientes rechazados, en formato Excel.</span>
                    
                    <form action="{{ url('/dashboard/reportes/clientes') }}" method="GET">
                        <div class="form-group mt-2 mb-3">
                            <label style="font-size: 15px;" for="estado">Estado:</label>
                            <div class="flex-center">
                                <select name="estado" id="estado" class="form-control w-25">
                                    <option value="aprobado">Clientes</option>
                                    <option value="aspirante">Aspirantes</option>
                                    <option value="rechazado">Rechazado</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Generar reporte</button>
                    </form>

                </div>
            </div>

            <div class="card mb-3 col-12">
                <div class="mt-1 card-body text-center">

                    <div class="mt-1 mb-3">
                        <h5 class="mb-2">🔖 Reporte por Marcas</h5>
                        <span>Obtén el reporte de según marcas que están registradas en el sistema en formato Excel.</span>
                    </div>

                    <div class="mt-1">
                        <a href="{{ url('/dashboard/reportes/marcas') }}" class="btn btn-primary">Generar reporte</a>
                    </div>
                </div>
            </div>

            <div class="card mb-3 col-12">
                <div class="mt-1 card-body text-center">

                    <div class="mt-1 mb-3">
                        <h5>🗂 Reporte por Categorías</h5>
                        <span>Obtén el reporte según categorías que estan registradas en el sistema en formato Excel.</span>
                    </div>
                    <div class="mt-1">
                        <a href="{{ url('/dashboard/reportes/categorias') }}" class="btn btn-primary">Generar reporte</a>
                    </div>

                </div>
            </div>

            <div class="card mb-3 col-12">
                <div class="mt-1 card-body text-center">

                    <h5>📥 Reportes por Órdenes</h5>
                    <span class="mb-3">Obtén el reporte de las órdenes que están registradas en el sistema en formato Excel.</span>
                    
                    <form action="{{ url('/dashboard/reportes/ordenes') }}" method="GET">
                        <div class="form-group mb-3 mt-2">
                            <label style="font-size: 15px;" for="estadoOrden">Estado:</label>
                            <div class="flex-center">
                                <select name="estadoOrden" id="estadoOrden" class="form-control w-25">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En proceso">Progreso</option>
                                    <option value="Finalizada">Finazliada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Generar reporte</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection
