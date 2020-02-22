@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-edit'])
  Gallerij bewerken
  @endcomponent
  <div id="vue">
    <gallery-upload></gallery-upload>
  </div>
</div>
@endsection
@section('footer')
<script defer src="{{ asset('js/gallery.js') }}"></script>
@endsection
