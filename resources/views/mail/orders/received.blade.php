@component('mail::message')
# '{{ $order->user->name }}' heeft een bestelling geplaatst

Email: {{ $order->user->email }}  
Gebruikersnaam: {{ $order->user->name }}  
Bestel tijd: {{ formatTimeForDisplay($order->created_at) }}  

@include('mail.partials.order-table')

Verder staan er nog {{ orderAmt() }} bestellingen open.  

Fijne dag,  
{{ config('app.name') }}
@endcomponent
