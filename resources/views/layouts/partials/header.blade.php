<nav class="navbar navbar-expand-lg fixed-top px-4 py-2 bg-white shadow-sm">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo" class="h-8"
                onerror="this.src='https://demo.bootstrapdash.com/skydash-free/images/logo1.svg'">
        </a>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">
        @php
        $user = auth()->user();
        $full = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $parts = preg_split('/\s+/', $full);
        $initials = 'NA';
        if (!empty($user->avatar)) {
        $avatar_url = Storage::disk('public')->url($user->avatar);
        } else {
        if (count($parts) >= 2 && $parts[0] !== '' && $parts[1] !== '') {
        $initials = mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
        } elseif (!empty($parts[0])) {
        $initials = mb_strtoupper(mb_substr($parts[0], 0, 2));
        }
        $avatar_url = null;
        }
        @endphp

        <!-- Profile Dropdown -->
        <div class="dropdown profile-dropdown">
            <a href="#" id="profileDropdown" class="d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown" aria-expanded="false" role="button">
                @if($avatar_url)
                <img src="{{ $avatar_url }}" alt="Avatar" class="avatar-box me-2">
                @else
                <div class="avatar-box me-2">{{ $initials }}</div>
                @endif
                <div class="d-none d-sm-block fw-semibold text-dark">
                    {{ $user->first_name ?? 'User' }} {{ $user->last_name ?? '' }}
                </div>
                <i class="mdi mdi-chevron-down ms-1 text-muted"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end mt-2 border-2 shadow-sm rounded-3 p-4"
                aria-labelledby="profileDropdown">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-semibold">{{ $user->getRoleNames()->join(', ') }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2">

                        <i class="mdi mdi-account-edit text-primary fs-5"></i> Edit Profile
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger">
                            <i class="mdi mdi-logout fs-5"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>