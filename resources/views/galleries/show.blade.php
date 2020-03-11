@extends('layouts.app')

@section('description', "Een collectie aan foto's die geschoten zijn bij het evenement/activiteit $gallery->title.")

@section('content')
<div class="container-fluid text-light">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            @component('components.title', ['icon' => 'fas fa-images'])
            {{ $gallery->title }}
            @endcomponent
        </div>
        @can('manage')
          <div>
              @component('components.modal', ['id' => 'remove-gallery-modal', 'title' => 'Gallerij verwijderen?'])
                  {{ Aire::open()->class('d-none')->route('galleries.destroy', ['gallery' => $gallery->id])->id('gallery-destroy-form') }}
                  {{ Aire::close() }}
                  @slot('footer')
                      <button class="btn btn-danger" data-submit="#gallery-destroy-form">Verwijderen</button>
                  @endslot
              @endcomponent
              <button class="btn btn-warning" data-toggle="modal" data-target="#remove-gallery-modal">Verwijderen</button>
              <a href="{{ route('galleries.edit', ['gallery' => $gallery->title]) }}" class="btn btn-primary">Bewerken</a>
          </div>
        @endcan
    </div>
    <div class="gallery-grid">
        @foreach($gallery->picture_columns as $column)
        <div class="gallery-grid__column">
            @foreach($column as $picture)
            <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $picture->dimensions[1] / $picture->dimensions[0] * 100 }}%;">
                <img class="lazy" data-src="{{ Storage::url($picture->url) }}">
                <div class="gallery-grid__icon-bar">
                  @can('manage')
                    <button class="btn btn-warning btn-sm">
                      <i class="fa fa-trash" data-submit="#destroy-{{ $picture->id }}"></i>
                    </button>
                    {{ Aire::open()->route('pictures.destroy', ['picture' => $picture->id])->id("destroy-$picture->id")->class('d-none') }}
                    {{ Aire::close() }}
                  @endcan
                  <button class="btn btn-primary btn-sm">
                    <i class="fa fa-close"></i>
                  </button>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endsection
