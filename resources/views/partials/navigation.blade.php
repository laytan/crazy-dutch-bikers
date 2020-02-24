<nav class="navbar navbar-expand-lg fixed-bottom lg-sticky-top navigation p-0 bg-lg-cdbb">
    <div id="navigation" class="navbar-collapse collapse order-lg-2">
        <div class="w-100 d-flex justify-content-end">
            <ul class="navbar-nav px-3 bg-cdbb d-inline-block w-100 d-lg-flex align-items-center">
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
            @yield('nav-end')
        </div>
    </div>
    <div class="bg-cdbb w-100 navbar-text d-flex justify-content-between pl-3 pr-1 w-lg-auto order-lg-1">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="navigation__logo d-inline-block">
                <img src="{{ url('/images/cdb-logo.png') }}" alt="Crazy Dutch Bikers logo">
            </div>
            <h1 class="d-none d-xl-inline-block brand-text mb-0">
                Cra<span class="brand-text__z">Z</span>y Dutch Bikers
            </h1>
        </a>
        <button class="btn btn-primary btn-sm align-self-center d-lg-none" data-toggle="modal" data-target="#login">
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
{{-- Login modal --}}
@include('partials.login')
</nav>
