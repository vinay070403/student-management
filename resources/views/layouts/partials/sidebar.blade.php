<nav class="sidebar sidebar-offcanvas bg-white shadow-sm" id="sidebar">
    <ul class="nav flex-column py-3">
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="mdi mdi-home menu-icon me-2"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @can('role-list')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'rolesPermission') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('rolesPermission.index') }}">
                    <i class="mdi mdi-shield-key menu-icon me-2"></i>
                    <span class="menu-title">Roles & Permissions</span>
                </a>
            </li>
        @endcan

        @can('user-list')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'users') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('users.index') }}">
                    <i class="mdi mdi-account menu-icon me-2"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        @endcan

        @can('country-list')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'countries') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('countries.index') }}">
                    <i class="mdi mdi-earth menu-icon me-2"></i>
                    <span class="menu-title">Countries</span>
                </a>
            </li>
        @endcan

        @can('state-list')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'states') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('states.index') }}">
                    <i class="mdi mdi-map-marker menu-icon me-2"></i>
                    <span class="menu-title">States</span>
                </a>
            </li>
        @endcan

        @can('school-list')
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'schools') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('schools.index') }}">
                    <i class="mdi mdi-school menu-icon me-2"></i>
                    <span class="menu-title">Schools</span>
                </a>
            </li>
        @endcan

        {{-- @can('student-list') --}}
            <li class="nav-item {{ Str::startsWith(request()->route()->getName(), 'students') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center" href="{{ route('students.index') }}">
                    <i class="mdi mdi-account-group menu-icon me-2"></i>
                    <span class="menu-title">Students</span>
                </a>
            </li>
        {{-- @endcan --}}
    </ul>
</nav>


@push('styles')
    <style>
        /* Sidebar layout fixes */
        .sidebar {
            position: fixed;
            top: 70px;
            /* height of navbar */
            left: 0;
            width: 230px;
            height: calc(100% - 70px);
            overflow-y: auto;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding-top: 10px;
            z-index: 1030;
        }

        .sidebar .nav-item {
            margin-bottom: 4px;
        }

        .sidebar .nav-link {
            color: #374151;
            font-weight: 500;
            padding: 10px 18px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .sidebar .nav-item.active>.nav-link {
            background-color: #2563eb;
            color: #ffffff;
        }

        .sidebar .menu-icon {
            font-size: 18px;
            line-height: 1;
        }

        /* Adjust main content */
        .main-panel {
            margin-left: 230px;
            padding: 30px;
        }

        @media (max-width: 991px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
            }

            .main-panel {
                margin-left: 0;
            }
        }
    </style>
@endpush
