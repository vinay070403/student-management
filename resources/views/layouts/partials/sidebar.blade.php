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
        <li class="nav-item {{ request()->routeIs('admin.schools') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.schools') }}">
                <i class="mdi mdi-school menu-icon"></i>
                <span class="menu-title">Schools</span>
            </a>
        </li>
        @endcan
    </ul>
</nav>