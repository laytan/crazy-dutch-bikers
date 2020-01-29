@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  @foreach($futureEvents as $day => $event)
  <li>
    <a href="#day-{{ $day }}">{{ $day }}</a>
  </li>
  @endforeach
  <div class="d-flex align-items-center border-bottom mb-4">
    <h2 class="text-center pt-2">Evenementen</h2>
    @hasanyrole('admin|super-admin')
    <a href="{{ route('events.create') }}" class="ml-auto btn btn-light">+</a>
    @endhasanyrole
  </div>
    <div class="bg-light text-dark border-right p-2">
      <ul class="list-group w-100">
        @foreach($futureEvents as $day => $events)
          <li id="day-{{ $day }}" class="list-group-item text-center cdb-font">
            {{ $day }}
          </li>
          @foreach($events as $event)
            <li class="list-group-item event-item">
              <div class="row">
                <div class="col-6 p-0 m-0">
                  <img class="w-100 h-100 object-fit-cover" src="{{ Storage::url($event->picture) }}" alt="{{ $event->title }}">
                </div>
                <div class="col-6 d-flex flex-column justify-content-between p-3">
                  <div>
                    <h3 class="mb-0">{{ $event->title }}</h3>
                    <p class="text-muted mt-0">
                      @if($event->location_link)
                      <a href="{{ $event->location_link }}" rel="noopener noreferrer" target="_BLANK">
                      @endif
                      {!! nl2br(e($event->location)) !!} <br>
                      @if($event->location_link)
                      </a>
                      @endif
                      {{ $event->formattedTime }}
                    </p>
                    <p class="mt-2">
                      {!! nl2br(e($event->description)) !!}
                    </p>
                  </div>
                  <div class="d-flex">
                    @if($event->facebook_link)
                      @hasanyrole('admin|super-admin|member')
                        <a target="_BLANK" rel="noopener noreferrer" href="{{ $event->facebook_link }}" class="btn btn-primary w-50">Bekijk op Facebook</a>
                      @endhasanyrole
                    @endif
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        @endforeach
      </ul>
  </div>
</div>
@endsection