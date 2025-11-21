@extends('layouts.app')

@section('title', 'Countries')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <div class="app-wrapper flex-column flex-row-fluid">
        <div class="p-4 bg-white border-2 rounded-2 mb-5 mb-xl-10" style="border-color:#adb5bd;">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold mb-0 text-dark">
                    <i class="fa-solid fa-earth-africa"></i> Countries
                </h3>

                <div class="d-flex align-items-center gap-2">
                    <button id="kt_refresh_countries" class="btn btn-light btn-sm d-flex align-items-center gap-1">
                        <i class="fas fa-sync-alt"></i>
                    </button>

                    <a href="{{ route('countries.create') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                        <i class="fa-solid fa-circle-plus"></i> Add Country
                    </a>
                </div>
            </div>


            {{-- Toolbar --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div data-kt-country-table-toolbar="base">
                    <span class="fw-semibold">Countries List</span>
                </div>
                <div class="d-none" data-kt-country-table-toolbar="selected">
                    <span class="fw-semibold">
                        <span data-kt-country-table-select="selected_count">0</span> selected
                    </span>
                    <button class="btn btn-danger btn-sm" data-kt-country-table-select="delete_selected"
                        data-url="{{ route('countries.bulkDelete') }}">
                        Delete Selected
                    </button>
                </div>
            </div>

            <div class="p-4 bg-white border rounded-3" style="border-color:#dee2e6;">
                {{-- Search --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="input-group" style="max-width: 350px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="mdi mdi-magnify text-muted"></i>
                        </span>
                        <input type="text" id="customSearchInput" class="form-control border-start-0 ps-0"
                            placeholder="Search countries...">
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="countries-table"
                        data-url="{{ route('countries.index') }}">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                </th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteCountryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        <b>Are you sure you want to delete this country?</b>
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

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/country/countries.js') }}"></script>
@endpush
