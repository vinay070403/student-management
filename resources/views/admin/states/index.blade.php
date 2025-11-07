@extends('layouts.app')

@section('title', 'States')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid">
    <!-- <div class="card border-0 shadow-sm rounded-3"> -->
    <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-semibold mb-1 text-dark" style="font-family: 'Inter', sans-serif">
                    States
                </h3>
                <!-- <p class="text-muted small mb-0">
                        A list of all states available in your system.
                    </p> -->
            </div>
            <a href="{{ route('states.create') }}"
                class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                <i class="mdi mdi-map-marker-plus"></i> Add State
            </a>
        </div>

        <!-- Alert Box -->
        <div id="alert-box" class="alert d-none" role="alert"></div>
        <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
            <!-- Search Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="mdi mdi-magnify text-muted"></i>
                    </span>
                    <input type="text" id="search-state" class="form-control border-start-0 ps-0"
                        placeholder="Search state..." />
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-3 table-hover state-table">
                    <thead class="table-light">
                        <tr>
                            <!-- <th style="width: 60px;">#</th> -->
                            <th>STATE NAME</th>
                            <th>COUNTRY</th>
                            <th class="text-center" style="width: 120px;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                        <tr id="state-row-{{ $state->id }}">
                            <!-- <td class="fw-bold text-secondary">{{ $state->id }}</td> -->
                            <td class="fw-semibold">{{ ucfirst($state->name) }}</td>
                            <td class="text-muted small">{{ $state->country->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('states.edit', $state->id) }}"
                                        class="btn btn-sm custom-edit-btn" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm custom-delete-btn delete-state-btn"
                                        data-id="{{ $state->id }}" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if ($states->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No state found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteStateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    <b>Are you sure you want to delete this state?</b><br>
                    <small>This will remove all related cities or schools.</small>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmStateDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");

    body {
        font-family: "Inter", sans-serif !important;
    }

    .state-table thead th {
        text-transform: uppercase;
        font-weight: 600;
        font-size: 0.85rem;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }

    .state-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease-in-out;
    }

    .state-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ✅ Edit Button */
    .custom-edit-btn {
        border: 1px solid #0d6efd;
        size: 26rem !important;
        color: #0d6efd;
        background-color: #fff;
        padding: 6px 10px !important;
        border-radius: 8px !important;
        transition: all 0.2s ease-in-out;
    }

    .custom-edit-btn:hover {
        background-color: #0d6efd;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ✅ Delete Button */
    .custom-delete-btn {
        border: 1.8px solid #dc3545;
        color: #dc3545;
        background-color: #fff;
        padding: 6px 10px !important;
        border-radius: 8px !important;
        transition: all 0.2s ease-in-out;
    }

    .custom-delete-btn:hover {
        background-color: #dc3545;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ✅ Alert Styling */
    #alert-box {
        border-radius: 10px;
        font-weight: 500;
        padding: 10px 15px;
        margin-bottom: 15px;
    }

    #alert-box.alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    #alert-box.alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .fade-out {
        opacity: 0;
        transition: opacity 0.4s ease-out;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const baseUrl = "{{ url('admin/states') }}"; // Dynamic base URL
        let currentId = null;
        let lastActiveElement = null;

        const modalEl = document.getElementById('deleteStateModal'); // modal ID in your Blade
        const deleteModal = new bootstrap.Modal(modalEl, {
            backdrop: true
        });
        const confirmBtn = document.getElementById('confirmStateDeleteBtn'); // confirm button ID
        const alertBox = document.getElementById('alert-box'); // make sure alert-box exists in Blade

        // Helper: show alert/toast
        function showToast(type, msg) {
            alertBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
            alertBox.textContent = msg;
            alertBox.classList.remove('d-none');
            setTimeout(() => alertBox.classList.add('d-none'), 3500);
        }

        // Open modal when delete button clicked
        document.querySelectorAll('.delete-state-btn').forEach(button => {
            button.addEventListener('click', function() {
                currentId = this.dataset.id;
                lastActiveElement = this;
                deleteModal.show();
            });
        });

        // Reset state when modal closes
        modalEl.addEventListener('hidden.bs.modal', () => {
            if (lastActiveElement) lastActiveElement.focus();
            currentId = null;
        });

        // Confirm delete
        confirmBtn.addEventListener('click', function() {
            if (!currentId) return;
            confirmBtn.disabled = true;

            axios.post(`${baseUrl}/${currentId}`, {
                    _method: 'DELETE' // Laravel method spoofing
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    const row = document.getElementById(`state-row-${currentId}`);
                    if (row) {
                        row.classList.add('fade-out');
                        setTimeout(() => row.remove(), 350);
                    }
                    deleteModal.hide();
                    showToast('success', response.data.message || 'Deleted successfully.');
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    showToast('danger', error.response?.data?.message || 'Failed to delete state.');
                })
                .finally(() => confirmBtn.disabled = false);
        });
        // Live search filter for states
        const searchInput = document.getElementById('search-state');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.state-table tbody tr');

            rows.forEach(row => {
                const stateName = row.querySelector('td')?.textContent.toLowerCase() || '';
                row.style.display = stateName.includes(searchTerm) ? '' : 'none';
            });
        });

    });
</script>
@endpush