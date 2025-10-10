@extends('layouts.app')
@section('title', "Edit School - {$school->name}")

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-dark">Edit School: {{ $school->name }}</h4>
            <a href="{{ route('schools.index') }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">← Back</a>
        </div>

        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="schoolTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">School Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">Classes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab">Subjects</button>
                </li>
            </ul>

            <div class="tab-content">

                <!-- School Info Tab -->
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <form action="{{ route('schools.update', $school->id) }}" method="POST" class="row g-3 mb-4">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="name" class="form-label">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $school->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                            <select name="state_id" class="form-select" required>
                                @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ $school->state_id == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $school->address }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="zipcode" class="form-label">Zipcode</label>
                            <input type="text" name="zipcode" class="form-control" value="{{ $school->zipcode }}" required>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-dark px-4 py-3 gap-2 rounded-3 btn-lg">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Classes Tab -->
                <div class="tab-pane fade" id="classes" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold text-dark">Classes List</h6>
                        <a href="{{ route('schools.classes.create', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">+ Add Class</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>School</th>
                                    <th>Class Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($school->classes as $class)
                                <tr>
                                    <!-- <td>{{ $class->id }}</td> -->
                                    <td>{{ $class->school->name ?? 'N/A' }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('schools.classes.edit', [$school->id, $class->id]) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-action="{{ route('schools.classes.destroy', [$school->id, $class->id]) }}">
                                            Delete
                                        </button>
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
                </div>

                <!-- Subjects Tab -->
                <div class="tab-pane fade" id="subjects" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold text-dark">Subjects List</h6>
                        <a href="{{ route('schools.subjects.create', $school->id) }}" class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">+ Add Subject</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Subject Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($school->subjects as $subject)
                                <tr>
                                    <td>{{ $subject->id }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('schools.subjects.edit', [$school->id, $subject->id]) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No subjects yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Global Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-4">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-semibold" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-secondary">Are you sure you want to delete this item? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 rounded-3">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('confirmDeleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', action);
        });
    });
</script>
@endpush