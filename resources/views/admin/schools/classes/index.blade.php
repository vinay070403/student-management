@extends('layouts.app')
@section('title', 'Classes')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid">
    <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h3 class="fw-semibold text-dark mb-0">
                <i class="bi bi-people me-2"></i> Classes List
            </h3>
            <div class="d-flex gap-2">
                <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-dark px-5 py-3 rounded-3 fw-bold shadow-sm">
                    ← Back
                </a>
                <!-- <a href="{{ route('schools.classes.create', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                + Add Class
            </a> -->
            </div>
        </div>

        <!-- Main bordered panel -->

        <div class="card-body p-4">
            @include('admin.schools.classes.partials.table')
        </div>

    </div>

</div>
@endsection