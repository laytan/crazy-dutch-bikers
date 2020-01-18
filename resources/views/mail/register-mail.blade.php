@component('mail::message')
# Uw registratie op Crazy Dutch Bikers

U bent zojuist door een beheerder geregistreerd op <a href="{{ URL::to('/') }}">Crazy Dutch Bikers</a>.

@component('mail::panel')
## Uw gegevens
<table>
  <tbody>
    <tr>
      <td>Naam:</td>
      <td>{{ $name }}</td>
    </tr>
    <tr>
      <td>Email:</td>
      <td>{{ $email }}</td>
    </tr>
    <tr>
      <td>Wachtwoord:</td>
      <td>{{ $password }}</td>
    </tr>
  </tbody>
</table>
@endcomponent

@component('mail::button', ['url' => URL::to('/login'), 'color' => 'primary'])
Log hier in
@endcomponent

Fijne dag,  
{{ config('app.name') }}
@endcomponent

