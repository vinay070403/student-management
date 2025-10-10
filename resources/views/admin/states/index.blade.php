@extends('layouts.app')

@section('title', 'States')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0 text-dark">States</h4>
                <a href="{{ route('states.create') }}" class="btn btn-dark px-3 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-map-marker-plus"></i> Add State
                </a>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-3 table-hover state-table">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>STATE</th>
                            <th>COUNTRY</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                        <tr id="state-row-{{ $state->id }}">
                            <td class="fw-bold">{{ $state->id }}</td>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->country->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-3">
                                    <a href="{{ route('states.edit', $state->id) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-3 position-relative" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-3 delete-state-btn position-relative"
                                        data-id="{{ $state->id }}" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
                    <b>Are you sure you want to delete this state?</b>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Table & card styling */
    .state-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease-in-out;
    }

    .state-table tbody tr:hover {
        background-color: #f9fafb;
        box-shadow: inset 3px 0 0 #2563eb;
    }

    .table thead th {
        border-bottom: 2px solid #e5e7eb;
    }

    /* Modal polish */
    .modal-content {
        border-radius: 14px;
        overflow: hidden;
    }

    /* Button hover effects */
    .btn-outline-danger:hover {
        background-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* Tooltip styling for action buttons */
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
        let stateId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Open modal
        document.querySelectorAll('.delete-state-btn').forEach(button => {
            button.addEventListener('click', function() {
                stateId = this.dataset.id;
                deleteModal.show();
            });
        });

        // Handle AJAX delete
        confirmDeleteBtn.addEventListener('click', function() {
            if (!stateId) return;

            fetch(`/states/${stateId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    deleteModal.hide();
                    document.getElementById(`state-row-${stateId}`).remove();
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to delete state.');
                });
        });
    });
</script>
@endpush