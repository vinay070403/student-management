@extends('layouts.app')
@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush


@section('content')
    <div class="app-wrapper flex-column flex-row-fluid">
        <div class="p-4 bg-white border-2 rounded-2 mb-5 mb-xl-10" style="border-color: #adb5bd;">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold mb-0 text-dark">
                    <i class="fa-solid fa-user-group"></i> Users
                </h3>
                <button id="bulkActionBtn"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                    <i class="fa-solid fa-user-plus"></i> Add User
                </button>
            </div>

            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">

                {{-- Search --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="input-group" style="max-width: 350px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="mdi mdi-magnify text-muted"></i>
                        </span>
                        <input type="text" id="customSearchInput" class="form-control border-start-0 ps-0"
                            placeholder="Search users...">
                    </div>
                </div>

                {{-- Users Table Partial --}}
                <div id="usersTableContainer">
                    @include('admin.users.partials.users_table')
                </div>

            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4"><b>Are you sure you want to delete this user?</b></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let userId = null;
                const deleteModal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
                const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
                const bulkActionBtn = document.getElementById("bulkActionBtn");
                const modalBody = document.querySelector("#deleteConfirmModal .modal-body p b");

                // debounce helper
                function debounce(fn, delay) {
                    let timer = null;
                    return function() {
                        const context = this,
                            args = arguments;
                        clearTimeout(timer);
                        timer = setTimeout(function() {
                            fn.apply(context, args);
                        }, delay);
                    };
                }

                // Initialize DataTable
                const table = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('users.index') }}",
                        data: function(d) {
                            d.custom_search = $('#customSearchInput').val();
                        }
                    },
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,

                        },
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'text-center'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            className: 'text-center'
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
                    searching: false,
                    paging: true,
                    lengthChange: true,
                    dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
                    createdRow: function(row, data, dataIndex) {
                        $('td', row).eq(0).addClass('fw-bold text-dark');
                        $('td', row).eq(1).addClass('fw-bold text-muted');
                    },
                    drawCallback: function() {
                        bindActions();
                    }
                });

                // Use debounce to reduce requests while typing
                $('#customSearchInput').on('keyup', debounce(function() {
                    table.ajax.reload();
                }, 300));

                // Update bulk button based on selection
                function updateBulkButton() {
                    const anyChecked = $('.select-user:checked').length > 0;
                    if (anyChecked) {
                        bulkActionBtn.innerHTML = '<i class="fa-solid fa-trash"></i> Delete Selected';
                        bulkActionBtn.classList.remove("btn-dark");
                        bulkActionBtn.classList.add("btn-danger");
                    } else {
                        bulkActionBtn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Add User';
                        bulkActionBtn.classList.remove("btn-danger");
                        bulkActionBtn.classList.add("btn-dark");
                    }
                }

                // Bind actions after each draw
                function bindActions() {
                    // Delete single user
                    $('.delete-user-btn').off('click').on('click', function() {
                        userId = $(this).data('id');
                        modalBody.textContent = "Are you sure you want to delete this user?";
                        deleteModal.show();
                    });

                    // Checkboxes
                    $('.select-user, #selectAllUsers').off('change').on('change', function() {
                        if (this.id === 'selectAllUsers') {
                            $('.select-user').prop('checked', this.checked);
                        }
                        updateBulkButton();
                    });

                    // Bulk button click
                    $('#bulkActionBtn').off('click').on('click', function() {
                        const selectedIds = $('.select-user:checked').map(function() {
                            return $(this).data('id');
                        }).get();

                        if (selectedIds.length) {
                            userId = null;
                            modalBody.textContent = "Are you sure you want to delete selected users?";
                            deleteModal.show();
                        } else {
                            window.location.href = "{{ route('users.create') }}";
                        }
                    });
                }

                // Confirm delete (single / bulk)
                confirmDeleteBtn.addEventListener("click", async function() {
                    const idsToDelete = userId ? [userId] : $('.select-user:checked').map(function() {
                        return $(this).data('id');
                    }).get();

                    if (!idsToDelete.length) return;

                    try {
                        const url = userId ? `/admin/users/${userId}` : `/admin/users/bulk-delete`;
                        const method = userId ? 'DELETE' : 'POST';
                        const res = await fetch(url, {
                            method: method,
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(userId ? {} : {
                                ids: idsToDelete
                            })
                        });

                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            throw new Error(data.message || 'Failed to delete');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: userId ? 'User deleted successfully.' :
                                'Selected users deleted successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        deleteModal.hide();
                        table.ajax.reload(null, false);
                        userId = null;
                        updateBulkButton();
                    } catch (err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: err.message || 'Something went wrong.'
                        });
                    }
                });

                // Status toggle
                $(document).on('change', '.statusToggle', function() {
                    let checkbox = $(this);
                    let ulid = checkbox.data('id');
                    let newStatus = checkbox.is(':checked') ? 'Active' : 'Inactive';

                    if (newStatus === 'Inactive') {
                        Swal.fire({
                            title: 'Deactivate user?',
                            text: 'User will be marked inactive!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, deactivate'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateStatus(ulid, newStatus, checkbox);
                            } else {
                                checkbox.prop('checked', true); // revert toggle
                            }
                        });
                    } else {
                        updateStatus(ulid, newStatus, checkbox);
                    }
                });

                function updateStatus(ulid, status, checkbox) {
                    $.ajax({
                        url: '/admin/users/change-status/' + ulid,
                        type: 'POST',
                        data: {
                            status: status,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            Swal.fire('Success', res.message, 'success');
                            // Optional: refresh DataTable row
                        },
                        error: function(err) {
                            Swal.fire('Error', err.responseJSON?.message || 'Something went wrong',
                                'error');
                            // revert toggle on error
                            checkbox.prop('checked', status === 'Inactive' ? true : false);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
