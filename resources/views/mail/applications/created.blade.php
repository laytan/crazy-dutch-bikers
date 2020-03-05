@component('mail::message')
# Nieuwe aanmelding voor de club!

Er is een nieuwe aanmelding verstuurd via het aanmeldformulier op {{ config('app.url') }}

## Hier het ingevulde formulier

|  |  |
|--|--|
| Naam | {{ $application->name }} |
| Email | {{ $application->email }} |
| Geboortedatum | {{ $application->date_of_birth }} |
| Adres | {{ $application->address }} |
| Plaats | {{ $application->town }} |
| Postcode | {{ $application->postal_code }} |

### Beschrijving

{{ $application->description }}

### Foto's

Persoon

![Persoon]({{ url(Storage::url($application->person_picture)) }})

Motor

![Motor]({{ url(Storage::url($application->bike_picture)) }})

Als je geen foto's ziet kun je deze bekijken via de knop hieronder.

@component('mail::button', ['url' => route('applications.show', ['application' => $application->id])])
Bekijk op de website
@endcomponent

Fijne dag,<br>
{{ config('app.name') }}
@endcomponent
