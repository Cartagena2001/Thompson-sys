@extends('layouts.app')

@section('content')
@section('title', 'Contactos: ' . $contacto->nombre)

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js"></script>

    {{-- Titulo --}}
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
        <div class="card-body position-relative mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">📬 Contactos 📬</h1>
                    <p class="mt-4 mb-4 text-center">En esta sección se muestran los potenciales clientes que han hecho alguna consulta a través del formulario de contacto.</p>
                </div>
                <div class="text-center mb-4">
                    <a class="btn btn-sm btn-primary" href="{{ url('/dashboard/contactos') }}"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de informacion --}}
    <div class="card mb-3">

        <div class="card-body" style="border: ridge 1px #ff1620;">

            <div class="mt-3 mb-4">
                <h4 class="text-center">Nombre del contacto: <br/> <span style="color: #ff161f">{{ $contacto->nombre }}</span> </h4>
            </div>

            <hr/>

            <div class="row">

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-end" style="font-size: 18px;">
                        <span class="font-weight-bold" style="color:#000;">Correo Electrónico:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Nombre de la Empresa:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">WhatsApp:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Mensaje:</span> <br><br><br>
                        <span class="font-weight-bold" style="color:#000;">Suscrito a Boletín:</span> <br>
                        <span class="font-weight-bold" style="color:#000;">Fecha/Hora: </span>
                    </p>
                </div>

                <div class="col-sm-6">
                    <p class="mt-4 mb-4 text-start" style="font-size: 18px;">
                        <a href="mailto:{{ $contacto->correo }}" title="contactar" target="_blank">{{ $contacto->correo }}</a><br>
                        {{ $contacto->nombre_empresa }} <br>
                        {{ $contacto->numero_whatsapp }} <br>
                        {{ $contacto->mensaje }} <br><br>
                        
                        @if( $contacto->boletin == 1 ) 
                            si
                        @else
                            no
                        @endif <br>
                        {{ \Carbon\Carbon::parse($contacto->fecha_hora_form)->isoFormat('D [de] MMMM [de] YYYY, h:mm:ss a') }}
                    </p>
                </div>

            </div>
            
        </div>
    </div>

@endsection
