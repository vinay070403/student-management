@extends('layouts.app')

@section('title', 'Edit State')

@section('content')
<div class="row">
    <div class="app-wrapper flex-column flex-row-fluid">
        <!-- <div class="card shadow-sm mb-6"> -->
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="card-title mb-0">Edit State</h2>
                <a href="{{ route('states.index') }}" class="btn btn-dark">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
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

                <form action="{{ route('states.update', $state->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">State Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" required value="{{ $state->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id" class="form-label">Country</label>
                                <select name="country_id" class="form-control form-control-lg" required>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $state->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Update & Delete Buttons side by side -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-dark px-3 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                            Save Changes
                        </button>

                        <!-- Delete Button triggers dialog -->
                        <!-- <button type="button" class="btn btn-danger px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg"
                            onclick="document.getElementById('delete-state-dialog-{{ $state->id }}').showModal()">
                            Delete State
                        </button> -->
                    </div>
                </form>

                <!-- Delete Confirmation Dialog -->
                <dialog id="delete-state-dialog-{{ $state->id }}" style="border:none; border-radius:12px; padding:25px; max-width:400px; width:90%;">
                    <form action="{{ route('states.destroy', $state->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                            <i class="mdi mdi-alert-circle-outline" style="font-size:28px; color:#f44336;"></i>
                            <h3 style="margin:0; font-size:20px;">Confirm Deletion</h3>
                        </div>
                        <p style="font-size:16px;">Are you sure you want to delete this state? This action cannot be undone.</p>
                        <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">
                            <button type="submit" class="btn btn-danger px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg">Yes, Delete</button>
                            <button type="button" class="btn btn-secondary px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg"
                                onclick="document.getElementById('delete-state-dialog-{{ $state->id }}').close()">Cancel</button>
                        </div>
                    </form>
                </dialog>

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
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .btn-primary:hover,
    .btn-dark:hover {
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

    .btn:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    dialog::backdrop {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
@endpush