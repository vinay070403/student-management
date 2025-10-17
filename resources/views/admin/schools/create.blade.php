@extends('layouts.app')
@section('title', 'Add School')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <!-- Header with Back Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Add New School</h4>
                    <a href="{{ route('schools.index') }}"
                        class="btn btn-light border px-3 py-3 d-flex align-items-center gap-2 rounded-3">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </a>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('schools.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">School Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_id" class="form-label">State</label>
                                <select name="state_id" class="form-control form-control-lg" required>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zipcode" class="form-label">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control form-control-lg">
                            </div>
                        </div> -->
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-dark btn-lg px-3 py-3 rounded-3">
                            Add School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Card styling */
    .card {
        border-radius: 20px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2.5rem !important;
    }

    /* Labels and inputs larger */
    .form-label {
        font-size: 1.2rem;
        font-weight: 500;
    }

    .form-control-lg {
        font-size: 1.1rem;
        height: 50px;
        border-radius: 10px;
        padding: 0.6rem 0.75rem;
    }

    /* Buttons */
    .btn-lg {
        font-size: 1.15rem;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
    }

    .btn-lg:hover {
        transform: scale(1.05);
        transition: all 0.2s ease-in-out;
    }

    .btn-lg:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* Back button styling */
    .btn-light {
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
    }

    .btn-light:hover {
        background-color: #f0f0f0;
        transform: scale(1.03);
    }
</style>
@endpush