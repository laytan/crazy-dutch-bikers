@extends('layouts.app')

@section('content')
<div class="container text-light">
  <div class="d-flex justify-content-between align-items-center">
    @component('components.title', ['icon' => 'fas fa-users'])
    Leden
    @endcomponent
    @can('manage')
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    @endcan
  </div>
  <div class="users">
    @foreach ($users as $user)
      <div class="users__user mb-3">
        <div class="card bg-cdbg-opaque">
          <div class="user__image-wrap"  style="padding-bottom: {{ $user->profilePictureDimensions[1] / $user->profilePictureDimensions[0] * 100 }}%;">
            <img class="card-img-top lazy" data-src="{{ $user->profile_picture }}" alt="{{ $user->name }}">
          </div>
          <div class="card-body">
            <h5 class="card-title">
              {{ $user->name }}
            </h5>
            <p class="card-text">
              {{ $user->description }}
            </p>
            @can('manage')
            <hr class="border-cdblg">

            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm w-100">
              <i class="fas fa-edit"></i> Bewerken
            </a>
              @can('destroy-user', $user)
              <button data-submit="#destroy-{{ $user->id }}-user" class="btn w-100 btn-danger btn-sm mt-2">
                <i class="fas fa-trash"></i> Verwijderen
              </button>
              {{ Aire::open()->id("destroy-{$user->id}-user")->route('users.destroy', ['user' => $user->id])->class('d-none') }}
              {{ aire::close() }}
              @endcan
            @endcan
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $users->links() }}
</div>
@endsection
