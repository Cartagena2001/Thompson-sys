@extends('layouts.app')

@section('content')

@section('title', 'Envío de correo de prueba')


    {{-- Titulo --}}

    <div class="container">
        <div class="card mb-3">

            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(/../../assets/img/icons/spot-illustrations/corner-4.png); border: ridge 1px #ff1620;"></div>
            <div class="card-body position-relative mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">✉️ Envío de Email de Pueba ✉️</h1>
                        <p class="mt-4 mb-4 text-center">Aquí podrás probar el estado del servicio de envío de correos electrónicos del sistema RT.
                        </p>
                    </div>
                    <div class="text-center mb-4">
                        <a class="btn btn-sm btn-primary" style="cursor: pointer;" onclick="history.back()"><span class="fas fa-long-arrow-alt-left me-sm-2"></span><span class="d-none d-sm-inline-block">Volver Atrás</span></a>
                    </div>
                </div>
                <hr/>
                <div class="row">
                <div class="col-lg-12">
                  <h3>INDICACIONES:</h3>
                  <p class="mb-0 text-justify">Ingresa la dirección de correo electrónico de destino (una solamente), ingresa el asunto y el mensaje a enviar, luego envia la prueba y este llegará al destino enviado desde la dirección de correo notificaciones@rtelsalvador.com. En caso ocurra algún error, este se desplegará en pantalla para su posterior análisis y así solventar cuaalquier falla existente.</p>
                </div>
              </div>
            </div>

        </div>
    </div>

    <div class="container mt-4 mb-4">
    
        @if ($message = Session::get('success'))
            <div class="alert alert-success  alert-dismissible">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger  alert-dismissible">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if(count($errors) > 0)
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif

        <form method="post" action="{{ route('send.php.mailer.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label style="color: #fff;">Correo de Destino:</label>
                <input type="email" name="email" class="form-control" />
            </div>
            <div class="form-group">
                <label style="color: #fff;">Asunto:</label>
                <input type="text" name="subject" class="form-control" />
            </div>
            <div class="form-group">
                <label style="color: #fff;">Mensaje:</label>
                <textarea class="form-control" name="body"></textarea>
            </div>
            <div class="form-group">
              <div style="display: flex; justify-content: center;">

              </div>  
            </div>
            <div class="form-group mt-3 mb-3">
                <button type="submit" class="btn btn-success btn-block">Enviar Correo</button>
            </div>
        </form>

    </div>

  @endsection