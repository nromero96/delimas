<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - {{ config('app.name') }}</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">


    </head>
    <body class="d-flex flex-column min-vh-100">
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #8ec500;">
            <div class="container">
                <a class="navbar-brand" href="{{  url('dashboard') }}">
                    <img src="{{ asset('/images/logo.png')}}" width="42px"> <b>{{ config('app.name') }}</b>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link opcsmenu {{ (request()->is('dashboard')) ? 'active' : '' }}" aria-current="page" href="{{  url('dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                <span>Tablero</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link opcsmenu dropdown-toggle {{ (request()->is('program*')) ? 'active' : '' }}" href="#" id="navbarDropdownProgram" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-collection"></i>
                                <span>Programa</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownProgram">
                                <li><a class="dropdown-item" href="{{  url('program/create') }}">Nuevo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  url('program') }}">Lista</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link opcsmenu dropdown-toggle {{ (request()->is('customer*')) ? 'active' : '' }}" href="#" id="navbarDropdownCustomer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people"></i>
                                <span>Cliente</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCustomer">
                                <li><a class="dropdown-item" href="{{  url('customer/create') }}">Nuevo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  url('customer') }}">Lista</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link opcsmenu dropdown-toggle {{ (request()->is('period*')) ? 'active' : '' }}" href="#" id="navbarDropdownCustomer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-calendar-range"></i>
                                <span>Periodo</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCustomer">
                                <li><a class="dropdown-item" href="{{  url('period/create') }}">Nuevo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  url('period') }}">Lista</a></li>
                            </ul>
                        </li>

                        <li class="nav-itemv dropdown">
                            <a class="nav-link opcsmenu dropdown-toggle {{ (request()->is('users')) ? 'active' : '' }}" href="#" id="navbarDropdownUsers" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Usuarios</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownUsers">
                                <li><a class="dropdown-item" href="{{  url('users/create') }}">Nuevo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  url('users') }}">Lista</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link opcsmenu dropdown-toggle {{ (request()->is('holiday','districts')) ? 'active' : '' }}"  href="#" id="navbarDropdownSetting" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i>
                                <span>Ajustes</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownSetting">
                                <li><a class="dropdown-item" href="{{  route('holiday.index') }}">Feriados</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  route('districts.index') }}">Distritos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{  route('landingsetting') }}">Landing Page</a></li>
                            </ul>
                        </li>

                    </ul>


                    @auth
                    <div class="nav-item dropdown profilenav">
                        <a href="#" class="nav-item nav-link dropdown-toggle user-action" id="navbarDropdownProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="https://www.tutorialrepublic.com/examples/images/avatar/3.jpg" class="avatar" alt="Avatar"> {{ Auth::user()->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProfile">

                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person-circle"></i> Perfil</a></li>

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-unlock-fill"></i> Cerrar sesión
                                    </a>
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                </li>
                        </ul>
                    </div>
                    @endauth

                </div>
            </div>
        </nav>

        <header class="d-flex py-2 bg-white shadow-sm border-bottom">
            <div class="container d-flex align-items-center">
                <h2 class="h4 me-auto font-weight-bold titlepage mb-0">@yield('title')</h2>
                @yield('buttonsarea')
            </div>
        </header>

        <div class="container">
            @yield('content')
        </div>


        <footer class="mt-auto bg-secondary pt-3 bg-opacity-10">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Facturación</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Precios</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
            </ul>
            <p class="text-center text-muted">© 2022 <b>Delimas</b> | Software by <a href="#">ExcelData</a></p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/locales/bootstrap-datepicker.es.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>

        <script type="text/javascript" src="{{ mix('js/adminjs.js') }}"></script>

        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>

        @yield('customscripts')

    </body>
</html>