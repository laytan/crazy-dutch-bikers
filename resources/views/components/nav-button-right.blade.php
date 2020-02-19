<li class="mb-md-3">
  <a href="{{ $link }}" class="cdb-nav-item cdb-nav-item--right d-inline-flex align-items-center">
    <span class="cdb-nav-item__inner h4">{{ $slot }}</span>
    <div class="cdb-nav-item__icon p-3">
      <img class="object-fit-cover" src="{{ url('/images/engines/' . $engine . '.png') }}">
      {{-- <i class="fas fa-calendar-week fa-4x"></i> --}}
    </div>
  </a>
</li>
