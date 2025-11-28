<table id="usersTable" class="table table-hover align-middle table-row-dashed fs-6 gy-4">
    <thead class="table-light text-nowrap">
        <tr>
            <th style="width: 45px;">
                <input type="checkbox" id="selectAllUsers">
            </th>

            <th>User</th>

            <th>Status</th>

            <th>Created At</th>

            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        {{-- Populated via Yajra DataTables --}}
        {{-- Example row structure --}}
        {{--
        <tr>
            <td><input type="checkbox" class="row-check"></td>

            <td>
                <div class="fw-bold">John Doe</div>
                <small class="text-muted">john@example.com</small>
            </td>

            <td class="text-center">
                <button
                    class="btn btn-sm statusToggleBtn"
                    data-id="{{ $user->id }}"
                    data-status="{{ $user->status }}"
                    style="padding: 5px 15px; border-radius: 20px;">
                    Active
                </button>
            </td>

            <td class="text-center">2025-02-10</td>

            <td class="text-end">
                <button class="btn btn-light btn-sm">View</button>
            </td>
        </tr>
        --}}
    </tbody>
</table>
