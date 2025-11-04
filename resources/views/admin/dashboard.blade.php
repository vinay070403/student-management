@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- ✅ Page Loader -->
<div class="page-loader" id="pageLoader" aria-hidden="true" role="status" aria-label="Loading">
    <div class="spinner" aria-hidden="true"></div>
</div>

<div class="container py-4">
    <!-- Dashboard Cards -->
    <div class="row g-4">
        @can('user-list')
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('users.index') }}" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">Users</h6>
                            <h3 class="fw-bold text-primary mb-0">{{ \App\Models\User::count() }}</h3>
                            <p class="text-muted small mb-0">Total registered</p>
                        </div>
                        <div class="bg-gradient-primary rounded-circle p-3 d-flex align-items-center justify-content-center card-icon">
                            <i class="mdi mdi-account-multiple text-white" style="font-size: 20px;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('school-list')
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('schools.index') }}" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">Schools</h6>
                            <h3 class="fw-bold text-success mb-0">{{ \App\Models\School::count() }}</h3>
                            <p class="text-muted small mb-0">Active schools</p>
                        </div>
                        <div class="bg-gradient-success rounded-circle p-3 d-flex align-items-center justify-content-center card-icon">
                            <i class="mdi mdi-school text-white" style="font-size: 20px;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('country-list')
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('countries.index') }}" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">Countries</h6>
                            <h3 class="fw-bold text-info mb-0">{{ \App\Models\Country::count() }}</h3>
                            <p class="text-muted small mb-0">Total countries</p>
                        </div>
                        <div class="bg-gradient-info rounded-circle p-3 d-flex align-items-center justify-content-center card-icon">
                            <i class="mdi mdi-earth text-white" style="font-size: 20px;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('state-list')
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('states.index') }}" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2">States</h6>
                            <h3 class="fw-bold text-danger mb-0">{{ \App\Models\State::count() }}</h3>
                            <p class="text-muted small mb-0">Total states</p>
                        </div>
                        <div class="bg-gradient-danger rounded-circle p-3 d-flex align-items-center justify-content-center card-icon">
                            <i class="mdi mdi-map-marker text-white" style="font-size: 20px;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan
    </div>
</div>
@endsection

@section('styles')
<style>
    /* ===== Page Loader ===== */
    .page-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(78, 115, 223, 0.3);
        border-top: 4px solid #4e73df;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* ===== Dashboard Cards ===== */
    .dashboard-card {
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(145deg, #ffffff 0%, #f8faff 100%);
        transition: all 0.3s ease;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        min-height: 180px;
    }

    .dashboard-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        background: linear-gradient(145deg, #f0f4ff 0%, #e0ebff 100%);
    }

    .dashboard-card .card-body {
        padding: 2rem;
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
    }

    .dashboard-card:hover .card-icon {
        transform: scale(1.2) rotate(10deg);
    }
</style>
@endsection

@push('scripts')
<script>
    // ✅ Show loader while navigating between pages
    document.addEventListener("DOMContentLoaded", function() {
        const loader = document.getElementById("pageLoader");

        // Hide loader when page finishes loading
        loader.style.display = "none";

        // Show loader when leaving page or clicking links
        window.addEventListener("beforeunload", function() {
            loader.style.display = "flex";
        });

        // Show loader when clicking dashboard links
        document.querySelectorAll(".dashboard-link").forEach(link => {
            link.addEventListener("click", function(e) {
                loader.style.display = "flex";
            });
        });
    });
</script>
@endpush