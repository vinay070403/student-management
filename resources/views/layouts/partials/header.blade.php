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
        $initials = '';
        if (count($parts) >= 2 && $parts[0] !== '' && $parts[1] !== '') {
        $initials = mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
        } elseif (!empty($parts[0])) {
        $initials = mb_strtoupper(mb_substr($parts[0], 0, 2));
        } else {
        $initials = 'NA';
        }
        @endphp

        <!-- Profile Dropdown (Bootstrap-friendly) -->
        <div class="dropdown profile-dropdown">
            <!-- use an anchor/button with data-bs-toggle -->
            <a href="#" id="profileDropdown" class="d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown" aria-expanded="false" role="button">
                <div class="avatar-box me-2">{{ $initials }}</div>
                <div class="d-none d-sm-block fw-semibold text-dark">
                    {{ $user->first_name ?? 'User' }} {{ $user->last_name ?? '' }}
                </div>
                <i class="mdi mdi-chevron-down ms-1 text-muted"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end mt-2 border-2 shadow-sm rounded-3 p-4"
                aria-labelledby="profileDropdown">
                <li class="px-3 py-2 border-bottom">
                    <!-- <div class="fw-semibold">{{ $user->first_name }} {{ $user->last_name }}</div> -->
                    <div class="fw-semibold">{{ $user->getRoleNames()->join(', ') }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
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

@push('styles')
<style>
    /* Avatar square */
    .avatar-box {
        width: 38px;
        height: 38px;
        background-color: #dbeafe;
        color: #1e3a8a;
        font-weight: 700;
        font-size: 14px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.06);
    }

    /* keep top spacing for fixed navbar */
    body {
        padding-top: 70px;
    }

    /* rely on .show added by Bootstrap JS — allow animation */
    .profile-dropdown {
        position: relative;
    }

    /* keep the menu in the DOM but hidden; show controlled by .show */
    .profile-dropdown .dropdown-menu {
        display: block;
        /* keep block so .show toggles visibility */
        opacity: 0;
        transform: translateY(6px);
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s;
        z-index: 2050;
        /* sit above sidebar/main-panel */
    }

    /* when Bootstrap adds .show, make it visible */
    .profile-dropdown .dropdown-menu.show {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
        pointer-events: auto;
    }

    /* stronger z-index safeguard for other dropdowns too */
    .dropdown-menu {
        z-index: 2050 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick check: is Bootstrap bundle loaded?
        const bsLoaded = (typeof bootstrap !== 'undefined');
        console.log('Bootstrap present?', bsLoaded);

        // If bootstrap isn't available, add a tiny fallback so dropdown still works for testing:
        if (!bsLoaded) {
            console.warn('Bootstrap JS not found — enabling simple dropdown fallback for profile menu.');
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.id;
                    const menu = document.querySelector('.dropdown-menu[aria-labelledby="' + id + '"]');
                    if (!menu) return;
                    menu.classList.toggle('show');
                });
            });

            // close fallback dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    const toggleId = menu.getAttribute('aria-labelledby');
                    const toggle = document.getElementById(toggleId);
                    if (!toggle) return;
                    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            });
        }
    });
</script>
@endpush