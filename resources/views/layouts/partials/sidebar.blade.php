<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('user-list')
        <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        @endcan
        @can('school-list')
        <li class="nav-item {{ request()->routeIs('schools.index') ? 'active' : '' }}">
            <!-- <a class="nav-link" href="{{ route('schools.index') }}"> -->
            <a class="nav-link" href="{{ route('schools.index') }}">
                <i class="mdi mdi-school menu-icon"></i>
                <span class="menu-title">Schools</span>
            </a>
        </li>
        @endcan
        @can('user-list') {{-- Students view ke liye bhi yahi permission use ho rahi hai --}}
        <li class="nav-item {{ request()->routeIs('students.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('students.index') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Students</span>
            </a>
        </li>
        @endcan
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('students.index') }}" @can('user-list') style="display: block;" @endcan>
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Students</span>
            </a>
        </li> -->
        @can('country-list')
        <li class="nav-item {{ request()->routeIs('countries.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('countries.index') }}">
                <i class="mdi mdi-earth menu-icon"></i>
                <span class="menu-title">Countries</span>
            </a>
        </li>
        @endcan
        @can('state-list')
        <li class="nav-item {{ request()->routeIs('states.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('states.index') }}">
                <i class="mdi mdi-map-marker menu-icon"></i>
                <span class="menu-title">States</span>
            </a>
        </li>
        @endcan
        @can('class-list')
        <li class="nav-item {{ request()->routeIs('classes.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('classes.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Classes</span>
            </a>
        </li>
        @endcan
        </li>
    </ul>
</nav>