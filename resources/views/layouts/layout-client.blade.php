<!DOCTYPE html>
<html lang="es-Es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Representaciones Thompson</title>
                                     

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/img/favicons/apple-touch-icon.png')}}"> 
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/img/favicons/favicon-32x32.png')}}"> 
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('assets/img/favicons/favicon-16x16.png')}}"> 
    <link rel="shortcut icon" type="image/x-icon" href="{{url('assets/img/favicons/favicon.ico')}}">         
    <link rel="manifest" href="{{url('assets/img/favicons/manifest.json')}}">                                
    <meta name="msapplication-TileImage" content="{{url('assets/img/favicons/mstile-150x150.png')}}">        
    <meta name="theme-color" content="#ffffff">

    <script src="{{url('assets/js/config.js')}}"></script>                                                   
    <script src="{{url('assets/vendors/overlayscrollbars/OverlayScrollbars.min.js')}}"></script>

    <!-- LOAD JQUERY LIBRARY -->                   
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <!-- LOADING FONTS AND ICONS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400%7CFira+Sans:500&display=swap" rel="stylesheet" property="stylesheet" media="all" type="text/css" >

    
    <link rel="stylesheet" type="text/css" href="{{ URL('assets/revs6/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ URL('assets/revs6/fonts/font-awesome/css/font-awesome.css') }}"> 
    
    <!-- REVOLUTION STYLE SHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ URL('assets/revs6/css/rs6.css') }}">  
    
    <!-- REVOLUTION LAYERS STYLES -->
    <!-- REVOLUTION JS FILES -->
    
    <script>
      window.RS_MODULES = window.RS_MODULES || {};
      window.RS_MODULES.modules = window.RS_MODULES.modules || {};
      window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
      window.RS_MODULES.defered = true;
      window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
      window.RS_MODULES.type = 'compiled';
    </script>
    <script src="{{ URL('assets/revs6/js/rbtools.min.js') }}"></script>   
    <script src="{{ URL('assets/revs6/js/rs6.min.js') }}"></script>         
            
    <script>function setREVStartSize(e){
      //window.requestAnimationFrame(function() {
        window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;
        window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;
        try {
          var pw = document.getElementById(e.c).parentNode.offsetWidth,
            newh;
          pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
          e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
          e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
          e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
          e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
          e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
          e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
          e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
          if(e.layout==="fullscreen" || e.l==="fullscreen")
            newh = Math.max(e.mh,window.RSIH);
          else{
            e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
            for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
            e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
            e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
            for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
                      
            var nl = new Array(e.rl.length),
              ix = 0,
              sl;
            e.tabw = e.tabhide>=pw ? 0 : e.tabw;
            e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
            e.tabh = e.tabhide>=pw ? 0 : e.tabh;
            e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
            for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
            sl = nl[0];
            for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
            var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
            newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
          }
          var el = document.getElementById(e.c);
          if (el!==null && el) el.style.height = newh+"px";
          el = document.getElementById(e.c+"_wrapper");
          if (el!==null && el) {
            el.style.height = newh+"px";
            el.style.display = "block";
          }
        } catch(e){
          console.log("Failure at Presize of Slider:" + e)
        }
      //});
      };</script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->

    <link href="{{url('assets/vendors/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="{{url('assets/vendors/overlayscrollbars/OverlayScrollbars.min.css')}}" rel="stylesheet">  
    <link href="{{url('assets/css/theme-rtl.css')}}" rel="stylesheet" id="style-rtl">
    <link href="{{url('assets/css/theme.css')}}" rel="stylesheet" id="style-default">
    <link href="{{url('assets/css/user-rtl.css')}}" rel="stylesheet" id="user-style-rtl"> 
    <link href="{{url('assets/css/user.css')}}" rel="stylesheet" id="user-style-default">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FontAwesome -->
    {{-- <script src="https://kit.fontawesome.com/9b3f9e4d8d.js" crossorigin="anonymous"></script> --}}

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
    
  {{--   @vite(['resources/sass/app.scss', 'resources/css/theme-rtl.css', 'resources/css/theme.css', 'resources/css/user-rtl.css', 'resources/css/user.css', 'resources/js/app.js'])
  --}}

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

    {!! htmlScriptTagJsApi(['lang' => 'es']) !!}
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
    <script src="{{url('assets/vendors/popper/popper.min.js')}}"></script>  
    <script src="{{url('assets/vendors/bootstrap/bootstrap.min.js')}}"></script> 
    <script src="{{url('assets/vendors/anchorjs/anchor.min.js')}}"></script>  
    <script src="{{url('assets/vendors/is/is.min.js')}}"></script>
    <script src="{{url('assets/vendors/swiper/swiper-bundle.min.js')}}"> </script>
    <script src="{{url('assets/vendors/typed.js/typed.js')}}"></script>
    <script src="{{url('assets/vendors/fontawesome/all.min.js')}}"></script> 
    <!--<script src="{{url('vendors/echarts/echarts.min.js')}}"></script>-->  
    <script src="{{url('assets/vendors/lodash/lodash.min.js')}}"></script>  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{url('assets/vendors/list.js/list.min.js')}}"></script>  
    <script src="{{url('assets/js/theme.js')}}"></script>
    
  </body>

</html>



