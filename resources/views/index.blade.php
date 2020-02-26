@extends('layouts.app')

@section('above-nav')
<div class="welcome-background container-fluid p-0">
  <div class="header-row">
    <div class="header-row__item">
      <ul class="header-menu d-flex justify-content-center flex-column h-100 no-list-style p-0">
        @component('components.nav-button', ['engine' => '1', 'link' => route('galleries.index')])
          Gallery
        @endcomponent
        @component('components.nav-button-right', ['engine' => '1', 'link' => route('events.index')])
          Events
        @endcomponent
        @component('components.nav-button', ['engine' => '1', 'link' => route('login')])
          <span dusk="home-login-btn">Members</span>
        @endcomponent
        @component('components.nav-button-right', ['engine' => '1', 'link' => url('/aanmelden')])
          Join
        @endcomponent
      </ul>
    </div>
    <div class="header-row__item">
      <div class="welcome text-center d-flex justify-content-center align-items-center flex-column">
        <img class="welcome__logo js-logo mb-4" src="{{ url('/images/cdb-logo.png') }}">
        <button onclick="document.getElementById('content').scrollIntoView({ behavior: 'smooth' });" class="wheel-btn mt-4 d-flex border-0 align-items-start justify-content-center">
          <img class="wheel-btn__wheel wheel-btn__wheel--left p-2" src="{{ url('/images/wheel.png') }}" alt="">
          <span class="wheel-btn__text h6">Maak kennis met de club</span>
          <img class="wheel-btn__wheel wheel-btn__wheel--right p-2" src="{{ url('/images/wheel.png') }}" alt="">
        </button>
      </div>
    </div>
  </div>
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
        <div class="px-lg-5 py-5">
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
  <div class="container-fluid p-0">
    <div class="row bg-primary p-5 my-6">
      <div class="col-12 col-lg-4 text-center border-bottom border-cdbg border-4 border-lg-0 pb-4 pb-lg-0">
        <h2>Broederschap</h2>
      </div>
      <div class="col-12 col-lg-4 text-center border-bottom border-cdbg border-4 border-lg-0 py-4 py-lg-0">
        <h2>Vertrouwen</h2>
      </div>
      <div class="col-12 col-lg-4 text-center pt-4 pt-lg-0">
        <h2>Gezelligheid</h2>
      </div>
    </div>
  </div>
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
  <div>
    <div class="container-fluid">
      <div class="row">
        @php
          $featured = App\Gallery::featured();
        @endphp
        <div class="col-12 order-2 col-lg-8 order-lg-1 mt-5 mt-lg-0 bg-cdbg-opaque rounded p-3">
          <div class="latest-images">
            <div class="latest-images__title text-center pl-lg-3 pb-2">
              <a href="{{ route('galleries.show', ['gallery' => $featured->id]) }}">
                <h2 class="h5 h-sm-2">{{ $featured->title }}</h2>
              </a>
              <div class="d-flex justify-content-between">
                <small><i class="fas fa-images"></i> {{ $featured->pictures_count }}</small>
                <small>{{ $featured->created_at->setTimeZone('Europe/paris')->diffForHumans() }} <i class="fas fa-clock"></i></small>
              </div>
            </div>
            @foreach($featured->pictures as $i => $pic)
            <div class="latest-images__{{ $i + 1 }} shadow">
              <img src="{{ Storage::url($pic->url) }}" class="rounded">
            </div>
            @endforeach
          </div>
        </div>
        <div class="col-12 order-1 col-lg-4 order-lg-2">
          <h3 class="h5">Nieuwste Gallerij</h3>
          <p>Bekijk hier een paar foto's van onze laatste gallerij.</p>
          <p>De Crazy Dutch Bikers zijn in voor feestjes en laten dat ook zien. Door middel van foto's kijken wij terug op alle gezellige feestjes, ritjes en evenementen.</p>
          <div>
            <button class="btn btn-primary d-block w-100">Bekijk alle foto's</button>
            <button class="btn btn-outline-primary d-block w-100 mt-2">Bekijk {{ $featured->title }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
