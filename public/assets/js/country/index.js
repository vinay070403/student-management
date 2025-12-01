function initCountries(config) {
    axios.get(config.indexUrl, { headers: { 'X-CSRF-TOKEN': config.csrfToken } });
}

$(function () {
    let currentId = null;

    const table = $('#countries-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#countries-table').data('url'),
            type: 'GET',
            data: function (d) {
                d.search = d.search || {};
                d.search.value = $('#customSearchInput').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                render: data => `<input type="checkbox" class="form-check-input" value="${data}">`
            },
            { data: 'name', name: 'name', width: '800px' },
            { data: 'created_at', name: 'created_at', width: '200px' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-end',
                width: '600px'
            }
        ],
        order: [[2, 'desc']],
        searching: false,
        paging: true,
        pageLength: 10,
        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>',
        createdRow: function(row, data, dataIndex) {
                            $('td', row).eq(1).addClass('fw-bold text-dark');
                            $('td', row).eq(2).addClass('fw-bold text-muted');
                        }
    });

    // Debounced search
    const debounce = (fn, delay) => {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    };

    $('#customSearchInput').on('keyup', debounce(() => table.ajax.reload(), 300));

    // Toolbar elements
    const toolbarBase = $('[data-kt-country-table-toolbar="base"]');
    const toolbarSelected = $('[data-kt-country-table-toolbar="selected"]');
    const selectedCount = $('[data-kt-country-table-select="selected_count"]');
    const deleteSelected = $('[data-kt-country-table-select="delete_selected"]');

    const toggleToolbars = () => {
        const allCheckboxes = $('#countries-table tbody input[type="checkbox"]');
        const checkedBoxes = allCheckboxes.filter(':checked');
        if (checkedBoxes.length > 0) {
            selectedCount.text(checkedBoxes.length);
            toolbarBase.addClass('d-none');
            toolbarSelected.removeClass('d-none');
        } else {
            toolbarBase.removeClass('d-none');
            toolbarSelected.addClass('d-none');
        }
    };

    // Checkbox click event
    $(document).on('click', '#countries-table tbody input[type="checkbox"]', toggleToolbars);

    // ----------------------
    // SINGLE DELETE
    // ----------------------
    $(document).on('click', '.delete-country-btn', function(e) {
        e.preventDefault();

        let deleteUlid = $(this).data('id');
        const countryName = $(this).closest('tr').find('td:nth-child(2)').text();

        Swal.fire({
            title: 'Are you sure?',
            text: `This will delete ${countryName} and all related states, schools, student grades, and grade scales.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/admin/countries/${deleteUlid}`, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(response => {
                    table.ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message ?? 'Country deleted successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete failed',
                        text: error.response?.data?.message ?? 'Failed to delete country.'
                    });

                }).finally(() => deleteUlid = null);
            }
        });
    });

    // ----------------------
    // BULK DELETE
    // ----------------------
    deleteSelected.on('click', function () {
        const selectedIds = $('#countries-table tbody input[type="checkbox"]:checked').map(function () {
            return $(this).val();
        }).get();

        if (!selectedIds.length) return;

        Swal.fire({
            text: "Are you sure you want to delete selected country(s)?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-light-primary"
            }
        }).then(result => {
            if (result.isConfirmed) {
                axios.delete($(this).data('url'), { data: { ids: selectedIds }, headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } })
                    .then(response => {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            text: response.data.message || 'Selected countries deleted!',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            customClass: { confirmButton: 'btn btn-primary' }
                        });
                    });
            }
        });
    });

    // ----------------------
    // REFRESH TABLE
    // ----------------------
    $('#kt_refresh_countries').on('click', function () {
        $(this).addClass('spinner-border');
        location.reload();
    });
});
