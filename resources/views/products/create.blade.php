@extends('layouts.app')

@section('content')
<div class="container text-light">
  <h2>Merchandise toevoegen</h2>
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
    <div class="col-4" style="height: 335px;">
      @component('components.image-upload', ['id' => 'product_picture', 'name' => 'product_picture', 'initSelf' => true])
      Productfoto kiezen
      @endcomponent
    </div>
  </div>
  {{ Aire::submit('Aanmaken') }}
  {{ Aire::close() }}
</div>
@endsection
