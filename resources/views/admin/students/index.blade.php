@extends('layouts.app')

@section('title', 'Students')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @section('content')
        <div class="app-wrapper flex-column flex-row-fluid">
            <div class="p-4 bg-white border-2 rounded-2 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-semibold mb-1 text-dark" style="font-family: 'Inter', sans-serif">
                            <i class="fa-solid fa-graduation-cap"></i> Students
                        </h3>
                    </div>
                    <a href="{{ route('students.create') }}"
                        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                        <i class="mdi mdi-account-plus"></i> Add Student
                    </a>
                </div>
                <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">

                    {{-- Search --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="input-group" style="max-width: 350px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" id="studentSearch" class="form-control border-start-0 ps-0"
                                placeholder="Search students...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-3 table-hover" id="studentsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>USER</th>
                                    <th style="width: 700px">STATUS</th>
                                    <th style="width: 400px">CREATED AT</th>
                                    <th class="text-center" style="width: 120px;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-4">
                            <b>Are you sure you want to delete <span id="studentName" class="text-danger"></span>?</b><br>
                            <small>This action cannot be undone.</small>
                        </p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fa-solid fa-xmark"></i></button>
                        <button id="confirmStudentDeleteBtn" type="button" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const table = $('#studentsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('students.index') }}",
                            type: 'GET',
                            data: function(d) {
                                d.search = $('#studentSearch').val();
                            }
                        },
                        columns: [{
                                data: 'student',
                                name: 'student',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        searching: false,
                        responsive: true,
                        paging: true,
                        lengthChange: true,
                        pageLength: 10,
                        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lp>',
                        createdRow: function(row, data, dataIndex) {
                            $('td', row).eq(0).addClass('fw-bold text-dark');
                            $('td', row).eq(1).addClass('fw-bold text-muted');
                        }

                    });

                    // Debounced search
                    const debounce = (fn, delay) => {
                        let timer;
                        return function(...args) {
                            clearTimeout(timer);
                            timer = setTimeout(() => fn.apply(this, args), delay);
                        };
                    };

                    $('#studentSearch').on('keyup', function() {
                        table.draw();
                    });

                    // DELETE FUNCTIONALITY
                    const baseUrl = "{{ url('admin/students') }}";
                    let currentId = null;
                    let studentName = '';
                    let lastActiveElement = null;
                    const modalEl = document.getElementById('deleteStudentModal');
                    const deleteModal = new bootstrap.Modal(modalEl, {
                        backdrop: true
                    });
                    const confirmBtn = document.getElementById('confirmStudentDeleteBtn');
                    const studentNameEl = document.getElementById('studentName');

                    $('#studentsTable').on('click', '.delete-student', function() {
                        currentId = $(this).data('id');
                        studentName = $(this).data('name');
                        studentNameEl.textContent = studentName;
                        lastActiveElement = this;
                        deleteModal.show();
                    });

                    confirmBtn.addEventListener('click', function() {
                        if (!currentId) return;
                        confirmBtn.disabled = true;

                        axios.post(`${baseUrl}/${currentId}`, {
                            _method: 'DELETE'
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            table.ajax.reload(null, false);
                            deleteModal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }).catch(error => {
                            console.error(error);
                            deleteModal.hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.response?.data?.message || 'Failed to delete student.'
                            });
                        }).finally(() => confirmBtn.disabled = false);
                    });
                });
            </script>
        @endpush
    @endsection
