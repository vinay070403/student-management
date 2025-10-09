@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card shadow-sm border-10">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Students</h4>
                    <a href="{{ route('students.create') }}" class="btn btn-dark px-4 py-2 d-flex align-items-center gap-2 rounded-3">
                        <i class="mdi mdi-account-plus"></i> + Add Student
                    </a>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle students-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td class="text-center fw-bold">{{ $student->id }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </a>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-student-id="{{ $student->id }}"
                                            data-student-name="{{ $student->first_name }} {{ $student->last_name }}">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-0 fs-5">Are you sure you want to delete <strong id="studentName"></strong>?</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 rounded-3">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
    }

    .students-table {
        border-radius: 8px;
        overflow: hidden;
    }

    .students-table thead {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .students-table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .students-table tbody tr:hover {
        background-color: #f1f5ff;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
        font-weight: 500;
        transition: all 0.15s;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const studentId = button.getAttribute('data-student-id');
        const studentName = button.getAttribute('data-student-name');

        const form = document.getElementById('deleteForm');
        form.action = `/admin/students/${studentId}`;

        document.getElementById('studentName').textContent = studentName;
    });
</script>
@endpush