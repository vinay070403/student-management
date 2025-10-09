@extends('layouts.app')

@section('title', 'Countries')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0 text-dark">Countries</h4>
                <a href="{{ route('countries.create') }}"
                    class="btn btn-dark px-4 py-2 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-plus"></i> Add Country
                </a>
            </div>

            <!-- Alert Box -->
            <div id="alert-box" class="alert d-none" role="alert"></div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-3 table-hover country-table">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>COUNTRY NAME</th>
                            <th>CREATED AT</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                        <tr id="country-row-{{ $country->id }}">
                            <td class="fw-bold">{{ $country->id }}</td>
                            <td>{{ ucfirst($country->name) }}</td>
                            <td>{{ $country->created_at->format('d M Y, h:i A') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-3">
                                    <a href="{{ route('countries.edit', $country->id) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-3 position-relative"
                                        title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-3 delete-country-btn position-relative"
                                        data-id="{{ $country->id }}" title="Delete">
                                        <i class="mdi mdi-delete"></i>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCountryModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    <b>Are you sure you want to delete this country?</b><br>
                    <small>This will also remove all related states and schools.</small>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmCountryDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Smooth fade out on delete */
    .fade-out {
        opacity: 0;
        transition: opacity 0.4s ease-out;
    }

    .btn-outline-danger:hover {
        background-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* Table hover */
    .country-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease-in-out;
    }

    .country-table tbody tr:hover {
        background-color: #f9fafb;
        box-shadow: inset 3px 0 0 #2563eb;
    }

    /* Alert styles */
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const baseUrl = "{{ url('admin/countries') }}"; // ensures correct prefix
        let currentId = null;
        let lastActiveElement = null;

        // Bootstrap modal element & buttons
        const modalEl = document.getElementById('deleteCountryModal');
        const deleteModal = new bootstrap.Modal(modalEl, {
            backdrop: true,
            keyboard: true
        });
        const confirmBtn = document.getElementById('confirmCountryDeleteBtn');
        const alertBox = document.getElementById('alert-box'); // optional alert box you may have

        // Helper: show alerts (if you have an alert element), otherwise falls back to alert()
        function showToast(type, msg) {
            if (alertBox) {
                alertBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
                alertBox.textContent = msg;
                alertBox.classList.remove('d-none');
                setTimeout(() => alertBox.classList.add('d-none'), 3500);
            } else {
                // fallback
                if (type === 'success') console.log(msg);
                else console.error(msg);
            }
        }

        // Open modal — capture the triggering element so we can restore focus later
        document.querySelectorAll('.delete-country-btn').forEach(button => {
            button.addEventListener('click', function() {
                currentId = this.dataset.id;
                lastActiveElement = this; // save trigger
                deleteModal.show();
            });
        });

        // Restore focus when modal fully hidden (fixes aria-hidden/focus issue)
        modalEl.addEventListener('hidden.bs.modal', () => {
            if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
                lastActiveElement.focus();
            }
            currentId = null;
        });

        // Also move focus into modal when shown (a11y nicety)
        modalEl.addEventListener('shown.bs.modal', () => {
            // try to focus the modal's close button if present
            const closeBtn = modalEl.querySelector('.btn-close');
            if (closeBtn) closeBtn.focus();
        });

        // Confirm delete
        confirmBtn.addEventListener('click', function() {
            if (!currentId) return;

            confirmBtn.disabled = true; // prevent double clicks
            const url = `${baseUrl}/${currentId}`;

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    confirmBtn.disabled = false;

                    // quick status-based handling
                    if (res.status === 404) {
                        throw new Error('Not found (404). Check the request URL or route.');
                    }
                    if (res.status === 405) {
                        throw new Error('Method Not Allowed (405). Route may not accept DELETE.');
                    }
                    if (res.status >= 500) {
                        // try to read server message, but keep a generic fallback
                        let txt = 'Server error';
                        try {
                            const j = await res.json();
                            if (j && j.message) txt = j.message;
                        } catch (e) {}
                        throw new Error('Server error: ' + txt);
                    }

                    // ok parse json
                    return res.json();
                })
                .then(data => {
                    if (data && data.success) {
                        // nicely remove row with fade
                        const row = document.getElementById(`country-row-${currentId}`);
                        if (row) {
                            row.classList.add('fade-out');
                            setTimeout(() => row.remove(), 350);
                        }
                        deleteModal.hide();
                        showToast('success', data.message || 'Deleted successfully.');
                    } else {
                        // server responded but success=false
                        const msg = (data && data.message) ? data.message : 'Could not delete.';
                        showToast('danger', msg);
                    }
                })
                .catch(err => {
                    // network or handled error
                    console.error('Delete error:', err);
                    showToast('danger', err.message || 'Failed to delete country.');
                });
        });
    });
</script>
@endpush