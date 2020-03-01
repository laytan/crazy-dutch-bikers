@component('mail::message')
# Nieuwe aanmelding voor evenement: {{ $eventApplication->event->title }}

{{ $eventApplication->name }} heeft zich aangemeld voor het evenement.  
Zijn telefoon nummer is {{ $eventApplication->phone }}.  
Er zijn nu {{ $eventApplication->event->eventApplications->count() }} aanmeldingen voor dit evenement.  

Fijne dag,<br>
{{ config('app.name') }}
@endcomponent
