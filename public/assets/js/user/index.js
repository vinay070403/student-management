
document.addEventListener("DOMContentLoaded", function() {
    let userId = null;

    const deleteModal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const bulkActionBtn = document.getElementById("bulkActionBtn");
    const modalBody = document.querySelector("#deleteConfirmModal .modal-body p b");

    // Get routes & CSRF from meta tags or data attributes
    // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const usersIndexUrl = document.getElementById('usersTable').dataset.url; // add data-url="{{ route('users.index') }}" in table

    // Debounce helper
    function debounce(fn, delay) {
        let timer = null;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(context, args), delay);
        };
    }

    // Initialize DataTable
    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: usersIndexUrl,
            data: function(d) {
                d.custom_search = $('#customSearchInput').val();
            }
        },
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'user', name: 'user' },
            { data: 'status', name: 'status', className: 'text-center' },
            { data: 'created_at', name: 'created_at', className: 'text-center' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' }
        ],
        order: [[1, 'desc']],
        searching: false,
        paging: true,
        lengthChange: true,
        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
        createdRow: function(row, data) {
            $('td', row).eq(0).addClass('fw-bold text-dark');
            $('td', row).eq(1).addClass('fw-bold text-muted');
        },
        drawCallback: function() {
            bindActions();
        }
    });

    $('#customSearchInput').on('keyup', debounce(() => table.ajax.reload(), 300));

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

    function bindActions() {
        $('.delete-user-btn').off('click').on('click', function() {
            userId = $(this).data('id');
            modalBody.textContent = "Are you sure you want to delete this user?";
            deleteModal.show();
        });

        $('.select-user, #selectAllUsers').off('change').on('change', function() {
            if (this.id === 'selectAllUsers') $('.select-user').prop('checked', this.checked);
            updateBulkButton();
        });

        bulkActionBtn.addEventListener('click', function() {
            const selectedIds = $('.select-user:checked').map(function() { return $(this).data('id'); }).get();
            if (selectedIds.length) {
                userId = null;
                modalBody.textContent = "Are you sure you want to delete selected users?";
                deleteModal.show();
            } else {
                window.location.href = '/admin/users/create';
            }
        });
    }

    confirmDeleteBtn.addEventListener("click", async function() {
        const idsToDelete = userId ? [userId] : $('.select-user:checked').map(function() { return $(this).data('id'); }).get();
        if (!idsToDelete.length) return;

        try {
            const url = userId ? `/admin/users/${userId}` : `/admin/users/bulk-delete`;
            const method = userId ? 'DELETE' : 'POST';
            const res = await fetch(url, {
                method: method,
                headers: { "X-CSRF-TOKEN": csrfToken, "Accept": "application/json", "Content-Type": "application/json" },
                body: JSON.stringify(userId ? {} : { ids: idsToDelete })
            });

            const data = await res.json();
            if (!res.ok || !data.success) throw new Error(data.message || 'Failed to delete');

            Swal.fire({ icon: 'success', title: 'Deleted!', text: userId ? 'User deleted successfully.' : 'Selected users deleted successfully.', timer: 2000, showConfirmButton: false });
            deleteModal.hide();
            table.ajax.reload(null, false);
            userId = null;
            updateBulkButton();
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error!', text: err.message || 'Something went wrong.' });
        }
    });

    $(document).on('change', '.statusToggle', function() {
        let checkbox = $(this), ulid = checkbox.data('id'), newStatus = checkbox.is(':checked') ? 'Active' : 'Inactive';
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
                if (result.isConfirmed) updateStatus(ulid, newStatus, checkbox);
                else checkbox.prop('checked', true);
            });
        } else updateStatus(ulid, newStatus, checkbox);
    });

    function updateStatus(ulid, status, checkbox) {
        $.ajax({
            url: `/admin/users/change-status/${ulid}`,
            type: 'POST',
            data: { status: status, _token: csrfToken },
            success: function(res) { Swal.fire('Success', res.message, 'success'); },
            error: function(err) {
                Swal.fire('Error', err.responseJSON?.message || 'Something went wrong', 'error');
                checkbox.prop('checked', status === 'Inactive' ? true : false);
            }
        });
    }
});
