@extends('layouts.app')

@section('content')
@section('title', 'Orden # ' . $orden->id)
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js">
</script>
{{-- Titulo --}}
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <div class="card-body position-relative mt-4">
        <div class="row">
            <div class="col-lg-8">
                <h3>🏷️ Ordenes 🏷️</h3>
                <p class="mt-2">Administracion de ordenes <b>para Thompson.</b> Aqui podras encontrar todas las
                    ordenes, podras ver el estado de cada orden, y podras editarlas.
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/ordenes') }}">
                    <span class="fas fa-long-arrow-alt-left me-sm-2">
                    </span>
                    <span class="d-none d-sm-inline-block">
                        Volver atras
                    </span>
                </a>
                <button id="imprimir_btn" class="btn btn-sm btn-primary" type="button"><i class="fas fa-print"></i> Imprimir detalle de la orden</button>
            </div>
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="card mb-3">
    
    <div class="card-body">
        <div id="contenido-imprimir">
            <div class="mt-3">
                <h2>Cliente: {{ $orden->user->name }} </h2>
                <h3>Tipo de cliente: {{ $orden->user->clasificacion }} </h3>
                <span>Empresa: {{ $orden->user->nombre_empresa }}</span> <br>
                <span>NIT: {{ $orden->user->nit }}</span><br>
                <span>NRC: {{ $orden->user->nrc }}</span>
            </div>
            <div>
                Orden #{{ $orden->id }} <br>
                Fecha: {{ $orden->created_at }} <br>
                <span class="text-warning">Estado: {{ $orden->estado }} <br></span>
            </div>
            <div class="table-responsive scrollbar mt-4">
                <table id="table_detalle" class="table display">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad De cajas</th>
                            <th>Cantidad por caja</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalle as $detalles)
                            <tr>
                                <td>{{ $detalles->producto->nombre }}</td>
                                <td>{{ $detalles->cantidad }}</td>
                                <td>{{ $detalles->producto->unidad_por_caja }}</td>
                                <td>{{ $detalles->producto->precio_1 }}</td>
                                <td>{{ $detalles->cantidad * $detalles->producto->precio_1 * $detalles->producto->unidad_por_caja }}</td>
                            </tr>
                        @endforeach
                        @php
                            $total = 0;
                            foreach ($detalle as $detalles) {
                                $total += $detalles->cantidad * $detalles->producto->precio_1 * $detalles->producto->unidad_por_caja;
                            }
                        @endphp
                        
                    </tbody>
                </table>
                <div class="card-body d-flex align-items-end flex-column">
                    <span colspan="3"><strong>Total a pagar</strong></span>
                    <h2>${{ $total }}</h2>
                </div>
            </div>
        </div>
        @if ($orden->estado == 'Finalizada' || $orden->estado == 'Cancelada')
            <h4>La orden ha sido finazalidada</h1>
            @else
                <div class="mt-4">
                    <h4>Actualizar estado de la orden</h1>
                        @if ($orden->estado == 'Pendiente')
                            <form action="{{ route('ordenes.enProceso', $orden->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-info p-2 p-0" type="submit">Actualizar En
                                    Progreso</button>
                            </form>
                        @elseif($orden->estado == 'En proceso')
                            <form action="{{ route('ordenes.finalizada', $orden->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-info p-2 p-0" type="submit">Actualizar a
                                    Finalizada</button>
                            </form>
                        @endif
                </div>
        @endif
        @if ($orden->estado != 'Cancelada' && $orden->estado != 'Finalizada')
            <form action="{{ route('ordenes.cancelada', $orden->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-primary p-2 p-0 mt-2" type="submit">Cancelar Orden</button>
            </form>
        @endif

    </div>
</div>
<script>
    document.getElementById('imprimir_btn').addEventListener('click', function() {
        var contenidoImprimir = document.getElementById('contenido-imprimir').innerHTML;

        var ventanaImpresion = window.open('', '_blank');
        ventanaImpresion.document.write('<html><head><title>Detalle Orden</title></head><body>' +
            contenidoImprimir + '</body></html>');
        ventanaImpresion.document.close();
        ventanaImpresion.print();
        ventanaImpresion.close();
    });
</script>
@endsection
