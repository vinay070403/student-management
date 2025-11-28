<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Custom Search Bar (Left) -->
    <div class="flex-grow me-4">
        <input type="text" id="customSearch" class="form-control form-control-sm rounded-3" placeholder="Search Roles..."
            style="max-width: 300px;">
    </div>

    <!-- Add Role Button (Right) -->
    <a href="{{ route('roles.create') }}"
        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">
        <i class="fa-solid fa-plus"></i> Add Role
    </a>
</div>



<div class="p-4 bg-white border rounded-3 mb-5 shadow-sm" style="border-color: #dee2e6;">
    <div class="table-responsive">
        <table class="table align-middle mb-0 table-hover school-table" id="rolesTable">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold">Name</th>
                    <th class="fw-bold">Display Name</th>
                    <th class="text-end fw-bold">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
