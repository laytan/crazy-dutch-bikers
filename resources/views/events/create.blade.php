@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'far fa-calendar-plus'])
  Evenement Aanmaken
  @endcomponent
  {{ Aire::open()->route('events.store')->multipart()->validate('App\Http\Requests\CreateEventRequest') }}
  {{ Aire::input('title', 'Titel *') }}
  {{ Aire::textArea('description', 'Beschrijving *') }}
  {{ Aire::textArea('location', 'Locatie *') }}
  <div class="row">
      <div
        class="col-12 col-md-8 col-lg-6"
        data-image-upload="true"
        data-start-image=""
        data-name="picture"
        data-id="picture"
        @error('picture') data-invalid="true" @enderror
        data-label="Kies foto"
      ></div>
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
    <div class="col-12 col-md-6">
      {{ Aire::url('location_link', 'Locatie link') }}
    </div>
    <div class="col-12 col-md-6">
      {{ Aire::url('facebook_link', 'Facebook link') }}
    </div>
  </div>
  {{ Aire::submit('Aanmaken') }}
  {{ Aire::close() }}
</div>
@endsection
