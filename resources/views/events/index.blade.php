@extends('layouts.app')

@section('content')
<div class="container text-light">
  {{ Aire::summary()->verbose() }}
  <div class="d-flex align-items-center mb-4">
    @component('components.title', ['icon' => 'fas fa-calendar-alt'])
    Evenementen
    @endcomponent
    @can('manage')
    <a href="{{ route('events.create') }}" class="ml-auto btn btn-primary"><i class="fas fa-plus"></i></a>
    @endcan
  </div>
  <ul class="nav nav-tabs" id="eventsTab" role="tablist">
    <li class="nav-item flex-grow-1 flex-grow-sm-0 text-center text-sm-left">
      <a class="nav-link active" id="future-tab" data-toggle="tab" href="#future" role="tab" aria-controls="future"
        aria-selected="true">Opkomend</a>
    </li>
    <li class="nav-item flex-grow-1 flex-grow-sm-0 text-center text-sm-left">
      <a class="nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab" aria-controls="past"
        aria-selected="false">Afgelopen</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="future" role="tabpanel" aria-labelledby="future-tab">
      <div class="bg-cdbg p-4">
        <ul class="list-group w-100">
          @foreach($futureEvents as $events)
          <li class="list-group-item event-item bg-cdbg border-0">
            <div class="row">
              <div class="col-12 col-sm-2 mb-3 pb-2 mb-sm-0 text-center bg-primary">
                <h2 class="m-0">{{ $events[0]->day }}</h2>
                {{ $events[0]->month }}<br>
                <small>{{ $events[0]->year }}</small>
              </div>
              <div class="col-12 col-sm-10 px-0 px-sm-3">
                @foreach($events as $i => $event)
                <div class="bg-primary p-2 rounded {{ $i !== 0 ? 'mt-3' : '' }}">
                  <img class="w-100 object-fit-cover" src="{{ Storage::url($event->picture) }}"
                    alt="{{ $event->title }}">
                </div>
                <h3>{{ $event->title }}</h3>
                <p class="my-2">
                  {!! nl2br(e($event->description)) !!}
                </p>
                <p class="my-1 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-lock-open mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {{ $event->start_time }}
                  </span>
                </p>
                @if($event->end_time)
                <p class="my-1 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-lock mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {{ $event->end_time }}
                  </span>
                </p>
                @endif
                <p class="my-1 mb-2 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {!! nl2br(e($event->location)) !!}
                  </span>
                </p>
                @if($event->facebook_link || $event->location_link)
                <p class="d-flex justify-content-between">
                  @auth
                  @if($event->facebook_link)
                  <a href="#" class="btn btn-primary">
                    <i class="fab fa-facebook-square"></i>
                    Bekijk op Facebook
                  </a>
                  @endif
                  @endauth
                  @if($event->location_link)
                  <a href="#" class="btn btn-primary">Bekijk Locatie</a>
                  @endif
                </p>
                @endif
                <hr class="border-cdblg">
                @can('manage')
                <a href="{{ route('events.edit', ['event' => $event->id]) }}" class="btn btn-warning"><i
                    class="fas fa-edit"></i> Bewerken</a>
                <button class="btn btn-danger" data-toggle="modal" data-target="#remove-event-{{ $event->id }}-modal">
                  <i class="fas fa-trash"></i> Verwijderen
                </button>
                @component('components.modal', ['id' => 'remove-event-' . $event->id . '-modal', 'title' => 'Evenement
                Verwijderen'])
                Weet u zeker dat het evenement met titel {{ $event->title }} verwijderd moet worden?
                @slot('footer')
                {{ Aire::open()->route('events.destroy', ['event' => $event->id])->class('m-0 p-0') }}
                {{ Aire::submit('Verwijderen') }}
                {{ Aire::close() }}
                @endslot
                @endcomponent
                @else
                <details>
                  <summary class="font-weight-bold">Meld je aan <span class="ml-2 badge badge-primary">{{ $event->eventApplications->count() }}</span></summary>
                  {{ Aire::open()
                    ->class('form-inline')
                    ->route('eventApplications.store', ['event' => $event->id])
                    ->validate('App\Http\Requests\CreateEventApplicationRequest') }}
                  {{ Aire::input('name', 'Naam') }}
                  {{ Aire::input('phone', 'Telefoonnr') }}
                  {{ Aire::submit('Ik wil mee!') }}
                  {{ Aire::close() }}
                </details>
                @endcan
                @endforeach
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
      <div class="bg-cdbg p-4">
        <ul class="list-group w-100">
          @foreach($pastEvents as $events)
          <li class="list-group-item event-item bg-cdbg border-0">
            <div class="row">
              <div class="col-12 col-sm-2 mb-3 pb-2 mb-sm-0 text-center bg-primary">
                <h2 class="m-0">{{ $events[0]->day }}</h2>
                {{ $events[0]->month }}<br>
                <small>{{ $events[0]->year }}</small>
              </div>
              <div class="col-12 col-sm-10 px-0 px-sm-3">
                @foreach($events as $i => $event)
                <div class="bg-primary p-2 rounded {{ $i !== 0 ? 'mt-3' : '' }}">
                  <img class="w-100 object-fit-cover" src="{{ Storage::url($event->picture) }}"
                    alt="{{ $event->title }}">
                </div>
                <h3>{{ $event->title }}</h3>
                <p class="my-2">
                  {!! nl2br(e($event->description)) !!}
                </p>
                <p class="my-1 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-lock-open mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {{ $event->start_time }}
                  </span>
                </p>
                @if($event->end_time)
                <p class="my-1 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-lock mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {{ $event->end_time }}
                  </span>
                </p>
                @endif
                <p class="my-1 mb-2 d-table-row">
                  <span class="d-table-cell">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                  </span>
                  <span class="d-table-cell">
                    {!! nl2br(e($event->location)) !!}
                  </span>
                </p>
                @if($event->facebook_link || $event->location_link)
                <p class="d-flex justify-content-between">
                  @auth
                  @if($event->facebook_link)
                  <a href="#" class="btn btn-primary">
                    <i class="fab fa-facebook-square"></i>
                    Bekijk op Facebook
                  </a>
                  @endif
                  @endauth
                  @if($event->location_link)
                  <a href="#" class="btn btn-primary">Bekijk Locatie</a>
                  @endif
                </p>
                @endif
                @can('manage')
                <hr class="border-cdblg">
                <a href="{{ route('events.edit', ['event' => $event->id]) }}" class="btn btn-warning"><i
                    class="fas fa-edit"></i> Bewerken</a>
                <button class="btn btn-danger" data-toggle="modal" data-target="#remove-event-{{ $event->id }}-modal">
                  <i class="fas fa-trash"></i> Verwijderen
                </button>
                @component('components.modal', ['id' => 'remove-event-' . $event->id . '-modal', 'title' => 'Evenement
                Verwijderen'])
                Weet u zeker dat het evenement met titel {{ $event->title }} verwijderd moet worden?
                @slot('footer')
                {{ Aire::open()->route('events.destroy', ['event' => $event->id])->class('m-0 p-0') }}
                {{ Aire::submit('Verwijderen') }}
                {{ Aire::close() }}
                @endslot
                @endcomponent
                @endcan
                @endforeach
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endsection
