document.addEventListener('DOMContentLoaded', function() {

    const tableElement = document.getElementById('schools-table');
    if (!tableElement) return;

    const baseUrl = tableElement.dataset.baseUrl; // data-base-url="{{ url('admin/schools') }}"
    const indexUrl = tableElement.datasetIndexUrl; // data-index-url="{{ route('schools.index') }}"

    const table = $('#schools-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: indexUrl,
            data: function(d) {
                d.custom_search = $('#custom-search').val();
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'state', name: 'state.name', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
        ],
        order: [[1, 'desc']],
        searching: false,
        responsive: true,
        paging: true,
        lengthChange: true,
        pageLength: 10,
        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
        createdRow: function(row) {
            $('td', row).eq(0).addClass('fw-bold text-dark');
            $('td', row).eq(1).addClass('fw-bold text-muted');
        }
    });

    // Live search
    $('#custom-search').on('keyup', function() {
        table.ajax.reload();
    });

    // -------------------------------
    // DELETE LOGIC
    // -------------------------------
    let currentId = null;
    let lastActiveElement = null;
    const modalEl = document.getElementById('deleteSchoolModal');
    const deleteModal = new bootstrap.Modal(modalEl, { backdrop: true });
    const confirmBtn = document.getElementById('confirmSchoolDeleteBtn');
    const schoolNameEl = document.getElementById('schoolName');

    $('#schools-table').on('click', '.delete-school-btn', function() {
        currentId = $(this).data('id');
        const schoolName = $(this).data('name');
        schoolNameEl.textContent = schoolName;
        lastActiveElement = this;
        deleteModal.show();
    });

    modalEl.addEventListener('hidden.bs.modal', () => {
        if (lastActiveElement) lastActiveElement.focus();
        currentId = null;
    });

    confirmBtn.addEventListener('click', function() {
        if (!currentId) return;
        confirmBtn.disabled = true;

        axios.post(`${baseUrl}/${currentId}`, { _method: 'DELETE' }, {

        }).then(response => {
            table.ajax.reload(null, false);
            deleteModal.hide();
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.data.message || 'School deleted successfully.',
                timer: 2500,
                showConfirmButton: false
            });
        }).catch(error => {
            console.error(error);
            deleteModal.hide();
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.response?.data?.message || 'Failed to delete school.',
            });
        }).finally(() => confirmBtn.disabled = false);
    });
});
