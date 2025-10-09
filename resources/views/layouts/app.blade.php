<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkyDash Admin') - Admin Panel</title>
    <!-- SkyDash CSS with fallbacks -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" onerror="this.href='https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.css'">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}" onerror="this.href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css'">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" onerror="this.href='https://demo.bootstrapdash.com/skydash-free/css/style.css'">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" onerror="this.href='https://demo.bootstrapdash.com/skydash-free/images/favicon.png'">
    <style>
        /* Reset & Base */
        html,
        body {
            height: 100%;
            overflow: hidden;
            background: #f8f9fa;
        }

        /* Header */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            z-index: 1030;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 250px;
            height: calc(100vh - 120px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e9ecef;
            z-index: 1020;
        }

        /* Main Panel (scrollable area) */
        .main-panel {
            margin-left: 230px;
            margin-top: 70px;
            margin-bottom: 50px;
            height: calc(100vh - 120px);
            overflow-y: auto;
            padding: 10px;
            background: #f9fafb;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 230px;
            right: 0;
            height: 50px;
            background: #fff;
            border-top: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #6c757d;
            z-index: 1020;
        }

        /* Sidebar Profile Image */
        .nav-profile-img {
            width: 32px;
            height: 32px;
            border-radius: 0;
            object-fit: cover;
            border: 1px solid #e9ecef;
            vertical-align: middle;
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .sidebar {
                left: -230px;
                transition: all 0.3s;
            }

            .sidebar.active {
                left: 0;
            }

            .main-panel {
                margin-left: 0;
            }

            .footer {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Panel -->
    <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    <!-- Common Scripts with fallbacks -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}" onerror="this.src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/off-canvas.js'"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/hoverable-collapse.js'"></script>
    <script src="{{ asset('assets/js/misc.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/misc.js'"></script>
    @stack('scripts')
</body>

</html>