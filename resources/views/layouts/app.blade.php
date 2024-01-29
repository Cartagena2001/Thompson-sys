<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Dashboard Thompson', 'Dashboard') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FontAwesome -->
    {{-- <script src="https://kit.fontawesome.com/9b3f9e4d8d.js" crossorigin="anonymous"></script> --}}
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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

    <!-- Glide -->
    <!-- Required Core Stylesheet -->
    <link rel="stylesheet" href="{{ url('assets/css/glide.core.min.css') }}">
    <!-- Optional Theme Stylesheet -->
    <link rel="stylesheet" href="{{ url('assets/css/glide.theme.min.css') }}">

    <!--
    <link href="{{url('assets/vendors/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{url('assets/vendors/overlayscrollbars/OverlayScrollbars.min.css')}}" rel="stylesheet"> -->

    @vite(['resources/sass/app.scss', 'resources/css/theme-rtl.css', 'resources/css/theme.css', 'resources/css/user-rtl.css', 'resources/css/user.css', 'resources/js/app.js'])
    
    <!-- tailwind CSS Style 
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    -->
    {!! htmlScriptTagJsApi(['lang' => 'es']) !!}
</head>

<?php
    
    $catalog_mode = 0;

    if ( isset($cat_mod) ) {
        $catalog_mode = $cat_mod;
    }

    
?>

<body class="test">



    <header class="sticky-menu">

        <nav class="navbar navbar-dark navbar-top navbar-expand-lg" style="background-color: #000; border-bottom: 2px ridge #ff1620;">

          <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

          <a class="navbar-brand me-1 me-sm-3" href="/" title="Ir a Inicio">
            <div class="d-flex align-items-center">
              @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 || Auth::user()->rol_id == 3 )
                   <img src="{{ URL('assets/img/accumetric-slv-logo-mod.png') }}" alt="rt-logo" style="width: 100%; max-width: 190px; height: auto;" />
              @else 
                   <img src="{{ Auth::user()->imagen_perfil_src }}" alt="client-logo" style="width: 100%; max-width: 52px; height: auto;" />
              @endif
            </div>
          </a>

          <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
            
            <ul class="navbar-nav">
              
              <li class="nav-item"><a class="nav-link {{ 'home' == request()->path() ? 'active-menu' : '' }}" href="{{ url('/home') }}" role="button" aria-haspopup="true" aria-expanded="false" id="inicios">🖥 Inicio  @if ( Auth::user()->rol_id == 1 || Auth::user()->rol_id == 0)  @endif</a>
              </li>

                @if ( Auth::user()->rol_id == 1 || Auth::user()->rol_id == 0)

                  {{-- MENU ADMIN y SUPERADMIN --}} 

                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="configs">⚒️ Configuraciones</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="configs">

                      <div class="bg-white dark__bg-1000 rounded-3 py-2">

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}" href="{{ url('/perfil/configuracion') }}">Perfil de Usuario</a>

                          @if ( Auth::user()->rol_id == 0)

                            {{-- MENU SUPERADMIN --}}
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/configuracion/cms') !== false ? 'active-menu' : '' }}" href="{{ url('/configuracion/cms') }}">CMS</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/configuracion/users') !== false ? 'active-menu' : '' }}" href="{{ url('/configuracion/users') }}">Usuarios</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/configuracion/bitacora') !== false ? 'active-menu' : '' }}" href="{{ url('/configuracion/bitacora') }}">Bitácora<span class="badge rounded-pill ms-2 badge-soft-success">Actualizado</span></a>

                          @endif

                      </div>

                    </div>

                  </li>

                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="documentations">👜 Tienda</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="documentations">
                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/tienda') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/tienda') }}"><i class="fas fa-shopping-basket"></i> Catálogo/Compra</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/compra-masiva') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/compra-masiva') }}"><i class="fas fa-box-open"></i> Compra Rápida</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/productos') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/productos') }}"><i class="fa-solid fa-newspaper"></i> Gestión de Productos</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/categorias') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/categorias') }}"><i class="fas fa-list-ul"></i> Categorías</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/marcas') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/marcas') }}"><i class="fas fa-copyright"></i> Marcas</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/ordenes/oficina') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/ordenes/oficina') }}"><i class="fas fa-folder-open"></i> Órdenes de Compra 
                          <?php
                              $ordenesSinVer = DB::table('orden')
                                  ->where('visto', 'nuevo')
                                  ->get();
                              if (count($ordenesSinVer) != 0) {
                                  echo '<sup class="cantnoti">'.count($ordenesSinVer).'</sup>';
                              }
                              
                          ?> </a>

                      </div>
                    </div>

                  </li>


                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="users">👥 Usuarios</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="users">

                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/aspirantes') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/aspirantes') }}"><i class="fas fa-users-cog"></i> Aspirantes 
                        <?php
                            $aspitanresNew = DB::table('users')
                                ->where('visto', 'nuevo')
                                ->where('estatus', 'aspirante')
                                ->get();
                            if (count($aspitanresNew) != 0) {
                                echo '<sup class="cantnoti">'.count($aspitanresNew).'</sup>';
                            }
                            
                        ?></a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/clientes') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/clientes') }}">
                          <i class="fas fa-medal"></i> Clientes</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/permisos') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/permisos') }}">
                          <i class="fas fa-lock-open"></i> Autorizar Marcas</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/permisos') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/permisos') }}">
                          <i class="fas fa-user-plus"></i> Contactos 
                          <?php
                              $msjNew = DB::table('contacto')
                                  ->where('visto', 'nuevo')
                                  ->get();
                              if (count($msjNew) != 0) {
                                  echo '<sup class="cantnoti">'.count($msjNew).'</sup>';
                              }
                              
                          ?></a>

                      </div>
                    </div>

                  </li>

                    <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="datos">📊 Datos</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="datos">

                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/reportes') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/reportes') }}">
                          <i class="fas fa-file-download"></i> Reportes</a>

                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/estadisticas') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/estadisticas') }}"><i class="fas fa-chart-pie"></i> Estadísticas</a>

                      </div>
                    </div>

                  </li>


                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="docs">📕 Documentación</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="docs">
                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/manuales') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/manuales') }}">
                          <i class="fas fa-file-pdf"></i> Manuales</a>

                      </div>
                    </div>

                  </li>

                @elseif ( Auth::user()->rol_id == 2 )
                  {{-- MENU CLIENTE --}}

                    <li class="nav-item dropdown">

                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="micuentas">👤 Mi Cuenta</a>

                      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="micuentas">

                        <div class="bg-white dark__bg-1000 rounded-3 py-2">
                          
                          <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}" href="{{ url('/perfil/configuracion') }}">
                            <i class="fas fa-user-edit"></i> Mi Perfil</a>

                          @if ( $catalog_mode == 0 )

                            <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/perfil/ordenes') !== false ? 'active-menu' : '' }}" href="{{ url('/perfil/ordenes') }}">
                            <i class="fas fa-truck-loading"></i> Mis Órdenes</a>

                          @endif

                        </div>
                      </div>

                    </li>

                    <li class="nav-item dropdown">

                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="tiendas">👜 Tienda</a>

                      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="tiendas">

                        <div class="bg-white dark__bg-1000 rounded-3 py-2">
                          
                          <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/catalogo') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/catalogo') }}">
                            <i class="fas fa-shopping-basket"></i> Catálogo</a>

                          @if ( $catalog_mode == 0 )

                            <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/tienda') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/tienda') }}">
                            <i class="fas fa-shopping-basket"></i> Catálogo/Compra</a>

                            <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/compra-masiva') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/compra-masiva') }}">
                            <i class="fas fa-box-open"></i> Compra Rápida</a>

                          @endif

                        </div>
                      </div>

                    </li>



                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="docs">📕 Documentación</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="docs">
                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/manuales') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/manuales') }}">
                          <i class="fas fa-file-pdf"></i> Manuales</a>

                      </div>
                    </div>

                  </li>

                @else
                  {{-- MENU BÓDEGA --}}

                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="configss">👤 Configuración de Cuenta</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="configss">

                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}" href="{{ url('/perfil/configuracion') }}">
                          <i class="fas fa-user-edit"></i> Mi Perfil</a>

                      </div>
                    </div>

                  </li>

                  <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="bodgs">🚚 Bódega</a>

                    <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="bodgs">

                      <div class="bg-white dark__bg-1000 rounded-3 py-2">
                        
                        <a class="dropdown-item link-600 fw-medium {{ strpos(request()->url(), '/dashboard/ordenes/bodega') !== false ? 'active-menu' : '' }}" href="{{ url('/dashboard/ordenes/bodega') }}">
                          <i class="fas fa-folder-open"></i> Órdenes de Compra</a>

                      </div>
                    </div>

                  </li>

                @endif

            </ul>
          
          </div>

          <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

            <li class="nav-item dropdown">
              
              <a class="nav-link px-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                  <img class="rounded-circle" src="{{ Auth::user()->imagen_perfil_src }}" alt="client-logo" style="width: 100%; max-width: 52px; height: auto;" />
                </div>
              </a>

              <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                  <a class="dropdown-item fw-bold text-warning" href="#!"><svg class="svg-inline--fa fa-crown fa-w-20 me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8 26.5 0 48-21.5 48-48s-21.5-48-48-48z"></path></svg><!-- <span class="fas fa-crown me-1"></span> Font Awesome fontawesome.com --><span>Go Pro</span></a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#!">Set status</a>
                  <a class="dropdown-item" href="../pages/user/profile.html">Profile &amp; account</a>
                  <a class="dropdown-item" href="#!">Feedback</a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../pages/user/settings.html">Settings</a>
                  <a class="dropdown-item" href="../pages/authentication/card/logout.html">Logout</a>
                </div>
              </div>
            </li>

            @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )
            
                {{-- CART ADMIN, SUPERADMIN --}}

                <li class="nav-item d-sm-block">

                  <a id="hcart" class="nav-link px-0" href="{{ url('/carrito') }}" title="Procesar Órden...">
                      <?php
                          $carrito = session('cart', []);
                          $cart = session()->get('cart', []);

                          $cantidad = 0;
                          
                          foreach ($carrito as $item) {
                              $cantidad += $item['cantidad'];
                          }
                      ?>
                    <i style="font-size: 16px; margin: 0px 4px; color: #fff;" class="fa-solid fa-cart-shopping"></i><sup>{{ $cantidad }}</sup>
                  </a>

                </li>

                <?php
                    $productosDisponibles = DB::table('producto')
                    ->where('estado_producto_id', '1')
                    ->get();
                ?>

            @elseif ( Auth::user()->rol_id == 2 && $catalog_mode == 0)

                {{-- CART CLIENTE --}}

                <li class="nav-item d-sm-block"> {{-- d-none --}}

                  <a id="hcart" class="nav-link px-0" href="{{ url('/carrito') }}" title="Procesar Órden...">
                      <?php
                          $carrito = session('cart', []);
                          $cart = session()->get('cart', []);

                          $cantidad = 0;
                          
                          foreach ($carrito as $item) {
                              $cantidad += $item['cantidad'];
                          }
                      ?>
                    <i style="font-size: 16px; margin: 0px 4px; color: #fff;" class="fa-solid fa-cart-shopping"></i><sup>{{ $cantidad }}</sup>
                  </a>

                </li>

                <?php
                    $productosDisponibles = DB::table('producto')
                    ->where('estado_producto_id', '1')
                    ->get();
                ?>

            @endif

          </ul>

        </nav>

        @if ( $catalog_mode == 1 )
            <div id="modMsg" style="font-size: 12px; text-align: center; background-color: black; color: #fff; padding: 5px 0px;"> 🔧 &nbsp; VERSIÓN DE PRUEBA - TIENDA EN DESARROLLO &nbsp; 🔨</div>
        @endif

    </header>
    
    <div class="pb-6 pt-8" id="app">
        <div class="container-fluid">

            <div class="row flex-nowrap">

                <div id="ctt" style="margin: 0 auto;" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-2 py-2">
                    @yield('content')
                </div>

            </div>

        </div>
    @include('sweetalert::alert')
    </div>

    <footer class="footer rt-color-2-bg" style="border-top: 2px ridge #ff1620;"> {{-- position: fixed; z-index: 1000; --}}
      
      <div class="row g-0 justify-content-between fs--1 mt-3 mb-3 mx-3">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600"> &copy; 2023 <span class=" d-sm-inline-block">|</span> <br class="d-sm-none" /> Powered by <a class="opacity-85" href="https://markcoweb.com/" title="Ir a">MarkCoWeb</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600 rt-color-3"><a class="opacity-85" href="#" title="">RT</a> | v1.0.0</p>
        </div>
      </div>

    </footer>

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script>
        am4core.options.commercialLicense = true;
    </script>  

</body>
</html>
