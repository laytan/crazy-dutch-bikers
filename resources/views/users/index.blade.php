@extends('layouts.app')

@section('content')
<div class="container-fluid text-light">
  <div class="row">
    @foreach ($active as $user)
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
            @if($user->email === auth()->user()->email || auth()->user()->hasAnyRole(['admin', 'super-admin']))
              <a href="{{ route('users-edit', ['id' => $user->id]) }}" class="btn btn-warning">Bewerken</a>
              <form action="{{ route('users-destroy') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="submit" value="Verwijder" class="btn btn-danger">
              </form>
            @endif
          </div>
        </div>
      </div>
    @endforeach
    @hasanyrole('admin|super-admin')
    <div class="col-12">
      <hr>
      <h2>Prullenbak</h2>
    </div>
    @foreach($trashed as $user)
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card text-dark mb-5">
        <img src="https://via.placeholder.com/150x200" alt="Profile picture" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">
            {{ $user->name }}
          </h5>
          <p class="card-text">
            {{ $user->description }}
            <small class="text-muted">{{ $user->email }}</small>
          </p>
          @hasanyrole('admin|super-admin')
            <form action="{{ route('users-activate') }}" method="POST">
              @csrf
              <input type="hidden" name="email" value="{{ $user->email }}">
              <input type="submit" value="Heractiveer" class="btn btn-warning">
            </form>
          @endhasanyrole
        </div>
      </div>
    </div>
    @endforeach
    @endhasanyrole
  </div>
</div>
@endsection
