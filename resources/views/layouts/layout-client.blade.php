<!DOCTYPE html>
<html lang="es-Es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Representaciones Thompson - El Salvador</title>
    <meta name="theme-color" content="#ffffff">                                     

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FontAwesome -->
    {{-- <script src="https://kit.fontawesome.com/9b3f9e4d8d.js" crossorigin="anonymous"></script> --}}
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/date-1.2.0/datatables.min.js">
    </script>
    
    @vite(['resources/sass/app.scss', 'resources/css/theme-rtl.css', 'resources/css/theme.css', 'resources/css/user-rtl.css', 'resources/css/user.css', 'resources/js/app.js'])

    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>

    <script>
        /* ésto comprueba la localStorage si ya tiene la variable guardada */
        function compruebaAceptaCookies() {
          if(localStorage.aceptaCookies == 'true'){
            cajacookies.style.display = 'none';
          }
        }

        /* aquí se guarda la variable de que se ha aceptado el uso de cookies y así no se muestra el mensaje de nuevo */
        function aceptarCookies() {
          localStorage.aceptaCookies = 'true';
          cajacookies.style.display = 'none';
        }

        /* ésto se ejecuta cuando la web está cargada */
        $(document).ready(function () {
          compruebaAceptaCookies();
        });
    </script>

    {{-- {!! htmlScriptTagJsApi(['lang' => 'es']) !!} --}}
  </head>

  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
 
      @yield('main-content')
      
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    {{-- <!-- @include('partials.setting-panel') --> --}}

    <div id="cajacookies">
      <p style="margin-bottom: 0;">
      Utilizamos cookies para asegurar que damos la mejor experiencia al usuario en nuestra web. Si sigues utilizando este sitio asumiremos que estás de acuerdo. Puedes leer más sobre el uso de cookies en nuestra <a href="{{url('/politica-de-privacidad')}}">política de privacidad</a>. &nbsp;&nbsp;&nbsp;<button onclick="aceptarCookies()" class="btn btn-primary">Aceptar</button>
      </p>
    </div>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    {{-- <script src="{{url('vendors/popper/popper.min.js')}}"></script>  
    <script src="{{url('vendors/bootstrap/bootstrap.min.js')}}"></script> 
    <script src="{{url('vendors/anchorjs/anchor.min.js')}}"></script>  
    <script src="{{url('vendors/is/is.min.js')}}"></script>
    <script src="{{url('vendors/swiper/swiper-bundle.min.js')}}"> </script>
    <script src="{{url('vendors/typed.js/typed.js')}}"></script>
    <script src="{{url('vendors/fontawesome/all.min.js')}}"></script> 
    <!--<script src="{{url('vendors/echarts/echarts.min.js')}}"></script>-->  
    <script src="{{url('vendors/lodash/lodash.min.js')}}"></script>  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{url('vendors/list.js/list.min.js')}}"></script>  
    <script src="{{asset('js/theme.js')}}"></script>  --}}

  </body>

</html>