@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-shopping-bag'])
  Bestellingen
  @endcomponent
  <table class="table table-dark table-hover table-responsive-lg">
    <caption class="ml-3">Open bestellingen</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col" class="text-right">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scole="col">Acties</th>
      </tr>
    </thead>
    <tbody>
      @foreach($non_fulfilled as $order)
      <tr>
        <th scope="row"><a href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->id }}</a></th>
        <td>{{ $order->user->name }}</td>
        <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
        <td class="text-right whitespace-nowrap">&euro; {{ centsToEuro($order->getTotal()) }}</td>
        <td>{{ formatTimeForDisplay($order->created_at) }}</td>
        <td>
          <button data-submit="#fulfill-{{ $order->id }}" class="d-block w-100 btn btn-primary btn-sm cursor-pointer">Vervul</button>
          {{ Aire::open()->route('orders.update', ['order' => $order->id])->id("fulfill-$order->id")->class('d-none') }}
          {{ Aire::input('fulfilled')->value('toggle') }}
          {{ Aire::close() }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <h2>Vervuld</h2>
  <table class="table table-dark table-hover table-responsive">
    <caption class="ml-3">Vervulde bestellingen</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col" class="text-right">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Laatst veranderd op</th>
        <th scope="col">Acties</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fulfilled as $order)
      <tr>
        <th scope="row"><a href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->id }}</a></th>
        <td>{{ $order->user->name }}</td>
        <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
        <td class="text-right whitespace-nowrap">&euro; {{ centsToEuro($order->getTotal()) }}</td>
        <td>{{ formatTimeForDisplay($order->created_at) }}</td>
        <td>{{ formatTimeForDisplay($order->updated_at) }}</td>
        <td>
          <button data-submit="#fulfill-{{ $order->id }}" class="btn btn-primary btn-sm">Onvervul</button>
          {{ Aire::open()->route('orders.update', ['order' => $order->id])->id("fulfill-$order->id")->class('d-none') }}
          {{ Aire::input('fulfilled')->value('toggle') }}
          {{ Aire::close() }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
