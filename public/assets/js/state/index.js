

document.addEventListener('DOMContentLoaded', function() {
    const tableElement = document.getElementById('states-table');
    if (!tableElement) return;

    const baseUrl = tableElement.dataset.baseUrl; // add data-base-url="{{ url('admin/states') }}"
    const indexUrl = tableElement.dataset.indexUrl; // add data-index-url="{{ route('states.index') }}"
    let deleteUlid = null;

    const table = $('#states-table').DataTable({
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
            { data: 'country', name: 'country.name', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' },
        ],
        order: [[0, 'desc']],
        lengthMenu: [10, 25, 50, 100],
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

    // live search
    $('#custom-search').on('keyup', function() {
        table.ajax.reload();
    });

    // Delete handler
    $(document).on('click', '.delete-state-btn', function(e) {
        e.preventDefault();

        deleteUlid = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the state, its schools, student grades, and grade scales.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`${baseUrl}/${deleteUlid}`, {
                    _method: 'DELETE'
                }, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                }).then(response => {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message ?? 'State deleted successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete failed',
                        text: error.response?.data?.message ?? 'Failed to delete state.'
                    });
                }).finally(() => deleteUlid = null);
            }
        });
    });
});
