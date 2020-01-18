<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body>
    <div id="app">
        <div class="top">
            <audio class="audio-theme" controls autoplay volume="0.2">
                <source src="{{ url('/audio/theme.mpeg') }}" type="audio/mpeg">
            </audio> 
            @yield('above-nav')
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @hasanyrole('admin|super-admin')
                                <li class="nav-item">
                                    <a href="{{ route('users-create') }}" class="nav-link">Leden toevoegen</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('products.create') }}" class="nav-link">Merchandise toevoegen</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('orders.index') }}" class="nav-link">Bestellingen ({{ orderAmt() }})</a>
                                </li>
                            @endhasanyrole
                            @hasanyrole('member|admin|super-admin')
                                <li class="nav-item">
                                    <a href="{{ route('users-index') }}" class="nav-link">Leden</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('products.index') }}" class="nav-link">Merchandise</a>
                                </li>
                            @endhasanyrole
                        </ul>
    
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown ml-auto">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @hasanyrole('member|admin|super-admin')
                                            <a class="dropdown-item" href="{{ route('change-password') }}">Verander wachtwoord</a>
                                        @endhasanyrole
    
                                        <a class="dropdown-item" href="#"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        @if(session('info'))
        <div class="container mt-4">
            <div class="alert alert-info">
                <p>{{ session('info') }}</p>
            </div>
        </div>
        @endif
        @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif
        @if (session('warning'))
        <div class="container mt-4">
            <div class="alert alert-warning">
                <p>{{ session('warning') }}</p>
            </div>
        </div>
        @endif
        @if (session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
