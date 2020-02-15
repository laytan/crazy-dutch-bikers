<a dusk="login-link" class="nav-link" href="#login" data-toggle="modal" data-target="#login">Login</a>
@component('components.modal', ['title' => 'Inloggen', 'id' => 'login'])
<form method="POST" action="{{ route('login') }}" id="loginForm">
  @csrf
  <p>
    Inloggen alleen mogelijk als lid van Crazy Dutch Bikers
  </p>
  <div class="form-group">
    <label for="email">E-Mail</label>
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ old('email') }}" required autocomplete="email" autofocus>
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="password">Wachtwoord</label>
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
      required autocomplete="current-password">
    @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" id="remember"
        {{ old('remember') ? 'checked' : '' }}>
      <label class="form-check-label" for="remember">
        Onthoud mijn gegevens
      </label>
    </div>
  </div>
</form>
@slot('footer')
<button dusk="login-submit" class="btn-cdbb btn" onclick="document.getElementById('loginForm').submit();">Log in!</button>
@endslot
@endcomponent

{{-- Show modal on page load if there are errors or if the backend asked via session --}}
@if(($errors->has('email') || $errors->has('password')) || session('showLogin'))
<script type="text/javascript">
  window.onload = function() {
      $('#login').modal('show');
  };
</script>
@endif
