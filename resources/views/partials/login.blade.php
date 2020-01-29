<a class="nav-link" href="#login" data-toggle="modal" data-target="#login">Login</a>
@component('components.modal', ['title' => 'Inloggen', 'id' => 'login'])
<form method="POST" action="{{ route('login') }}" id="loginForm">
  @csrf
  <div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
    <div class="col-md-6">
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ old('email') }}" required autocomplete="email" autofocus>
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
    <div class="col-md-6">
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
        required autocomplete="current-password">
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-6 offset-md-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember"
          {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
          {{ __('Remember Me') }}
        </label>
      </div>
    </div>
  </div>
</form>
@slot('footer')
<button class="btn-cdbb btn" onclick="document.getElementById('loginForm').submit();">Log in!</button>
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