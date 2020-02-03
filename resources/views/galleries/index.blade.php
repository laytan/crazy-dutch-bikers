@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>Gallerijen</h2>
  @foreach($galleries as $gallery)
  <h3>{{ $gallery->title }}</h3>
    @foreach($gallery->pictures as $picture) 
      <img src="{{ Storage::url($picture->url) }}">
    @endforeach
  @endforeach
</div>
@endsection
