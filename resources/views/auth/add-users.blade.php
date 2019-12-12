@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    <form action="/leden-toevoegen" method="post">
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

      <button type="submit" class="btn btn-primary">Voeg toe</button>
    </form>
</div>
<script>
  const randomPasswordBox = document.getElementById('random-password');
  const passwordWrapper = document.getElementById('password-form-group');
  
  randomPasswordBox.addEventListener('change', function(e) {
    const checked = randomPasswordBox.checked;
    console.log(checked);
    if(checked) {
      passwordWrapper.style.display = "none";
    } else {
      passwordWrapper.style.display = "block";
    }
  });

  // Initial
  randomPasswordBox.checked = true;
  passwordWrapper.style.display = "none";
</script>
@endsection
