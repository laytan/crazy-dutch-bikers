@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'far fa-calendar-plus'])
  Evenement Aanmaken
  @endcomponent
  {{ Aire::open()->route('events.update', ['event' => $event->id])->multipart()->validate('App\Http\Requests\UpdateEventRequest')->bind($event) }}
  {{ Aire::input('title', 'Titel') }}
  {{ Aire::textArea('description', 'Beschrijving') }}
  {{ Aire::textArea('location', 'Locatie') }}
  <div class="row">
      <div
        class="col-12 col-md-8 col-lg-6"
        data-image-upload="true"
        data-start-image="{{ Storage::url($event->picture) }}"
        data-name="picture"
        data-id="picture"
        @error('picture') data-invalid="true" @enderror
        data-label="Kies foto"
      ></div>
  </div>
  <div class="row">
    <p class="px-3 mb-2">
      Tijd op dit moment: <br>
      {{ $event->formattedTime }} <br>
      <span class="text-danger">LET OP: Het bewerken van alleen de datum vereist het bewerken van alle velden die met tijd te maken hebben</span>
      <br>
      <small>Laat de velden leeg om niet te veranderen</small>
    </p>
    <div class="col-6">
      {{ Aire::date('date', 'Datum')->value('') }}
    </div>
    <div class="col-6">
      {{ Aire::input('time', 'Tijd')->placeholder('hh:mm')->value('') }}
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      {{ Aire::date('end_date', 'Eind datum')->value('') }}
    </div>
    <div class="col-6">
      {{ Aire::input('end_time', 'Eind tijd')->placeholder('hh:mm')->value('') }}
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
