@component('components.modal', ['title' => 'Inloggen', 'id' => 'login'])
{{ Aire::open()->route('login')->method('POST')->id('loginForm')->validate('App\Http\Requests\LoginRequest') }}
<p>
  Inloggen alleen mogelijk als lid van Crazy Dutch Bikers
</p>
{{ Aire::email('email', 'E-Mail') }}
{{ Aire::password('password', 'Wachtwoord') }}
{{ Aire::checkbox('remember', 'Onthoud mijn gegevens')->checked(old('remember') ? true : false) }}
{{ Aire::close() }}
@slot('footer')
<button dusk="login-submit" class="btn-cdbb btn" data-submit="#loginForm">Log in!</button>
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
