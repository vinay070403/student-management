<div class="table-grid table-responsive">
    <table class="table align-middle mb-3 table-hover user-table">
        <thead class="table-light">
            <tr>
                <th style="width: 60px;"><input type="checkbox" id="selectAllUsers" /></th>
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
                    <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('assets/images/default-avatar.png') }}"
                        alt="{{ $user->first_name }}" class="rounded-circle shadow-sm" width="42" height="42" />

                    <div>
                        <div class="fw-semibold text-dark mb-1">
                            {{-- ✅ Limit name length and append "....." if too long --}}
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
                <td class="text-muted">
                    {{ $user->created_at->format('d M Y, h:i A') }}
                </td>
                <td class="text-end">
                    <div class="d-inline-flex justify-content-end gap-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm custom-edit-btn" title="Edit">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <button class="delete-user-btn custom-delete-btn" data-id="{{ $user->id }}" title="Delete" type="button">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-end">
    {!! $users->links() !!}
</div>