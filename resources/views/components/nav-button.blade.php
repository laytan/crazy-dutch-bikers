<li class="mb-3">
  <a href="{{ $link }}" class="cdb-nav-item d-inline-flex align-items-center">
    <div class="cdb-nav-item__icon p-3">
      <img class="object-fit-cover" src="{{ url('/images/engines/' . $engine . '.png') }}">
    </div>
    <span class="cdb-nav-item__inner h3">{{ $slot }}</span>
  </a>
</li>