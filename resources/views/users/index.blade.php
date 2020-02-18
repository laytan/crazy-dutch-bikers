@extends('layouts.app')

@section('content')
<div class="container-fluid text-light">
  <div class="row">
    @foreach ($users as $user)
      <div class="col-12 col-sm-6 col-md-4">
        <div class="card text-dark mb-5">
          <img src="{{ $user->profile_picture }}" alt="Geen profiel foto" class="card-img-top member-profile-picture">
          <div class="card-body">
            <h5 class="card-title">
              {{ $user->name }}
            </h5>
            <p class="card-text">
              <p>
                {{ $user->description }}
              </p>
              <small class="text-muted">{{ $user->email }}</small>
            </p>
            @can('update-user', $user)
              <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-warning">Bewerken</a>
            @endcan
            @can('destroy-user', $user)
              {{ Aire::open()->route('users.destroy', ['user' => $user->id]) }}
              {{ Aire::input('user')->type('hidden')->value($user->id) }}
              {{ Aire::submit('Verwijder') }}
              {{ Aire::close() }}
            @endcan
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
