@extends('layouts.app')

@section('content')
<div class="container text-light">
  <p class="bg-info text-dark d-block px-2 py-3">Laat de velden leeg die niet bewerkt hoeven te worden!</p>
  <h2 class="d-inline-block">{{ $product->title }} bewerken</h2>
  <small class="d-inline-block">Laatst bewerkt door {{ $product->user->name }} op {{ $product->updatedAtFormatted() }}</small>
  @include('partials.form-errors')
  <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
      <label for="title">Titel</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="{{ $product->title }}">
    </div>
    <div class="form-group">
      <label for="description">Beschrijving</label>
      <textarea type="text" name="description" id="description" class="form-control" placeholder="{{ $product->description }}"></textarea>
    </div>
    <div class="form-group">
      <label for="price">Prijs in centen</label>
      <input type="number" name="price" id="price" class="form-control" placeholder="{{ $product->price }}">
    </div>
    <div class="form-group row">
      <div class="col-4">
        <img class="fit-image" src="{{ Storage::url($product->product_picture) }}">
      </div>
      <div class="col-8">
        <label for="product_picture">Productfoto</label>
        <input type="file" name="product_picture" id="product_picture" class="form-control-file">
      </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Bewerken">
  </form>
</div>
@endsection
