@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <div class="row">
    <div class="col-8">
      <h2>Merchandise</h2>
      <div class="row">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-xl-3">
          <div class="card text-dark">
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
              <button onclick="addToCart({{ json_encode($product) }});" class="btn btn-primary">Winkelwagen</button>
              @hasanyrole('admin|super-admin')
              <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-info">Bewerken</a>
              <button onclick="document.getElementById('destroy-{{ $product->id }}-product').submit();" class="btn btn-danger">Verwijderen</button>
              <form id="destroy-{{ $product->id }}-product" action="{{ route('products.destroy', ['product' => $product->id]) }}" method="post" class="d-none">
                @csrf
                @method('DELETE')
              </form>
              @endhasanyrole
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
        <button onclick="order();" class="btn btn-primary">Bestellen</button>
      </div>
      <form class="d-none" id="order" action="{{ route('orders.store') }}" method="post">
        @csrf
        <input type="text" name="product-ids" id="cart-product-ids">
      </form>
    </div>
  </div>
</div>
@endsection
<script>
let cart = [];
function addToCart(product) {
  cart.push(product);
  onCartChange();
}

function clearCart() {
  cart.length = 0;
  onCartChange();
}

function onCartChange() {
  updateCartVisual();
}

function updateCartVisual() {
  const container = document.getElementById('cart-items');
  container.innerHTML = '';
  cart.forEach(product => {
    container.appendChild(getElement(product));
  });

  const priceElement = document.getElementById('total');
  const total = centsToEuro(cart.reduce((prev, curr) => prev + curr.price, 0));
  priceElement.textContent = total;
}

function getElement(product) {
  const element = document.createElement('div');
  element.classList.add('cart-item', 'd-flex', 'align-items-center', 'justify-content-between');
  
  const image = document.createElement('img');
  image.src = '/storage/' + product.product_picture;
  image.classList.add('cart-ítem-img');
  element.appendChild(image);

  const title = document.createElement('span');
  title.textContent = product.title.length > 50 ? product.title.substring(0, 50) + '...' : product.title;
  title.classList.add('cart-item-title');
  element.appendChild(title);

  const price = document.createElement('span');
  price.textContent = centsToEuro(product.price);
  title.classList.add('cart-item-price');
  element.appendChild(price);

  return element;
}

function centsToEuro(cents) {
  let euro = cents / 100;
  euro = euro.toLocaleString("nl-NL", {style:"currency", currency:"EUR"});
  return euro;
}

function updateCartProductIds() {
  const input = document.getElementById('cart-product-ids');
  input.value = cart.reduce((prev, curr) => prev.length > 0 ? prev + ',' + curr.id : prev + curr.id, '');
}

function order() {
  updateCartProductIds();
  if(confirm('Bestelling plaatsen?')) {
    document.getElementById('order').submit();
  }
}
</script>