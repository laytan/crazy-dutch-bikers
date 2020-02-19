@extends('layouts.app')

@section('nav-end')
<div class="audio-player d-flex align-items-end position-lg-absolute position-xl-relative d-lg-block" data-audio-player="" data-song-name="Wild Ride">
    <audio>
        <source src="{{ url('/audio/theme.mpeg') }}" type="audio/mpeg">
    </audio>
    <div class="js-render">
        {{-- The actual audio element will render here --}}
    </div>
</div>
@endsection

@section('above-nav')
<div class="welcome-background container-fluid">
  <div class="welcome text-center p-5 d-flex justify-content-center align-items-center flex-column position-absolute">
    <img class="welcome__logo js-logo mb-4" src="{{ url('/images/cdb-logo.png') }}">
    <button onclick="document.getElementById('content').scrollIntoView({ behavior: 'smooth' });" class="wheel-btn mt-4 d-flex border-0 align-items-start justify-content-center">
      <img class="wheel-btn__wheel wheel-btn__wheel--left p-2" src="{{ url('/images/wheel.png') }}" alt="">
      <span class="wheel-btn__text h4">Maak kennis met de club</span>
      <img class="wheel-btn__wheel wheel-btn__wheel--right p-2" src="{{ url('/images/wheel.png') }}" alt="">
    </button>
  </div>
  <ul class="d-flex justify-content-center flex-column h-100 no-list-style">
    @component('components.nav-button', ['engine' => '1', 'link' => route('galleries.index')])
      Gallery
    @endcomponent
    @component('components.nav-button', ['engine' => '3', 'link' => route('events.index')])
      Events
    @endcomponent
    @component('components.nav-button', ['engine' => '2', 'link' => route('login')])
      <span dusk="home-login-btn">Members only</span>
    @endcomponent
    @component('components.nav-button', ['engine' => '4', 'link' => url('/aanmelden')])
      Join us
    @endcomponent
  </ul>
</div>
@endsection

@section('content')
<div id="content">
  <div class="container-fluid text-light text-lg mb-6">
    <div class="row">
      <div class="col-12 d-none col-md-6 d-md-block p-0 overflow-hidden" data-match="#home-about-section">
        <img class="w-100 h-100 object-fit-cover" src="{{ url('/images/background-2.jpeg') }}" alt="Motor">
      </div>
      <div id="home-about-section" class="col-12 col-md-6 bg-cdbg-opaque">
        <div class="p-5">
          <h2 class="border-bottom pb-3 border-primary border-4">De <span class="h1 text-primary">Cra<span class="h5 text-primary">Z</span>y</span><br>Dutch Bikers</h2>
          <p class="pt-3 lead">
            Welkom bij MTC Crazy Dutch Bikers.
          </p>
          <p>
            Wij zijn een Motor Touring Club dat graag zijn passie voor motoren en motorrijden deelt met andere motorrijders.
          </p>
          <button class="btn btn-primary">Meer informatie</button>
        </div>
      </div>
    </div>
  </div>
  <p class="bg-primary p-5 my-6 d-flex justify-content-around lead">
    <span class="px-2 h3">Broederschap</span>
    <span class="px-2 h3">Vertrouwen</span>
    <span class="px-2 h3">Gezelligheid</span>
  </p>
  <div class="container-fluid my-6">
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-4 mb-4 order-xl-5">
            <div class="pr-3 pr-md-5">
                <h2>Onze opkomende evenementen</h2>
                <p>
                    De Crazy Dutch Bikers houden van een feestje en nodigen jullie uit om een keer mee te komen.
                </p>
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">
                    Bekijk alle evenementen
                </a>
            </div>
        </div>
        @foreach(App\Event::nearest(4) as $event)
            <div class="col-6 col-lg-4 col-xl-2 featured-event mb-6">
                <a class="d-flex flex-column h-100" href="{{ route('events.index') }}">
                    <div class="flex-grow-1 bg-cdbg-opaque d-flex align-items-center featured-event__picture">
                        <img src="{{ Storage::url($event->picture) }}" alt="{{ $event->title }}">
                    </div>
                    <div class="featured-event__text ml-2 mb-2 text-white">
                        <p class="mt-2 lead mb-0">{{ $event->title }}</p>
                        <small>{{ $event->formattedTime }}</small>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
  </div>
  <div class="bg-cdbg-opaque py-5 my-6">
    <div class="text-center">
      <h2 class="p-0 m-0">Nieuwste foto's</h2>
    </div>
    <div class="container">
      <div class="row">
        @for($i = 0; $i < 4; $i++)
        <div class="col-6">
          <div class="mt-4 p-4 bg-cdbg">
            <p class="m-0">Openingsfeest</p>
            <img class="w-100 my-2" src="{{ url('/images/background-2.jpeg') }}" alt="Motor">
            <div class="d-flex justify-content-between align-items-center">
              <small>20 september 2020</small>
              <a href="#">Bekijk volledige gallerij</a>
            </div>
          </div>
        </div>
        @endfor
      </div>
    </div>
  </div>
</div>
@endsection
