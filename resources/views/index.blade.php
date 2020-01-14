@extends('layouts.app')

@section('above-nav')
<div class="container-fluid header-background" style="background-image: linear-gradient(black, black), url('{{ url('/images/background-1.jpeg') }}');">
  <img class="logo" src="{{ url('/images/cdb-logo.png') }}">
  <ul>
    <li class="cdb-nav-item">
      <img src="{{ url('/images/engines/1.png') }}">
      <span>Gallerij</span>
    </li>
  </ul>
</div>
@endsection

@section('content')
<div class="container">
  <button class="btn btn-light nav-button">
    <span class="d-inline-block mr-2">Gallerij</span><img class="d-inline-block" src="{{ url('/images/engines/1.png') }}">
  </button>
  <button class="btn btn-light nav-button-2">
    <a href="#">
      <img class="d-inline-block" src="{{ url('/images/engines/1.png') }}">
      <span>Gallerij</span>
    </a>
  </button>
</div>
@endsection
