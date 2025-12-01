@extends('layouts.app')

@section('title', 'States')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @section('content')
        <div class="app-wrapper flex-column flex-row-fluid">

            <div class="p-4 bg-white border-2 rounded-2 mb-5" style="border-color:#adb5bd;">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-semibold mb-0 text-dark" style="font-family: 'Inter', sans-serif">
                        <i class="fa-solid fa-location-dot"></i> States
                    </h3>

                    <a href="{{ route('states.create') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                        <i class="mdi mdi-map-marker-plus"></i> Add State
                    </a>
                </div>

                {{-- White Box --}}
                <div class="p-4 bg-white border rounded-3" style="border-color:#dee2e6;">

                    {{-- Search --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="input-group" style="max-width: 350px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" id="custom-search" class="form-control border-start-0 ps-0"
                                placeholder="Search state...">
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table id="states-table" class="table align-middle table-hover yajra-custom-table">
                            <thead class="table-light">
                                <tr>
                                    <th>STATE NAME</th>
                                    <th>COUNTRY</th>
                                    <th class="text-end" style="width: 140px;">ACTIONS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script src="{{ asset('assets/js/state/index.js') }}"></script>
        @endpush
    @endsection
