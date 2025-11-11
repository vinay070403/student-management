@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="app-wrapper flex-column flex-row-fluid">
        <div class="p-4 bg-white border-2 rounded-2 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-semibold mb-1 text-dark" style="font-family: 'Inter', sans-serif">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Students
                    </h3>
                </div>
                <a href="{{ route('students.create') }}"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                    <i class="mdi mdi-account-plus"></i> Add Student
                </a>
            </div>

            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
                <!-- Search Bar -->
                <div class="col-md-6 mb-3">
                    <input type="text" id="studentSearch" class="form-control form-control-lg"
                        placeholder="Search by name or email...">
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-middle mb-3 table-hover student-table">
                        <thead class="table-light">
                            <tr>
                                <th>USER</th>
                                <th>CREATED AT</th>
                                <th class="text-center" style="width: 120px;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            @foreach ($students as $student)
                                <tr id="student-row-{{ $student->id }}">
                                    <td class="d-flex align-items-center gap-3">
                                        <img src="{{ $student->avatar ? asset('storage/' . $student->avatar) : asset('assets/images/default-avatar1.jpg') }}"
                                            alt="{{ $student->first_name }}" class="rounded-circle shadow-sm" width="42"
                                            height="42" />
                                        <div>
                                            <div class="fw-semibold">{{ $student->first_name }} {{ $student->last_name }}
                                            </div>
                                            <div class="fw-semibold text-gray">{{ $student->email }}</div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $student->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-sm custom-edit-btn" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm custom-delete-btn delete-student-btn"
                                                data-id="{{ $student->id }}"
                                                data-name="{{ $student->first_name }} {{ $student->last_name }}"
                                                title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($students->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No students found.</td>
                                </tr>
                            @endif
                        </tbody>
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
@endsection

@push('styles')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");

        body {
            font-family: "Inter", sans-serif !important;
        }

        .student-table thead th {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
        }

        .student-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease-in-out;
        }

        .student-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .custom-edit-btn {
            border: 1px solid #0d6efd;
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

        .fade-out {
            opacity: 0;
            transition: opacity 0.4s ease-out;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // SEARCH FILTER
            const searchInput = document.getElementById('studentSearch');
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                document.querySelectorAll('#studentTableBody tr').forEach(row => {
                    const nameEl = row.querySelector('td div.fw-semibold');
                    const emailEl = row.querySelector('td div.fw-semibold.text-gray');

                    const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                    const email = emailEl ? emailEl.textContent.toLowerCase() : '';

                    row.style.display = name.includes(filter) || email.includes(filter) ? '' :
                        'none';
                });
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

            document.querySelectorAll('.delete-student-btn').forEach(button => {
                button.addEventListener('click', function() {
                    currentId = this.dataset.id;
                    studentName = this.dataset.name;
                    studentNameEl.textContent = studentName;
                    lastActiveElement = this;
                    deleteModal.show();
                });
            });

            modalEl.addEventListener('hidden.bs.modal', () => {
                if (lastActiveElement) lastActiveElement.focus();
                currentId = null;
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
                    })
                    .then(response => {
                        const row = document.getElementById(`student-row-${currentId}`);
                        if (row) {
                            row.classList.add('fade-out');
                            setTimeout(() => row.remove(), 350);
                        }
                        deleteModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.data.message || `${studentName} has been deleted.`,
                            timer: 2500,
                            showConfirmButton: false
                        });
                    })
                    .catch(error => {
                        console.error('Delete error:', error);
                        deleteModal.hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.response?.data?.message || 'Failed to delete student.',
                        });
                    })
                    .finally(() => confirmBtn.disabled = false);
            });

        });
    </script>
@endpush
