@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-edit'])
  Profiel bewerken
  @endcomponent
  {{ Aire::open()->route('users.update', ['user' => $user->id])->multipart()->bind($user) }}
  {{ Aire::input('name', 'Naam') }}
  {{ Aire::input('email', 'E-Mail') }}
  {{ Aire::textarea('description', 'Beschrijving') }}
  <div class="row">
      <div
        class="col-12 col-md-8 col-lg-6"
        data-image-upload="true"
        data-start-image="{{ $user->profile_picture }}"
        data-name="profile_picture"
        data-id="profile_picture"
        @error('profile_picture') data-invalid="true" @enderror
        data-label="Kies profiel foto"
      ></div>
  </div>
  @can('manage-roles')
  {{ Aire::select(['member' => 'Lid', 'admin' => 'Beheer'], 'role', 'Rol') }}
  @endcan
  {{ Aire::password('old_password', 'Oud wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::password('password', 'Nieuw wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::submit('Bewerken') }}
  {{ Aire::close() }}
</div>
@endsection
