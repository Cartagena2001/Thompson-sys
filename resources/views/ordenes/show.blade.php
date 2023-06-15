@extends('layouts.app')

@section('content')
@section('title', 'Orden # ' . $orden->id)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">📥 Órdenes de Compra 📥</h1>
                    <p class="mt-4 mb-4 text-center">Administración de órdenes de compra de productos en venta en la Tienda <b>rtelsalvador.</b> <br/>Aquí podrás encontrar todas las órdenes de compra de tus clientes y podrás gestionarlas.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/ordenes') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <button id="imprimir_btn" class="btn btn-sm btn-primary" type="button"><i class="fas fa-print"></i> Imprimir detalle de la orden</button>

        <div class="card-body">

            <div id="contenido-imprimir">

                <div class="mt-3">
                    <h2>Cliente: <span class="rt-color-1">{{ $orden->user->name }}</span></h2>
                    <hr/>
                    <span class="rt-color-2">Categoría:</span> <span class="">{{ $orden->user->clasificacion }}</span><br>
                    <span class="rt-color-2">Empresa:</span> <span class="">{{ $orden->user->nombre_empresa }}</span><br>
                    <span class="rt-color-2">NIT:</span> <span class="">{{ $orden->user->nit }}</span><br>
                    <span class="rt-color-2">NRC:</span> <span class="">{{ $orden->user->nrc }}</span>
                </div>
                
                <hr/>
                
                <div>
                    <span class="rt-color-2">Orden ID: #</span> <span class="">{{ $orden->id }}</span><br>
                    <span class="rt-color-2">Fecha:</span> <span class="">{{ $orden->created_at }}</span><br>
                    <span class="rt-color-2">Estado:</span> <span class="text-warning">{{ $orden->estado }}</span>
                </div>

                <hr/>

                <div class="table-responsive scrollbar mt-4">
                    <table id="table_detalle" class="table display">
                        <thead>
                            <tr>
                                <th class="text-start">Producto</th>
                                <th class="text-center">Cantidad (caja)</th>
                                <th class="text-center">Precio (caja)</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalle as $detalles)
                                <tr>
                                    <td class="text-start">{{ $detalles->producto->nombre }}</td>
                                    <td class="text-center">{{ $detalles->cantidad }}</td>
                                    <td class="text-center">$ {{ $detalles->producto->precio_1 }}</td>
                                    <td class="text-center">$ {{ $detalles->cantidad * $detalles->producto->precio_1 }}</td>
                                </tr>
                            @endforeach
                            @php
                                $total = 0;
                                foreach ($detalle as $detalles) {
                                    $total += $detalles->cantidad * $detalles->producto->precio_1;
                                }
                            @endphp
                            <tr>
                                <td class="text-start" colspan="3"><strong>Total:</strong></td>
                                <td class="text-center">$ {{ $total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row mb-4">
            @if ($orden->estado == 'Finalizada' || $orden->estado == 'Cancelada')
                <h4 class="text-center mb-4">La orden ha sido Finalizada.</h4>
                @else
                    <div class="row mt-4">
                        <h4 class="text-center mb-4">Actualizar estado de la Orden:</h4>

                        <div class="col-md-6 text-end">
                            @if ($orden->estado == 'Pendiente')
                                <form action="{{ route('ordenes.enProceso', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: En Proceso</button>
                                </form>
                            @elseif($orden->estado == 'En proceso')
                                <form action="{{ route('ordenes.finalizada', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: Finalizada</button>
                                </form>
                            @endif
                        </div>
            @endif
            @if ($orden->estado != 'Cancelada' && $orden->estado != 'Finalizada')
                <div class="col-md-6 text-start">
                    <form action="{{ route('ordenes.cancelada', $orden->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary p-3 w-100" type="submit">Cancelar Orden</button>
                    </form>
                 </div>
            @endif
                       
                 </div>  
            </div>

        </div>
    </div>

    <script>
        document.getElementById('imprimir_btn').addEventListener('click', function() {
            var contenidoImprimir = document.getElementById('contenido-imprimir').innerHTML;

            var ventanaImpresion = window.open('', '_blank');
            ventanaImpresion.document.write('<html><head><title>Detalle Orden</title></head><body>' + contenidoImprimir + '</body></html>');
            ventanaImpresion.document.close();
            ventanaImpresion.print();
            ventanaImpresion.close();
        });
    </script>

@endsection
