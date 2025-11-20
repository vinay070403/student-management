@extends('layouts.app')
@section('title', "Edit School - {$school->name}")

@push('styles')
    <!-- Bootstrap 5 DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

        <!-- Panel Header -->
        <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
            <h3 class="fw-bold text-dark mb-0" style="letter-spacing:1px;">
                <i class="fa-solid fa-school-circle-check"></i>
                Edit School: {{ $school->name }}
            </h3>
            <a href="{{ route('schools.index') }}" class="btn btn-dark px-5 py-3 rounded-3 fw-bold shadow-sm">
                ← Back
            </a>
        </div>

        <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-5 fw-bold" id="schoolTabs" role="tablist" style="font-size: 1.1rem;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                        type="button" role="tab">
                        School Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button"
                        role="tab">
                        Classes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects"
                        type="button" role="tab">
                        Subjects
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="schoolTabsContent">

                <!-- School Info Tab -->
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <form action="{{ route('schools.update', $school->ulid) }}" method="POST" class="row g-4">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-dark fw-bold text-dark">School Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg rounded-3 shadow-sm"
                                value="{{ $school->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="state_id" class="form-label fw-bold text-dark fw-bold text-dark">State Name <span
                                    class="text-danger">*</span></label>
                            <select name="state_id" class="form-select form-select-lg rounded-3 shadow-sm select2"
                                style="font-weight:700; color:#212529;" required>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ $school->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr class="my-3">

                        <!-- Grade Scale Section -->
                        <div class="p-4 bg-light border rounded-4 shadow-sm mb-5">
                            <h4 class="fw-bold mb-4 text-dark">Grade Scales</h4>
                            <div id="grade-scale-wrapper">
                                <div class="row fw-bold border-bottom pb-3 mb-3 d-none d-md-flex">
                                    <div class="col-md-2">Grade</div>
                                    <div class="col-md-3">Min</div>
                                    <div class="col-md-3">Max</div>
                                    <div class="col-md-2">Grade Point</div>
                                    <div class="col-md-2 text-end">Action</div>
                                </div>
                                <div id="grade-rows">
                                    @foreach ($school->gradeScales as $grade)
                                        <div class="row align-items-center mb-3 grade-row bg-white p-2 rounded-3 shadow-sm">
                                            <input type="hidden" name="grade_ids[]" value="{{ $grade->id }}">
                                            <div class="col-md-2">
                                                <input type="text" name="grade[]"
                                                    class="form-control form-control-sm fw-bold text-center"
                                                    value="{{ $grade->grade }}" placeholder="Grade" required>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="min[]" class="form-select form-select-sm text-center"
                                                    required>
                                                    <option value="">Select</option>
                                                    @for ($i = 0; $i <= 100; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $grade->min_score == $i ? 'selected' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="max[]" class="form-select form-select-sm text-center"
                                                    required>
                                                    <option value="">Select</option>
                                                    @for ($i = 0; $i <= 100; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $grade->max_score == $i ? 'selected' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="point[]"
                                                    class="form-control form-control-sm text-center"
                                                    value="{{ $grade->grade_point }}" placeholder="Point" required>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button"
                                                    class="btn btn-light btn-sm rounded-3 remove-grade-btn">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-grade-btn" class="btn btn-dark mt-3 fw-bold shadow-sm">+
                                    Add Grade</button>
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-dark px-5 py-3 rounded-3 btn-lg fw-bold shadow-sm">Save
                                Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Classes Tab -->

                <div class="tab-pane fade" id="classes" role="tabpanel">
                    <div class="d-flex gap-2">

                        <a href="{{ route('schools.classes.create', $school->ulid) }}"
                            class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                            + Add Class
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="classes-table" class="table table-hover align-middle mb-0">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Subjects Tab -->
                <div class="tab-pane fade" id="subjects" role="tabpanel">
                    <div class="table-responsive">
                        <table id="subjects-table" class="table table-hover align-middle mb-0">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>Subject Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ---------------------- Grade Scale JS ----------------------
            const gradeRows = document.getElementById('grade-rows');
            const addGradeBtn = document.getElementById('add-grade-btn');
            const form = document.querySelector('#info form');

            // Add new grade row dynamically
            addGradeBtn.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'align-items-center', 'mb-2', 'grade-row');
                newRow.innerHTML = `
                    <div class="col-md-2">
                        <input type="text" name="grade[]" class="form-control grade-input" placeholder="Grade" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="min[]" class="form-control min-input" placeholder="Min" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="max[]" class="form-control max-input" placeholder="Max" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="point[]" class="form-control" placeholder="Grade Point" required>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-light btn-sm rounded-3 remove-grade-btn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                gradeRows.appendChild(newRow);
            });

            // Remove grade row
            gradeRows.addEventListener('click', function(e) {
                if (e.target.closest('.remove-grade-btn')) {
                    const row = e.target.closest('.grade-row');
                    row.remove();
                }
            });

            // Form submit validation
            form.addEventListener('submit', function(e) {
                if (!validateAllGrades()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please correct the highlighted fields.',
                        confirmButtonColor: '#000',
                    });
                }
            });

            function validateAllGrades() {
                document.querySelectorAll('.text-danger.validation-error').forEach(el => el.remove());
                let hasError = false;

                const gradeInputs = Array.from(document.querySelectorAll('input[name="grade[]"]'));
                const minInputs = Array.from(document.querySelectorAll(
                    'input[name="min[]"], select[name="min[]"]'));
                const maxInputs = Array.from(document.querySelectorAll(
                    'input[name="max[]"], select[name="max[]"]'));

                const grades = gradeInputs.map(i => i.value.trim().toUpperCase());
                const mins = minInputs.map(i => parseFloat(i.value));
                const maxs = maxInputs.map(i => parseFloat(i.value));

                const gradeSet = new Set();
                grades.forEach((g, i) => {
                    if (g && gradeSet.has(g)) {
                        showInlineError(gradeInputs[i], 'Duplicate grade not allowed');
                        hasError = true;
                    }
                    gradeSet.add(g);
                });

                const ranges = mins.map((min, i) => ({
                    min,
                    max: maxs[i],
                    index: i
                }));
                ranges.sort((a, b) => a.min - b.min);
                ranges.forEach((r, i) => {
                    if (isNaN(r.min) || isNaN(r.max)) return;
                    if (r.min >= r.max) {
                        showInlineError(minInputs[r.index], 'Min must be less than Max');
                        hasError = true;
                    }
                    if (i > 0 && r.min <= ranges[i - 1].max) {
                        showInlineError(minInputs[r.index], 'Overlapping range, please adjust');
                        hasError = true;
                    }
                });

                return !hasError;
            }

            function showInlineError(input, message) {
                const error = document.createElement('div');
                error.className = 'text-danger small mt-1 validation-error';
                error.innerText = message;
                input.insertAdjacentElement('afterend', error);
            }

            // ---------------------- Classes DataTable ----------------------
            const classesTable = $('#classes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('schools.classes.index', $school->ulid) }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: data => data ? new Date(data).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }) : '-'
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
                    [1, 'desc']
                ],
                responsive: true,
                paging: true,
                lengthChange: true,
                pageLength: 10
            });

            $('#classes-table').on('click', '.delete-class', function() {
                const ulid = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the class and its student grades.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.delete(
                            `{{ url('admin/schools') }}/{{ $school->ulid }}/classes/${ulid}`, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(res => {
                            classesTable.ajax.reload(null, false);
                            Swal.fire('Deleted!', res.data.message || 'Class deleted.',
                                'success');
                        }).catch(err => {
                            Swal.fire('Error!', err.response?.data?.message ||
                                'Failed to delete class.', 'error');
                        });
                    }
                });
            });

            // ---------------------- Subjects DataTable ----------------------
            const subjectsTable = $('#subjects-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('schools.subjects.index', $school->ulid) }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                responsive: true,
                paging: true,
                lengthChange: true,
                pageLength: 10
            });

            $('#subjects-table').on('click', '.delete-subject', function() {
                const ulid = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the subject.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.delete(
                            `{{ url('admin/schools') }}/{{ $school->ulid }}/subjects/${ulid}`, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(res => {
                            subjectsTable.ajax.reload(null, false);
                            Swal.fire('Deleted!', res.data.message || 'Subject deleted.',
                                'success');
                        }).catch(err => {
                            Swal.fire('Error!', err.response?.data?.message ||
                                'Failed to delete subject.', 'error');
                        });
                    }
                });
            });

        });
    </script>
@endpush
