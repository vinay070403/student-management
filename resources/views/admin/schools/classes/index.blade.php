@extends('layouts.app')
@section('title', 'Classes')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h3 class="fw-semibold text-dark mb-0">
            <i class="bi bi-people me-2"></i> Classes List
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-secondary px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                ← Back
            </a>
            <a href="{{ route('schools.classes.create', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                + Add Class
            </a>
        </div>
    </div>

    <!-- Main bordered panel -->
    <div class="border border-2 rounded-3 p-4 mb-5 mb-xl-10 bg-white shadow-sm">
        <div class="card-body p-4">
            @include('admin.schools.classes.partials.table')
        </div>

    </div>

</div>
@endsection