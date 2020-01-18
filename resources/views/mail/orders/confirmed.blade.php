@component('mail::message')
# Uw bestelling met bestelnummer {{ $order->id }}

## Details
|  |  |
|--|--|
| Email | {{ $order->user->email }} |
| Gebruikersnaam | {{ $order->user->name }} |
| Bestel tijd | {{ formatTimeForDisplay($order->created_at) }} |
<br>
@include('mail.partials.order-table')  
<br>
Bedankt voor uw bestelling,  
{{ config('app.name') }}
@endcomponent
