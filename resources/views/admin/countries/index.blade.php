@extends('layouts.app')

@section('title', 'Countries')

@section('content')
    <div class="app-wrapper flex-column flex-row-fluid">
        <!-- <div class="card border-0 shadow-sm rounded-3"> -->
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-semibold mb-1 text-dark" style="font-family: 'Inter', sans-serif">
                        <i class="fa-solid fa-earth-africa"></i>
                        Countries
                    </h3>
                    <!-- <p class="text-muted small mb-0">
                            A list of all countries available in your system.
                        </p> -->
                </div>
                <a href="{{ route('countries.create') }}"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                    <i class="mdi mdi-plus"></i> Add Country
                </a>
            </div>
            <!-- Alert Box -->
            <div id="alert-box" class="alert d-none" role="alert"></div>

            <div class="p-4 border rounded-3 mb-5" style="border-color: #dee2e6; background-color: #f8f9fa;">

                <!-- Search Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="input-group" style="max-width: 350px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="mdi mdi-magnify text-muted"></i>
                        </span>
                        <input type="text" id="search-country" class="form-control border-start-0 ps-0"
                            placeholder="Search country..." />
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-middle mb-3 table-hover country-table">
                        <thead class="table-light">
                            <tr>
                                <!-- <th style="width: 60px;">#</th> -->
                                <th>COUNTRY NAME</th>
                                <th>CREATED AT</th>
                                <th class="text-center" style="width: 120px;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                                <tr id="country-row-{{ $country->id }}">
                                    <!-- <td class="fw-bold text-secondary">{{ $country->id }}</td> -->
                                    <td class="fw-semibold">{{ ucfirst($country->name) }}</td>
                                    <td class="text-muted small">{{ $country->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('countries.edit', $country->id) }}"
                                                class="btn btn-sm custom-edit-btn" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm custom-delete-btn delete-country-btn"
                                                data-id="{{ $country->id }}" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($countries->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No Country found.</td>
                                </tr>
                            @endif
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
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");

        body {
            font-family: "Inter", sans-serif !important;
        }

        .country-table thead th {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
        }

        .country-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease-in-out;
        }

        .country-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* ✅ Edit Button (Clean Blue) */
        .custom-edit-btn {
            border: 1.8px solid #0d6efd;
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

        /* ✅ Delete Button (Clean Red) */
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

        /* ✅ Fade Out Animation */
        .fade-out {
            opacity: 0;
            transition: opacity 0.4s ease-out;
        }

        #search-country {
            border-radius: 10px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        #search-country:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = "{{ url('admin/countries') }}"; // Dynamic base URL
            let currentId = null;
            let lastActiveElement = null;

            const modalEl = document.getElementById('deleteCountryModal');
            const deleteModal = new bootstrap.Modal(modalEl, {
                backdrop: true
            });
            const confirmBtn = document.getElementById('confirmCountryDeleteBtn');
            const alertBox = document.getElementById('alert-box');

            function showToast(type, msg) {
                alertBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
                alertBox.textContent = msg;
                alertBox.classList.remove('d-none');
                setTimeout(() => alertBox.classList.add('d-none'), 3500);
            }

            // Open modal
            document.querySelectorAll('.delete-country-btn').forEach(btn => {
                btn.addEventListener('click', function() {
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
                        const row = document.getElementById(`country-row-${currentId}`);
                        if (row) {
                            row.classList.add('fade-out');
                            setTimeout(() => row.remove(), 350);
                        }
                        deleteModal.hide();
                        showToast('success', response.data.message || 'Deleted successfully.');
                    })
                    .catch(error => {
                        console.error(error);
                        showToast('danger', error.response?.data?.message || 'Delete failed.');
                    })
                    .finally(() => confirmBtn.disabled = false);
            });
        });
        // Country Search Filter
        const searchInput = document.getElementById('search-country');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.country-table tbody tr');

            rows.forEach(row => {
                const countryName = row.querySelector('td')?.textContent.toLowerCase() || '';
                row.style.display = countryName.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endpush
