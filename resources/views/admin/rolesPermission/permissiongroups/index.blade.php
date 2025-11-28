<div class="d-flex justify-content-between align-items-center mb-4">
    {{-- Search --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group" style="max-width: 350px;">
            <span class="input-group-text bg-white border-end-0">
                <i class="mdi mdi-magnify text-muted"></i>
            </span>
            <input type="text" id="customSearchInput" class="form-control border-start-0 ps-0"
                placeholder="Search permission...">
        </div>
    </div>
    <a href="{{ route('permission-groups.create') }}"
        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">Add Group</a>
</div>
<div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
    <div class="table-responsive">
        <table class="table align-middle table-hover" id="permissionGroupTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
