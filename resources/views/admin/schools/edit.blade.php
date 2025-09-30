@extends('layouts.app')
@section('title', "Edit School - {$school->name}")

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-dark">Edit School: {{ $school->name }}</h4>
            <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
        </div>

        <div class="card-body">
            <!-- School Information -->
            <h5 class="fw-semibold mb-3 text-primary">School Information</h5>
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
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="schoolTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">Classes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab">Subjects</button>
                </li>
            </ul>

            <div class="tab-content pt-3">
                <!-- Classes Tab -->
                <div class="tab-pane fade show active" id="classes" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold text-dark">Classes List</h6>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#addClassForm">+ Add Class</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($school->classes as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="collapse" href="#editClassForm-{{ $class->id }}">Edit</a>
                                        <form action="{{ route('schools.classes.destroy', [$school->id, $class->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse bg-light" id="editClassForm-{{ $class->id }}">
                                    <td colspan="2">
                                        <form action="{{ route('schools.classes.update', [$school->id, $class->id]) }}" method="POST" class="p-3 rounded border">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label class="form-label">Class Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#editClassForm-{{ $class->id }}">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No classes yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="collapse" id="addClassForm">
                        <form action="{{ route('schools.classes.store', $school) }}" method="POST" class="p-3 border rounded bg-light">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">New Class Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Add</button>
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#addClassForm">Cancel</button>
                        </form>
                    </div>
                </div>

                <!-- Subjects Tab -->
                <div class="tab-pane fade" id="subjects" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold text-dark">Subjects List</h6>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#addSubjectForm">+ Add Subject</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($school->subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="collapse" href="#editSubjectForm-{{ $subject->id }}">Edit</a>
                                        <form action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse bg-light" id="editSubjectForm-{{ $subject->id }}">
                                    <td colspan="2">
                                        <form action="{{ route('schools.subjects.update', [$school->id, $subject->id]) }}" method="POST" class="p-3 rounded border">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label class="form-label">Subject Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#editSubjectForm-{{ $subject->id }}">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No subjects yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="collapse" id="addSubjectForm">
                        <form action="{{ route('schools.subjects.store', $school) }}" method="POST" class="p-3 border rounded bg-light">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">New Subject Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Add</button>
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#addSubjectForm">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection