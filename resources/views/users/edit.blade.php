@extends('layouts.app')

@section('content')
<div class="container text-light">
  @component('components.title', ['icon' => 'fas fa-edit'])
  Profiel bewerken
  @endcomponent
  {{ Aire::open()->route('users.update', ['user' => $user->id])->multipart() }}
	@component('components.alert', ['type' => 'secondary'])
		Alle ingevulde velden worden veranderd, laat velden leeg die niet veranderd hoeven te worden.
  @endcomponent
  @can('manage')
    {{ Aire::input('name', 'Naam') }}
    {{ Aire::input('email', 'E-Mail') }}
  @endcan
  {{ Aire::textarea('description', 'Beschrijving') }}
  <div class="row">
      <div
        class="col-12 col-md-8 col-lg-6"
        data-image-upload="true"
        data-start-image=""
        data-name="profile_picture"
        data-id="profile_picture"
        @error('profile_picture') data-invalid="true" @enderror
        data-label="Kies profiel foto"
      ></div>
  </div>
  @can('manage-roles')
    @if(!$user->hasRole('super-admin'))
      {{ Aire::select(['member' => 'Lid', 'admin' => 'Beheer'], 'role', 'Rol') }}
    @endif
  @endcan
  {{ Aire::password('old_password', 'Oud wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::password('password', 'Nieuw wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::submit('Bewerken') }}
  {{ Aire::close() }}
</div>
@endsection
