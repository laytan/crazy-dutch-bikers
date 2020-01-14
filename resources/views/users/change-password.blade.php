@extends('layouts.app')

@section('content')
<div class="container text-light">
    @include('partials.form-errors')
    <form action="{{ route('change-password') }}" method="post">
      @csrf

      <div class="form-group">
        <label for="password-old">Oud wachtwoord</label>
        <input type="password" name="password-old" id="password-old" class="form-control" placeholder="Vul het oude wachtwoord in">
      </div>

      <div class="form-group">
        <label for="password-new">Nieuw wachtwoord</label>
        <input type="password" name="password-new" id="password-new" class="form-control" placeholder="Vul het nieuwe wachtwoord in">
      </div>

      <button type="submit" class="btn btn-primary">Verander wachtwoord</button>
    </form>
</div>
@endsection
