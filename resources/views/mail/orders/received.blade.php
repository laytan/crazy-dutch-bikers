@component('mail::message')
# '{{ $order->user->name }}' heeft een bestelling geplaatst

## Gegevens
|    |    |
| -- | -- |
| Email | {{ $order->user->email }} |
| Gebruikersnaam | {{ $order->user->name }} |
| Bestel tijd | {{ formatTimeForDisplay($order->created_at) }} |  
<br>
@include('mail.partials.order-table')
<br>
Verder staan er nog {{ orderAmt() }} bestellingen open.  
<br>
Fijne dag,  
{{ config('app.name') }}
@endcomponent
