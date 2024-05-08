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
                    <h1 class="text-center">📥 Resumen orden de compra 📥</h1>
                    <p class="mt-4 mb-4 text-center">Detalle de la orden de compra, acá podrás encontrar toda la información relevante de la orden de compra seleccionada.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/ordenes/bodega') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block"> Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3" style="border: ridge 1px #ff1620;">

        <button id="imprimir_btn" class="btn btn-sm btn-primary" type="button"><i class="fas fa-print"></i> Imprimir detalle de la orden</button>

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
                        <span class="rt-color-2"># Factura:</span> <span class="">{{ $orden->corr }}</span><br>
                        <span class="rt-color-2">Fecha/Hora:</span> <span class="">{{ \Carbon\Carbon::parse($orden->created_at)->format('d/m/Y, h:m:s a') }}</span><br>
                        <span class="rt-color-2">Notas:</span> <span>{{ $orden->notas }}</span><br>
                        <span class="rt-color-2">Estado:</span> <span class="text-warning">{{ $orden->estado }} @if ($orden->estado == 'Pagada') <span>(DESPACHO AUTORIZADO)</span> @endif</span>
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

                                @if ( $orden->estado == 'Proceso' || $orden->estado == 'Preparada' || $orden->estado == 'Espera' )
                                    <th class="text-center">Cantidad (Despachada)</th>
                                    <th class="text-center"># Bultos</th>
                                @endif

                                <th class="text-center">Precio (caja)</th>
                                
                                @if ( Auth::user()->rol_id != 3 )
                                <th class="text-center">Subtotal Parcial</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($detalle as $detalles)
                                <tr class="pb-5">

                                    <td class="text-start">{{ $detalles->producto->OEM }}</td>
                                    <td class="text-start">{{ $detalles->producto->nombre }}</td>

                                    <td class="text-center">
                                        {{ $detalles->producto->ubicacion_bodega }}  
                                    </td>

                                    <td class="text-center">
                                        {{ $detalles->producto->ubicacion_oficina }}
                                    </td>

                                    <td class="text-center">
                                        {{ $detalles->cantidad * $detalles->producto->unidad_por_caja }}
                                    </td>
                                    
                                    @if ( $orden->estado == 'Proceso' || $orden->estado == 'Preparada' || $orden->estado == 'Espera' )
                                        <td>
                                            <input id="cantd_{{ $detalles->producto->id }}" name="cantd_{{ $detalles->id }}" class="form-control text-center" type="text" value="{{ $detalles->cantidad_despachada }}" placeholder="0" onchange="updateCantD(this.id, this.name)" style="max-width: 80px; margin: 0 auto;" />
                                            <br> 
                                            <div class="alert alert-success" role="alert" id="successMsg3" style="display: none" >Cantidad despachada actualizada con éxito.</div>
                                        </td>

                                        <td>
                                            <input id="nbulto_{{ $detalles->producto->id }}" name="nbulto_{{ $detalles->id }}" class="form-control text-center" type="text" value="{{ $detalles->n_bulto }}" placeholder="0" onchange="updateNb(this.id, this.name)" style="max-width: 80px; margin: 0 auto" />
                                            <br> 
                                            <div class="alert alert-success" role="alert" id="successMsg4" style="display: none" >Cantidad de bultos actualizada con éxito.</div>
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
                            
                            @if ( Auth::user()->rol_id != 3 )
                                <tr class="pt-5" style="border-top: solid 4px #979797;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ( Auth::user()->rol_id == 0 && $orden->estado != 'Pendiente' || Auth::user()->rol_id == 1 && $orden->estado != 'Pendiente' )
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
                                    @if ( Auth::user()->rol_id == 0 && $orden->estado != 'Pendiente' || Auth::user()->rol_id == 1 && $orden->estado != 'Pendiente' )
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
                                    @if ( Auth::user()->rol_id == 0 && $orden->estado != 'Pendiente' || Auth::user()->rol_id == 1 && $orden->estado != 'Pendiente' )
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-start" style="font-weight: 600;">Total:</td> 
                                    <td class="text-end">{{ number_format($total, 2, '.', ',');  }} $</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>


            @if ( Auth::user()->rol_id == 3 )

            <form method="POST" action="{{ route('ordenehoj.uploadB', $orden->id) }}" role="form" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf

                @if ( $orden->estado == 'Pagada' )
                    <div class="mt-3 col-auto text-center col-4 mx-auto">
                        <label for="hoja_salida_href">Adjuntar Hoja de Salida: </label>
                        <br/>
                        <a href="{{ $orden->hoja_salida_href }}" title="Ver Hoja de Salida" target="_blank"><img class="rounded mt-2" src="{{ $orden->hoja_salida_href }}" alt="hoja-salida-img" width="400"></a>
                        <br/>
                        <br/>
                        <input class="form-control" type="file" name="hoja_salida_href" id="hoja_salida_href" value="{{ $orden->hoja_salida_href }}">  
                        <br/>
                        @error('hoja_salida_href')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

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

            @endif



            <div class="row mb-4">
            @if ($orden->estado == 'Finalizada' || $orden->estado == 'Cancelada')
                <h4 class="text-center mb-4">La orden ha sido Finalizada.</h4>
                
                @else
                    <div class="row mt-4">
                        <h4 class="text-center mb-4">Actualizar estado de la Orden:</h4>

                        <div class="col-md-12 text-end">
                            @if ($orden->estado == 'Proceso')
                                <form action="{{ route('ordenes.preparadaB', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: Preparada</button>
                                </form>
                            @elseif($orden->estado == 'Preparada')
                                <h2 class="text-center">A LA ESPERA DE INDICACIONES DESDE OFICINA</h2>
                            @elseif($orden->estado == 'Espera')
                                <h2 class="text-center">A LA ESPERA DE INDICACIONES DESDE OFICINA</h2>
                            @elseif($orden->estado == 'Pagada')
                                <form action="{{ route('ordenes.finalizadaB', $orden->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-info p-3 w-100" type="submit">Actualizar a: Finalizada</button>
                                </form>
                            @endif
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

        function updateCantD(prod_id, ordd_id) {

            var CantD = $('#'+prod_id).val();
            //var OrdIDD = ordd_id;

            $.ajax({
                url: "{{ route('producto.updateCantD') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&cantidad_despachada=" + CantD + "&producto_id=" + prod_id + "&ordend_id=" + ordd_id,

                success: function(response){
                    $('#successMsg3').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.CantD);
                    $('#ErrorMsg2').text(response.responseJSON.errors.prod_id);
                },
            });
            
        }

        function updateNb(prod_id, ordd_id) {

            var nBulto = $('#'+prod_id).val();
            //var OrdIDD = ordd_id;

            $.ajax({
                url: "{{ route('producto.updateNb') }}",
                type: "POST",
                data:
                    "_token=" + "{{ csrf_token() }}" + "&n_bulto=" + nBulto + "&producto_id=" + prod_id + "&ordend_id=" + ordd_id,

                success: function(response){
                    $('#successMsg4').show();
                    console.log(response);
                },
                error: function(response) {
                    $('#ErrorMsg1').text(response.responseJSON.errors.nBulto);
                    $('#ErrorMsg2').text(response.responseJSON.errors.prod_id);
                },
            });
            
        }
    </script>

@endsection
