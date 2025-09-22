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
        /* Custom CSS to fix layout issues */
        .page-body-wrapper {
            display: flex;
            flex-direction: row-reverse;
            /* Move sidebar to right */
            min-height: 100vh;
        }

        .sidebar {
            order: 2;
            /* Sidebar on right */
        }

        .main-panel {
            order: 1;
            /* Content on left */
            flex-grow: 1;
            width: 100%;
        }

        .content-wrapper {
            padding: 20px;
            min-height: calc(100vh - 60px);
            /* Adjust for header/footer height */
        }

        @media (max-width: 991px) {
            .page-body-wrapper {
                flex-direction: column;
            }

            .sidebar {
                order: 1;
                width: 100%;
            }

            .main-panel {
                order: 2;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="page-body-wrapper">
            <!-- Header -->
            @include('layouts.partials.header')
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')
            <!-- Main Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- Footer -->
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
    <!-- Common Scripts with fallbacks -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}" onerror="this.src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/off-canvas.js'"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/hoverable-collapse.js'"></script>
    <script src="{{ asset('assets/js/misc.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/misc.js'"></script>
    @stack('scripts')
</body>

</html>