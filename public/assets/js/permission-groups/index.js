$(function() {
    const pgTable = $('#permissionGroupTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: permissionGroupConfig.listURL,
        columns: [
            { data: 'name', name: 'name' },
            {
                data: 'id',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function(data) {
                    let editUrl = permissionGroupConfig.baseURL + "/" + data + "/edit";
                    let deleteUrl = permissionGroupConfig.baseURL + "/" + data;
                    return `
                        <a href="${editUrl}" class="btn btn-sm btn-primary me-2">Edit</a>

                    `;
                }
            }
        ],
        order: [[0, 'asc']],
        responsive: true,
        pageLength: 10,
    });

    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if(!confirm('Are you sure you want to delete this group?')) return;

        $.ajax({
            url: permissionGroupConfig.baseURL + "/" + id,
            type: 'DELETE',
            data: { _token: permissionGroupConfig.csrfToken },
            success: function() { pgTable.ajax.reload(null, false); }
        });
    });
});
