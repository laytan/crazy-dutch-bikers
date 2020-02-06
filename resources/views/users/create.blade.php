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
          @component('components.image-upload', ['name' => 'profile_picture', 'id' => 'profile-picture'])
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
{{-- <div class="container text-light">
    @include('partials.form-errors')
    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="name">Naam</label>
        <input type="name" name="name" id="name" class="form-control" placeholder="Vul de naam in">
      </div>

      <div class="form-group">
        <label for="email">Email Adres</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Vul het email adres in">
      </div>

      <div class="form-group form-check">
        <input name="generate-password" type="checkbox" class="form-check-input" id="random-password">
        <label class="form-check-label" for="random-password">Genereer een willekeurig wachtwoord</label>
      </div>
      
      <div id="password-form-group" class="form-group">
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Vul het wachtwoord in">
      </div>

      <div class="form-group">
        <label for="description">Beschrijving</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label for="profile_picture">Profielfoto</label>
        <input type="file" name="profile_picture" id="profile_picture" class="form-control-file">
      </div>

      @can('manage-roles')
      <div class="form-group">
        <label for="role">Rol</label>
        <select name="role" id="role" class="form-control">
          <option value="member">Lid</option>
          <option value="admin">Beheer</option>
        </select>
      </div>
      @endcan

      <button type="submit" class="btn btn-primary">Voeg toe</button>
    </form>
</div> --}}
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
