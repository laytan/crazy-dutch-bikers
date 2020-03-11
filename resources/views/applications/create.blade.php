@extends('layouts.app')

@section('description', 'Meld je aan bij de Crazy Dutch Bikers door ons een beeld te geven in jouw leven, wij nemen contact op en als het klikt hebben we je er graag bij.')

@section('content')
<div class="container">
    @component('components.title', ['icon' => 'fas fa-id-card'])
    Aanmelden bij de club
    @endcomponent
    {{ Aire::open()->route('applications.store')->multipart()->validate('App\Http\Requests\CreateApplicationRequest') }}
    @honeypot
    <div class="row">
        <div class="col-12 col-md-6">
            <fieldset class="border-top border-cdblg px-4 mb-4">
                <legend class="w-auto px-3">Wie ben je?</legend>
                {{ Aire::input('name', 'Naam') }}
                {{ Aire::tel('phone', 'Telefoon Nummer')->helpText('Hier nemen wij contact mee op') }}
                {{ Aire::date('date_of_birth', 'Geboortedatum') }}
                {{ Aire::textarea('description', 'Vertel kort over jezelf')->rows(6) }}
            </fieldset>
            <fieldset class="border-top border-cdblg px-4 mb-4">
                <legend class="w-auto px-3">Waar woon je?</legend>
                {{ Aire::input('address', 'Straat + Nummer') }}
                {{ Aire::input('town', 'Plaats') }}
                {{ Aire::input('postal_code', 'Postcode') }}
            </fieldset>
        </div>
        <div class="col-12 col-md-6">
            <fieldset class="border-top border-cdblg px-4 mb-4">
                <legend class="w-auto px-3">Geef ons een beeld</legend>
                <div class="form-group">
                    <label for="person_picture">Foto van jezelf</label>
                    <div
                        data-image-upload="true"
                        data-start-image=""
                        data-name="person_picture"
                        data-id="person_picture"
                        @error('person_picture') data-invalid="true" @enderror
                        data-label="Kies een foto"
                    ></div>
                </div>
                <div class="form-group">
                    <label for="bike_picture">Foto van je motor</label>
                    <div
                        data-image-upload="true"
                        data-start-image=""
                        data-name="bike_picture"
                        data-id="bike_picture"
                        @error('bike_picture') data-invalid="true" @enderror
                        data-label="Kies een foto"
                    ></div>
                </div>
            </fieldset>
        </div>
    </div>
    {{ Aire::submit('Aanmelden') }}
    {{ Aire::close() }}
</div>
@endsection
