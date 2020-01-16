@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>Bestelling #{{ $order->id }}</h2>
</div>
@endsection
