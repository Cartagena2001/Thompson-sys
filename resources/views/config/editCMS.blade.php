@extends('layouts.app')

@section('content')
@section('title', 'CMS')
    
          {{-- Titulo --}}
          <div class="card mb-3">
              <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
              <div class="card-body position-relative mt-4">
                  <div class="row">
                      <div class="col-lg-12">
                          <h1 class="text-center">🎨 CMS</h1>
                          <p class="mt-4 mb-4 text-center">Administración de contenido del sitio web de <b>RTElsalvador.</b> Aquí podrás encontrar todos los campos editables del contenido del sitio web.</p>
                      </div>
                  </div>
              </div>
          </div>

          {{-- Cards de informacion --}}

          <div class="card mb-3" style="border: ridge 1px #ff1620;">
            <div class="card-header">
              <div class="row flex-between-end">

                <div class="col-auto align-self-center mb-3">
                    <h5 class="mb-0" data-anchor="data-anchor">✍️ Información en página de Inicio:</h5>
                </div>

                <hr />

                <form method="POST" action="{{ route('cms.update') }}" role="form" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf
              
                <div class="mb-3">
                  <label class="form-label" for="numWhat">Número de WhatsApp: *</label>
                  <input class="form-control" id="numWhat" name="numWhat" type="text" placeholder="0000-0000" value=" {{ $cmsVars[0]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="numWhatURL">Número de WhatsApp-URL: *</label>
                  <input class="form-control" id="numWhatURL" name="numWhatURL" type="text" placeholder="0000-0000" value=" {{ $cmsVars[1]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="numFijo">Número Fijo: *</label>
                  <input class="form-control" id="numFijo" name="numFijo" type="text" placeholder="0000-0000" value=" {{ $cmsVars[2]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="numFijoURL">Número Fijo-URL: *</label>
                  <input class="form-control" id="numFijoURL" name="numFijoURL" type="text" placeholder="0000-0000" value=" {{ $cmsVars[3]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="fbURL">Perfil Facebook: *</label>
                  <input class="form-control" id="fbURL" name="fbURL" type="text" placeholder="-" value=" {{ $cmsVars[4]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="igURL">Perfil Instagram: *</label>
                  <input class="form-control" id="igURL" name="igURL" type="text" placeholder="-" value=" {{ $cmsVars[5]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="dirOF">Dirección Oficina: *</label>
                  <input class="form-control" id="dirOF" name="dirOF" type="text" placeholder="-" value=" {{ $cmsVars[6]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="horarioOF">Horario Oficina: *</label>
                  <input class="form-control" id="horarioOF" name="horarioOF" type="text" placeholder="-" value=" {{ $cmsVars[7]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="dirBod">Dirección Bódega: *</label>
                  <input class="form-control" id="dirBod" name="dirBod" type="text" placeholder="-" value=" {{ $cmsVars[8]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="horarioBod">Horario Bódega: *</label>
                  <input class="form-control" id="horarioBod" name="horarioBod" type="text" placeholder="-" value=" {{ $cmsVars[9]['parametro'] }} " />
                </div>

                <div class="col-auto align-self-center mb-3 mt-5">
                    <h5 class="mb-0" data-anchor="data-anchor">🔧 Otras configuraciones:</h5>
                </div>

                <hr />

                <div class="mb-3">
                  <label class="form-label" for="corrContacto">Correo Electrónico de Contacto: *</label>
                  <input class="form-control" id="corrContacto" name="corrContacto" type="text" placeholder="-" value=" {{ $cmsVars[10]['parametro'] }} " />
                </div>

                <div class="mb-3">
                  <label class="form-label" for="corrOrden">Correo Electrónico para recibir Órdenes de Compra: *</label>
                  <input class="form-control" id="corrOrden" name="corrOrden" type="text" placeholder="-" value=" {{ $cmsVars[11]['parametro'] }} " />
                </div>

                <hr class="my-4" style="border-style: dashed; padding: 2px 0px; background-color: #ff161f; border-radius: 10px;" />

                <div class="my-3">
                  <label class="form-label" for="catalogMod">Modo Catálogo: 
                    <input type="radio" name="catalogMod" value="1" @if ( $cmsVars[12]['parametro'] == 1 ) checked @endif > <span style="color: green;">Activo</span>
                    <input type="radio" name="catalogMod" value="0"  @if ( $cmsVars[12]['parametro'] == 0 ) checked @endif > <span style="color: red;">Inactivo</span>
                    </label>
                </div>

                <div class="my-3">
                  <label class="form-label" for="mantMod">Modo Mantenimiento: 
                    <input type="radio" name="mantMod" value="1" @if ( $cmsVars[13]['parametro'] == 1 ) checked @endif > <span style="color: green;">Activo</span>
                    <input type="radio" name="mantMod" value="0"  @if ( $cmsVars[13]['parametro'] == 0 ) checked @endif > <span style="color: red;">Inactivo</span>
                  </label>
                </div>

                <div class="mt-4 mb-4 col-auto text-center col-4 mx-auto">
                    <button type="submit" href="" class="btn btn-primary btn-sm"><i class="far fa-save"></i> Guardar Configuración</button>
                </div>

                </form>

              </div>
            </div>
          </div>
          
@endsection