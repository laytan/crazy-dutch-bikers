@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-tag'])
  Merchandise Toevoegen
  @endcomponent
  {{ Aire::open()->route('products.store')->multipart()->validate('App\Http\Requests\CreateProductRequest') }}
  <div class="row">
    <div class="col-8">
      {{ Aire::input('title', 'Titel') }}
    </div>
    <div class="col-4">
      {{ Aire::number('price', 'Prijs in centen') }}
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-8">
      {{ Aire::textArea('description', 'Beschrijving')->rows(10) }}
    </div>
    <div class="col-4">
      <div
        data-image-upload="true"
        data-start-image=""
        data-name="product_picture"
        data-id="product_picture"
        @error("product_picture") data-invalid="true" @enderror
        data-label="Kies productfoto"
      ></div>
    </div>
  </div>
  {{ Aire::submit('Aanmaken') }}
  {{ Aire::close() }}
</div>
@endsection
