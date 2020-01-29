@extends('layouts.app')

@section('above-nav')
<audio data-bpm="72" class="js-audio-theme" controls volume="0.2">
  <source src="{{ url('/audio/theme.mpeg') }}" type="audio/mpeg">
</audio> 
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
    @component('components.nav-button', ['engine' => '1', 'link' => url('/gallerij')])
      Gallerij
    @endcomponent
    @component('components.nav-button', ['engine' => '2', 'link' => url('/aanmelden')])
      Aanmelden
    @endcomponent
    @component('components.nav-button', ['engine' => '3', 'link' => route('events.index')])
      Evenementen
    @endcomponent
  </ul>
</div>
@endsection

@section('content')
<div id="content" class="container text-light mt-5 text-lg">
  <div class="row">
    <div class="col-5">
      <h2>De Club</h2>
      <p>
        Lorem ipsum dolor sit, amet <a href="#">consectetur</a> adipisicing elit. <strong>Fugit</strong> consectetur labore reiciendis, tempore voluptate cumque expedita error ipsa maxime perspiciatis atque nesciunt dolores libero iure vero vel delectus quisquam itaque similique! Cum placeat totam amet earum aspem recusandae!
        <button type="button" class="btn m-1 btn-primary">Primary</button>
        <button type="button" class="btn m-1 btn-secondary">Secondary</button>
        <button type="button" class="btn m-1 btn-success">Success</button>
        <button type="button" class="btn m-1 btn-danger">Danger</button>
        <button type="button" class="btn m-1 btn-warning">Warning</button>
        <button type="button" class="btn m-1 btn-info">Info</button>
        <button type="button" class="btn m-1 btn-light">Light</button>
        <button type="button" class="btn m-1 btn-dark">Dark</button>
        <button type="button" class="btn m-1 btn-link">Link</button>
      </p>
    </div>
    <div class="col-7">
      <img class="w-100" src="{{ url('/images/background-2.jpeg') }}" alt="Motor">
    </div>
  </div>
</div>
@endsection

<script>
window.onload = function() {
  const audio = document.querySelector('.js-audio-theme');
  const logo = document.querySelector('.js-logo');
  const pulse = (60 / Number(audio.dataset.bpm)) * 1000;
  console.log(logo, pulse);

  audio.play();
  audio.classList.add('playing');

  pulsing(logo, pulse);
  setInterval(function() { pulsing(logo, pulse) }, pulse);
};

function pulsing(logo, pulse) {
  logo.classList.add('pulse');

  setTimeout(() => {
    logo.classList.remove('pulse');
  }, pulse - 100);
}
</script>