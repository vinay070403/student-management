@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,700|Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

<style>
    /* General Setup */
    * {
        transition: .5s;
        box-sizing: border-box;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        background: #f5f7fb;
    }

    .h-100 {
        height: 100vh !important;
    }

    .align-middle {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    .column {
        margin-top: 3rem;
        padding-left: 3rem;
    }

    .column:hover {
        padding-left: 0;
    }

    .column:hover .card .txt {
        margin-left: 1rem;
    }

    .column:hover .card .txt h1,
    .column:hover .card .txt p {
        color: rgba(255, 255, 255, 1);
        opacity: 1;
    }

    .column:hover .card a {
        color: rgba(255, 255, 255, 1);
    }

    .column:hover .card a::after {
        width: 10%;
    }

    /* Card Design */
    .card {
        position: relative;
        min-height: 200px;
        margin: 0;
        padding: 2rem 1.2rem;
        border: none;
        border-radius: 10px;
        color: rgba(255, 255, 255, 1);
        letter-spacing: .05rem;
        box-shadow: 0 0 21px rgba(0, 0, 0, .2);
        overflow: hidden;
        cursor: pointer;
    }

    .card .txt {
        margin-left: -2rem;
        z-index: 1;
    }

    .card .txt h1 {
        font-family: 'Oswald', sans-serif;
        font-size: 1.5rem;
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: .5rem;
    }

    .card .txt p {
        font-size: .8rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card a {
        z-index: 3;
        font-size: .8rem;
        color: rgba(255, 255, 255, .9);
        margin-left: 1rem;
        position: relative;
        bottom: -.5rem;
        text-transform: uppercase;
        text-decoration: none;
    }

    .card a::after {
        content: "";
        display: inline-block;
        height: 0.5em;
        width: 0;
        margin-right: -100%;
        margin-left: 10px;
        border-top: 1px solid rgba(255, 255, 255, 1);
        transition: .5s;
    }

    .card .ico-card {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
    }

    .card i {
        position: absolute;
        right: -40%;
        top: 50%;
        font-size: 10rem;
        line-height: 0;
        opacity: .2;
        color: rgba(255, 255, 255, 1);
        transform: translateY(-50%);
    }

    /* Gradient Backgrounds */
    .gr-1 {
        background: linear-gradient(170deg, #01E4F8 0%, #1D3EDE 100%);
    }

    .gr-2 {
        background: linear-gradient(170deg, #B4EC51 0%, #429321 100%);
    }

    .gr-3 {
        background: linear-gradient(170deg, #C86DD7 0%, #3023AE 100%);
    }

    .gr-4 {
        background: linear-gradient(170deg, #FFB75E 0%, #ED8F03 100%);
    }

    /* Loader */
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
        width: 50px;
        height: 50px;
        border: 3px solid rgba(78, 115, 223, 0.3);
        border-top: 3px solid #4e73df;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endsection


@section('content')

<!-- Loader -->
<div class="page-loader" id="pageLoader">
    <div class="spinner"></div>
</div>

<div class="container h-100">
    <div class="row align-middle">

        @can('user-list')
        <div class="col-md-6 col-lg-3 column">
            <a href="{{ route('admin.users') }}" class="dashboard-link text-decoration-none">
                <div class="card gr-1">
                    <div class="txt">
                        <h1>Users</h1>
                        <p>Total Registered: {{ \App\Models\User::count() }}</p>
                    </div>
                    <a href="#">More</a>
                    <div class="ico-card"><i class="fa fa-users"></i></div>
                </div>
            </a>
        </div>
        @endcan

        @can('school-list')
        <div class="col-md-6 col-lg-3 column">
            <a href="{{ route('schools.index') }}" class="dashboard-link text-decoration-none">
                <div class="card gr-2">
                    <div class="txt">
                        <h1>Schools</h1>
                        <p>Active Schools: {{ \App\Models\School::count() }}</p>
                    </div>
                    <a href="#">More</a>
                    <div class="ico-card"><i class="fa fa-school"></i></div>
                </div>
            </a>
        </div>
        @endcan

        @can('country-list')
        <div class="col-md-6 col-lg-3 column">
            <a href="{{ route('countries.index') }}" class="dashboard-link text-decoration-none">
                <div class="card gr-3">
                    <div class="txt">
                        <h1>Countries</h1>
                        <p>Total Countries: {{ \App\Models\Country::count() }}</p>
                    </div>
                    <a href="#">More</a>
                    <div class="ico-card"><i class="fa fa-globe"></i></div>
                </div>
            </a>
        </div>
        @endcan

        @can('state-list')
        <div class="col-md-6 col-lg-3 column">
            <a href="{{ route('states.index') }}" class="dashboard-link text-decoration-none">
                <div class="card gr-4">
                    <div class="txt">
                        <h1>States</h1>
                        <p>Total States: {{ \App\Models\State::count() }}</p>
                    </div>
                    <a href="#">More</a>
                    <div class="ico-card"><i class="fa fa-map"></i></div>
                </div>
            </a>
        </div>
        @endcan

    </div>
</div>
@endsection


@push('scripts')
<script>
    document.querySelectorAll('.dashboard-link').forEach(link => {
        link.addEventListener('click', () => {
            const loader = document.getElementById('pageLoader');
            loader.style.display = 'flex';
            setTimeout(() => loader.style.display = 'none', 1500);
        });
    });
</script>
@endpush