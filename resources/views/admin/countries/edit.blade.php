@extends('layouts.app')

@section('title', 'Edit Country')

@section('content')
<div class="row">
    <div class="app-wrapper flex-column flex-row-fluid">
        <!-- <div class="card shadow-sm mb-4"> -->
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Edit Country</h4>
                <a href="{{ route('countries.index') }}" class="btn btn-dark btn-sm-2">
                    <i class="mdi mdi-arrow-left sm-2"></i> Back
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

            <form action="{{ route('countries.update', $country->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Country Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" required value="{{ $country->name }}">
                        </div>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-dark px-3 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">Save Changes</button>
                    <form action="{{ route('countries.update', $country->id) }}" method="POST" style="margin:0;">
                        <!-- Delete Button triggers dialog -->
                        <!-- <button type="button" class="btn btn-danger  px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg" onclick="document.getElementById('delete-country-dialog-{{ $country->id }}').showModal()">
                                Delete Country
                            </button> -->
                    </form>
                    <!-- Delete Confirmation Dialog -->
                    <dialog id="delete-country-dialog-{{ $country->id }}" style="border:none; border-radius:12px; padding:25px; max-width:400px; width:90%;">
                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                                <i class="mdi mdi-alert-circle-outline" style="font-size:28px; color:#f44336;"></i>
                                <h3 style="margin:0; font-size:20px;">Confirm Deletion</h3>
                            </div>
                            <p style="font-size:16px;">Are you sure you want to delete this country? This action cannot be undone.</p>
                            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">

                                <button type="submit" class="btn btn-danger px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg">Yes, Delete</button>
                                <button type="button" class="btn btn-secondary px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg" onclick="document.getElementById('delete-country-dialog-{{ $country->id }}').close()">Cancel</button>
                            </div>
                        </form>
                    </dialog>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
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
    .btn-gray {
        background-color: #e6e6e6;
        color: #111;
        border: 1px solid #ccc;
    }

    .btn-gray:hover {
        background-color: #ffe6e6;
        color: #b30000;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #ff4d4f;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    dialog::backdrop {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
@endpush