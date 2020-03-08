@extends('layouts.app')

@section('content')
<div class="container-fluid text-light">
  @component('components.title', ['icon' => 'fas fa-tags'])
  Merchandise
  @endcomponent
  <div class="row js-products">
    <div class="col-12 col-md-9 order-2 order-md-1 mt-5 mt-md-0">
      @error('product-ids')
        @component('components.alert', ['type' => 'danger'])
        Er is een fout opgetreden met de bestelling. Neem alstublieft contact op.
        @endcomponent
      @enderror
      <div class="row">
        @foreach($products as $product)
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card bg-cdbg-opaque js-product" data-product="{{ json_encode($product) }}">
            <img class="card-img-top merchandise-picture" src="{{ Storage::url($product->product_picture) }}" alt="{{ $product->title }}">
            <div class="card-body">
              <h5 class="card-title">
                {{ $product->title }}
              </h5>
              <p class="card-text">
                {{ $product->description }}
              </p>
              <p class="card-text d-flex justify-content-between align-items-center">
                &euro;{{ centsToEuro($product->price) }}
                <i class="btn btn-primary js-product__add-to-cart fas fa-cart-plus"></i>
              </p>
              @can('manage', $product)
              <hr class="border-cdblg">

              <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-info btn-sm w-100">
                <i class="fas fa-edit"></i> Bewerken
              </a>
              <button data-submit="#destroy-{{ $product->id }}-product" class="btn w-100 btn-danger btn-sm mt-2">
                <i class="fas fa-trash"></i> Verwijderen
              </button>
              {{ Aire::open()->id("destroy-{$product->id}-product")->route('products.destroy', ['product' => $product->id])->class('d-none') }}
              {{ aire::close() }}
              @endcan
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-12 col-md-3 order-1 order-md-2">
      <div class="d-flex flex-column justify-content-between bg-cdbg-opaque h-100">
        <div>
          <small class="p-2 mb-0 font-weight-bold">WINKELWAGEN</small>
          <div class="js-cart-items px-2">
          </div>
        </div>
        {{-- Bottom of the cart --}}
        <div>
          <button class="btn btn-sm btn-link js-clear-cart-btn p-0 pr-2 text-right w-100 mt-3">
            <i class="fas fa-dumpster"></i> Leegmaken
          </button>
          <hr class="border-cdblg">
          <p class="text-right w-100 mb-3 pr-2">Totaal: <span class="js-cart-total">&euro; 0,00</span></p>
          <button class="btn btn-primary w-100 js-order-btn">Bestelling plaatsen</button>
          {{ Aire::open()->route('orders.store')->class('d-none') }}
          {{ Aire::hidden('product-ids') }}
          {{ Aire::close() }}
        </div>
      </div>
    </div>
  </div>
  {{-- Controlled in Cart.ts --}}
  @component('components.modal', ['id' => 'confirm-order-modal', 'title' => 'Bestelling'])
    Wilt u deze bestelling plaatsen?
    De staff gaat dan aan de slag met de producten.
    @slot('footer')
        <button class="btn btn-primary order-btn">Plaatsen</button>
    @endslot
  @endcomponent
</div>
<script>
// Configure cart
window.addEventListener('load', function() {
  new Cart(document.querySelector('.js-products'), document.querySelector('[name="product-ids"]'), {});
});
</script>
@endsection
