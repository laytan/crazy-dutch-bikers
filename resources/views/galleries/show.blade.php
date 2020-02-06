@extends('layouts.app')

@section('content')
<div class="container text-light">
  <h2>{{ $gallery->title }}</h2>
  <div class="masonry">
    @foreach($gallery->pictures as $picture) 
      <div class="masonry__tile">
        <img src="{{ Storage::url($picture->url) }}">
      </div>
    @endforeach
  </div>
</div>
@endsection
