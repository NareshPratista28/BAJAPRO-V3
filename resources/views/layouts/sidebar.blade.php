<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/1.png') }}" width="160" alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/logo-single.png') }}" width="70px" alt="" />
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-globe"></i> View Site
        </a>
    </div>
</aside>
