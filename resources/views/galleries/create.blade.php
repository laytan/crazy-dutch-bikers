@extends('layouts.app')

@section('content')
<div class="container text-light">
  <div class="w-75 m-auto bg-cdbg-opaque p-3">
    <h2>Gallerij aanmaken</h2>
    {{ Aire::summary()->verbose() }}
    {{ Aire::open()->route('galleries.store')->validate($rules)->multipart() }}
    {{ Aire::input('title', 'Titel')->id('title')->autocomplete('off') }}
    {{ Aire::checkbox('is_private', 'Prive?') }}
    <fieldset class="border border-cdblg px-4 mb-4">
      <legend class="w-auto px-3">Foto's</legend>
      <div
        data-images-upload="true"
        data-name="images[]"
        data-label="Kies een foto"
        data-initial-boxes="3"
        data-row-size="3"
      ></div>
    </fieldset>
    {{ Aire::submit('Aanmaken') }}
    {{ Aire::close() }}
  </div>
</div>
@endsection
