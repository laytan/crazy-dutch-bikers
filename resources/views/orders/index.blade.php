@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>bestellingen</h2>
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col" class="text-right">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Vervul</th>
        <th scope="col">Verwijderen</th>
      </tr>
    </thead>
    <tbody>
      @foreach($non_fulfilled as $order)
      <tr>
        <th scope="row"><a href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->id }}</a></th>
        <td>{{ $order->user->name }}</td>
        <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
        <td class="text-right">&euro; {{ centsToEuro($order->getTotal()) }}</td>
        <td>{{ formatTimeForDisplay($order->created_at) }}</td>
        <td>
          <button onclick="document.getElementById('fulfill-{{ $order->id }}').submit();" class="btn btn-primary btn-sm">Vervul</button>
          <form id="fulfill-{{ $order->id }}" action="{{ route('orders.update', ['order' => $order->id]) }}" method="post" class="d-none">
            @csrf
            @method('PATCH')
            <input type="text" name="fulfilled" value="toggle">
          </form>
        </td>
        <td>
          <button onclick="if(confirm('Bestelling verwijderen?')) { document.getElementById('delete-{{ $order->id }}').submit(); }" class="btn btn-danger btn-sm">Verwijder</button>
          <form id="delete-{{ $order->id }}" action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="post" class="d-none">
            @csrf
            @method('DELETE')
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <h2>Vervuld</h2>
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col" class="text-right">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Laatst veranderd op</th>
        <th scope="col">Onvervul</th>
        <th scope="col">Verwijder</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fulfilled as $order)
      <tr>
        <th scope="row"><a href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->id }}</a></th>
        <td>{{ $order->user->name }}</td>
        <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
        <td class="text-right">&euro; {{ centsToEuro($order->getTotal()) }}</td>
        <td>{{ formatTimeForDisplay($order->created_at) }}</td>
        <td>{{ formatTimeForDisplay($order->updated_at) }}</td>
        <td>
          <button onclick="document.getElementById('fulfill-{{ $order->id }}').submit();" class="btn btn-primary btn-sm">Onvervul</button>
          <form id="fulfill-{{ $order->id }}" action="{{ route('orders.update', ['order' => $order->id]) }}" method="post" class="d-none">
            @csrf
            @method('PATCH')
            <input type="text" name="fulfilled" value="toggle">
          </form>
        </td>
        <td>
          <button onclick="if(confirm('Bestelling verwijderen?')) { document.getElementById('delete-{{ $order->id }}').submit(); }" class="btn btn-danger btn-sm">Verwijder</button>
          <form id="delete-{{ $order->id }}" action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="post" class="d-none">
            @csrf
            @method('DELETE')
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
