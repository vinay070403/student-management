@extends('layouts.app')
@section('title', 'Classes')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @section('content')
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h3 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-people me-2"></i> Classes List
                    </h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('schools.edit', $school->ulid) }}"
                            class="btn btn-dark px-5 py-3 rounded-3 fw-bold shadow-sm">
                            ← Back
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="d-flex justify-content-end mb-3"></div>
                        <a href="{{ route('schools.classes.create', $school->ulid) }}"
                            class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                            + Add Class
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="classes-table" class="table table-hover align-middle mb-0">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>Class Name</th>
                                    <th>Created At</th>
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

                const classesTable = $('#classes-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('schools.classes.index', $school->ulid) }}",
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
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-end'
                        }
                    ],
                    order: [
                        [1, 'desc']
                    ],
                    responsive: true,
                    lengthChange: true,
                    dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
                });

                $('#classes-table').on('click', '.delete-class', function() {
                    const ulid = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will permanently delete the class and its student grades.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then(result => {
                        if (result.isConfirmed) {
                            axios.delete(
                                `{{ url('admin/schools') }}/{{ $school->ulid }}/classes/${ulid}`, {
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                }).then(res => {
                                classesTable.ajax.reload(null, false);
                                Swal.fire('Deleted!', res.data.message || 'Class deleted.',
                                    'success');
                            }).catch(err => {
                                Swal.fire('Error!', err.response?.data?.message ||
                                    'Failed to delete class.', 'error');
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
