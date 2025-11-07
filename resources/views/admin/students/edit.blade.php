@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- <div class="card shadow-sm mb-6"> -->
        <div class="p-4 bg-white border-2 rounded-4 shadow-lg mb-5 mb-xl-10" style="border-color: #adb5bd;">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title mb-0">
                    <i class="fa-solid fa-users-gear"></i>
                    Edit Student Details
                </h3>
                <a href="{{ route('students.index') }}" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
            </div>

            {{-- Validation & Success Messages --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="p-4 bg-white border rounded-3 mb-5" style="border-color: #dee2e6;">
                {{-- Tabs --}}
                <ul class="nav nav-tabs mb-4" id="studentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button" role="tab">Grades</button>
                    </li>
                </ul>

                <div class="tab-content" id="studentTabContent">
                    {{-- Details Tab --}}
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control form-control-lg" value="{{ $student->first_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control form-control-lg" value="{{ $student->last_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg" value="{{ $student->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label for="phone" class="form-label">Phone</label>
                                        <div class="input-group"> <select name="phone_code" class="form-select form-select-lg" style="max-width: 90px;">
                                                <option value="+91">+91</option>
                                                <!-- More codes if needed -->
                                            </select> <input type="text" name="phone" class="form-control form-control-lg" pattern="\d{10}" placeholder="1234567890" maxlength="10"> </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control form-control-lg" value="{{ $student->dob }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Avatar</label>
                                    <input type="file" name="avatar" class="form-control form-control-lg">
                                    @if ($student->avatar)
                                    <img src="{{ asset('storage/' . $student->avatar) }}"
                                        alt="Avatar" class="img-thumbnail mt-2" style="max-width: 100px;">
                                    @endif

                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control form-control-lg" value="{{ $student->address }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-dark py-3 px-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Grades Tab --}}
                    <div class="tab-pane fade" id="grades" role="tabpanel">
                        <!-- <h5 class="fw-bold fs-5">Assign School</h5> -->

                        @php $hasSchool = (bool) $student->school_id; @endphp

                        {{-- Country/State/School selects --}}
                        <div id="school-select-area" class="row g-3 mb-4" @if($hasSchool) style="display:none;" @endif>
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <select id="select-country" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <select id="select-state" class="form-select" disabled>
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">School</label>
                                <select id="select-school" class="form-select" disabled>
                                    <option value="">Select School</option>
                                </select>
                            </div>
                            <div id="save-school-container" class="col-12 mt-2 d-none">
                                <button id="btn-save-school" class="btn btn-dark">Save & Next</button>
                            </div>
                        </div>

                        {{-- School info + Add Class --}}
                        <div id="school-actions" class="mb-3 d-flex align-items-center justify-content-between" @if(!$hasSchool) style="display:none;" @endif>
                            <span class="fw-bold fs-4">
                                School : <span id="school-name">@if($student->school){{ $student->school->name }}@endif</span>
                            </span>

                            <div>
                                <button id="btn-add-class" class="btn btn-light border py-3 px-3 d-flex align-items-center gap-2 rounded-3"> + Add Class</button>
                            </div>
                        </div>

                        {{-- Grades Sections Container --}}
                        <div id="grades-sections-container"></div>

                        {{-- Add Class Modal --}}
                        <div class="modal fade" id="modal-add-class" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Select Class</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <select id="select-new-class" class="form-select">
                                            <option value="">Select Class</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-add-class-confirm" class="btn btn-dark">Add Class</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.15.3/tingle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const studentId = "{{ $student->id }}";
        const csrfToken = "{{ csrf_token() }}";

        let savedSchool = JSON.parse('{!! addslashes(json_encode($student->school ?? null)) !!}');
        let selectedSchoolId = null;

        const countrySelect = $('#select-country');
        const stateSelect = $('#select-state');
        const schoolSelect = $('#select-school');
        const saveSchoolContainer = $('#save-school-container');
        const btnSaveSchool = $('#btn-save-school');
        const schoolActions = $('#school-actions');
        const schoolNameSpan = $('#school-name');
        const sectionsContainer = $('#grades-sections-container');
        const addClassBtn = $('#btn-add-class');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // ------------------------------ COUNTRY → STATE → SCHOOL ------------------------------
        countrySelect.on('change', function() {
            const id = $(this).val();
            stateSelect.html('<option value="">Select State</option>').prop('disabled', true);
            schoolSelect.html('<option value="">Select School</option>').prop('disabled', true);
            saveSchoolContainer.addClass('d-none');
            if (!id) return;
            $.getJSON(`/admin/countries/${id}/states`, data => {
                data.states?.forEach(s => stateSelect.append(`<option value="${s.id}">${s.name}</option>`));
                stateSelect.prop('disabled', false);
            }).fail(() => alert('Error fetching states'));
        });

        stateSelect.on('change', function() {
            const id = $(this).val();
            schoolSelect.html('<option value="">Select School</option>').prop('disabled', true);
            saveSchoolContainer.addClass('d-none');
            if (!id) return;
            $.getJSON(`/admin/states/${id}/schools`, data => {
                data.schools?.forEach(s => schoolSelect.append(`<option value="${s.id}">${s.name}</option>`));
                schoolSelect.prop('disabled', false);
            }).fail(() => alert('Error fetching schools'));
        });

        schoolSelect.on('change', function() {
            selectedSchoolId = $(this).val();
            selectedSchoolId ? saveSchoolContainer.removeClass('d-none') : saveSchoolContainer.addClass('d-none');
        });

        btnSaveSchool.on('click', function(e) {
            e.preventDefault();
            if (!selectedSchoolId) return alert('Please select a school.');

            $.post(`/admin/students/${studentId}/assign-school`, {
                    school_id: selectedSchoolId
                })
                .done(() => {
                    const schoolText = $('#select-school option:selected').text();
                    savedSchool = {
                        id: selectedSchoolId,
                        name: schoolText,
                        classes: []
                    };
                    schoolNameSpan.text(schoolText);
                    $('#school-select-area').hide();
                    schoolActions.show();
                    sectionsContainer.html('');
                    Swal.fire('Success!', 'School assigned successfully.', 'success');
                })
                .fail(() => Swal.fire('Error!', 'Unable to assign school.', 'error'));
        });

        if (savedSchool?.id) {
            schoolNameSpan.text(savedSchool.name);
            $('#school-select-area').hide();
            schoolActions.show();
        }

        // ------------------------------ ADD CLASS ------------------------------
        addClassBtn.on('click', function() {
            if (!savedSchool?.id) return Swal.fire('Oops!', 'Please assign a school first.', 'warning');

            $('#select-new-class').html('<option value="">Select Class</option>');

            $.getJSON(`/admin/students/${studentId}/grades-sections/${savedSchool.id}`, function(data) {
                data.classes?.forEach(cl => $('#select-new-class').append(`<option value="${cl.id}">${cl.name}</option>`));
                $('#modal-add-class').modal('show');
            });
        });

        $('#btn-add-class-confirm').on('click', function() {
            const classId = $('#select-new-class').val();
            const className = $('#select-new-class option:selected').text();

            if (!classId) return Swal.fire('Oops!', 'Select a class.', 'warning');

            $('#modal-add-class').modal('hide');

            if ($(`.class-section[data-class-id="${classId}"]`).length) {
                return Swal.fire('Oops!', 'This class section already exists.', 'warning');
            }

            const $section = $(`
            <div class="card mb-3 class-section" data-class-id="${classId}">
                
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Class: ${className}</h5>
                    </div>
                    <div class="subjects-container mb-2"></div>
                    <button class=btn btn-light btn-sm btn-add-subject mb-2">Add Subject</button>
                    
                </div>
            </div>
        `);
            sectionsContainer.append($section);

            loadClassSubjects($section, classId);
        });

        // ------------------------------ LOAD SUBJECTS ------------------------------
        function loadClassSubjects($section, classId) {
            $.getJSON(`/admin/students/${studentId}/grades-sections/${savedSchool.id}?class_id=${classId}`, function(data) {
                const $container = $section.find('.subjects-container');
                $container.empty();

                const subjects = data.subjects || [];
                const grades = data.grades || [];

                if (!subjects.length) {
                    return $container.append('<p class="text-muted">No subjects found for this class.</p>');
                }

                // Create and animate new row
                const $newRow = generateSubjectRow(subjects, grades);
                $container.append($newRow);

                // Trigger smooth animation (using CSS class)           &times;</button>
                setTimeout(() => $newRow.addClass('show'), 10);
            });
        }

        // ------------------------------ GENERATE SUBJECT ROW ------------------------------
        function generateSubjectRow(subjects = [], grades = [], selectedSubjectId = '', selectedGradeId = '', minScore = '', maxScore = '') {
            return $(`
        <div class="row g-2 mb-2 align-items-center subject-grade-row smooth-appear  bg-white p-2 rounded-3 shadow-sm">
            <div class="col-md-4">
                <select class="form-select form-select-sm subject-select">
                    <option value="">Select Subject</option>
                    ${subjects.map(s => `<option value="${s.id}" ${s.id == selectedSubjectId ? 'selected' : ''}>${s.name}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm grade-select">
                    <option value="">Select Grade</option>
                    ${grades.map(g => `<option value="${g.id}" data-min="${g.min_score}" data-max="${g.max_score}" ${g.id == selectedGradeId ? 'selected' : ''}>${g.grade}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control form-control-sm min-score" placeholder="Min" value="${minScore}" readonly>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control form-control-sm max-score" placeholder="Max" value="${maxScore}" readonly>
            </div>
            <div class="col-md-1 text-end">
                <button class="btn btn-light btn-sm rounded-5 btn-delete-subject">
               <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>
    `);
        }


        // ------------------------------ LOAD EXISTING GRADES ------------------------------
        if (savedSchool?.id) {
            $.getJSON(`/admin/students/${studentId}/grades-sections/${savedSchool.id}?load_existing=1`, function(data) {
                const savedClasses = data.saved_classes || [];

                savedClasses.forEach(cls => {
                    const $section = $(`
                    <div class="card mb-3 class-section" data-class-id="${cls.id}">
                        <div class="p-4 bg-light border rounded-4 shadow-sm mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4>Class: ${cls.name}</h4>
                                <button class="btn btn-light border py-2 px-2 rounded-3 btn-delete-section">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="subjects-container mb-4"></div>
                            <button class="btn btn-light btn-sm btn-add-subject mb-2">+ Add Subject</button>
                        </div>
                    </div>
                `);

                    sectionsContainer.append($section);

                    const $container = $section.find('.subjects-container');
                    cls.subjects.forEach(sub => {
                        const $row = generateSubjectRow(
                            data.subjects,
                            data.grades,
                            sub.subject_id ?? '',
                            sub.grade_id ?? '',
                            sub.min_score ?? '',
                            sub.max_score ?? ''
                        );
                        $container.append($row);

                        const $gradeSelect = $row.find('.grade-select');
                        const $selectedOption = $gradeSelect.find('option:selected');
                        $row.find('.min-score').val($selectedOption.data('min') ?? sub.min_score ?? '');
                        $row.find('.max-score').val($selectedOption.data('max') ?? sub.max_score ?? '');
                    });
                });

                // Add a single "Save All" button at the bottom if not exists
                if ($('#btn-save-all').length === 0) {
                    sectionsContainer.after(`
                    <div class="text-end mt-3">
                        <button id="btn-save-all" class="btn btn-dark">Save All</button>
                    </div>
                `);
                }
            });
        }

        // ------------------------------ ADD SUBJECT ------------------------------
        sectionsContainer.on('click', '.btn-add-subject', function() {
            const $section = $(this).closest('.class-section');
            const classId = $section.data('class-id');

            $.getJSON(`/admin/students/${studentId}/grades-sections/${savedSchool.id}?class_id=${classId}`, function(data) {
                const $container = $section.find('.subjects-container');
                const subjects = data.subjects || [];
                const grades = data.grades || [];
                $container.append(generateSubjectRow(subjects, grades));

            });
        });

        // ------------------------------ DELETE SUBJECT ------------------------------
        sectionsContainer.on('click', '.btn-delete-subject', function() {
            const $row = $(this).closest('.subject-grade-row');
            const subjectId = $row.find('.subject-select').val();
            const classId = $(this).closest('.class-section').data('class-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the subject row!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    if (subjectId) {
                        $.post(`/admin/students/${studentId}/delete-subject`, {
                            _token: csrfToken,
                            class_id: classId,
                            subject_id: subjectId
                        }).done(() => {
                            $row.remove();
                            Swal.fire('Deleted!', 'Subject deleted successfully.', 'success');
                        }).fail(() => Swal.fire('Error', 'Failed to delete subject.', 'error'));
                    } else {
                        $row.remove();
                        Swal.fire('Deleted!', 'Subject row removed.', 'success');
                    }
                }
            });
        });

        // ------------------------------ DELETE CLASS ------------------------------
        sectionsContainer.on('click', '.btn-delete-section', function() {
            const $section = $(this).closest('.class-section');
            const classId = $section.data('class-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the class and all its subjects/grades!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/students/${studentId}/delete-class`,
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            class_id: classId
                        },
                        success: function(res) {
                            $section.remove();
                            Swal.fire('Deleted!', 'Class and all related subjects/grades removed.', 'success');
                        },
                        error: function(err) {
                            console.error(err.responseJSON);
                            let msg = 'Failed to delete class.';
                            if (err.responseJSON && err.responseJSON.message) {
                                msg = err.responseJSON.message;
                            }
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });

        // ------------------------------ AUTO-FILL MIN/MAX ------------------------------
        sectionsContainer.on('change', '.grade-select', function() {
            const $row = $(this).closest('.subject-grade-row');
            const $selectedOption = $(this).find('option:selected');
            $row.find('.min-score').val($selectedOption.data('min') ?? '');
            $row.find('.max-score').val($selectedOption.data('max') ?? '');
        });

        // ------------------------------ SAVE ALL LOGIC ------------------------------
        $(document).on('click', '#btn-save-all', function() {
            const allData = [];

            $('.class-section').each(function() {
                const classId = $(this).data('class-id');
                $(this).find('.subjects-container .subject-grade-row').each(function() {
                    const subjectId = $(this).find('.subject-select').val();
                    const gradeId = $(this).find('.grade-select').val();
                    if (!subjectId || !gradeId) return; // skip incomplete rows

                    allData.push({
                        class_id: classId,
                        subject_id: subjectId,
                        grade_id: gradeId,
                        min_score: $(this).find('.min-score').val() || null,
                        max_score: $(this).find('.max-score').val() || null
                    });
                });
            });

            if (!allData.length) {
                return Swal.fire('Warning', 'No subjects/grades to save!', 'warning');
            }

            $.ajax({
                url: `/admin/students/${studentId}/storegrades`,
                method: 'POST',
                data: {
                    _token: csrfToken,
                    grades: allData
                },
                success: function(res) {
                    Swal.fire('Success', 'All grades saved successfully!', 'success');
                },
                error: function(err) {
                    console.error(err.responseJSON);
                    let msg = 'Something went wrong while saving.';
                    if (err.responseJSON && err.responseJSON.errors) {
                        msg = Object.values(err.responseJSON.errors).flat().join('<br>');
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });

    });
</script>
@endpush