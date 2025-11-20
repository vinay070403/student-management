function initCountries(config) {
    axios.get(config.indexUrl, { headers: { 'X-CSRF-TOKEN': config.csrfToken } });
}

$(function () {
    let currentId = null;

    const tableElement = $('#countries-table')[0]; // plain DOM element for advanced selection
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
                render: function (data) {
                    return `<input type="checkbox" class="form-check-input" value="${data}">`;
                }
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
        // responsive: true,
        paging: true,
        // lengthChange: true,
        pageLength: 10,
        dom: '<"table-top">rt<"d-flex justify-content-between align-items-center mt-4"lfp>'
    });

    // Debounced search
    const debounce = (fn, delay) => {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    };

    $('#customSearchInput').on('keyup', debounce(function () {
        table.ajax.reload();
    }, 300));

    // Toolbar elements
    const toolbarBase = $('[data-kt-country-table-toolbar="base"]');
    const toolbarSelected = $('[data-kt-country-table-toolbar="selected"]');
    const selectedCount = $('[data-kt-country-table-select="selected_count"]');
    const deleteSelected = $('[data-kt-country-table-select="delete_selected"]');

    // Toggle toolbar based on checkbox selection
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

    // Single row delete
    $(document).on('click', '.delete-country-btn', function (e) {
        e.preventDefault();
        currentId = $(this).data('id');
        const parentRow = $(this).closest('tr');
        const countryName = parentRow.find('td:nth-child(2)').text();

        Swal.fire({
            text: `Are you sure you want to delete ${countryName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'No, cancel',
            customClass: {
                confirmButton: 'btn fw-bold btn-danger',
                cancelButton: 'btn fw-bold btn-light-primary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                loadingBlockUI.block();
                axios.delete(`/admin/countries/${currentId}`, {
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                }).then((response) => {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message || 'Country deleted successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete failed',
                        text: err.response?.data?.message || 'Failed to delete country.'
                    });
                }).finally(() => {
                    currentId = null;
                    loadingBlockUI.release();
                });
            }
        });
    });

    // Bulk delete
    deleteSelected.on('click', function () {
        const selectedIds = $('#countries-table tbody input[type="checkbox"]:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

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
        }).then((result) => {
            if (result.isConfirmed) {
                loadingBlockUI.block();
                axios.delete($(this).data('url'), { data: { ids: selectedIds } })
                    .then((response) => {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            text: response.data.message || 'Selected countries deleted!',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            customClass: { confirmButton: 'btn btn-primary' }
                        });
                    }).finally(() => loadingBlockUI.release());
            }
        });
    });
// Full page refresh button
$('#kt_refresh_countries').on('click', function () {
    const el = $(this);
    el.addClass('spinner-border');

    // Reload the entire page
    location.reload();
});

});


