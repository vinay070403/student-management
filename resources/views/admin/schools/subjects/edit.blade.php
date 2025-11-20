@extends('layouts.app')
@section('title', 'Edit Subject')

@section('content')
    <div class="container-fluid">
        <div class=" border-2 rounded-3 p-4 mb-5 bg-white shadow-sm">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h3 class="fw-semibold text-dark mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Subject
                </h3>
                <a href="{{ route('schools.subjects.index', $school->ulid) }}"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    ← Back
                </a>
            </div>

            <!-- Main Panel -->

            <form action="{{ route('schools.subjects.update', [$school->ulid, $subject->ulid]) }}" method="POST"
                class="row g-3">
                @csrf
                @method('PUT')
                <!-- Subject Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                        value="{{ old('name', $subject->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Update Button -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-dark px-4 py-3 rounded-3 btn-lg d-flex align-items-center gap-2">
                        <i class="bi bi-save"></i> Update Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
