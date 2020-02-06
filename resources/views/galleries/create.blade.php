@extends('layouts.app')

@section('content')
<div class="container text-light">
  <div class="w-75 m-auto bg-cdbg-opaque p-3">
    <h2>Gallerij aanmaken</h2>
    {{ Aire::summary()->verbose() }}
    {{ Aire::open()->route('galleries.store')->validate($rules)->multipart() }}
    {{ Aire::input('title', 'Titel')->id('title')->autocomplete('off') }}
    {{ Aire::checkbox('is_private', 'Prive?') }}
    <fieldset class="border border-cdblg px-4 mb-4">
      <legend class="w-auto px-3">Foto's</legend>
      <div class="js-image-uploads row"></div>
      <div class="d-flex justify-content-center w-100">
        <a href="#" class="mt-4 mb-2 text-center" onclick="event.preventDefault(); addFileInputRow();">Meer foto's toevoegen</a>
      </div>
    </fieldset>
    {{ Aire::submit('Aanmaken') }}
    {{ Aire::close() }}
    <div class="js-file-input-copy">
      <div class="col-4 d-none mt-4" style="height: 300px;">
        @component('components.image-upload', [ 'name' => 'images[]', 'id' => 'temp-id', 'initSelf' => false ])
        Kies foto
        @endcomponent
      </div>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', addFileInputRow);

function addFileInputRow() {
  addFileInput();
  addFileInput();
  addFileInput();
}

let id = 1;
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
  label.setAttribute('for', `image-${id}`);
  input.setAttribute('id', `image-${id}`);
  id++;
  container.appendChild(fileInput);

  const imageUpload = fileInput.querySelector('.image-upload');
  imageUpload.setAttribute('id', `image-upload-${id}`);
  initImageUpload(`#image-upload-${id}`);
}
</script>
@endsection
