@extends('layouts.app')

@section('content')
@section('title', 'Manuales del sistema')

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
                <h1 class="text-center">📄 Manuales del sistema 📄</h1>
                <p class="mt-4 mb-4 text-center"> En esta sección se encuentran los manuales de usuario y administrador del sistema.</p>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3" style="border: ridge 1px #ff1620;">
    <div class="card-header">
        <h1>Manual del cliente</h1>
        <span>En este manual se explica el funcionamiento del sistema para los clientes.</span>
    </div>
    <hr />
    <div class="card-body">
        <iframe src="{{ asset('assets/pdf/MANUAL_DE_USUARIO_ACCUMETRIC.pdf') }}" width="100%" height="600px"></iframe>
    </div>
</div>

@if (Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1)
<div class="card mb-3" style="border: ridge 1px #ff1620;">
    <div class="card-header">
        <h1>Manual del administrador</h1>
        <span>En este manual se explica el funcionamiento del sistema para los administradores.</span>
    </div>
    <hr />
    <div class="card-body">
        <iframe src="{{ asset('assets/pdf/MANUAL_DE_USUARIO_ACCUMETRIC_ADMIN.pdf') }}" width="100%" height="600px"></iframe>
    </div>
</div>
@endif

<script>

</script>
@endsection