@extends('layouts.app')
@section('title', 'Add Class')
@section('content')
    <div class="row">
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-plus-lg me-2"></i>Add New Class</h4>
                    {{-- <a href="{{ route('schools.classes.index', $school->id) }}" class="btn btn-dark px-5 py-3 mb-2 rounded-3 fw-bold shadow-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a> --}}
                    <a href="{{ route('schools.edit', $school->id) }}"
                        class="btn btn-dark px-5 py-3 mb-3 rounded-3 fw-bold shadow-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>

                </div>

                <div class="card-body p-4">
                    <form action="{{ route('schools.classes.store', $school) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Class Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                    placeholder="Enter class name" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-dark btn-lg d-flex align-items-center gap-2">
                                <i class="bi bi-save"></i> Add Class
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
