<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <!-- <h3 class="fw-semibold text-dark mb-0">
            <i class="bi bi-people me-2"></i> Classes List
        </h3> -->
        <div class="d-flex gap-2">
            <!-- <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-secondary px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                ← Back
            </a> -->
            <a href="{{ route('schools.classes.create', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                + Add Class
            </a>
        </div>
    </div>
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <!-- <th>School</th> -->
                <th>Class Name</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($school->classes as $class)
            <tr>
                <!-- <td>{{ $class->school->name ?? 'N/A' }}</td> -->
                <td>{{ $class->name }}</td>
                <td class="text-end">
                    <a href="{{ route('schools.classes.edit', [$school->id, $class->id]) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                    <form action="{{ route('schools.classes.destroy', [$school->id, $class->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No classes yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>