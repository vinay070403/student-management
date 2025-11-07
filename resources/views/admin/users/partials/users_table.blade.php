<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="user-search" class="form-control form-control-lg" placeholder="Search users by name or email...">
    </div>
</div>

<div class="table-grid table-responsive">
    <table class="table align-middle mb-3 table-hover user-table">
        <thead class="table-light">
            <tr>
                <th style="width:20px;"><input type="checkbox" id="selectAllUsers" /></th>
                <th>USER</th>
                <th>ROLE</th>
                <th>CREATED AT</th>
                <th class="text-center" style="width: 120px;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr id="user-row-{{ $user->id }}" class="user-row">
                <td><input type="checkbox" class="select-user" data-id="{{ $user->id }}" /></td>

                <td class="d-flex align-items-center gap-3">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/images/default-avatar1.jpg') }}"
                        alt="{{ $user->first_name }}" class="rounded-circle shadow-sm" width="42" height="42" />
                    <div>
                        <div class="fw-semibold text-dark mb-1">
                            {{ Str::limit(ucfirst($user->first_name) . ' ' . ucfirst($user->last_name), 20, '.....') }}
                        </div>
                        <div class="fw-semibold text-gray">{{ $user->email }}</div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-light text-dark border border-secondary-subtle px-3 py-2 rounded-3">
                        {{ $user->getRoleNames()->join(', ') }}
                    </span>
                </td>
                <td class="text-muted">{{ $user->created_at->format('d M Y, h:i A') }}</td>
                <td class="text-end">
                    <div class="d-inline-flex justify-content-end gap-3">
                        <!-- Edit Button (Professional) -->
                        <a href="{{ route('users.edit', $user->id) }}"
                            class="btn btn-outline-old-dark btn-sm d-flex align-items-center justify-content-center p-2"
                            style="width: 36px; height: 36px; border-radius: 8px;"
                            title="Edit">
                            <i class="mdi mdi-pencil-outline" style="font-size: 1.1rem;"></i>
                        </a>

                        <!-- Delete Button (Professional) -->
                        <button type="button"
                            class="btn btn-outline- btn-sm d-flex align-items-center justify-content-center p-2 delete-user-btn"
                            data-id="{{ $user->id }}"
                            style="width: 36px; height: 36px; border-radius: 8px;"
                            title="Delete">
                            <i class="mdi mdi-delete-circle-outline" style="font-size: 1.1rem;"></i>
                        </button>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Custom Pagination -->
<div class="d-flex justify-content-end">
    {{ $users->links() }}

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#user-search').on('keyup', function() {
                const query = $(this).val().toLowerCase();
                $('.user-row').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1)
                });
            });
        });
    </script>
    @endpush