@extends('layouts.app')

@section('content')
<div class="container text-light">
    @component('components.title', ['icon' => 'fas fa-images'])
    Gallerij Aanmaken
    @endcomponent
    {{ Aire::summary()->verbose() }}
    {{ Aire::open()->route('galleries.store')->validate($rules)->multipart() }}
    {{ Aire::input('title', 'Titel')->id('title')->autocomplete('off') }}
    {{ Aire::checkbox('is_private', 'Prive?') }}
    {{-- <fieldset class="border border-cdblg px-4 mb-4">
        <legend class="w-auto px-3">Foto's</legend>
        <div
            data-images-upload="true"
            data-name="images[]"
            data-label="Kies een foto"
            data-initial-boxes="3"
            data-row-size="3"
        ></div> --}}
        <div id="vue">
        <gallery-upload gallery="{{ $gallery->title }}"></gallery-upload>
        </div>
    {{-- </fieldset>     --}}
    {{ Aire::submit('Aanmaken') }}
    {{ Aire::close() }}
</div>
@endsection
@section('footer')
<script defer src="{{ asset('js/gallery.js') }}"></script>
@endsection
