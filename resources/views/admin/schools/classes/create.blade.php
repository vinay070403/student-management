@extends('layouts.app')
@section('title', 'Add Class')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-plus-lg me-2"></i>Add New Class</h4>
                <a href="{{ route('schools.classes.index', $school->id) }}" class="btn btn-secondary d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('schools.classes.store', $school) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Class Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter class name" required>
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