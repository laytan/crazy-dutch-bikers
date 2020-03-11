<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google search console -->
    <meta name="google-site-verification" content="ywOBdHgBTPhbVrdQi5lYPIzmNeH9WbOzbvauUwcQOhI" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Crazy Dutch Bikers') }}@yield('title')</title>
    <meta name="title" content="{{ config('app.name', 'Crazy Dutch Bikers') }}@yield('title')">

    <meta name="description" content="@yield('description', 'Wij zijn een Motor Touring Club dat graag zijn passie voor motoren en motorrijden deelt met andere motorrijders')">

    <!-- Icon -->
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="icon" href="/favicon.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column">
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
    <footer class="bg-cdbg pt-3 footer mt-6">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-6 col-lg-3 mt-3 footer-item">
              <h2 class="footer-item__title">Links</h2>
              <ul>
                <li>
                  <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                  <a href="{{ route('login') }}">Login</a>
                </li>
                <li>
                  <a href="{{ route('applications.create') }}">Aanmelden</a>
                </li>
                <li>
                  <a href="{{ route('about') }}">Over ons</a>
                </li>
                <li>
                  <a href="{{ route('galleries.index') }}">Gallerijen</a>
                </li>
                <li>
                  <a href="{{ route('events.index') }}">Evenementen</a>
                </li>
                @auth
                  <li>
                    <a href="{{ route('products.index') }}">Merchandise</a>
                  </li>
                @endauth
                @can('manage')
                  <li>
                    <a href="{{ route('orders.index') }}">Bestellingen</a>
                  </li>
                  <li>
                    <a href="{{ route('applications.index') }}">Aanmeldingen</a>
                  </li>
                @endcan
                <li>
                  <a href="{{ route('privacy') }}">Privacy Beleid</a>
                </li>
                <li>
                  <a href="{{ route('disclaimer') }}">Disclaimer</a>
                </li>
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-3 footer-item">
              <h2 class="footer-item__title">Laatste Gallerijen</h2>
              <ul>
                @foreach(App\Gallery::latest(5) as $gallery)
                  <li>
                    <a href="{{ route('galleries.show', ['gallery' => $gallery->title]) }}">{{ $gallery->title }}</a>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-3 footer-item">
              <h2 class="footer-item__title">Opkomende Evenementen</h2>
              <ul>
                @foreach(App\Event::nearest(5) as $event)
                <li>
                  <a href="{{ route('events.index') }}">{{ $event->title }}</a>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mt-3 footer-item footer-item--no-title">
              <p>
                Wij zijn een Motor Touring Club dat graag zijn passie voor motoren en motorrijden deelt met andere motorrijders.
              </p>
              <p class="mb-2">
                Volg ons op social media:
              </p>
              <a href="https://facebook.com/groups/crazydutchbikers" target="_BLANK" rel="noreferrer noopener"><i class="fab fa-facebook fa-2x"></i></a>
            </div>
          </div>
        </div>
        <div class="copyright py-3 bg-cdbb mt-4">
            <p class="text-center text-light m-0">
                Powered by <a target="_BLANK" href="https://laytanlaats.com/" rel="noreferrer noopener">Laytan Laats</a>
            </p>
        </div>
        @yield('footer')
    </footer>
</body>
</html>
