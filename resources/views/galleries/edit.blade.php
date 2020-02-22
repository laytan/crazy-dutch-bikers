@extends('layouts.app')

@section('content')
<div class="container text-light">
  <div class="d-flex justify-content-between flex-wrap align-items-center">
    @component('components.title', ['icon' => 'fas fa-edit'])
    Gallerij '{{ $gallery->title }}' bewerken
    @endcomponent
    <a href="{{ route('galleries.show', ['gallery' => $gallery->title]) }}" class="btn btn-primary mt-2 mb-4 mb-lg-0">Gallerij Bekijken</a>
  </div>
  {{ Aire::open()->route('galleries.update', ['gallery' => $gallery->id])->validate('App\Http\Requests\UpdateGalleryRequest')->bind($gallery) }}
  {{ Aire::input('title', 'Titel')->placeholder($gallery->title)->value('') }}
  {{ Aire::checkbox('is_private', 'Prive Gallerij?') }}
  {{ Aire::submit('Bewerken') }}
  {{ Aire::close() }}

  <div class="mt-5">
    @component('components.title', ['icon' => 'fas fa-images'])
    Foto's toevoegen
    @endcomponent
    <div class="bg-cdbg-opaque p-3">
      <div id="vue">
        <gallery-upload api-token="{{ Auth::user()->api_token }}" gallery="{{ $gallery->title }}"></gallery-upload>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer')
<script defer src="{{ asset('js/gallery.js') }}"></script>
@endsection
