@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="font-weight-bold mb-0">Welcome {{ auth()->user()->first_name ?? 'User' }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @can('user-list')
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Users</h4>
                <p class="card-description">Total Users</p>
                <h4>{{ \App\Models\User::count() }}</h4>
            </div>
        </div>
    </div>
    @endcan
    @can('school-list')
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Schools</h4>
                <p class="card-description">Total Schools</p>
                <h4>{{ \App\Models\School::count() }}</h4>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/dashboard.js') }}" onerror="this.src='https://demo.bootstrapdash.com/skydash-free/js/dashboard.js'"></script>
@endpush