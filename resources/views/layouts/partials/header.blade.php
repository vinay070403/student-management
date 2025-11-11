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

        // Full name
        $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $nameParts = preg_split('/\s+/', $fullName);

        // Default initials
        $initials = 'NA';

        // Determine avatar URL
        if (!empty($user->avatar)) {
        $avatarUrl = Storage::disk('public')->url($user->avatar);
        } else {
        // Compute initials
        if (count($nameParts) >= 2 && !empty($nameParts[0]) && !empty($nameParts[1])) {
        $initials = mb_strtoupper(mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[1], 0, 1));
        } elseif (!empty($nameParts[0])) {
        $initials = mb_strtoupper(mb_substr($nameParts[0], 0, 2));
        }
        $avatarUrl = null;
        }
        @endphp
        <!-- Profile Dropdown -->
        <div class="dropdown profile-dropdown">
            <a href="#" id="profileDropdown"
                class="d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                role="button"
                style="gap: 8px;">

                @if (!empty($avatar_url))
                <img src="{{ $avatar_url }}"
                    alt="Avatar"
                    class="rounded-circle border shadow-sm"
                    style="width: 38px; height: 38px; object-fit: cover;">
                @else
                <div class="rounded-circle bg-primary text-white fw-semibold d-flex justify-content-center align-items-center shadow-sm"
                    style="width: 38px; height: 38px; font-size: 14px;">
                    {{ $initials }}
                </div>
                @endif

                <div class="d-none d-sm-block text-dark fw-semibold">
                    {{ $user->first_name ?? 'User' }} {{ $user->last_name ?? '' }}
                </div>

                <i class="mdi mdi-chevron-down text-muted ms-1"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2 border-2 shadow-sm rounded-3 p-4"
                aria-labelledby="profileDropdown">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-semibold">{{ $user->getRoleNames()->join(', ') }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </li>
                <li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                        <i class="mdi mdi-account-edit text-primary fs-5"></i> Edit Profile
                    </a>
                </li>

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