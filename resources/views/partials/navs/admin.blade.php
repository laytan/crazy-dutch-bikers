@component('components.dropdown', ['id' => 'members-dropdown', 'title' => 'Leden'])
	<a href="{{ route('users.create') }}" class="dropdown-item">Leden toevoegen</a>
	<a href="{{ route('users.index') }}" class="dropdown-item">Leden overzicht</a>
@endcomponent
@component('components.dropdown', ['id' => 'events-dropdown', 'title' => 'Evenementen'])
	<a href="{{ route('events.create') }}" class="dropdown-item">Evenementen toevoegen</a>
	<a href="{{ route('events.index') }}" class="dropdown-item">Evenementen overzicht</a>
@endcomponent
@component('components.dropdown', ['id' => 'merchandise-dropdown', 'title' => 'Merchandise'])
	<a href="{{ route('products.create') }}" class="dropdown-item">Merchandise toevoegen</a>
	<a href="{{ route('products.index') }}" class="dropdown-item">Merchandise overzicht</a>
@endcomponent
@component('components.dropdown', ['id' => 'gallery-dropdown', 'title' => 'Gallerij'])
	<a href="{{ route('galleries.create') }}" class="dropdown-item">Gallerij toevoegen</a>
	<a href="{{ route('galleries.index') }}" class="dropdown-item">Gallerijen overzicht</a>
@endcomponent
<li class="nav-item">
	<div class="d-flex align-items-center">
		<a href="{{ route('orders.index') }}" class="nav-link d-flex align-items-center">
			Bestellingen<span class="badge badge-primary ml-2">{{ orderAmt() }}</span>
		</a>
	</div>
</li>
<li class="nav-item">
	<div class="d-flex align-items-center">
		<a href="{{ route('applications.index') }}" class="nav-link d-flex align-items-center">
			Aanmeldingen
		</a>
	</div>
</li>
@include('partials.navs.user-dropdown')
