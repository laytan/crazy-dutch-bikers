<nav class="navbar navbar-expand-lg fixed-bottom navigation p-0">
    <div id="navigation" class="navbar-collapse collapse">
        <div class="w-100 d-flex justify-content-end">
            <ul class="navbar-nav px-3 bg-cdbb d-inline-block">
                @guest
                    @include('partials.navs.guest')
                @else
                    @can('manage')
                        @include('partials.navs.admin')
                    @else
                        @include('partials.navs.member')
                    @endcan
                @endguest
            </ul>
        </div>
    </div>
    <div class="bg-cdbb w-100 navbar-text d-flex justify-content-between pl-3 pr-1">
        <a href="{{ url('/') }}" class="navbar-brand navigation__logo">
            <img src="{{ url('/images/cdb-logo.png') }}" alt="Crazy Dutch Bikers logo">
        </a>
        <button class="btn btn-primary btn-sm align-self-center">
            <i class="fas fa-user-lock"></i> Members only
        </button>
        <button
        class="navbar-toggler border-0 collapsed navigation-toggler"
        aria-expanded="false"
        aria-controls="#navigation"
        data-toggle="collapse"
        data-target="#navigation"
        type="button">
            <span class="navigation-toggler__bar"></span>
            <span class="navigation-toggler__bar"></span>
            <span class="navigation-toggler__bar"></span>
        </button>
    </div>
</nav>
