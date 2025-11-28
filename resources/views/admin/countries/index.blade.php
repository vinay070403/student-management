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


@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/js/country/index.js') }}"></script>
@endpush
