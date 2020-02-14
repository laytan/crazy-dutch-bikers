@extends('layouts.app')

@section('content')
<div class="container text-light">
  <div class="w-75 m-auto bg-cdbg-opaque p-3">
    {{ Aire::open()->route('users.store')->validate('App\Http\Requests\CreateUserRequest')->multipart() }}
    <div class="row">
      <div class="col-6">
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
      <div class="col-6">
        <div style="height: 400px;" class="mb-3">
          @component('components.image-upload', ['name' => 'profile_picture', 'id' => 'profile-picture', 'initSelf' => true])
          Profiel foto
          @endcomponent
          </div>
        </div>
      </div>
    {{ Aire::textarea('description', 'Beschrijving') }}
    {{ Aire::submit('Aanmaken') }}
    {{ Aire::close() }}
  </div>
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
