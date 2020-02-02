@extends('layouts.app')

@section('content')
<div class="container text-light">
  @include('partials.form-errors')
  <h2>{{ $user->name }} bewerken</h2>
  <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="name">Naam</label>
      <input value="{{ $user->name }}" type="name" name="name" id="name" class="form-control" placeholder="Vul de naam in">
    </div>

    <div class="form-group">
      <label for="email">Email Adres</label>
      <input value="{{ $user->email }}" type="email" name="email" id="email" class="form-control" placeholder="Vul het email adres in">
    </div>

    <div class="form-group">
      <label for="description">Beschrijving</label>
      <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $user->description }}</textarea>
    </div>

    <div class="form-group row">
      <div class="col-4">
        <img class="fit-image" src="{{ $user->profile_picture }}">
      </div>
      <div class="col-8">
        <label for="profile_picture">Profielfoto</label>
        <input type="file" name="profile_picture" id="profile_picture" class="form-control-file">
        <small id="profile_pictureHelp" class="form-text text-muted">Laat leeg om niet te veranderen</small>
      </div>
    </div>

    @can('manage-roles')
    <div class="form-group">
      <label for="role">Rol</label>
      <select name="role" id="role" class="form-control">
        <option value="member" {{ $user->hasRole('member') ? 'selected' : '' }}>Lid</option>
        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Beheer</option>
      </select>
    </div>
    @endcan

    <div id="old_password-form-group" class="form-group">
      <label for="old_password">Oud wachtwoord</label>
      <input type="old_password" name="old_password" id="old_password" class="form-control" placeholder="Oud wachtwoord">
      <small id="old_passwordHelp" class="form-text text-muted">Laat leeg om niet te veranderen</small>
    </div>

    <div id="password-form-group" class="form-group">
      <label for="password">Wachtwoord</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord">
      <small id="passwordHelp" class="form-text text-muted">Laat leeg om niet te veranderen</small>
    </div>

    <button type="submit" class="btn btn-primary">Bewerken</button>
  </form>
</div>
@endsection
