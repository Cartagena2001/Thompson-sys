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
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/ordenes/oficina') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
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
                        <span class="rt-color-2">Lista de Precios:</span> <span class="">{{ $orden->user->clasificacion }}</span> | <span class="rt-color-2">Tipo Cliente:</span> <span class="">{{ $orden->user->usr_tipo }}</span><br>
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
                        <span class="rt-color-2"># Factura:</span> <span class="">{{ $orden->corr }}</span><br>
                        <span class="rt-color-2">Fecha/Hora:</span> <span class="">{{ \Carbon\Carbon::parse($orden->fecha_envio)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}</span><br>
                        <span class="rt-color-2">Notas:</span> <span>{{ $orden->notas }}</span><br>
                        <span class="rt-color-2">Estado:</span> <span class="text-warning">{{ $orden->estado }}</span>
                    </div>
                    
                </div>

                <hr/>

                <div class="table-responsive scrollbar mt-4">
                    <table id="table_detalle" class="table display">
                        <thead>
                            <tr>
                                <th class="text-start">OEM</th>
                                <th class="text-start">Producto</th>
                                <th class="text-center">Ubicación (Bodega)</th>
                                <th class="text-center">Ubicación (Oficina)</th>
                                <th class="text-center">Cantidad (Solicitada)</th>

                                @if ( $orden->estado != 'Pendiente' )
                                    <th class="text-center">Cantidad (Despachada)</th>
                                    <th class="text-center"># Bultos</th>
                                @endif

                                <th class="text-center">Precio (caja)</th>
                                <th class="text-center">Subtotal Parcial</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($detalle as $detalles)
                                <tr class="pb-5">
                                    <td class="text-start">{{ $detalles->producto->OEM }}</td>
                                    <td class="text-start">{{ $detalles->producto->nombre }}</td>

                                    <td class="text-start">
                                        <input id="ubbo_{{ $detalles->producto->id }}" name="ubbo" class="form-control" type="text" value="{{ $detalles->producto->ubicacion_bodega }}" placeholder="A-00-00" onchange="updateUbiBo(this.id)" /> 
                                        <br> 
                                        <div class="alert alert-success" role="alert" id="successMsg1" style="display: none" >Ubicación actualizada con éxito.</div>
                                    </td>

                                    <td class="text-start">
                                        <input id="ubof_{{ $detalles->producto->id }}" name="ubof" class="form-control" type="text" value="{{ $detalles->producto->ubicacion_oficina }}" placeholder="OF-00" onchange="updateUbiOf(this.id)" /> 
                                        <br> 
                                        <div class="alert alert-success" role="alert" id="successMsg2" style="display: none" > Ubicación actualizada con éxito.</div>
                                    </td>

                                    <td class="text-center">{{ $detalles->cantidad * $detalles->producto->unidad_por_caja }}</td>
                                    
                                    @if ( $orden->estado != 'Pendiente' )
                                        <td class="text-center">{{ $detalles->cantidad_despachada }}</td>
                                        <td class="text-center">{{ $detalles->n_bulto }}</td>
                                    @endif

                                    @if ( $orden->estado == 'Proceso' )
                                        <td class="flex-center">
                                            <input id="nbulto_{{ $detalles->producto->id }}" name="nbulto" class="form-control text-center" type="text" value="{{ $detalles->n_bulto }}" placeholder="0" onchange="updateNb(this.id)" style="max-width: 80px;" />
                                        </td>
                                    @endif

                                    @if ( $orden->estado == 'Proceso' )
                                        <td class="flex-center">
                                            <input id="cantd_{{ $detalles->producto->id }}" name="cantd" class="form-control text-center" type="text" value="{{ $detalles->cantidad_despachada }}" placeholder="0" onchange="updateCantD(this.id)" style="max-width: 80px;" />
                                        </td>
                                    @endif

                                    
                                    <td class="text-center">{{ number_format(($detalles->precio), 2, '.', ','); }} $</td>
                                    @if ( Auth::user()->rol_id != 3 )
                                        <td class="text-center">{{ number_format(($detalles->cantidad * $detalles->precio), 2, '.', ','); }} $</td>
                                    @endif 
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
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ( $orden->estado != 'Pendiente' )
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-start" style="font-weight: 600;">Subtotal:</td> 
                                    <td class="text-end">{{ number_format($subtotal, 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td> 
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ( $orden->estado != 'Pendiente' )
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-start" style="font-weight: 600;">IVA (13%):</td> 
                                    <td class="text-end">{{ number_format(($subtotal * $iva), 2, '.', ',');  }} $</td> 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ( $orden->estado != 'Pendiente' )
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-start" style="font-weight: 600;">Total:</td> 
                                    <td class="text-end">{{ number_format($total, 2, '.', ',');  }} $</td>
                                </tr>

                        </tbody>
                    </table>
                </div>

            </div>


            <form method="POST" action="{{ route('ordenecif.upload', $orden->id) }}" role="form" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf

                @if ( !$orden->estado == 'Pendiente' || !$orden->estado == 'Proceso' )
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
                @endif

                <div class="row mb-2">  

                    @if ( !$orden->estado == 'Pendiente' || !$orden->estado == 'Proceso' )
                        <div class="col-6">
                            <label for="corr"># de Factura: </label>
                            <input class="form-control" type="text" name="corr" id="corr" value="{{ $orden->corr }}" maxlength="24" placeholder="-">
                            @error('corr')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    
                    <div class="col-6">
                        <label for="ubicacion">Ubicación (Despacho): </label>
                        
                        <select name="ubicacion" id="ubicacion" class="form-control">
                            <option value="Ambas" @if ( $orden->ubicacion == 'Ambas') ) selected @endif >Ambas</option>
                            <option value="Oficina" @if ( $orden->ubicacion == 'Oficina') ) selected @endif >Oficina</option>
                            <option value="Bodega" @if ( $orden->ubicacion == 'Bodega') ) selected @endif >Bodega</option> 
                        </select>

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
                    <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Guardar</button>
                </div>

            </form>


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
                            @elseif($orden->estado == 'Proceso')
                                <form action="{{ route('ordenes.preparada', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: Preparada</button>
                                </form>
                             @elseif($orden->estado == 'Preparada')
                                <form action="{{ route('ordenes.espera', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: En Espera</button>
                                </form>
                            @elseif($orden->estado == 'Espera')
                                <form action="{{ route('ordenes.pagada', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: Pagada</button>
                                </form>
                            @elseif($orden->estado == 'Pagada')
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


        function updateUbiBo(prod_id) {

            var ubiBod = $('#'+prod_id).val();
            
            $.ajax({
                url: "{{ route('producto.updateUbiBO') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&ubicacionBod=" + ubiBod + "&producto_id=" + prod_id,

                success: function(response){
                    $('#successMsg1').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.ubiBod);
                    $('#ErrorMsg2').text(response.responseJSON.errors.prod_id);
                },
            });
            
        }

        function updateUbiOf(prod_id) {

            var ubiOf = $('#'+prod_id).val();

            $.ajax({
                url: "{{ route('producto.updateUbiOF') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&ubicacionOf=" + ubiOf + "&producto_id=" + prod_id,

                success: function(response){
                    $('#successMsg2').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.ubiOf);
                    $('#ErrorMsg2').text(response.responseJSON.errors.prod_id);
                },
            });
            
        }
    </script>

@endsection
