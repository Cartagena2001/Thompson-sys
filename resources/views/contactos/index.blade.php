@extends('layouts.app')

@section('content')
@section('title', 'Contactos')

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
        </div>
    </div>
</div>

{{-- Cards de informacion --}}
<div class="row g-3 mb-3">

    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6># Mensajes</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los mensajes --}}
                    <?php
                    $contactosNum = DB::table('contacto')
                        ->get();
                    echo count($contactosNum);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6># Suscritos a boletín</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                    {{-- contar los contactos suscritos a boletin --}}
                    <?php
                    $contactosNumBol = DB::table('contacto')
                        ->where('boletin', 1)
                        ->get();
                    echo count($contactosNumBol);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="card mb-3" style="border: ridge 1px #ff1620;">

    <div class="card-body pt-3">
        <div class="table-responsive scrollbar">

            <table id="table_contactos" class="table display pb-4 pt-4">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre de contacto</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">WhatsApp</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col" class="text-center">Boletín</th>
                        <th scope="col" class="text-center">Fecha/Hora</th>
                        <th scope="col" class="text-center no-export">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contactos as $contacto)
                    <tr>
                        <td class="text-center">{{ $contacto->id }}</td>
                        <td>{{ $contacto->nombre }}</td>
                        <td>{{ $contacto->correo }}</td>
                        <td>{{ $contacto->nombre_empresa }}</td>
                        <td>{{ $contacto->numero_whatsapp }}</td>
                        <td>{{ $contacto->mensaje }}</td>

                        <td @if( $contacto->boletin == 1 )
                            class="text-success text-center"
                            @else
                            class="text-danger text-center"
                            @endif
                            style="font-weight:bold;"

                            >

                            @if( $contacto->boletin == 1 )
                            si
                            @else
                            no
                            @endif
                        </td>

                        <td class="text-center">{{ $contacto->fecha_hora_form }}</td>

                        <td class="text-center">
                            <a href="{{ route('contactos.show', $contacto->id) }}">
                                <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-eye"></span> Ver Detalle </button>
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#table_contactos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Descargar en Excel',
                exportOptions: {
                    columns: ':not(.no-export)'
                }
            }]
        });
    });
</script>

@endsection