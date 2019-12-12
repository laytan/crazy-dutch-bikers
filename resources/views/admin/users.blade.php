@extends('layouts.app')

@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Actieve leden</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="trashed-tab" data-toggle="tab" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false">Prullenbak</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active mt-3" id="active" role="tabpanel" aria-labelledby="active-tab">
        <h2>Gebruikers</h2>
        <table class="table table-striped">
          <thead>
            <th scope="col">Naam</th>
            <th scope="col">Email</th>
            <th scope="col">Naar prullenbak</th>
          </thead>
          <tbody>
            @foreach ($active as $user)
              <tr>
                <th scope="row">{{ $user->name }}</th>
                <th>{{ $user->email }}</th>
                <th>
                <form action="/leden/verwijder" method="POST">
                  @csrf
                  <input type="hidden" name="email" value="{{ $user->email }}">
                  <input type="submit" value="Verwijder" class="btn btn-warning">
                </form>
                </th>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade mt-3" id="trashed" role="tabpanel" aria-labelledby="trashed-tab">
        <h2>Prullenbak</h2>
        <table class="table">
            <thead>
              <th scope="col">Naam</th>
              <th scope="col">Email</th>
              <th scope="col">Activeer</th>
            </thead>
            <tbody>
              @foreach ($trashed as $user)
                <tr>
                  <th scope="row">{{ $user->name }}</th>
                  <th>{{ $user->email }}</th>
                  <th>
                    <form action="/leden/activeer" method="POST">
                      @csrf
                      <input type="hidden" name="email" value="{{ $user->email }}">
                      <input type="submit" value="Heractiveer" class="btn btn-info">
                    </form>
                  </th>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </div>
</div>
@endsection
