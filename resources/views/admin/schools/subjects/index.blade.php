@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card shadow-sm border-10">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Subjects</h4>
                    <a href="{{ route('schools.subjects.create', $school) }}" class="btn btn-primary mb-4">
                        + Add Subject
                    </a>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle subjects-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>School</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            <tr>
                                <td class="text-center fw-bold">{{ $subject->id }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->school->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('schools.subjects.edit', [$school->id, $subject->id]) }}" class="btn btn-sm-2 btn-block">
                                            Edit
                                        </a>
                                        <form action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm-2 btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Card polish */
    .card {
        border-radius: 12px;
    }

    /* Table look */
    .subjects-table {
        border-radius: 8px;
        overflow: hidden;
    }

    .subjects-table thead {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .subjects-table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .subjects-table tbody tr:hover {
        background-color: #f1f5ff;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Buttons polish */
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
        font-weight: 500;
        transition: all 0.15s;
    }

    .btn-danger:hover {
        background-color: #c82333 !important;
    }
</style>
@endpush
