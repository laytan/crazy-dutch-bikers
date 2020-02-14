@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <div class="row">
    <div class="col-8">
      <h2>Merchandise</h2>
      <div class="row">
        @foreach($products as $product)
        <div class="col-6">
          <div class="card text-dark" data-product="{{ json_encode($product) }}">
            <img class="card-img-top merchandise-picture" src="{{ Storage::url($product->product_picture) }}" alt="{{ $product->title }}">
            <div class="card-body">
              <h5 class="card-title">
                {{ $product->title }}
              </h5>
              <p class="card-text">
                {{ $product->description }}
              </p>
              <p class="card-text">
                &euro;{{ centsToEuro($product->price) }}
              </p>
              <button class="btn btn-primary">Winkelwagen</button>
              @can('manage', $product)
              <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-info">Bewerken</a>
              <button onclick="document.getElementById('destroy-{{ $product->id }}-product').submit();" class="btn btn-danger">Verwijderen</button>
              <form id="destroy-{{ $product->id }}-product" action="{{ route('products.destroy', ['product' => $product->id]) }}" method="post" class="d-none">
                @csrf
                @method('DELETE')
              </form>
              @endcan
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-4 bg-white text-dark d-flex flex-column justify-content-between">
      <div>
        <h2 class="mt-3">Winkelwagen</h2>
        <hr>
        <div id="cart-items">

        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <span>Totaalprijs: <span id="total">&euro; 0,00</span></span>
        <button onclick="clearCart();" class="btn btn-warning">Leegmaken</button>
        <button onclick="$('#confirm-order').modal('show');" class="btn btn-primary">Bestellen</button>
      </div>
      <form class="d-none" id="order" action="{{ route('orders.store') }}" method="post">
        @csrf
        <input type="text" name="product-ids" id="cart-product-ids">
      </form>
    </div>
  </div>
  @component('components.modal', ['id' => 'confirm-order', 'title' => 'Bestellen'])
    Weet u zeker dat u een bestelling wilt plaatsen?
    @slot('footer')
    <button class="btn btn-success" onclick="document.getElementById('order').submit();">Plaatsen</button>
    @endslot
  @endcomponent
</div>
@endsection
