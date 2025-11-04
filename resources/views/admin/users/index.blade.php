@extends('layouts.app')
@section('title', 'Users')
@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3
                        class="fw-semibold mb-1 text-dark"
                        style="font-family: 'Inter', sans-serif">
                        Users
                    </h3>
                    <!-- <p class="text-muted small mb-0">
                        A list of all users in your account, including their
                        name, role, and creation date.
                    </p> -->
                </div>
                <button
                    id="bulkActionBtn"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                    <i class="mdi mdi-plus"></i> Add User
                </button>
            </div>

            <!-- Table -->
            <div id="usersTableContainer">
                @include('admin.users.partials.users_table')
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div
    class="modal fade"
    id="deleteConfirmModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Confirm Deletion</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    <b>Are you sure you want to delete this user?</b>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
                <button
                    id="confirmDeleteBtn"
                    type="button"
                    class="btn btn-danger">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection @push('styles') @section('styles')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

    body {
        font-family: "Inter", sans-serif !important;
    }

    .user-row:hover {
        background-color: #f8fafc !important;
        transition: background-color 0.25s ease;
    }

    /* ✅ Delete Button — white icon, red hover */
    .custom-delete-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 7px 10px !important;
        min-width: 38px !important;
        height: 36px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        border: 2px solid #dc3545 !important;
        background-color: #fff !important;
        color: #dc3545 !important;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .custom-delete-btn:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.35);
        transform: translateY(-2px);
    }

    /* ✅ Edit Button — white icon, blue hover */
    .custom-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 7px 10px !important;
        min-width: 38px !important;
        height: 36px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        border: 2px solid #0d6efd !important;
        background-color: #fff !important;
        color: #0d6efd !important;
        transition: all 0.3s ease-in-out;
    }

    .custom-edit-btn:hover {
        background-color: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.35);
        transform: translateY(-2px);
    }

    /* Avatar hover effect */
    .user-table img {
        transition: transform 0.2s ease;
    }

    .user-table img:hover {
        transform: scale(1.1);
    }

    .table thead th {
        text-transform: uppercase;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        border-bottom: 2px solid #dee2e6;
    }

    .badge {
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: capitalize;
    }
</style>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let userId = null;
        const deleteModal = new bootstrap.Modal(
            document.getElementById("deleteConfirmModal")
        );
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        const bulkActionBtn = document.getElementById("bulkActionBtn");
        const modalBody = document.querySelector(
            "#deleteConfirmModal .modal-body p b"
        );

        // Individual Delete
        document.querySelectorAll(".delete-user-btn").forEach((button) => {
            button.addEventListener("click", function() {
                userId = this.dataset.id;
                modalBody.textContent =
                    "Are you sure you want to delete this user?";
                deleteModal.show();
            });
        });

        // Handle Confirm Delete
        // Handle Confirm Delete
        confirmDeleteBtn.addEventListener("click", async function() {
            if (userId) {
                try {
                    const response = await fetch(`/admin/users/${userId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            Accept: "application/json",
                        },
                    });

                    if (!response.ok)
                        throw new Error(`HTTP ${response.status}`);

                    const data = await response.json();
                    if (data.success) {
                        // Success — remove user instantly
                        document.getElementById(`user-row-${userId}`)?.remove();
                        deleteModal.hide();

                        // Reset UI state
                        userId = null;
                        document
                            .querySelectorAll(".select-user")
                            .forEach((cb) => (cb.checked = false));
                        bulkActionBtn.innerHTML =
                            '<i class="mdi mdi-plus"></i> Add User';
                        bulkActionBtn.classList.remove("btn-danger");
                        bulkActionBtn.classList.add("btn-dark");
                    } else {
                        alert(data.message || "Failed to delete user.");
                    }
                } catch (err) {
                    console.error("Delete error:", err);
                    alert("Failed to delete user. Check console.");
                }
            } else {
                // Bulk delete
                const selectedIds = [
                    ...document.querySelectorAll(".select-user:checked"),
                ].map((cb) => cb.dataset.id);
                if (selectedIds.length === 0) return;

                try {
                    const response = await fetch(`/admin/users/bulk-delete`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            ids: selectedIds,
                        }),
                    });

                    if (!response.ok)
                        throw new Error(`HTTP ${response.status}`);

                    const data = await response.json();
                    if (data.success) {
                        deleteModal.hide();
                        selectedIds.forEach((id) => {
                            document.getElementById(`user-row-${id}`)?.remove();
                        });

                        // Reset
                        document.querySelector(
                            "#selectAllUsers"
                        ).checked = false;
                        bulkActionBtn.innerHTML =
                            '<i class="mdi mdi-plus"></i> Add User';
                        bulkActionBtn.classList.remove("btn-danger");
                        bulkActionBtn.classList.add("btn-dark");
                    } else {
                        alert(
                            data.message || "Failed to delete selected users."
                        );
                    }
                } catch (err) {
                    console.error("Bulk delete error:", err);
                    alert("Failed to delete selected users.");
                }
            }
        });

        // Bulk button click - show modal for bulk delete
        bulkActionBtn.addEventListener("click", function() {
            const selectedIds = [
                ...document.querySelectorAll(".select-user:checked"),
            ].map((cb) => cb.dataset.id);
            if (selectedIds.length > 0) {
                userId = null; // Reset single user
                modalBody.textContent =
                    "Are you sure you want to delete selected users?";
                deleteModal.show();
            } else {
                // Redirect to Add User page if no selection
                window.location.href = "{{ route('users.create') }}";
            }
        });

        // Bulk select & button toggle
        const selectAllCheckbox = document.getElementById("selectAllUsers");
        const userCheckboxes = document.querySelectorAll(".select-user");

        function updateBulkButton() {
            const anyChecked = [...userCheckboxes].some((cb) => cb.checked);
            if (anyChecked) {
                bulkActionBtn.innerHTML =
                    '<i class="mdi mdi-delete"></i> Delete all ';
                bulkActionBtn.classList.remove("btn-dark");
                bulkActionBtn.classList.add("btn-danger");
            } else {
                bulkActionBtn.innerHTML =
                    '<i class="mdi mdi-plus"></i> Add User';
                bulkActionBtn.classList.remove("btn-danger");
                bulkActionBtn.classList.add("btn-dark");
            }
        }

        selectAllCheckbox.addEventListener("change", function() {
            userCheckboxes.forEach((cb) => (cb.checked = this.checked));
            updateBulkButton();
        });

        userCheckboxes.forEach((cb) => {
            cb.addEventListener("change", updateBulkButton);
        });
    });

    // AJAX Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchUsers(page);
    });

    function fetchUsers(page) {
        $.ajax({
            url: "{{ route('users.index') }}?page=" + page,
            success: function(data) {
                $('#usersTableContainer').html(data);
            },
            error: function() {
                alert('Failed to load users. Please try again.');
            }
        });
    }
</script>
@endpush