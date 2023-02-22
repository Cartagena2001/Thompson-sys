<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Dashboard Thompson', 'Dashboard') }}</title>

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
    
</head>

<body class="test">
    <div id="app">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 nav-thompson">
                    <div
                        class="d-flex flex-column align-items-center align-items-sm-start px-5 pt-2 text-white min-vh-100">
                        <a href="/"
                            class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <img src="{{ URL('assets/img/rtthompson-logo.png') }}" alt="" width="200">
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <li>
                                <a href="{{ url('/home') }}" class="nav-link px-0 align-middle {{ 'home' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-chart-pie"></i> <span
                                        class="ms-1 d-none d-sm-inline">Dashboard</span></a>
                            </li>
                            <div class="divider">Productos</div>
                            <li>
                                <a href="{{ url('/dashboard/tienda') }}" class="nav-link px-0 align-middle {{ 'dashboard/tienda' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-shopping-basket"></i> <span
                                        class="ms-1 d-none d-sm-inline">Tienda</span></a>
                            </li>
                            <div class="divider">Ventas</div>
                            <li>
                                <a href="{{ url('/dashboard/productos') }}" class="nav-link px-0 align-middle {{ 'dashboard/productos' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-shopping-cart"></i> <span
                                        class="ms-1 d-none d-sm-inline">Productos</span></a>
                            </li>
                            <li>
                                <a href="{{ url('/dashboard/precios') }}" class="nav-link px-0 align-middle {{ 'dashboard/precios' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-dollar-sign"></i> <span class="ms-1 d-none d-sm-inline">Tipos de
                                        precio</span></a>
                            </li>
                            <li>
                                <a href="{{ url('/dashboard/categorias') }}" class="nav-link px-0 align-middle {{ 'dashboard/categorias' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-list-ul"></i> <span
                                        class="ms-1 d-none d-sm-inline">Categorias</span></a>
                            </li>
                            <li>
                                <a href="{{ url('/dashboard/marcas') }}" class="nav-link px-0 align-middle {{ 'dashboard/marcas' == request()->path() ? 'active-menu' : '' }}">
                                    <i class="fas fa-copyright"></i> <span
                                        class="ms-1 d-none d-sm-inline">Marcas</span></a>
                            </li>
                            <div class="divider">Clientes</div>
                            <li>
                                <a href="{{ url('/dashboard/cliente_lista') }}" class="nav-link px-0 align-middle">
                                    <i class="fas fa-user"></i> <span class="ms-1 d-none d-sm-inline">Lista de
                                        clientes</span></a>
                            </li>
                            <li>
                                <a href="{{ url('/dashboard/aspirante') }}" class="nav-link px-0 align-middle">
                                    <i class="fas fa-users-cog"></i> <span
                                        class="ms-1 d-none d-sm-inline">Aspirantes</span></a>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown pb-4">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30"
                                    class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                <li><a class="dropdown-item" href="#">Configuracion</a></li>
                                <li><a class="dropdown-item" href="#">perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="col py-3">
                    Content area...
                </div> --}}
                <div class="col py-5 px-5">
                    @yield('content')
                </div>
            </div>
        </div>
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}
        @include('sweetalert::alert')

    </div>
</body>

</html>
