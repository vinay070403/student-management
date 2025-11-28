<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Permissions</h4>
    <a href="{{ route('permissions.create') }}"
        class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg shadow-sm">Add Permission</a>
</div>

<div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
    <div class="table-responsive">
        <table class="table align-middle mb-3 table-hover school-table" id="permissionsTable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Display Name</th>
                    <th>Group</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
