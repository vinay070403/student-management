$(function () {
    const config = window.roleConfig;

    const table = $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: config.listURL,
        columns: [
            { data: 'name', name: 'name' },
            { data: 'display_name', name: 'display_name' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: true,
                className: 'text-end'
            }
        ],
        order: [[0, 'desc']],
        searching: true,
        responsive: true,
        paging: true,
        lengthChange: true,
        pageLength: 10,
        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
    });

    // DELETE ACTION
    $('#rolesTable').on('click', '.delete-role', function () {
        const id = $(this).data('id');
        const url = `${config.baseURL}/${id}`;

        if (confirm('Are you sure you want to delete this role?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: config.csrfToken },
                success: function (response) {
                    table.ajax.reload(null, false);
                    alert(response.message);
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.message || 'Error deleting role.');
                }
            });
        }
    });
});
