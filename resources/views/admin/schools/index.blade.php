@extends('layouts.app')

@section('title', 'Schools')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0 text-dark">Schools</h4>
                <a href="{{ route('schools.create') }}"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-school"></i> + Add School
                </a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-3 table-hover schools-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>NAME</th>
                            <th>STATE</th>
                            <th>ADDRESS</th>
                            <th>ZIPCODE</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                        <tr id="school-row-{{ $school->id }}">
                            <td class="text-center fw-bold">{{ $school->id }}</td>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->state->name ?? 'N/A' }}</td>
                            <td>{{ $school->address ?? 'N/A' }}</td>
                            <td>{{ $school->zipcode ?? 'N/A' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-3">
                                    <a href="{{ route('schools.edit', $school->id) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-3 position-relative"
                                        title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-3 delete-school-btn position-relative"
                                        data-id="{{ $school->id }}" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if ($schools->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No schools found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->


        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    <b>Are you sure you want to delete this school?</b>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteSchoolForm" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Table row hover + border */
    .schools-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease-in-out;
    }

    .schools-table tbody tr:hover {
        background-color: #f9fafb;
        box-shadow: inset 3px 0 0 #2563eb;
    }

    .table thead th {
        border-bottom: 2px solid #e5e7eb;
    }

    /* Modal styling */
    .modal-content {
        border-radius: 14px;
        overflow: hidden;
    }

    /* Delete button hover */
    .btn-outline-danger:hover {
        background-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* Tooltip for action buttons */
    .btn[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: -28px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #111827;
        color: #fff;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0.9;
        pointer-events: none;
    }

    /* Pagination styling */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 8px !important;
    }

    .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let schoolId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmDeleteForm = document.getElementById('deleteSchoolForm');

        // Open modal
        document.querySelectorAll('.delete-school-btn').forEach(button => {
            button.addEventListener('click', function() {
                schoolId = this.dataset.id;
                confirmDeleteForm.action = `/schools/${schoolId}`;
                deleteModal.show();
            });
        });
    });
</script>
@endpush