@extends('layouts.app')

@section('title', 'Subjects')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
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
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('schools.subjects.create', $school->ulid) }}"
                                class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                                + Add Subject
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="subjects-table" class="table table-hover align-middle mb-0">
                                <thead class="table-light fw-bold">
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Created At</th>`
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
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
                                data: 'created_at',
                                name: 'created_at',
                                render: data => data ? new Date(data).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                }) : '-'
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
                        lengthChange: true,
                        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
                    });

                    $('#subjects-table').on('click', '.delete-subject', function() {
                        const ulid = $(this).data('id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will permanently delete the subject.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then(result => {
                            if (result.isConfirmed) {
                                axios.delete(
                                    `{{ url('admin/schools') }}/{{ $school->ulid }}/subjects/${ulid}`, {
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    }).then(res => {
                                    subjectsTable.ajax.reload(null, false);
                                    Swal.fire('Deleted!', res.data.message || 'Subject deleted.',
                                        'success');
                                }).catch(err => {
                                    Swal.fire('Error!', err.response?.data?.message ||
                                        'Failed to delete subject.', 'error');
                                });
                            }
                        });
                    });
                });
            </script>
        @endpush
