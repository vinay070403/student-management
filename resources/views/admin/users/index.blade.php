@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid">
    <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-account-group" style="font-size: 2.3rem; color: #0d6efd;"></i>
                <h3 class="fw-semibold mb-0 text-dark" style="font-family: 'Inter', sans-serif">
                    Users
                </h3>
            </div>
            <button id="bulkActionBtn" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
                <i class="mdi mdi-plus"></i> Add User
            </button>
        </div>

        <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
            <!-- Table -->
            <div id="usersTableContainer">
                @include('admin.users.partials.users_table')
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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
@endsection

@push('styles')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

    body {
        font-family: "Inter", sans-serif !important;
    }

    .user-row:hover {
        background-color: #f8fafc !important;
        transition: background-color 0.5s ease;
    }

    .custom-delete-btn,
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
        transition: all 0.3s ease-in-out;
    }

    .custom-delete-btn {
        border: 2px solid #dc3545 !important;
        background-color: #fff !important;
        color: #dc3545 !important;
    }

    .custom-delete-btn:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.35);
        transform: translateY(-2px);
    }

    .custom-edit-btn {
        border: 2px solid #0d6efd !important;
        background-color: #fff !important;
        color: #0d6efd !important;
    }

    .custom-edit-btn:hover {
        background-color: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.35);
        transform: translateY(-2px);
    }

    .table thead th {
        text-transform: uppercase;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        border-bottom: 2px solid #dee2e6;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let userId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        const bulkActionBtn = document.getElementById("bulkActionBtn");
        const modalBody = document.querySelector("#deleteConfirmModal .modal-body p b");

        const selectAllCheckbox = document.getElementById("selectAllUsers");
        const userCheckboxes = document.querySelectorAll(".select-user");

        function updateBulkButton() {
            const anyChecked = [...userCheckboxes].some(cb => cb.checked);
            if (anyChecked) {
                bulkActionBtn.innerHTML = '<i class="mdi mdi-delete"></i> Delete selected';
                bulkActionBtn.classList.remove("btn-dark");
                bulkActionBtn.classList.add("btn-danger");
            } else {
                bulkActionBtn.innerHTML = '<i class="mdi mdi-plus"></i> Add User';
                bulkActionBtn.classList.remove("btn-danger");
                bulkActionBtn.classList.add("btn-dark");
            }
        }

        selectAllCheckbox.addEventListener("change", function() {
            userCheckboxes.forEach(cb => cb.checked = this.checked);
            updateBulkButton();
        });

        userCheckboxes.forEach(cb => cb.addEventListener("change", updateBulkButton));

        document.querySelectorAll(".delete-user-btn").forEach(button => {
            button.addEventListener("click", function() {
                userId = this.dataset.id;
                modalBody.textContent = "Are you sure you want to delete this user?";
                deleteModal.show();
            });
        });

        confirmDeleteBtn.addEventListener("click", async function() {
            const idsToDelete = userId ? [userId] : [...document.querySelectorAll(".select-user:checked")].map(cb => cb.dataset.id);
            if (!idsToDelete.length) return;

            try {
                const url = userId ? `/admin/users/${userId}` : `/admin/users/bulk-delete`;
                const method = userId ? 'DELETE' : 'POST';
                const body = userId ? JSON.stringify({}) : JSON.stringify({
                    ids: idsToDelete
                });

                const res = await fetch(url, {
                    method: method,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: body
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                if (data.success) {
                    idsToDelete.forEach(id => {
                        document.getElementById(`user-row-${id}`)?.remove();
                    });
                    deleteModal.hide();
                    userId = null;
                    document.querySelectorAll(".select-user").forEach(cb => cb.checked = false);
                    updateBulkButton();
                } else {
                    alert(data.message || 'Failed to delete.');
                }
            } catch (err) {
                console.error('Delete error:', err);
                alert('Failed to delete user(s). Check console.');
            }
        });

        bulkActionBtn.addEventListener("click", function() {
            const selectedIds = [...document.querySelectorAll(".select-user:checked")].map(cb => cb.dataset.id);
            if (selectedIds.length) {
                userId = null;
                modalBody.textContent = "Are you sure you want to delete selected users?";
                deleteModal.show();
            } else {
                window.location.href = "{{ route('users.create') }}";
            }
        });
    });
</script>
@endpush