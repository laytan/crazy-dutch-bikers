<a class="dropdown-item" href="#password-change" data-toggle="modal" data-target="#password-change">Wachtwoord veranderen</a>
@component('components.modal', ['title' => 'Wachtwoord veranderen', 'id' => 'password-change'])
  {{ Aire::open()->route('change-password')->id('password-change-form')->validate('App\Http\Requests\ChangePasswordRequest')->method('PATCH') }}
  {{ Aire::password('password-old', 'Oud wachtwoord') }}
  {{ Aire::password('password-new', 'Nieuw wachtwoord') }}
  {{ Aire::close() }}
  @slot('footer')
    <button data-submit="#password-change-form" class="btn btn-cdbb">Verander wachtwoord</button>
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
