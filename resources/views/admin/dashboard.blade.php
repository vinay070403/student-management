@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-loader" aria-hidden="true" role="status" id="pageLoader" aria-label="Loading" style="display: none;">
    <div class="spinner" aria-hidden="true"></div>
</div>

<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm-0 mb-0">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1 fw-bold text-gradient-primary">Welcome, {{ auth()->user()->first_name ?? 'User' }} {{ auth()->user()->last_name ?? '' }}!</h2>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-weather-sunny me-2 text-warning" style="font-size: 24px;"></i>
                            <span class="text-muted">All systems running smoothly</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards (Larger, Colorful, Interactive) -->
    <div class="row g-4">
        @can('user-list')
        <div class="col-xl-4 col-lg-4 col-md-6">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);">
                    <div class="card-body py-4 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase mb-2">Users</h6>
                                <h3 class="fw-bold text-primary mb-0">{{ \App\Models\User::count() }}</h3>
                                <p class="text-muted small mb-0">Total registered</p>
                            </div>
                            <div class="bg-gradient-primary rounded-circle p-3 ms-3" style="min-width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-account-multiple text-white" style="font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('school-list')
        <div class="col-xl-4 col-lg-4 col-md-6">
            <a href="{{ route('schools.index') }}" class="text-decoration-none">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);">
                    <div class="card-body py-4 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase mb-2">Schools</h6>
                                <h3 class="fw-bold text-success mb-0">{{ \App\Models\School::count() }}</h3>
                                <p class="text-muted small mb-0">Active schools</p>
                            </div>
                            <div class="bg-gradient-success rounded-circle p-3 ms-3" style="min-width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-school text-white" style="font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('student-list')
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);">
                    <div class="card-body py-4 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase mb-2">Students</h6>
                                <h3 class="fw-bold text-warning mb-0">{{ \App\Models\User::role('Student')->count() }}</h3>
                                <p class="text-muted small mb-0">Enrolled students</p>
                            </div>
                            <div class="bg-gradient-warning rounded-circle p-3 ms-3" style="min-width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-account-group text-white" style="font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('country-list')
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="{{ route('countries.index') }}" class="text-decoration-none">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);">
                    <div class="card-body py-4 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase mb-2">Countries</h6>
                                <h3 class="fw-bold text-info mb-0">{{ \App\Models\Country::count() }}</h3>
                                <p class="text-muted small mb-0">Total countries</p>
                            </div>
                            <div class="bg-gradient-info rounded-circle p-3 ms-3" style="min-width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-earth text-white" style="font-size: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('state-list')
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="{{ route('states.index') }}" class="text-decoration-none">
                <div class="card dashboard-card h-100 border-0 shadow-sm overflow-hidden" style="transition: all 0.3s ease; transform: translateY(0);">
                    <div class="card-body py-4 px-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase mb-2">States</h6>
                                <h3 class="fw-bold text-danger mb-0">{{ \App\Models\State::count() }}</h3>
                                <p class="text-muted small mb-0">Total states</p>
                            </div>
                            <div class="bg-gradient-danger rounded-circle p-3 ms-3" style="min-width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-map-marker text-white" style="font-size: 20px;"></i>
                            </div>
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
    /* Dashboard Enhancements */
    .dashboard-card {
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(145deg, #ffffff 0%, #f8faff 100%);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        min-height: 180px;
        /* Bigger card */
    }

    .dashboard-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    }

    .dashboard-card .card-body {
        padding: 2rem;
        /* Bigger padding */
    }

    .dashboard-card h3 {
        font-size: 2rem;
    }

    .dashboard-card h6 {
        font-size: 0.95rem;
    }

    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 1rem;
        transition: all 0.4s ease;
    }

    .dashboard-card:hover .card-icon {
        transform: scale(1.2) rotate(10deg);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Loader Animation */
    .page-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 3px solid rgba(78, 115, 223, 0.3);
        border-top: 3px solid #4e73df;
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

    /* Gradient Texts */
    .text-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection

@push('scripts')
<script>
    // Card Hover Effects (smooth)
    document.querySelectorAll('.dashboard-card').forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-10px) scale(1.03)');
        card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0) scale(1)');
        card.addEventListener('touchstart', () => card.style.transform = 'translateY(-10px) scale(1.03)', {
            passive: true
        });
        card.addEventListener('touchend', () => card.style.transform = 'translateY(0) scale(1)', {
            passive: true
        });
    });

    // Loader on Navigation
    document.querySelectorAll('.dashboard-link').forEach(link => {
        link.addEventListener('click', (e) => {
            const loader = document.getElementById('pageLoader');
            loader.style.display = 'flex';
            setTimeout(() => loader.style.display = 'none', 1500); // Hide after 1.5s
        });
    });

    // Optional: Add subtle hover effect on icon inside card
    document.querySelectorAll('.card-icon').forEach(icon => {
        icon.addEventListener('mouseenter', () => {
            icon.style.transform = 'scale(1.2) rotate(10deg)';
        });
        icon.addEventListener('mouseleave', () => {
            icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });
</script>
@endpush