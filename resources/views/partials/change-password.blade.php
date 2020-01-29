<a class="dropdown-item" href="#password-change" data-toggle="modal" data-target="#password-change">Wachtwoord veranderen</a>
@component('components.modal', ['title' => 'Wachtwoord veranderen', 'id' => 'password-change'])
  <form action="{{ route('change-password') }}" method="post" id="password-change-form">
    @csrf
    <div class="form-group">
      <label for="password-old">Oud wachtwoord</label>
      <input type="password" name="password-old" id="password-old" class="form-control @error('password-old') is-invalid @enderror" placeholder="Vul het oude wachtwoord in">
      @error('password-old')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-group">
      <label for="password-new">Nieuw wachtwoord</label>
      <input type="password" name="password-new" id="password-new" class="form-control @error('password-new') is-invalid @enderror" placeholder="Vul het nieuwe wachtwoord in">
      @error('password-new')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </form>
  @slot('footer')
    <button onclick="document.getElementById('password-change-form').submit();" class="btn btn-cdbb">Verander wachtwoord</button>
  @endslot
@endcomponent

{{-- Show modal on page load if there are errors or if the backend asked via session --}}
@if(($errors->has('password-old') || $errors->has('password-new')) || session('showChangePassword'))
<script type="text/javascript">
  window.onload = function() {
      $('#password-change').modal('show');
  };
</script>
@endif