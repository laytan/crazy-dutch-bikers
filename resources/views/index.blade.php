@extends('layouts.app')

@section('above-nav')
<audio data-bpm="72" class="audio-theme" controls volume="0.2">
  <source src="{{ url('/audio/theme.mpeg') }}" type="audio/mpeg">
</audio> 
<div class="container-fluid header-background" style="background-image: linear-gradient(black, black), url('{{ url('/images/background-2.jpeg') }}');">
  <div class="header-center text-center p-5 d-flex justify-content-center align-items-center flex-column">
    <img class="logo mb-4" src="{{ url('/images/cdb-logo.png') }}">
    <button onclick="document.getElementById('content').scrollIntoView({ behavior: 'smooth' });" class="cdb-btn mt-4">
      <img class="img-one" src="{{ url('/images/wheel.png') }}" alt="">
      <span>Maak kennis met de club</span>
      <img class="img-two" src="{{ url('/images/wheel.png') }}" alt="">
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
      <h2 class="cdb-font">De Club</h2>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, vero pariatur itaque cum modi soluta velit voluptates quis voluptatibus unde quo quam, adipisci odit quasi cumque totam rerum? Quos, dicta.
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
  const audio = document.querySelector('.audio-theme');
  const logo = document.querySelector('.logo');
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