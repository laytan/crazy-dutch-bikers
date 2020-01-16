@extends('layouts.app')

@section('content')
<div class="container text-light">
  <h2>Merchandise toevoegen</h2>
  @include('partials.form-errors')
  <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="title">Titel</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="Titel">
    </div>
    <div class="form-group">
      <label for="description">Beschrijving</label>
      <textarea type="text" name="description" id="description" class="form-control" placeholder="Beschrijving"></textarea>
    </div>
    <div class="form-group">
      <label for="price">Prijs in centen</label>
      <input type="number" name="price" id="price" class="form-control" placeholder="Prijs">
    </div>
    <div class="form-group">
      <label for="product_picture">Productfoto</label>
      <input type="file" name="product_picture" id="product_picture" class="form-control-file">
    </div>
    <input class="btn btn-primary" type="submit" value="Aanmaken">
  </form>
</div>
@endsection
