@extends('layouts.app')

@section('content')
<div class="container text-light">
    @component('components.title', ['icon' => 'fas fa-user-plus'])
    Lid Toevoegen
    @endcomponent
    {{ Aire::open()->route('users.store')->validate('App\Http\Requests\CreateUserRequest')->multipart() }}
    {{ Aire::summary()->verbose() }}
    <div class="row">
      <div class="col-12 col-md-6">
        {{ Aire::input('name', 'Naam') }}
        {{ Aire::email('email', 'E-Mail')->autocomplete('off') }}
        {{ Aire::checkbox('generate-password', 'Genereer een willekeuring wachtwoord')->id('random-password') }}
        <div id="password-form-group">
          {{ Aire::password('password', 'Wachtwoord')->autocomplete('off') }}
        </div>
        @can('manage-roles')
          {{ Aire::select(['member' => 'Lid', 'admin' => 'Beheerder'], 'role', 'Rol') }}
        @endcan
      </div>
      <div class="col-12 col-md-6">
        <div class="mb-3">
          <div
            data-image-upload="true"
            data-start-image=""
            data-name="profile_picture"
            data-id="profile_picture"
            @error('profile_picture') data-invalid="true" @enderror
            data-label="Profiel foto"
          ></div>
          </div>
        </div>
      </div>
    {{ Aire::textarea('description', 'Beschrijving') }}
    {{ Aire::submit('Aanmaken') }}
    {{ Aire::close() }}
</div>
<script>
  window.onload = handlePasswordBox;
  const randomPasswordBox = document.getElementById('random-password');
  const passwordWrapper = document.getElementById('password-form-group');

  function handlePasswordBox(e) {
    const checked = randomPasswordBox.checked;
    if(checked) {
      passwordWrapper.style.display = "none";
    } else {
      passwordWrapper.style.display = "block";
    }
  }

  randomPasswordBox.addEventListener('change', handlePasswordBox);

  // Initial
  randomPasswordBox.checked = true;
  passwordWrapper.style.display = "none";
</script>
@endsection
