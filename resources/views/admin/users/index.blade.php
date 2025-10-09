@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0 text-dark">Users</h4>
                <button id="bulkActionBtn"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-plus"></i> Add User
                </button>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle mb-3 table-hover user-table">
                    <thead class="bg-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAllUsers">
                            </th>
                            <th>USER</th>
                            <th>ROLE</th>
                            <th>CREATED AT</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr id="user-row-{{ $user->id }}">
                            <td>
                                <input type="checkbox" class="select-user" data-id="{{ $user->id }}">
                            </td>
                            <td class="d-flex align-items-center gap-3">
                                <!-- Avatar -->
                                <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('assets/images/default-avatar.png') }}"
                                    alt="{{ $user->first_name }}" class="rounded-circle" width="40" height="40">
                                <div>
                                    <div class="fw-bold">{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</div>
                                    <div class="text-muted" style="font-size:0.9rem">{{ $user->email }}</div>
                                </div>
                            </td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-3">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-2 position-relative"
                                        title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-3 delete-user-btn position-relative"
                                        data-id="{{ $user->id }}" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-end">
                {{ $users->links('pagination::bootstrap-5') }}
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
                <p class="text-muted mb-4">
                    <b>Are you sure you want to delete this user?</b>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let userId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const bulkActionBtn = document.getElementById('bulkActionBtn');
        const modalBody = document.querySelector('#deleteConfirmModal .modal-body p b');

        // Individual Delete
        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                userId = this.dataset.id;
                modalBody.textContent = "Are you sure you want to delete this user?";
                deleteModal.show();
            });
        });

        // Handle Confirm Delete
        confirmDeleteBtn.addEventListener('click', function() {
            if (userId) { // Single user delete
                fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    })
                    .then(data => {
                        deleteModal.hide();
                        document.getElementById(`user-row-${userId}`).remove();
                        userId = null;
                        // Reset checkboxes and bulk button if any selected
                        document.querySelectorAll('.select-user').forEach(cb => cb.checked = false);
                        bulkActionBtn.innerHTML = '<i class="mdi mdi-plus"></i> Add User';
                        bulkActionBtn.classList.remove('btn-danger');
                        bulkActionBtn.classList.add('btn-dark');
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to delete user.');
                    });
            } else { // Bulk delete
                const selectedIds = [...document.querySelectorAll('.select-user:checked')].map(cb => cb.dataset.id);
                if (selectedIds.length === 0) return;

                fetch(`/admin/users/bulk-delete`, { // Make a route for bulk delete
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    })
                    .then(data => {
                        deleteModal.hide();
                        selectedIds.forEach(id => {
                            const row = document.getElementById(`user-row-${id}`);
                            if (row) row.remove();
                        });
                        // Reset checkboxes and bulk button
                        document.querySelector('#selectAllUsers').checked = false;
                        bulkActionBtn.innerHTML = '<i class="mdi mdi-plus"></i> Add User';
                        bulkActionBtn.classList.remove('btn-danger');
                        bulkActionBtn.classList.add('btn-dark');
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to delete selected users.');
                    });
            }
        });

        // Bulk button click - show modal for bulk delete
        bulkActionBtn.addEventListener('click', function() {
            const selectedIds = [...document.querySelectorAll('.select-user:checked')].map(cb => cb.dataset.id);
            if (selectedIds.length > 0) {
                userId = null; // Reset single user
                modalBody.textContent = "Are you sure you want to delete selected users?";
                deleteModal.show();
            } else {
                // Redirect to Add User page if no selection
                window.location.href = "{{ route('admin.users.create') }}";
            }
        });

        // Bulk select & button toggle
        const selectAllCheckbox = document.getElementById('selectAllUsers');
        const userCheckboxes = document.querySelectorAll('.select-user');

        function updateBulkButton() {
            const anyChecked = [...userCheckboxes].some(cb => cb.checked);
            if (anyChecked) {
                bulkActionBtn.innerHTML = '<i class="mdi mdi-delete"></i> Delete all ';
                bulkActionBtn.classList.remove('btn-dark');
                bulkActionBtn.classList.add('btn-danger');
            } else {
                bulkActionBtn.innerHTML = '<i class="mdi mdi-plus"></i> Add User';
                bulkActionBtn.classList.remove('btn-danger');
                bulkActionBtn.classList.add('btn-dark');
            }
        }

        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(cb => cb.checked = this.checked);
            updateBulkButton();
        });

        userCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkButton);
        });
    });
</script>
@endpush