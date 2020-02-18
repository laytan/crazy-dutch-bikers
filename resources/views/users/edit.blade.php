@extends('layouts.app')

@section('content')
<div class="container text-light">
  <h2>Profiel bewerken</h2>
  {{ Aire::open()->route('users.update', ['user' => $user->id])->multipart()->bind($user) }}
  {{ Aire::input('name', 'Naam') }}
  {{ Aire::input('email', 'E-Mail') }}
  {{ Aire::textarea('description', 'Beschrijving') }}
  @component('components.image-upload', ['old' => $user->profile_picture, 'id' => 'profile_picture', 'name' => 'profile_picture', 'initSelf' => true])
    Profielfoto kiezen
  @endcomponent
  @can('manage-roles')
  {{ Aire::select(['member' => 'Lid', 'admin' => 'Beheer'], 'role', 'Rol') }}
  @endcan
  {{ Aire::password('old_password', 'Oud wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::password('password', 'Nieuw wachtwoord')->helpText('Laat leeg om niet te veranderen') }}
  {{ Aire::submit('Bewerken') }}
  {{ Aire::close() }}
</div>
@endsection
