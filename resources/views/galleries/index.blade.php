@extends('layouts.app')

@section('description', 'Een collectie van al onze gallerijen en foto\'s, kom hier meer te weten over de evenementen en activiteiten door middel van een visueel beeld.')

@section('content')
<div class="container text-light">
  <div class="d-flex align-items-center justify-content-between">
    @component('components.title', ['icon' => 'fas fa-images'])
    Gallerijen
    @endcomponent
    @can('manage')
      @component('components.modal', ['id' => 'create-gallery-modal', 'title' => 'Gallerij aanmaken'])
        {{ Aire::open()->route('galleries.store')->multipart()->id('create-gallery-form') }}
        {{ Aire::input('title', 'Titel')->id('title')->autocomplete('off') }}
        {{ Aire::checkbox('is_private', 'Prive?') }}
        {{ Aire::close() }}
        @slot('footer')
        <button class="btn btn-primary" data-submit="#create-gallery-form">Aanmaken</button>
        @endslot
      @endcomponent
      <button class="btn btn-primary mt-2" data-toggle="modal" data-target="#create-gallery-modal"><i class="fas fa-plus"></i></button>
    @endcan
  </div>
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
