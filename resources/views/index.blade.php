@extends('layouts.app')

@section('above-nav')
<div class="audio-player" data-audio-player="" data-song-name="Wild Ride">
  <audio>
    <source src="{{ url('/audio/theme.mpeg') }}" type="audio/mpeg">
  </audio>
  <div class="js-render">
    {{-- The actual audio element will render here --}}
  </div>
</div>
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
  <div class="container-fluid text-light text-lg">
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
  <div class="bg-cdbg-opaque py-5">
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
