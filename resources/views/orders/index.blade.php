@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>bestellingen</h2>
  <table class="table table-light table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Producten</th>
        <th scope="col">Vervul</th>
        <th scope="col">Bekijken</th>
      </tr>
    </thead>
    <tbody>
      @foreach($non_fulfilled as $order)
      @include('partials.order-row')
      @endforeach
    </tbody>
  </table>
  <h2>Vervuld</h2>
  <table class="table table-light table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Producten</th>
        <th scope="col">Vervul</th>
        <th scope="col">Bekijken</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fulfilled as $order)
      @include('partials.order-row')
      @endforeach
    </tbody>
  </table>
  <h2>Verwijderd</h2>
  <table class="table table-light table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">E-mail</th>
        <th scope="col">Prijs</th>
        <th scope="col">Besteld op</th>
        <th scope="col">Producten</th>
        <th scope="col">Vervul</th>
        <th scope="col">Bekijken</th>
        <th scope="col">Verwijder</th>
      </tr>
    </thead>
    <tbody>
      @foreach($deleted as $order)
      @include('partials.order-row')
      @endforeach
    </tbody>
  </table>
</div>
@endsection
