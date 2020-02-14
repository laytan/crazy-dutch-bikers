<div>
@if(session('info'))
    @component('components.alert', ['type' => 'info'])
        {{ session('info') }}
    @endcomponent
@endif
@if(session('success'))
    @component('components.alert', ['type' => 'success'])
        {{ session('success') }}
    @endcomponent
@endif
@if(session('warning'))
    @component('components.alert', ['type' => 'warning'])
        {{ session('warning') }}
    @endcomponent
@endif
@if(session('error'))
    @component('components.alert', ['type' => 'danger'])
        {{ session('error') }}
    @endcomponent
@endif
</div>
