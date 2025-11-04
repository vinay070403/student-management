@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-loader" aria-hidden="true" role="status" id="pageLoader" aria-label="Loading" style="display: none;">
    <div class="spinner" aria-hidden="true"></div>
</div>

<div class="container py-4">
    <!-- Dashboard Cards -->
    <div class="row g-4">
        @can('user-list')
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
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
            <a href="{{ route('schools.index') }}" class="text-decoration-none">
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
            <a href="{{ route('countries.index') }}" class="text-decoration-none">
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
            <a href="{{ route('states.index') }}" class="text-decoration-none">
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

    <!-- Chart Section -->
    <!-- <div class="row mt-4">
        <div class="col-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Student Enrollment Trend</h6>
                    <div style="position: relative; height:400px;">
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Monthly New Registrations</h6>
                    <div style="position: relative; height:400px;">
                        <canvas id="registrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> -->




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
    }

    .dashboard-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        background: linear-gradient(145deg, #f0f4ff 0%, #e0ebff 100%);
    }

    .dashboard-card .card-body {
        padding: 2rem;
    }

    .dashboard-card h3 {
        font-size: 2rem;
    }

    .dashboard-card h6 {
        font-size: 0.95rem;
    }

    .card-icon {
        width: 60px;
        height: 60px;
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

    @media (max-width: 576px) {
        .dashboard-card {
            min-height: 150px;
            padding: 1.5rem;
        }

        .card-icon {
            width: 50px;
            height: 50px;
        }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Card Hover Effects
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
    // document.querySelectorAll('.dashboard-link').forEach(link => {
    //     link.addEventListener('click', (e) => {
    //         const loader = document.getElementById('pageLoader');
    //         loader.style.display = 'flex';
    //         setTimeout(() => loader.style.display = 'none', 1500);
    //     });
    // });

    // Icon hover
    document.querySelectorAll('.card-icon').forEach(icon => {
        icon.addEventListener('mouseenter', () => {
            icon.style.transform = 'scale(1.2) rotate(10deg)';
        });
        icon.addEventListener('mouseleave', () => {
            icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // Chart.js - Student Enrollment
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Students',
                data: [2, 10, 18, 6, 5, 22], // Replace with dynamic data
                borderColor: '#1173d4',
                backgroundColor: 'rgba(17, 115, 212, 0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // This prevents infinite height issue
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });


    // Chart.js - Monthly New Registrations
    const regCtx = document.getElementById('registrationChart').getContext('2d');
    const registrationChart = new Chart(regCtx, {
        type: 'bar', // different type than enrollment chart
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Users',
                data: [5, 12, 9, 15, 7, 18], // replace with dynamic data later
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush