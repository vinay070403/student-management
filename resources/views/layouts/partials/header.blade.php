<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/logo1.svg') }}" alt="logo" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/images/logo1.svg'"></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/images/logo-mini.svg'"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <span class="nav-profile-name">{{ auth()->user()->first_name ?? 'User' }} {{ auth()->user()->last_name ?? '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>