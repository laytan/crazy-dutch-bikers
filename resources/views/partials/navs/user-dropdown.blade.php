@component('components.dropdown', ['id' => 'user-dropdown', 'title' => Auth::user()->name, 'right' => false])
	<a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}" class="dropdown-item">Profiel bewerken</a>
	<a
	class="dropdown-item"
	href="#"
	data-submit="#logout-form">
		Uitloggen
	</a>
	{{ Aire::open()->route('logout')->id('logout-form')->class('d-none') }}
	{{ Aire::close() }}
@endcomponent
