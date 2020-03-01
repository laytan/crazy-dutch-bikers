<li class="mb-md-3">
  <a href="{{ $link }}" class="cdb-nav-item cdb-nav-item--right d-inline-flex align-items-center d-md-none">
    <span class="cdb-nav-item__inner h4">{{ $slot }}</span>
    <div class="cdb-nav-item__icon p-3">
      <img class="object-fit-cover" src="{{ url('/images/engines/' . $engine . '.png') }}">
    </div>
  </a>
  <a href="{{ $link }}" class="cdb-nav-item align-items-center d-none d-md-inline-flex">
    <div class="cdb-nav-item__icon p-3">
      <img class="object-fit-cover" src="{{ url('/images/engines/' . $engine . '.png') }}">
    </div>
    <span class="cdb-nav-item__inner h4">{{ $slot }}</span>
  </a>
</li>
