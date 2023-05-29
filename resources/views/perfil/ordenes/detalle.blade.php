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
                <h3>Orden # {{ $orden->id }}</h3>
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ url('/perfil/ordenes') }}">
                    <span class="fas fa-long-arrow-alt-left me-sm-2">
                    </span>
                    <span class="d-none d-sm-inline-block">
                        Volver atras
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
{{-- Cards de informacion --}}
<div class="card mb-3">
    <div class="card-body">
        <div class="mt-3">
            <h2>Cliente: {{ $orden->user->name }} </h2>
            <span>Empresa: {{ $orden->user->nombre_empresa }}</span> <br>
            <span>NIT: {{ $orden->user->nit }}</span><br>
            <span>NRC: {{ $orden->user->nrc }}</span>
        </div>
        <div>
            Orden #{{ $orden->id }} <br>
            Fecha: {{ $orden->created_at }} <br>
            <h4 class="text-warning">Estado: {{ $orden->estado }} <br></h4>
        </div>
        <div class="table-responsive scrollbar mt-4">
            <table id="table_detalle" class="table display">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle as $detalles)
                        <tr>
                            <td>{{ $detalles->producto->nombre }}</td>
                            <td>{{ $detalles->cantidad }}</td>
                            <td>{{ $detalles->producto->precio_1 }}</td>
                            <td>{{ $detalles->cantidad * $detalles->producto->precio_1 }}</td>
                        </tr>
                    @endforeach
                    @php
                        $total = 0;
                        foreach ($detalle as $detalles) {
                            $total += $detalles->cantidad * $detalles->producto->precio_1;
                        }
                    @endphp
                    <tr>
                        <td colspan="3"><strong>Total a pagar</strong></td>
                        <td>{{ $total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
