@extends('layouts.app')

@section('content')
<div class="container-fluid text-light">
    @component('components.title', ['icon' => 'fas fa-images'])
    {{ $gallery->title }}
    @endcomponent
    {{ Aire::open()->route('galleries.destroy', ['gallery' => $gallery->id])->id('gallery-destroy-form-' . $gallery->id) }}
    {{ Aire::close() }}
    <button class="btn btn-warning" data-submit="#gallery-destroy-form-{{ $gallery->id }}">Verwijder gallerij</button>
    <button class="btn btn-primary" data-toggle="modal" data-target="#gallery-update-{{ $gallery->id }}">Gallerij bewerken</button>
    <div class="gallery-grid">
        @foreach($gallery->picture_columns as $column)
        <div class="gallery-grid__column">
            @foreach($column as $picture)
            <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $picture->dimensions[1] / $picture->dimensions[0] * 100 }}%;">
                <img class="lazy" data-src="{{ Storage::url($picture->url) }}">
                <i class="fa fa-trash d-block" data-submit="#destroy-{{ $picture->id }}"></i>
                {{ Aire::open()->route('pictures.destroy', ['picture' => $picture->id])->id("destroy-$picture->id") }}
                {{ Aire::close() }}
                <i class="fa fa-close"></i>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@component('components.modal', ['id' => 'gallery-update-' . $gallery->id, 'title' => $gallery->title . ' bewerken'])
    {{ Aire::open()
        ->route('galleries.update', ['gallery' => $gallery->id])
        ->rules($updateRequest)
        ->multipart()
        ->bind($gallery)
        ->id('gallery-update-form-' . $gallery->id) }}
    {{ Aire::input('title', 'Titel')->id('title')->value('')->autocomplete('off')->placeholder($gallery->title) }}
    {{ Aire::checkbox('is_private', 'Prive?')->checked($gallery->is_private) }}
    <fieldset class="border border-cdblg px-4 mb-4">
    <legend class="w-auto px-3">Foto's toevoegen</legend>
    <div
        data-images-upload="true"
        data-name="images[]"
        data-label="Kies een foto"
        data-initial-boxes="3"
        data-row-size="3"
    ></div>
    </fieldset>
    {{ Aire::close() }}
    @slot('footer')
    <button class="btn btn-primary" data-submit="#gallery-update-form-{{ $gallery->id }}">Gallerij bewerken</button>
    @endslot
@endcomponent
@endsection
