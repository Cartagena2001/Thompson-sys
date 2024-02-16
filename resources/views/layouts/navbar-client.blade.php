      <nav style="padding-bottom: 10px; background-color: black; border-bottom: 1px solid #ff1620; background-image: none;" class="navbar navbar-standard navbar-expand-lg navbar-dark" data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">

        <div class="container">

          {{-- 
          <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('assets/img/rtthompson-logo.png')}}" title="Ir a Inicio" style="width: 100%; max-width: 200px; height: auto;" class="" alt="rt-logo-img" /></a>
          --}}

          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

          <div class="collapse navbar-collapse scrollbar" id="navbarStandard">

            <!-- Menu Izq -->
            <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">

              <li class="nav-item">
                <a class="nav-link" href="{{url('/')}}" role="button" aria-haspopup="true" aria-expanded="false" id="dashboards">Inicio</a>
              </li>

              {{-- 
              <li class="nav-item">
                <a class="nav-link" href="{{url('/#servsection')}}" role="button" aria-haspopup="true" aria-expanded="false" id="documentations">Servicios</a>
              </li>
              --}}

              <li class="nav-item">
                <a class="nav-link" href="{{url('/#ussection')}}" role="button" aria-haspopup="true" aria-expanded="false" id="documentations">Nosotros</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{url('/#contactsection')}}" role="button" aria-haspopup="true" aria-expanded="false" id="documentations">Contáctanos</a>
              </li>

            </ul>

            <!-- Menu Der -->
            <ul class="navbar-nav ms-auto">

              @if (Route::has('login'))

                @auth

                  <div class="col-lg-12 text-center pt-2 mb-4">
                      <div class="dropdown flex-center">
                          <a href="" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                              id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" style="border: ridge 1px #ff1620; border-radius: 20px; padding: 1px 1px;">
                              <img src={{ Auth::user()->imagen_perfil_src }} alt="img-perfil" width="30" height="30" class="rounded-circle" />
                              <span class="d-none d-sm-inline mx-1" style="font-size: 12px; text-transform: uppercase; font-weight: 800;">{{ Auth::user()->name }}</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark text-small shadow py-1">
                              <li>
                                <a class="dropdown-item text-center" href="{{ route('home') }}">🏠 {{ __('Dashboard') }}</a>
                              </li>
                              <li>
                                <a class="dropdown-item text-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">❌ {{ __('Cerrar Sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                                </form>
                              </li>
                          </ul>
                      </div>                
                  </div>

                @else
                  <li id="iniMenu" class="nav-item"><a class="nav-link" href="{{ route('login') }}">Inicio de Sesión</a></li>

                  @if (Route::has('register'))
                    <li id="regMenu" class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                  @endif
                @endauth
              @endif
            </ul>

          </div>

        </div>

      </nav>




