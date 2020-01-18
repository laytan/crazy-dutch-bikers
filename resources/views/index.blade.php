@extends('layouts.app')

@section('above-nav')
<div class="container-fluid header-background" style="background-image: linear-gradient(black, black), url('{{ url('/images/background-1.jpeg') }}');">
  <img class="logo" src="{{ url('/images/cdb-logo.png') }}">
  <ul class="d-flex justify-content-center flex-column h-100">
    @component('components.nav-button', ['engine' => '1', 'link' => url('/gallerij')])
      Gallerij
    @endcomponent
    @component('components.nav-button', ['engine' => '2', 'link' => url('/aanmelden')])
      Aanmelden
    @endcomponent
    @component('components.nav-button', ['engine' => '3', 'link' => url('/aanmelden')])
      Test
    @endcomponent
    @component('components.nav-button', ['engine' => '4', 'link' => url('/aanmelden')])
      Test 2
    @endcomponent
    @component('components.nav-button', ['engine' => '5', 'link' => url('/aanmelden')])
      Test 3
    @endcomponent
    @component('components.nav-button', ['engine' => '6', 'link' => url('/aanmelden')])
      Test 5
    @endcomponent
  </ul>
</div>
@endsection

@section('content')
<div class="container">
</div>
@endsection
