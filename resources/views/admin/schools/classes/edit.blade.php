@extends('layouts.app')
@section('title', 'Edit Class')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h3 class="fw-semibold text-dark mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Class
        </h3>
        <a href="{{ route('schools.classes.index', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
            ← Back
        </a>
    </div>

    <!-- Main Bordered Panel -->
    <div class="border border-2 rounded-3 p-4 mb-5 mb-xl-10 bg-white shadow-sm">

        <form action="{{ route('schools.classes.update', [$school->id, $class->id]) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="name" class="form-label">Class Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $class->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-dark px-4 py-3 rounded-3 btn-lg d-flex align-items-center gap-2">
                    <i class="bi bi-save"></i> Update Class
                </button>
            </div>
        </form>

    </div>
</div>
@endsection