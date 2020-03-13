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
    {{ Aire::summary()->verbose() }}
    <div class="gallery-grid">
        @foreach($gallery->picture_columns as $column)
        <div class="gallery-grid__column">
            @foreach($column as $picture)
            <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $picture->dimensions[1] / $picture->dimensions[0] * 100 }}%;">
                <img class="lazy" data-src="{{ Storage::url($picture->url) }}">
                <div class="gallery-grid__icon-bar">
                  @can('manage')
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#destroy-{{ $picture->id }}-modal">
                      <i class="fa fa-trash"></i>
                    </button>
                    @component('components.modal', ['title' => 'Foto verwijderen?', 'id' => 'destroy-' . $picture->id . '-modal'])
                      Weet je zeker dat deze foto verwijderd moet worden?
                      {{ Aire::open()->route('pictures.destroy', ['picture' => $picture->id])->id("destroy-$picture->id")->class('d-none') }}
                      {{ Aire::close() }}
                      @slot('footer')
                        <button class="btn btn-warning" data-submit="#destroy-{{ $picture->id }}">Verwijderen</button>
                      @endslot
                    @endcomponent
                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#edit-{{ $picture->id }}-modal">
                      <i class="fas fa-edit"></i>
                    </button>
                    @component('components.modal', ['title' => 'Foto bewerken', 'id' => 'edit-' . $picture->id . '-modal'])
                      {{ Aire::open()
                        ->route('pictures.update', ['picture' => $picture->id])
                        ->class('bg-transparant')
                        ->bind($picture)
                        ->id('picture-' . $picture->id . '-update-form')
                      }}
                      {{ Aire::checkbox('is_private', 'Prive?') }}
                      {{ Aire::checkbox('is_featured', 'Uitgelicht?') }}
                      {{ Aire::close() }}
                      @slot('footer')
                        <button class="btn btn-primary" data-submit="#picture-{{ $picture->id }}-update-form">Bijwerken</button>
                      @endslot
                    @endcomponent
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
