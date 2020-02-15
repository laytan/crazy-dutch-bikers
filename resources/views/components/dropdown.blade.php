<li class="nav-item dropdown">
  <a id="{{ $title }}-dropdown" class="nav-link dropdown-toggle text-decoration-none" role="button"
  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ $title }} <span class="caret"></span>
  </a>
  <div class="dropdown-menu {{ isset($right) ? 'dropdown-menu-right' : '' }}" aria-labelledby="{{ $title }}Dropdown">
      {{ $slot }}
  </div>
</li>
