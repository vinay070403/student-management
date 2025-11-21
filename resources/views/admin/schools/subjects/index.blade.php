@extends('layouts.app')

@section('title', 'Subjects')

@push('styles')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-book me-2"></i>Subjects</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('schools.edit', $school->ulid) }}"
                                class="btn btn-dark px-5 py-3 rounded-3 fw-bold shadow-sm ">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <!-- <a href="{{ route('schools.subjects.create', $school) }}" class="btn btn-dark d-flex align-items-center gap-2 rounded-3 btn-lg">
                                                                                                            <i class="bi bi-plus-lg"></i> Add Subject   btn btn-secondary d-flex align-items-center gap-2 rounded-3 btn-lg
                                                                                                        </a> -->
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body p-4">
                            @include('admin.schools.subjects.partials.table')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const subjectsTable = $('#subjects-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('schools.subjects.index', $school->ulid) }}",
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-end'
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ],
                    responsive: true,
                    pageLength: 10,
                });

                // Optional: handle delete via AJAX (instead of form submit)
                $('#subjects-table').on('click', '.btn-danger', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the subject permanently.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(form.attr('action'), form.serialize())
                                .then(res => {
                                    subjectsTable.ajax.reload(null, false);
                                    Swal.fire('Deleted!', res.data.message || 'Subject deleted.',
                                        'success');
                                })
                                .catch(err => {
                                    Swal.fire('Error!', err.response?.data?.message ||
                                        'Failed to delete.', 'error');
                                });
                        }
                    });
                });
            });
        </script>
