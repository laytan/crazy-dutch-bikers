@extends('layouts.app')

@section('content')
<div class="container">
    @component('components.title', ['icon' => 'fas fa-tag'])
    {{ $product->title }} bewerken
    @endcomponent
  <small>Laatst bewerkt door {{ $product->user->name }} op {{ formatTimeForDisplay($product->updated_at) }}</small>
  {{ Aire::open()
      ->route('products.update', ['product' => $product->id])
      ->multipart()
      ->bind($product)
      ->validate('App\Http\Requests\UpdateProductRequest')
  }}
  <div class="row">
    <div class="col-8">
      {{ Aire::input('title', 'Titel') }}
    </div>
    <div class="col-4">
      {{ Aire::number('price', 'Prijs in centen') }}
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-8">
      {{ Aire::textArea('description', 'Beschrijving')->rows(10) }}
    </div>
    <div class="col-4" style="height: 335px;">
      <div
        data-image-upload="true"
        data-start-image="{{ Storage::url($product->product_picture) }}"
        data-name="product_picture"
        data-id="product_picture"
        @error("product_picture") data-invalid="true" @enderror
        data-label="Kies product foto"
      ></div>
    </div>
  </div>
  {{ Aire::submit('Bewerken') }}
  {{ Aire::close() }}
</div>
@endsection
