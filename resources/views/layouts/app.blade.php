<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    <div id="app">
        <div class="top">
            @yield('above-nav')
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark navigation sticky-top">
            <a class="navbar-brand h1 mr-5" href="{{ route('index') }}">
                Cra<span class="navbar-brand__z">Z</span>y Dutch Bikers
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navigation" class="navbar-collapse collapse w-100 order-1 order-lg-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    @can('manage')
                        @component('components.dropdown', ['title' => 'Leden'])
                            <a href="{{ route('users.create') }}" class="dropdown-item">Leden toevoegen</a>
                            <a href="{{ route('users.index') }}" class="dropdown-item">Leden overzicht</a>
                        @endcomponent
                        @component('components.dropdown', ['title' => 'Evenementen'])
                            <a href="{{ route('events.create') }}" class="dropdown-item">Evenementen toevoegen</a>
                            <a href="{{ route('events.index') }}" class="dropdown-item">Evenementen overzicht</a>
                        @endcomponent
                        @component('components.dropdown', ['title' => 'Merchandise'])
                            <a href="{{ route('products.create') }}" class="dropdown-item">Merchandise toevoegen</a>
                            <a href="{{ route('products.index') }}" class="dropdown-item">Merchandise overzicht</a>
                        @endcomponent
                        @component('components.dropdown', ['title' => 'Gallerij'])
                            <a href="{{ route('galleries.create') }}" class="dropdown-item">Gallerij toevoegen</a>
                            <a href="#" class="dropdown-item">Gallerijen overzicht</a>
                            <a href="#" class="dropdown-item">Foto's toevoegen</a>
                            <a href="#" class="dropdown-item">Foto's overzicht</a>
                        @endcomponent
                        <li class="nav-item">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('orders.index') }}" class="nav-link d-flex align-items-center">
                                    Bestellingen<span class="badge badge-primary ml-2">{{ orderAmt() }}</span>
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link text-decoration-none">Leden</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" class="nav-link text-decoration-none">Evenementen</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link text-decoration-none">Merchandise</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-decoration-none">Gallerij</a>
                        </li>
                    @endcan
                </ul>
            </div>
            <div class="navbar-collapse collapse w-100 order-2 dual-collapse2">
                <ul class="navbar-nav ml-auto justify-content-end">
                    @guest
                        <li class="nav-item">
                            @include('partials.login')
                        </li>
                    @else
                        @component('components.dropdown', ['title' => Auth::user()->name, 'right' => true])
                            <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}" class="dropdown-item">Profiel</a>
                            @include('partials.change-password')
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Uitloggen
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @endcomponent
                    @endguest
                </ul>
            </div>
        </nav>
        @if(session('info'))
        <div class="container mt-4">
            <div role="alert" class="alert-dismissible fade show alert alert-info">
                <p class="mb-0">{{ session('info') }}</p>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if (session('success'))
        <div class="container mt-4">
            <div role="alert" class="alert-dismissible fade show alert alert-success">
                <p class="mb-0">{{ session('success') }}</p>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if (session('warning'))
        <div class="container mt-4">
            <div role="alert" class="alert-dismissible fade show alert alert-warning">
                <p class="mb-0">{{ session('warning') }}</p>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if (session('error'))
        <div class="container mt-4">
            <div role="alert" class="alert-dismissible fade show alert alert-danger">
                <p class="mb-0">{{ session('error') }}</p>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        <main>
            @yield('content')
        </main>
    </div>
    <footer class="bg-cdblg footer">
        <i class="fab fa-facebook"></i>
        <div class="copyright py-1">
            <p class="text-center text-cdbg">
                Powered by <a href="https://github.com/laytan">Laytan Laats</a>
            </p>
        </div>
        @yield('footer')
    </footer>
</body>
</html>
