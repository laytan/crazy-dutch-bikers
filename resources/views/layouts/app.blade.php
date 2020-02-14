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
        @include('partials.navigation')
        <div class="container">
            @include('partials.alerts')
        </div>
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
