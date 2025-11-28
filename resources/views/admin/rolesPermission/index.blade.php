@extends('layouts.app')

@section('title', 'Roles & Permissions')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />

    @section('content')

        <div class="p-4 bg-white border-2 rounded-2 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">
            <h3 class="mb-4 montserrat-bold">Roles & Permissions</h3>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4 fw-bold" id="rolesPermissionTabs" role="tablist">
                <li class="nav-item" style="font-size: 1.1rem;">
                    <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button">
                        Roles
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" id="permission-groups-tab" data-bs-toggle="tab" data-bs-target="#permission-groups"
                        type="button">
                        Permission Groups
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions"
                        type="button">
                        Permissions
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3">

                <!-- Roles -->
                <div class="tab-pane fade show active" id="roles">
                    @include('admin.rolesPermission.roles.index')
                </div>

                <!-- Permission Groups -->
                <div class="tab-pane fade" id="permission-groups">
                    @include('admin.rolesPermission.permissionGroups.index')
                </div>

                <!-- Permissions -->
                <div class="tab-pane fade" id="permissions">
                    @include('admin.rolesPermission.permissions.index')
                </div>

            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>

            <script>
                $(function() {
                    const table = $('#rolesTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('roles.index') }}",
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'display_name',
                                name: 'display_name'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-end'
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        searching: true,
                        responsive: true,
                        lengthChange: true,
                        dom: '<"top d-flex justify-content-between mb-3">rt<"d-flex justify-content-between align-items-center mt-4"lp>',
                        language: {
                            search: "" // disable default search box
                        },
                        createdRow: function(row, data, dataIndex) {
                            $('td', row).eq(0).addClass('fw-bold text-dark');
                            $('td', row).eq(1).addClass('fw-bold text-muted');
                        }
                    });

                    // Custom Search
                    $('#customSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });

                    // DELETE ACTION
                    $('#rolesTable').on('click', '.delete-role', function() {
                        const id = $(this).data('id');
                        const url = "{{ url('admin/roles') }}/" + id;

                        if (confirm('Are you sure you want to delete this role?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    table.ajax.reload(null, false);
                                    alert(response.message);
                                },
                                error: function(xhr) {
                                    alert(xhr.responseJSON?.message || 'Error deleting role.');
                                }
                            });
                        }
                    });
                });
            </script>

            // Permissions DataTable and Delete Action
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
            <script>
                $(document).ready(function() {
                    var table = $('#permissionsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('permissions.index') }}",
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'display_name',
                                name: 'display_name'
                            },
                            {
                                data: 'group',
                                name: 'group'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-end'
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        searchable: true,
                        responsive: true,
                        pageLength: 10,
                        lengthChange: true,
                        dom: '<"top d-flex justify-content-between mb-3">rt<"d-flex justify-content-between align-items-center mt-4"lp>',

                        createdRow: function(row, data, dataIndex) {
                            $('td', row).eq(0).addClass('fw-bold text-dark');
                            $('td', row).eq(1).addClass('fw-bold text-muted');
                        }
                    });

                    // Custom Search
                    $('#customSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });


                    // Delete permission
                    $('#permissionsTable').on('click', '.delete-permission', function() {
                        var url = $(this).data('url');
                        if (confirm('Are you sure you want to delete this permission?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    table.ajax.reload();
                                    alert(response.message);
                                },
                                error: function(xhr) {
                                    alert(xhr.responseJSON.message || 'Something went wrong.');
                                }
                            });
                        }
                    });
                });
            </script>

            // Permission Groups DataTable and Delete Action
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
            <script>
                $(document).ready(function() {
                    var table = $('#permissionGroupTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{ route('permission-groups.index') }}',
                        columns: [{
                                data: 'id',
                                name: 'id',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-end'
                            }
                        ],
                        order: [
                            [1, 'asc']
                        ],
                        searchable: true,
                        responsive: true,
                        pageLength: 10,
                        lengthChange: true,
                        dom: '<"top d-flex justify-content-between mb-3">rt<"d-flex justify-content-between align-items-center mt-4"lp>',
                        createdRow: function(row, data, dataIndex) {
                            $('td', row).eq(1).addClass('fw-bold text-dark');
                            $('td', row).eq().addClass('fw-bold text-muted');
                        }
                    });

                    // Select all checkboxes
                    $('#selectAll').on('click', function() {
                        var rows = table.rows({
                            'search': 'applied'
                        }).nodes();
                        $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    });

                    // Custom Search
                    $('#customSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });


                    // Delete group
                    $(document).on('click', '.delete-group', function() {
                        var url = $(this).data('url');
                        if (confirm('Are you sure you want to delete this group?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    alert(response.message);
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    alert(xhr.responseJSON.message || 'Something went wrong');
                                }
                            });
                        }
                    });
                });
            </script>

        @endpush
    @endsection
