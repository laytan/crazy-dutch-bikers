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
                  <a href="{{ route('applications.index') }}">Aanmelden</a>
                </li>
                <li>Over ons</li>
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
              <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum laudantium maxime sunt nesciunt velit quidem vitae atque! Perspiciatis deserunt, doloremque debitis nihil aut vero nisi numquam optio esse, sunt quibusdam aliquid impedit? Labore provident corporis soluta culpa inventore sint natus? Omnis deserunt tempora quod illum error nobis et quos harum?</p>
              <a href="https://facebook.com/groups/crazydutchbikers" target="_BLANK" rel="noreferrer noopener"><i class="fab fa-facebook fa-2x"></i></a>
            </div>
          </div>
        </div>
        <div class="copyright py-3 bg-cdblg mt-4">
            <p class="text-center text-cdbg m-0">
                Powered by <a target="_BLANK" href="https://nl.linkedin.com/in/laytan" rel="noreferrer noopener">Laytan Laats</a>
            </p>
        </div>
        @yield('footer')
    </footer>
</body>
</html>
