@component('mail::table')
| # | Titel | Beschrijving | Kosten |
|-- | ----- | ------------ | -----: |
@foreach($order->orderHasProducts as $ohp)
| {{ $ohp->product->id }} | {{ $ohp->product->title }} | {{ $ohp->product->description }} | &euro; {{ centsToEuro($ohp->product->price) }} |
@endforeach
| Totaal | | | &euro; {{ centsToEuro($order->getTotal()) }} | 
@endcomponent

@component('mail::button', ['url' => route('orders.show', ['order' => $order->id]), 'color' => 'primary'])
Bekijk bestelling
@endcomponent