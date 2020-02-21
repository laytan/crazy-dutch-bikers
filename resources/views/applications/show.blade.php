@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h2>Aanmelding van {{ $application->name }}</h2> --}}
    <div class="row mt-5">
        <div class="col-12 col-md-6">
            @component('components.title', ['icon' => 'fas fa-id-card'])
            Persoonlijke informatie
            @endcomponent
            <img class="w-100 h-auto object-fit-cover img-thumbnail bg-cdblg" src="{{ Storage::url($application->person_picture) }}" alt="{{ $application->name }}">
            <div class="application-details mt-3">
                <div class="application-details__row">
                    <div class="pr-3">Naam</div>
                    <div>{{ $application->name }}</div>
                </div>
                <div class="application-details__row">
                    <div class="pr-3">Adres</div>
                    <div>{{ $application->address }}, {{ $application->postal_code }} {{ $application->town }}</div>
                </div>
                <div class="application-details__row">
                    <div class="pr-3">Leeftijd</div>
                    <div>
                        {{ $application->age }} jaar <small>({{ $application->date_of_birth }})</small>
                    </div>
                </div>
                <div class="application-details__row">
                    <div class="pr-3">Telefoon Nummmer</div>
                    <div>
                        <a href="tel:{{ $application->phone }}" class="btn-primary btn-sm mr-2 mb-2 mb-md-0"><i class="fas fa-phone"></i> Bel</a> {{ $application->phone }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-5 mt-md-0">
            @component('components.title', ['icon' => 'fas fa-motorcycle'])
            Beschrijving en motor
            @endcomponent
            <p>{{ $application->description }}</p>
            <img src="{{ Storage::url($application->bike_picture) }}" alt="Motor" class="w-100 h-auto object-fit-cover img-thumbnail bg-cdblg">
        </div>
    </div>
</div>
@endsection
