<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkyDash Admin') - Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Google Font: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- SkyDash CSS with fallbacks -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" onerror="this.href='https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.css'">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}" onerror="this.href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css'">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" onerror="this.href='https://demo.bootstrapdash.com/skydash-free/css/style.css'">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" onerror="this.href='https://demo.bootstrapdash.com/skydash-free/images/favicon.png'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.15.3/tingle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @yield('styles')

    <style>
        /* -------------------- Font Integration -------------------- */
        body {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        /* You can also apply heavier/lighter font weights if needed */
        .montserrat-bold {
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
        }

        .montserrat-medium {
            font-family: "Montserrat", sans-serif;
            font-weight: 500;
        }

        .montserrat-light {
            font-family: "Montserrat", sans-serif;
            font-weight: 300;
        }

        /* -------------------- Layout Styling -------------------- */
        html,
        body {
            height: 100%;
            overflow: hidden;
            background: #bdd6f1ff;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            z-index: 1030;
        }

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

        .main-panel {
            margin-left: 230px;
            margin-top: 60px;
            margin-bottom: 50px;
            height: calc(100vh - 120px);
            overflow-y: auto;
            padding: 10px;
            background: #f9fafb;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 250px;
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

        .nav-profile-img {
            width: 32px;
            height: 32px;
            border-radius: 0;
            object-fit: cover;
            border: 1px solid #e9ecef;
            vertical-align: middle;
        }

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    <!-- Common Scripts with fallbacks -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}" onerror="this.src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/off-canvas.js'"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.15.3/tingle.min.js"></script>
    @stack('scripts')
    @include('sweetalert2::index')

</body>

</html>