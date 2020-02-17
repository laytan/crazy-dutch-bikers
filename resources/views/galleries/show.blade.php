@extends('layouts.app')

@section('content')
<div class="container-fluid text-light">
  <h2>{{ $gallery->title }} {{ $gallery->is_private ? '(prive)' : '(publiekelijk)' }}</h2>
  {{ Aire::open()->route('galleries.destroy', ['gallery' => $gallery->id])->id('gallery-destroy-form-' . $gallery->id) }}
  {{ Aire::close() }}
  <button class="btn btn-warning" data-submit="#gallery-destroy-form-{{ $gallery->id }}">Verwijder gallerij</button>
  <button class="btn btn-primary" data-toggle="modal" data-target="#gallery-update-{{ $gallery->id }}">Gallerij bewerken</button>
  <div class="gallery-grid">
    <div class="gallery-grid__column">
      @php for($i = 0; $i < count($gallery->pictures) / 4; $i++) { @endphp
        <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $gallery->pictures[$i]->dimensions[1] / $gallery->pictures[$i]->dimensions[0] * 100 }}%;">
          <img class="lazy" data-src="{{ Storage::url($gallery->pictures[$i]->url) }}">
          <i class="fa fa-trash d-block" onclick="removePicture({{ $gallery->pictures[$i]->id }});"></i>
          <i class="fa fa-close"></i>
        </div>
      @php } @endphp
    </div>
    <div class="gallery-grid__column">
      @php for($i = ceil(count($gallery->pictures) / 4); $i < ceil((count($gallery->pictures) / 4) * 2); $i++) { @endphp
        <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $gallery->pictures[$i]->dimensions[1] / $gallery->pictures[$i]->dimensions[0] * 100 }}%;">
          <img class="lazy" data-src="{{ Storage::url($gallery->pictures[$i]->url) }}">
          <i class="fa fa-close"></i>
        </div>
      @php } @endphp 
    </div>
    <div class="gallery-grid__column">
      @php for($i = ceil((count($gallery->pictures) / 4) * 2); $i < ceil((count($gallery->pictures) / 4) * 3); $i++) { @endphp
        <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $gallery->pictures[$i]->dimensions[1] / $gallery->pictures[$i]->dimensions[0] * 100 }}%;">
          <img class="lazy" data-src="{{ Storage::url($gallery->pictures[$i]->url) }}">
          <i class="fa fa-close"></i>
        </div>
      @php } @endphp
    </div>
    <div class="gallery-grid__column">
      @php for($i = ceil((count($gallery->pictures) / 4) * 3); $i < count($gallery->pictures); $i++) { @endphp
        <div class="gallery-grid__image-wrap bg-cdbg" style="padding-bottom: {{ $gallery->pictures[$i]->dimensions[1] / $gallery->pictures[$i]->dimensions[0] * 100 }}%;">
          <img class="lazy" data-src="{{ Storage::url($gallery->pictures[$i]->url) }}">
          <i class="fa fa-close"></i>
        </div>
      @php } @endphp
    </div>
  </div>
</div>
@component('components.modal', ['id' => 'gallery-update-' . $gallery->id, 'title' => $gallery->title . ' bewerken'])
  {{ Aire::summary()->verbose() }}
  {{ Aire::open()
    ->route('galleries.update', ['gallery' => $gallery->id])
    ->rules($updateRequest)
    ->multipart()
    ->bind($gallery)
    ->id('gallery-update-form-' . $gallery->id) }}
  {{ Aire::input('title', 'Titel')->id('title')->value('')->autocomplete('off')->placeholder($gallery->title) }}
  {{ Aire::checkbox('is_private', 'Prive?')->checked($gallery->is_private) }}
  <fieldset class="border border-cdblg px-4 mb-4">
    <legend class="w-auto px-3">Foto's toevoegen</legend>
    <div class="js-image-uploads row"></div>
    <div class="d-flex justify-content-center w-100">
      <a href="#" class="mt-4 mb-2 text-center" onclick="event.preventDefault(); addFileInputRow();">Meer foto's toevoegen</a>
    </div>
  </fieldset>
  {{ Aire::close() }}
  <div class="js-file-input-copy">
    <div class="col-6 d-none mt-4" style="height: 300px;">
      @component('components.image-upload', [ 'name' => 'images[]', 'id' => 'temp-id', 'initSelf' => false ])
      Kies foto
      @endcomponent
    </div>
  </div>
  @slot('footer')
  <button class="btn btn-primary" data-submit="#gallery-update-form-{{ $gallery->id }}">Gallerij bewerken</button>
  @endslot
@endcomponent
<script>
  window.addEventListener('load', addFileInputRow);

  function addFileInputRow() {
    addFileInput();
    addFileInput();
  }

  let inputId = 1;
  function addFileInput() {
    const container = document.querySelector('.js-image-uploads');
    const fileInput = document.querySelector('.js-file-input-copy div').cloneNode(true);
    fileInput.classList.remove('d-none');
    const label = fileInput.querySelector('.js-label');
    const input = fileInput.querySelector('.js-input');
    const xIcon = fileInput.querySelector('i');
    xIcon.addEventListener('click', e => {
      if(e.target.dataset.hasImage === 'false') {
        fileInput.remove();
      }
    });
    label.setAttribute('for', `image-${inputId}`);
    input.setAttribute('id', `image-${inputId}`);
    inputId++;
    container.appendChild(fileInput);

    const imageUpload = fileInput.querySelector('.image-upload');
    imageUpload.setAttribute('id', `image-upload-${inputId}`);
    initImageUpload(`#image-upload-${inputId}`);
  } 

  function removePicture(picture) {
    console.log('TODO: Implement');
  }
</script>
@endsection
