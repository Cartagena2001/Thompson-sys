@extends('layouts.app')

@section('content')
@section('title', 'Orden # ' . $orden->id)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js">
    </script>


    {{-- Titulo --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">📥 Resumen Orden de Compra # {{ $orden->id }} 📥</h1>
                    <p class="mt-4 mb-4 text-center">Aquí podrás encontrar el detalle de tu orden de compra y su estado de procesamiento.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/perfil/ordenes') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <button id="imprimir_btn" class="btn btn-sm btn-primary" type="button"><i class="fas fa-print"></i> Imprimir orden</button>

        <div class="card-body">

            <div id="contenido-imprimir">

                <div class="row">

                    <div class="col-12 mt-3">
                        <h2>Cliente: <span class="rt-color-1">{{ $orden->user->name }}</span></h2>
                        <hr/>
                    </div>

                    <div class="col-6 mt-3">
                        <span class="rt-color-2">NRC:</span> <span class="">{{ $orden->user->nrc }}</span> &nbsp;|&nbsp; <span class="rt-color-2">NIT:</span> <span class="">{{ $orden->user->nit }}</span> &nbsp;|&nbsp; <span class="rt-color-2">DUI:</span> <span class="">{{ $orden->user->dui }}</span> <br>
                        <span class="rt-color-2">Nombre/Razón ó denominación social:</span> <span class="">{{ $orden->user->razon_social }}</span><br> 
                        <span class="rt-color-2">Nombre Comercial:</span> <span class="">{{ $orden->user->nombre_empresa }}</span><br> 
                        <span class="rt-color-2">Dirección:</span> <span class="">{{ $orden->user->direccion }}, {{ $orden->user->departamento }}, {{ $orden->user->municipio }} </span><br> 
                        <span class="rt-color-2">Teléfono:</span> <span class="">+503 {{ $orden->user->telefono }}</span> 
                    </div>
                
                    <div class="col-6 mt-3">
                        <span class="rt-color-2">Orden ID: #</span> <span class="">{{ $orden->id }}</span><br>
                        <span class="rt-color-2"># Factura:</span> <span class="">{{ $orden->corr }}</span><br>
                        <span class="rt-color-2">Fecha/Hora:</span> <span class="">{{ \Carbon\Carbon::parse($orden->created_at)->format('d/m/Y, h:m:s a') }}</span><br>
                        {{--<span class="rt-color-2">Notas:</span> <span>{{ $orden->notas }}</span><br> --}}
                        <span class="rt-color-2">Estado:</span> <span class="text-warning">{{ $orden->estado }}</span>
                    </div>
                    
                </div>

                <hr/>

                <div class="table-responsive scrollbar mt-4">
                    <table id="table_ordenc" class="table display">
                        <thead>
                            <tr>
                                <th class="text-start">OEM</th>
                                <th class="text-start">Producto</th>
                                {{-- 
                                <th class="text-center">Ubicación (Bodega)</th>
                                <th class="text-center">Ubicación (Oficina)</th>
                                --}}
                                <th class="text-center">Cantidad (Solicitada)</th>
                                <th class="text-center">Cantidad (Despachada)</th>
                                <th class="text-center"># Bultos</th>
                                <th class="text-center">Precio (caja)</th>
                                <th class="text-center">Subtotal Parcial</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($detalle as $detalles)
                                <tr class="pb-5">
                                    <td class="text-start">{{ $detalles->producto->OEM }}</td>
                                    <td class="text-start">{{ $detalles->producto->nombre }}</td>

                                    {{-- 
                                    <td class="text-start">{{ $detalles->producto->ubicacion_bodega }} </td>
                                    <td class="text-start">{{ $detalles->producto->ubicacion_oficina }}</td>
                                    --}}

                                    <td class="text-center">{{ $detalles->cantidad * $detalles->producto->unidad_por_caja }}</td>
                                    
                                    <td class="text-center">{{ $detalles->cantidad_despachada }}</td>
                                    <td class="text-center">{{ $detalles->n_bulto }}</td>

                                    <td class="text-center">{{ number_format(($detalles->precio), 2, '.', ','); }} $</td>
                                    <td class="text-center">{{ number_format(($detalles->cantidad * $detalles->precio), 2, '.', ','); }} $</td> 
                                </tr>
                            @endforeach

                            @php
                                $subtotal = 0;
                                $iva = 0.13;
                                $total = 0;

                                foreach ($detalle as $detalles) {
                                    $subtotal += $detalles->cantidad * $detalles->precio;
                                }

                                $total = $subtotal + ($subtotal * $iva);
                            @endphp
                            
                                <tr class="pt-5" style="border-top: solid 4px #979797;">
                                    <td></td>
                                    {{--
                                    <td></td>
                                    <td></td>
                                    --}}
                                    <td style="font-weight: 600;">Ubicación (Despacho):</td>
                                    <td>{{ $orden->ubicacion }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-start" style="font-weight: 600;">Subtotal:</td> 
                                    <td class="text-end">{{ number_format($subtotal, 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    {{--
                                    <td></td> 
                                    <td></td>
                                    --}}
                                    <td style="font-weight: 600;"># bultos:</td>
                                    <td>{{ $orden->bulto }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-start" style="font-weight: 600;">IVA (13%):</td> 
                                    <td class="text-end">{{ number_format(($subtotal * $iva), 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    {{--
                                    <td></td>
                                    <td></td>
                                    --}}
                                    <td style="font-weight: 600;"># paletas:</td>
                                    <td>{{ $orden->paleta }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-start" style="font-weight: 600;">Total:</td> 
                                    <td class="text-end">{{ number_format($total, 2, '.', ',');  }} $</td>
                                </tr>
                        </tbody>
                    </table>
                </div>

            </div>

                <hr/>

                <div class="row">

                    <div class="mt-3 col-auto text-center col-4 mx-auto">
                        <label for="factura_href">Factura/Crédito Fiscal: </label>
                        <br/>
                        <a href="{{ $orden->factura_href }}" title="Ver Factura" target="_blank"><img class="rounded mt-2" src="{{ $orden->factura_href }}" alt="factura-img" width="400"></a>
                    </div>

                    <div class="mt-3 col-auto text-center col-4 mx-auto">
                        <label for="comp-pago">Comprobante de Pago: </label>
                        <br/>
                        <a href="{{ $orden->comprobante_pago_href }}" title="Ver Comprobante" target="_blank"><img class="rounded mt-2" src="{{ $orden->comprobante_pago_href }}" alt="factura-img" width="400"></a>
                    </div>

                       <div class="mt-3 col-auto text-center col-4 mx-auto">
                        <label for="hoja_salida_href">Hoja de Salida: </label>
                        <br/>
                        <a href="{{ $orden->hoja_salida_href }}" title="Ver Hoja de Salida" target="_blank"><img class="rounded mt-2" src="{{ $orden->hoja_salida_href }}" alt="hoja-salida-img" width="400"></a>
                    </div>
                    
                </div>

    
        </div>
    </div>

    <script>
        document.getElementById('imprimir_btn').addEventListener('click', function() {
            var contenidoImprimir = document.getElementById('contenido-imprimir').innerHTML;

            var ventanaImpresion = window.open('', '_blank');
            ventanaImpresion.document.write('<html><head><title>órden #</title></head><body>' + contenidoImprimir + '</body></html>');
            ventanaImpresion.document.close();
            ventanaImpresion.print();
            ventanaImpresion.close();
        });
    </script>

@endsection
