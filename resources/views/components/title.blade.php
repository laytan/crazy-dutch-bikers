<h2 class="py-3 mb-0 h7 h-md-4 h-md-4">
  @isset($icon)
    <i class="{{ $icon }} px-2 py-1 bg-primary text-white rounded mr-2"></i>
  @endisset
  {{ $slot }}
</h2>
@section('title', ' - ' . strip_tags($slot))
