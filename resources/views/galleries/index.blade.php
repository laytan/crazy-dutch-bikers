@extends('layouts.app')

@section('content')
<div class="container text-light">
  <h2 class="pl-2">Gallerijen</h2>
  <div class="row">
    @foreach($galleries as $galleryIndex => $gallery)
      <div class="col col-12 col-md-6 py-4 p-md-4">
        <div id="carousel-{{ $gallery->id }}" class="carousel slide lazy" data-ride="carousel">
          <div class="carousel-inner">
            @foreach($gallery->pictures as $index => $picture)
            <div id="carousel-item-{{ $galleryIndex }}-{{ $index }}" class="carousel-item {{ $index === 0 ? 'active' : '' }}">
              <img loading="lazy" @if($index === 0 || $index === 1) src="{{ Storage::url($picture->url) }}" @else data-src="{{ Storage::url($picture->url) }}" @endif alt="{{ $picture->title }} carousel" class="d-block w-100 rounded-top carousel__image">
            </div>
            @endforeach
          </div>
        </div>
        <div class="gallery-title bg-cdbg p-3 w-100 rounded-bottom">
          <div class="row">
            <div class="col-6 d-flex align-items-center lead">
              {{ $gallery->title }}
            </div>
            <div class="col-6 d-flex align-items-end justify-content-end">
              <a class="btn btn-link btn-sm" href="{{ route('galleries.show', ['gallery' => $gallery->title]) }}">Bekijk alles <i class="fas fa-angle-double-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
