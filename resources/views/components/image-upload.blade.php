<div id="{{ $id }}" class="@error($name) is-invalid @enderror w-100 h-100 image-upload position-relative bg-cdbb d-flex justify-content-center align-items-center">
  <i data-has-image="false" class="image-upload__remove-icon h-100 text-danger position-absolute top-0 right-0 mt-2 mr-2 fas fa-trash"></i>
  <img alt="" class="d-none w-100 h-100 object-fit-cover position-absolute">
  <div class="js-upload-button">
    <label for="{{ $id }}-input" class="js-label btn btn-primary"><i class="fas fa-upload mr-2"></i>
      <span class="v-align-middle">
        {{ $slot }}  
      </span>
    </label>
    <input id="{{ $id }}-input" type="file" accept="image/*" name="{{ $name }}" class="js-input d-none"> 
  </div>
</div>
@error($name)
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
@enderror
<script>
@if($initSelf === true)
window.addEventListener('load', () => initImageUpload('#' + '{{ $id }}'));
@endif

function initImageUpload(selector) {
  console.log(selector);
  const container = document.querySelector(selector);
  const input = container.querySelector('input');
  console.log(container, input);
  populateOnImage(container, input);
  const removeBtn = container.querySelector('i');
  removeBtn.addEventListener('click', e => {
    const imageEl = container.querySelector('img');
    imageEl.src = '';
    imageEl.classList.add('d-none');
    container.querySelector('.js-upload-button').classList.remove('d-none');
    e.target.setAttribute('data-has-image', 'false');
  });

  const old = {!! isset($old) ? '"'.$old.'"' : 'false' !!};
  if(old) {
    setImage(container, old);
  }
}

function populateOnImage(imageUpload, input) {
  input.addEventListener('change', e => {
    if(!e.target.files || !e.target.files[0]) {
      return;
    }
    const reader = new FileReader();
    reader.onload = e => {
      setImage(imageUpload, e.target.result);
    };
    reader.readAsDataURL(e.target.files[0]);  
  });
}

function setImage(imageUpload, src) {
  const imageEl =  imageUpload.querySelector('img');
  imageEl.src = src;
  imageEl.classList.remove('d-none');
  imageUpload.querySelector('.js-upload-button').classList.add('d-none');
  imageUpload.querySelector('i').setAttribute('data-has-image', 'true');
}
</script>
