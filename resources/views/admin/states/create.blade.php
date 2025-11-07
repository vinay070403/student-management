@extends('layouts.app')

@section('title', 'Add State')

@section('content')
<div class="row">
    <div class="app-wrapper flex-column flex-row-fluid">
        <!-- <div class="card shadow-sm mb-4"> -->
        <div class=" p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <div class=" d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Add New State</h4>
                <a href="{{ route('states.index') }}"
                    class="btn btn-dark">
                    <i class="mdi mdi-arrow-left me-1"></i> Back
                </a>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">

                <form action="{{ route('states.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">State Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter state name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id" class="form-label">Country</label>
                                <select name="country_id" class="form-control form-control-lg" required>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-dark px-4 py-3 d-inline-flex btn-lg">Add State</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Smooth input and label styling */
    .form-label {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .form-control-lg {
        height: 48px;
        font-size: 1rem;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }

    /* Buttons styling */
    .btn-dark {
        font-size: 1rem;
        padding: 10px 24px;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }

    .btn-dark:hover {
        transform: scale(1.05);
    }

    .btn-dark:active {
        transform: scale(0.97);
    }

    .btn.text-dark:hover {
        background-color: #e6e6e6;
        color: #111;
        border: 1px solid #ccc;
    }

    .card {
        border-radius: 12px;
        background-color: #fafafa;
    }
</style>
@endpush