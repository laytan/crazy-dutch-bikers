@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-shopping-bag'])
  Bestelling #{{ $order->id }}
  @endcomponent
  <p>
    Status: {{ $order->fulfilled ? 'Vervuld' : 'In behandeling' }}
  </p>
  <table class="table table-striped table-dark">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Foto</th>
        <th scope="col">Titel</th>
        <th scope="col">Beschrijving</th>
        <th scope="col">Prijs</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->orderHasProducts as $ohp)
      <tr>
        <th scope="row">{{ $ohp->product->id }}</th>
        <td><img style="max-height: 2rem;" src="{{ Storage::url($ohp->product->product_picture) }}"></td>
        <td>{{ $ohp->product->title }}</td>
        <td>{{ $ohp->product->description }}</td>
        <td class="text-align-right">&euro; {{ centsToEuro($ohp->product->price) }}</td>
      </tr>
      @endforeach
      <tr>
        <th scope="row">Totaal</th>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-align-right">&euro; {{ centsToEuro($order->getTotal()) }}</td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
