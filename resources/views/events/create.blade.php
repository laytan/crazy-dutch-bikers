@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>Evenement aanmaken</h2>
  {{ Aire::open()->class('bg-cdbg-opaque p-3')->route('events.store')->multipart()->validate('App\Http\Requests\CreateEventRequest') }}
  {{ Aire::input('title', 'Titel *') }}
  {{ Aire::textArea('description', 'Beschrijving *') }}
  {{ Aire::textArea('location', 'Locatie *') }}
  <div class="row mb-2">
    <div class="col-4" style="height: 350px;">
      @component('components.image-upload', ['name' => 'picture', 'id' => 'picture', 'initSelf' => true])
      Foto *
      @endcomponent
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      {{ Aire::date('date', 'Datum *') }}
    </div>
    <div class="col-6">
      {{ Aire::input('time', 'Tijd')->placeholder('hh:mm')->helpText('Laat leeg om zonder tijd aan te geven') }}
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      {{ Aire::date('end_date', 'Eind datum')->helpText('Laat leeg om geen eind datum aan te geven') }}
    </div>
    <div class="col-6">
      {{ Aire::input('end_time', 'Eind tijd')->placeholder('hh:mm')->helpText('Laat leeg om geen eind tijd aan te geven') }}
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      {{ Aire::url('location_link', 'Locatie link') }}
    </div>
    <div class="col-6">
      {{ Aire::url('facebook_link', 'Facebook link') }}
    </div>
  </div>
  {{ Aire::submit('Aanmaken') }}
  {{ Aire::close() }}
</div>
@endsection
