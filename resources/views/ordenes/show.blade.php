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
                    <h1 class="text-center">📥 Resumen Órden de Compra 📥</h1>
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

        <button id="imprimir_btn" class="btn btn-sm btn-primary" type="button"><i class="fas fa-print"></i> Imprimir detalle de la órden</button>

        <div class="card-body">

            <div id="contenido-imprimir">

                <div class="row">

                    <div class="col-12 mt-3">
                        <h2>Cliente: <span class="rt-color-1">{{ $orden->user->name }}</span></h2>
                        @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )
                        <span class="rt-color-2">Categoría:</span> <span class="">{{ $orden->user->clasificacion }}</span><br>
                        @endif
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
                        <span class="rt-color-2"># Factura:</span> <span class="">{{ $orden->cif }}</span><br>
                        <span class="rt-color-2">Fecha/Hora:</span> <span class="">{{ \Carbon\Carbon::parse($orden->created_at)->format('d/m/Y, h:m:s a') }}</span><br>
                        <span class="rt-color-2">Notas:</span> <span>{{ $orden->notas }}</span><br>
                        <span class="rt-color-2">Estado:</span> <span class="text-warning">{{ $orden->estado }}</span>
                    </div>
                    
                </div>

                <hr/>

                <div class="table-responsive scrollbar mt-4">
                    <table id="table_detalle" class="table display">
                        <thead>
                            <tr>
                                <th class="text-start">Producto</th>
                                <th class="text-center">Cantidad (caja)</th>
                                <th class="text-center">Precio (caja)</th>
                                <th class="text-center">Subtotal Parcial</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($detalle as $detalles)
                                <tr class="pb-5">
                                    <td class="text-start">{{ $detalles->producto->nombre }}</td>
                                    <td class="text-center">{{ $detalles->cantidad }}</td>
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
                                    <td></td> 
                                    <td class="text-start" style="font-weight: 600;">Subtotal:</td> 
                                    <td class="text-end">{{ number_format($subtotal, 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td> 
                                    <td class="text-start" style="font-weight: 600;">IVA (13%):</td> 
                                    <td class="text-end">{{ number_format(($subtotal * $iva), 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-start" style="font-weight: 600;">Total:</td> 
                                    <td class="text-end">{{ number_format($total, 2, '.', ',');  }} $</td> 
                                </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )

            <form method="POST" action="{{ route('ordenecif.upload', $orden->id) }}" role="form" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf

                <div class="mt-3 col-auto text-center col-4 mx-auto">
                    <label for="factura_href">Adjuntar Factura/Crédito Fiscal: </label>
                    <br/>
                    <a href="{{ $orden->factura_href }}" title="Ver Factura" target="_blank"><img class="rounded mt-2" src="{{ $orden->factura_href }}" alt="factura-img" width="400"></a>
                    <br/>
                    <br/>
                    <input class="form-control" type="file" name="factura_href" id="factura_href" value="{{ $orden->factura_href }}">  
                    <br/>
                    @error('factura_href')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-2">  

                    <div class="col-6">
                        <label for="cif"># de Factura: </label>
                        <input class="form-control" type="text" name="cif" id="cif" value="{{ $orden->cif }}" maxlength="24" placeholder="-">
                        @error('cif')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="ubicacion">Ubicación: </label>
                        <input class="form-control" type="text" name="ubicacion" id="ubicacion" value="{{ $orden->ubicacion }}" maxlength="7" placeholder="A-00-00">
                        @error('ubicacion')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

               <div class="row mb-2">

                    <div class="col-12">
                        <label for="notas">Notas (Oficina): </label>
                        <textarea class="form-control" type="text" name="notas" id="notas" rows="4" cols="50" maxlength="250" placeholder="-">{{ $orden->notas }}</textarea>
                        @error('notas')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                    <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Adjuntar información</button>
                </div>

            </form>

            @elseif ( Auth::user()->rol_id == 3 )

            <form method="POST" action="{{ route('ordenecif.upload', $orden->id) }}" role="form" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf

                <div class="row mb-2">  

                    <div class="col-6">
                        <label for="bulto"># bulto: </label>
                        <input class="form-control" type="text" name="bulto" id="bulto" value="{{ $orden->bulto }}" maxlength="9" placeholder="-">
                        @error('bulto')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="paleta"># paleta: </label>
                        <input class="form-control" type="text" name="paleta" id="paleta" value="{{ $orden->paleta }}" maxlength="9" placeholder="-">
                        @error('paleta')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

               <div class="row mb-2">

                    <div class="col-12">
                        <label for="notas_bodega">Notas (Bodega): </label>
                        <textarea class="form-control" type="text" name="notas_bodega" id="notas_bodega" rows="4" cols="50" maxlength="250" placeholder="-">{{ $orden->notas_bodega }}</textarea>
                        @error('notas_bodega')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                    <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Guardar</button>
                </div>

            </form>

            @else
            
            {{-- CLIENTE --}}

            @endif



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
