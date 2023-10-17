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
        <div class="row g-0 pb-2 pt-2" style="background-color: #000; border-bottom: 2px ridge #ff1620;">

            <div class="col-12 col-lg-6 text-start pt-2 ps-5 me-md-auto">
                <a href="/" class="text-decoration-none" title="Ir a Inicio">
                    @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 || Auth::user()->rol_id == 3 )
                         <img src="{{ URL('assets/img/rtthompson-logo.png') }}" alt="rt-logo" width="200" />
                    @else 
                         <img src="{{ Auth::user()->imagen_perfil_src }}" alt="client-logo" style="width: 100%; max-width: 115px; height: auto;" />
                    @endif
                </a>     
            </div>

            <div class="col-11 col-lg-5 text-end pt-2 pe-1 me-md-auto">
                
                <div class="my-4">
                    
                    <p>
                    <a href="" class="text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" title="En Línea">
                        <i class="fas fa-circle" style="font-size: 12px; color: green;"></i>
                        <span class="d-none d-sm-inline mx-1" style="font-size: 12px; text-transform: uppercase; font-weight: 800;">{{ Auth::user()->name }}</span>
                        @if ( Auth::user()->nombre_empresa != null)
                            <span class="d-none d-sm-inline mx-1" style="font-size: 12px; text-transform: uppercase; font-weight: 800;">({{ Auth::user()->nombre_empresa }})</span>
                        @endif
                    </a> | <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar Sesión">
                        <span class="d-none d-sm-inline mx-1" style="font-size: 12px; text-transform: uppercase; font-weight: 800;">SALIR</span> <i style="font-size: 12px;" class="fas fa-sign-out-alt"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf </form>
                    </p>

                </div> 
                
            </div>

            @if ( Auth::user()->rol_id == 0 || Auth::user()->rol_id == 1 )
                                
            {{-- CART ADMIN, SUPERADMIN y CLIENTE --}}
            <div id="hcart" class="col-1 col-lg-1 text-start pt-2 pe-2 me-md-auto">
                
                <div class="my-4 text-start" style="display: block;">
                    <a style="position: relative;" href="{{ url('/carrito') }}" title="Procesar Órden...">
                            <?php
                                $carrito = session('cart', []);
                                $cart = session()->get('cart', []);

                                $cantidad = 0;
                                
                                foreach ($carrito as $item) {
                                    $cantidad += $item['cantidad'];
                                }
                            ?>
                            <i style="font-size: 21px; margin: 3px 10px; color: #fff;" class="fa-solid fa-cart-shopping"></i><span style="position: absolute; bottom: 15px; left: 42px;">{{ $cantidad }}</span>
                    </a>
                </div>

                <?php
                $productosDisponibles = DB::table('producto')
                    ->where('estado_producto_id', '1')
                    ->get();
                ?>
            </div>

            @elseif ( Auth::user()->rol_id == 2 && $catalog_mode == 0)

            {{-- CART CLIENTE --}}
            <div class="col-1 col-lg-1 pt-2 text-center me-md-auto">

                <a class="btn btn-sm btn-primary py-2 px-3 my-4" style="position: relative;" href="{{ url('/carrito') }}" title="Procesar Órden ->">
                        <?php
                            $carrito = session('cart', []);
                            $cart = session()->get('cart', []);

                            $cantidad = 0;
                            
                            foreach ($carrito as $item) {
                                $cantidad += $item['cantidad'];
                            }
                        ?>
                        <i style="font-size: 20px;" class="fa-solid fa-cart-shopping"></i><span style="position: absolute; bottom: 20px; left: 42px;">{{ $cantidad }}</span>
                </a>

                <?php
                $productosDisponibles = DB::table('producto')
                    ->where('estado_producto_id', '1')
                    ->get();
                ?>
            </div>        

            @endif

        </div>
        @if ( $catalog_mode == 1 )
            <div id="modMsg" style="text-align: center; background-color: black; color: #fff; padding: 5px 0px;"> 🔧 VERSIÓN DE PRUEBA - TIENDA EN DESARROLLO 🔨</div>
        @endif
    </header>
    

    <div class="pb-6 pt-8" id="app">
        <div class="container-fluid">

            <div class="row flex-nowrap">

                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 py-5 px-2 nav-thompson">

                    <div class="d-flex flex-column align-items-center align-items-sm-start px-2 pt-2 text-white min-vh-100">
                        
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0" id="menu">
                            
                                <li>
                                    <a href="{{ url('/home') }}" class="nav-link px-0 align-middle {{ 'home' == request()->path() ? 'active-menu' : '' }}"><h5 class="rt-color-3 font-weight-bold">🖥 Dashboard  @if ( Auth::user()->rol_id == 1 || Auth::user()->rol_id == 0) (50%) @endif</h5></a>
                                </li>

                                <li><hr/></li>

                            @if ( Auth::user()->rol_id == 1 || Auth::user()->rol_id == 0)
                                
                                {{-- MENU ADMIN y SUPERADMIN --}}

                                <div class="divider mb-2"><h5 class="rt-color-3 font-weight-bold">⚒️ Configuraciones</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/perfil/configuracion') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-user-edit"></i> <span class="ms-1 d-none d-sm-inline">Perfil de Usuario</span></a>
                                </li>

                                @if ( Auth::user()->rol_id == 0)

                                    {{-- MENU SUPERADMIN --}}

                                    <li class="ps-4">
                                        <a href="{{ url('/configuracion/cms') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/configuracion/cms') !== false ? 'active-menu' : '' }}">
                                            <i class="fas fa-brush"></i> <span class="ms-1 d-none d-sm-inline">CMS</span></a>
                                    </li>

                                    <li class="ps-4">
                                        <a href="{{ url('/configuracion/users') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/configuracion/users') !== false ? 'active-menu' : '' }}">
                                            <i class="fas fa-users-cog"></i> <span class="ms-1 d-none d-sm-inline">Usuarios</span></a>
                                    </li>

                                    <li class="ps-4">
                                        <a href="{{ url('/configuracion/bitacora') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/configuracion/bitacora') !== false ? 'active-menu' : '' }}">
                                            <i class="fab fa-readme"></i> <span class="ms-1 d-none d-sm-inline">Bitácora</span> (75%)</a>
                                    </li>

                                @endif

                                <li><hr/></li>

                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">👜 Tienda</h5></div>
                                
                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/tienda') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/tienda') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-shopping-basket"></i> <span class="ms-1 d-none d-sm-inline">Catálogo/Compra</span>
                                    </a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/compra-masiva') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/compra-masiva') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-box-open"></i> <span class="ms-1 d-none d-sm-inline">Compra Rápida</span>
                                    </a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/productos') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/productos') !== false ? 'active-menu' : '' }}">
                                        <i class="fa-solid fa-newspaper"></i> <span class="ms-1 d-none d-sm-inline">Gestión de Productos</span>
                                    </a>
                                </li>
                                
                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/categorias') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/categorias') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-list-ul"></i> <span class="ms-1 d-none d-sm-inline">Categorías</span>
                                    </a>
                                </li>
                                
                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/marcas') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/marcas') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-copyright"></i> <span class="ms-1 d-none d-sm-inline">Marcas</span></a>
                                </li>
                                
                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/ordenes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/ordenes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-folder-open"></i> 
                                        <span class="ms-1 d-none d-sm-inline">Órdenes de Compra 
                                        <?php
                                            $ordenesSinVer = DB::table('orden')
                                                ->where('visto', 'nuevo')
                                                ->get();
                                            if (count($ordenesSinVer) != 0) {
                                                echo '<sup class="cantnoti">'.count($ordenesSinVer).'</sup>';
                                            }
                                            
                                        ?>    
                                        </span>
                                    </a>
                                </li>

                                <li><hr/></li>

                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">👥 Usuarios</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/aspirantes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/aspirantes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-users-cog"></i> 
                                        <span class="ms-1 d-none d-sm-inline">Aspirantes 
                                        <?php
                                            $aspitanresNew = DB::table('users')
                                                ->where('visto', 'nuevo')
                                                ->where('estatus', 'aspirante')
                                                ->get();
                                            if (count($aspitanresNew) != 0) {
                                                echo '<sup class="cantnoti">'.count($aspitanresNew).'</sup>';
                                            }
                                            
                                        ?>
                                        </span>
                                    </a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/clientes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/clientes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-medal"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span></a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/permisos') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/permisos') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-lock-open"></i> <span class="ms-1 d-none d-sm-inline">Autorizar Marcas</span></a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/contactos') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/contactos') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-user-plus"></i> 
                                        <span class="ms-1 d-none d-sm-inline">Contactos 
                                        <?php
                                            $msjNew = DB::table('contacto')
                                                ->where('visto', 'nuevo')
                                                ->get();
                                            if (count($msjNew) != 0) {
                                                echo '<sup class="cantnoti">'.count($msjNew).'</sup>';
                                            }
                                            
                                        ?>
                                        </span></a>
                                </li>

                                <li><hr/></li>

                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">📊 Datos</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/reportes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/reportes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-file-download"></i> <span class="ms-1 d-none d-sm-inline">Reportes</span>
                                    </a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/estadisticas') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/estadisticas') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-chart-pie"></i> <span class="ms-1 d-none d-sm-inline">Estadísticas (35%)</span>
                                    </a>
                                </li>

                                <li><hr/></li>

                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">📕 Documentación</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/manuales') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/manuales') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-file-pdf"></i> <span class="ms-1 d-none d-sm-inline">Manuales (1%)</span>
                                    </a>
                                </li>


                            @elseif ( Auth::user()->rol_id == 2 )
                                {{-- MENU CLIENTE --}}

                                <div class="divider mb-2"><h5 class="rt-color-3 font-weight-bold">👤 Mi Cuenta</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/perfil/configuracion') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-user-edit"></i> <span class="ms-1 d-none d-sm-inline">Mi Perfil</span></a>
                                </li>

                                @if ( $catalog_mode == 0 )

                                <li class="ps-4">
                                    <a href="{{ url('/perfil/ordenes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/perfil/ordenes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-truck-loading"></i> <span class="ms-1 d-none d-sm-inline">Mis Órdenes</span></a>
                                </li>

                                @endif

                                <li><hr/></li>
                                
                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">👜 Tienda</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/catalogo') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/catalogo') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-shopping-basket"></i> <span class="ms-1 d-none d-sm-inline">Catálogo</span>
                                    </a>
                                </li>

                                @if ( $catalog_mode == 0 )

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/tienda') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/tienda') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-shopping-basket"></i> <span class="ms-1 d-none d-sm-inline">Catálogo/Compra</span>
                                    </a>
                                </li>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/compra-masiva') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/compra-masiva') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-box-open"></i> <span class="ms-1 d-none d-sm-inline">Compra Rápida</span>
                                    </a>
                                </li>

                                @endif

                                <li><hr/></li>

                                <div class="divider"><h5 class="rt-color-3 font-weight-bold">📕 Documentación</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/manuales') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/manuales') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-file-pdf"></i> <span class="ms-1 d-none d-sm-inline">Manuales</span>
                                    </a>
                                </li>
                                 
                            @else
                                {{-- MENU BÓDEGA --}}

                                <div class="divider mb-2"><h5 class="rt-color-3 font-weight-bold">👤 Configuración de Cuenta</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/perfil/configuracion') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/perfil/configuracion') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-user-edit"></i> <span class="ms-1 d-none d-sm-inline">Mi Perfil</span></a>
                                </li>

                                <li><hr/></li>

                                <div class="divider mb-2"><h5 class="rt-color-3 font-weight-bold">🚚 Bódega</h5></div>

                                <li class="ps-4">
                                    <a href="{{ url('/dashboard/ordenes') }}" class="nav-link px-0 align-middle {{ strpos(request()->url(), '/dashboard/ordenes') !== false ? 'active-menu' : '' }}">
                                        <i class="fas fa-folder-open"></i> <span class="ms-1 d-none d-sm-inline">Órdenes de Compra</span></a>
                                </li>

                            @endif

                        </ul>

                    </div>

                </div>

                <div class="col-12 col-sm-9 col-md-9 col-lg-9 col-xl-9 py-5 px-2">
                    @yield('content')
                </div>

            </div>

        </div>
    @include('sweetalert::alert')
    </div>

    <footer class="footer rt-color-2-bg" style="border-top: 2px ridge #ff1620;">
      <div class="row g-0 justify-content-between fs--1 mt-4 mb-4 mx-4">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600"> &copy; 2023 <span class="d-none d-sm-inline-block">|</span> <br class="d-sm-none" /> Powered by <a class="opacity-85" href="https://markcoweb.com/" title="Ir a">MarkCoWeb</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600 rt-color-3"><a class="opacity-85" href="#" title="">RT</a> | v1.0.0</p>
        </div>
      </div>
    </footer>



</body>
</html>
