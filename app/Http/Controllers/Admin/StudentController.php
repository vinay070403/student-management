<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\Country;
use App\Models\Schoolclass;
use App\Models\School;
use App\Models\Subject;
use App\Models\StudentGrade;
use App\Models\User;
use App\Models\GradeScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller // implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:student-list|student-create|student-edit|student-delete', only: ['index', 'show']),
            new Middleware('permission:student-create', only: ['create', 'store']),
            new Middleware('permission:student-edit', only: ['edit', 'update']),
            new Middleware('permission:student-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    // ------------------------
    // CRUD: Students
    // ------------------------
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Base query: only students
            $students = User::role('Student')->with('school')->select(
                'id',
                'ulid',
                'first_name',
                'last_name',
                'email',
                'avatar',
                'status',
                'school_id',
                'created_at'
            );

            // Custom search
            $search = $request->input('search');
            if (!empty($search)) {
                $students->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }


            return DataTables::of($students)
                ->addColumn('student', function ($student) {
                    $avatar = $student->avatar
                        ? asset('storage/' . $student->avatar)
                        : asset('assets/images/default-avatar.png');

                    return '
                <div class="d-flex align-items-center">
                    <img src="' . $avatar . '" class="me-3 border shadow-sm" width="48" height="48"
                        style="object-fit: cover; border-radius: 0;">

                    <div style="line-height: 1.4;">
                        <div class="fw-bold text-dark" style="font-size: 15px;">' . e($student->first_name . ' ' . $student->last_name) . '</div>

                        <div class="text-muted" style="font-size: 13px; margin-top: 3px;">
                            <strong>Email:</strong> ' . e($student->email) . '
                        </div>

                        <div class="text-muted" style="font-size: 13px; margin-top: 4px;">
                            <strong>School:</strong> ' . e($student->school?->name ?? 'No School Assigned') . '
                        </div>
                    </div>
                </div>';
                })
                ->addColumn('status', function ($student) {
                    $badge = $student->status ? 'success' : 'danger';
                    $text = $student->status ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $badge . '" style="border-radius:0; padding:6px 12px;">' . $text . '</span>';
                })
                ->addColumn('created_at', function ($student) {
                    return $student->created_at ? $student->created_at->format('d M Y, h:i A') : '';
                })
                ->addColumn('actions', function ($student) {
                    return view('admin.students.partials.student_actions', compact('student'))->render();
                })
                ->rawColumns(['student', 'status', 'actions'])
                ->make(true);
        }

        return view('admin.students.index');
    }

    // ------------------------
    // Create Student
    // ------------------------
    public function create()
    {
        $schools = School::all();
        $countries = Country::with('states')->get();
        return view('admin.students.create', compact('schools', 'countries'));
    }

    // ------------------------
    // Store Student
    // ------------------------
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:10|min:2',
            'last_name'  => 'required|string|max:10|min:2',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string',
            'dob'        => 'nullable|date',
            'avatar'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            // 'password'   => 'required|min:8',
        ]);

        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        }
        $data['password'] = Hash::make($request->password);
        $student = User::create($data);
        $student->assignRole('Student');

        return redirect()->route('students.index')->with('success', 'Student added!');
    }

    // ------------------------
    // Edit Student
    // ------------------------
    public function edit(User $student)
    {
        $schools = School::all();
        $countries = Country::with('states')->get();

        // Load related grades for summary
        $grades = $student->grades()->with('SchoolClass', 'subject', 'gradeScale')->get();

        return view('admin.students.edit', compact('student', 'schools', 'countries', 'grades'));
    }

    // ------------------------
    // Update Student Info)
    // ------------------------
    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:10|min:2',
            'last_name'  => 'required|string|max:10|min:2',
            'email'      => 'required|email|unique:users,email,' . $student->id,
            'phone'      => 'nullable|string',
            'dob'        => 'nullable|date',
            'avatar'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
                Storage::disk('public')->delete($student->avatar);
            }

            // Store new avatar in "avatar" folder
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['avatar'] = $file->storeAs('avatar', $filename, 'public'); // <-- avatar folder
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated!');
    }

    // ------------------------
    // Update Student Grades
    // ------------------------
    public function updateGrades(Request $request, User $student)
    {
        $request->validate([
            'schools' => 'required|array|min:1',
            'schools.*.school_name' => 'required|string|max:25',
            'schools.*.classes' => 'required|array|min:1',
            'schools.*.classes.*.class_name' => 'required|string|max:25',
            'schools.*.classes.*.subjects' => 'required|array|min:1',
            'schools.*.classes.*.subjects.*.subject_id' => 'required|string|max:25',
            'schools.*.classes.*.subjects.*.grade_id' => 'nullable|exists:grade_scales,id',
            'schools.*.classes.*.subjects.*.min_percentage' => 'nullable|numeric|min:0|max:100|required_with:schools.*.classes.*.subjects.*.max_percentage',
            'schools.*.classes.*.subjects.*.max_percentage' => 'nullable|numeric|min:0|max:100|gt:schools.*.classes.*.subjects.*.min_percentage|required_with:schools.*.classes.*.subjects.*.min_percentage',
        ]);

        $schools = $request->input('schools', []);

        foreach ($schools as $schoolData) {
            $school = School::firstOrCreate(['name' => $schoolData['school_name']]);

            foreach ($schoolData['classes'] as $classData) {
                $class = Schoolclass::firstOrCreate([
                    'school_id' => $school->id,
                    'name'      => $classData['class_name']
                ]);

                foreach ($classData['subjects'] as $subjectData) {
                    $subject = Subject::firstOrCreate([
                        'school_id' => $school->id,
                        'name'      => $subjectData['subject_name']
                    ]);

                    if (!empty($subjectData['grade_id'])) {
                        StudentGrade::updateOrCreate(
                            [
                                'student_id' => $student->id,
                                'class_id'   => $class->id,
                                'subject_id' => $subject->id,
                            ],
                            [
                                'grade_id'       => $subjectData['grade_id'],
                                'min_percentage' => $subjectData['min_percentage'] ?? null,
                                'max_percentage' => $subjectData['max_percentage'] ?? null,
                            ]
                        );
                    }
                }
            }
        }

        return back()->with('success', 'Student grades updated successfully!');
    }

    // ------------------------
    // Update Grades Inline (AJAX)
    // ------------------------
    public function updateGradesInline(Request $request, User $student)
    {
        $request->validate([
            'grades' => 'required|array|min:1',
            'grades.*.id' => 'required|exists:student_grades,id',
            'grades.*.subject_id' => 'required|exists:subjects,id',
            'grades.*.grade_id' => 'required|exists:grade_scales,id',
            'grades.*.min_score' => 'nullable|numeric|min:0|max:100|required_with:grades.*.max_score',
            'grades.*.max_score' => 'nullable|numeric|min:0|max:100|gt:grades.*.min_score|required_with:grades.*.min_score',

        ]);

        foreach ($request->grades as $g) {
            \App\Models\StudentGrade::where('id', $g['id'])
                ->where('student_id', $student->id)
                ->update([
                    'subject_id' => $g['subject_id'],
                    'grade_id'   => $g['grade_id'],
                    'min_percentage' => $g['min_score'] ?? null,
                    'max_percentage' => $g['max_score'] ?? null,
                ]);
        }

        return response()->json(['message' => 'Grades updated successfully.']);
    }

    // ------------------------
    // Assign School (AJAX)
    // ------------------------
    public function assignSchool(Request $request, User $student)
    {
        // incoming school_id is ULID from the frontend select
        $request->validate([
            'school_id' => 'required|string|exists:schools,ulid',
        ]);

        // resolve numeric id from ULID safely
        $school = School::where('ulid', $request->school_id)->first();

        if (! $school) {
            return response()->json(['success' => false, 'message' => 'School not found.'], 404);
        }

        $student->school_id = $school->id; // numeric id column
        $student->save();

        return response()->json(['success' => true]);
    }

    // ------------------------
    // Load Grades, Classes, Subjects for Student (AJAX)
    // ------------------------
    public function gradesSections(Request $request, $studentId, $schoolId)
    {
        $student = User::where('ulid', $studentId)->firstOrFail();

        $school = School::with([
            'classes:id,school_id,name',
            'subjects:id,school_id,name',
            'gradeScales:id,school_id,grade,min_score,max_score'
        ])->findOrFail($schoolId);

        $grades = $school->gradeScales->map(fn($g) => [
            'id' => $g->id,
            'grade' => $g->grade,
            'min_score' => $g->min_score,
            'max_score' => $g->max_score,
        ]);

        if (!$request->has('load_existing')) {
            return response()->json([
                'classes'  => $school->classes,
                'subjects' => $school->subjects,
                'grades'   => $grades,
            ]);
        }

        $studentGrades = StudentGrade::with(['Schoolclass', 'subject', 'gradeScale'])
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('class_id');

        $savedClasses = [];

        foreach ($studentGrades as $classId => $gradesGroup) {
            $class = $gradesGroup->first()->Schoolclass;

            $savedClasses[] = [
                'id' => $classId,
                'name' => $class?->name ?? 'Unknown Class',
                'subjects' => $gradesGroup->map(fn($g) => [
                    'subject_id' => $g->subject_id,
                    'grade_id' => $g->grade_id,
                    'min_score' => $g->min_score,
                    'max_score' => $g->max_score,
                ])->values(),
            ];
        }

        return response()->json([
            'saved_classes' => $savedClasses,
            'subjects' => $school->subjects,
            'grades' => $grades,
        ]);
    }

    // ------------------------
    // Store Student Grades (AJAX)
    // ------------------------
    // Before: public function storeGrades($studentId, Request $request)
    public function storeGrades(User $student, Request $request)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.class_id' => 'required|integer',
            'grades.*.subject_id' => 'required|integer',
            'grades.*.grade_id' => 'required|integer',
            'grades.*.min_score' => 'nullable|numeric|min:0|max:100|required_with:grades.*.max_score',
            'grades.*.max_score' => 'nullable|numeric|min:0|max:100|gt:grades.*.min_score|required_with:grades.*.min_score',
        ]);

        foreach ($validated['grades'] as $data) {
            StudentGrade::updateOrCreate(
                [
                    'student_id' => $student->id,      // Use numeric ID
                    'class_id'   => $data['class_id'],
                    'subject_id' => $data['subject_id'],
                ],
                [
                    'grade_id'    => $data['grade_id'],
                    'min_percentage' => $data['min_score'] ?? null,
                    'max_percentage' => $data['max_score'] ?? null,
                ]
            );
        }

        // Return the updated grades immediately
        $grades = $student->grades()
            ->with('Schoolclass:id,name', 'subject:id,name', 'gradeScale:id,grade,min_score,max_score')
            ->get()
            ->map(function ($g) {
                return [
                    'id' => $g->id,
                    'class_name' => $g->Schoolclass->name ?? '',
                    'subject_name' => $g->subject->name ?? '',
                    'grade' => $g->gradeScale->grade ?? '',
                    'min_score' => $g->min_percentage ?? $g->gradeScale->min_score ?? '',
                    'max_score' => $g->max_percentage ?? $g->gradeScale->max_score ?? '',
                ];
            });

        return response()->json(['success' => true]);
    }

    // ------------------------
    // Load saved grades for student (AJAX)
    // ------------------------
    public function loadGrades(User $student)
    {
        $grades = $student->grades()
            ->with('Schoolclass:id,name', 'subject:id,name', 'gradeScale:id,grade,min_score,max_score')
            ->get()
            ->map(function ($g) {
                return [
                    'id' => $g->id,
                    'class_name' => $g->Schoolclass->name ?? '',
                    'subject_name' => $g->subject->name ?? '',
                    'grade' => $g->gradeScale->grade ?? '',
                    'min_score' => $g->gradeScale->min_score ?? '',
                    'max_score' => $g->gradeScale->max_score ?? '',
                ];
            });

        return response()->json(['grades' => $grades]);
    }

    // ------------------------
    // Delete Class and its Subjects/Grades (AJAX)
    // ------------------------
    public function deleteClass(Request $request, $studentId)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
        ]);

        $student = User::where('ulid', $studentId)->firstOrFail();

        StudentGrade::where('student_id', $student->id)
            ->where('class_id', $request->class_id)
            ->delete();

        return response()->json(['success' => true]);
    }
    // ------------------------
    // Delete Subject (AJAX)
    // ------------------------
    public function deleteSubject($studentId, Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);

        $student = User::where('ulid', $studentId)->firstOrFail();

        StudentGrade::where('student_id', $student->id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->delete();

        return response()->json(['success' => true]);
    }

    // ------------------------
    // Delete Grade (AJAX)
    // ------------------------
    public function destroyGrade(User $student, $gradeId)
    {
        $grade = StudentGrade::where('student_id', $student->id)
            ->where('id', $gradeId)
            ->firstOrFail();
        $grade->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Delete student and their related grades
     */
    public function destroy(User $student)
    {
        try {
            // If Student has related grades
            if ($student->grades()->exists()) {
                $student->grades()->delete();
            }

            // Now delete the student
            $student->delete();

            return redirect()
                ->route('students.index')
                ->with('success', 'Student and all related grades deleted successfully!');
        } catch (\Throwable $e) {
            Log::error('Student delete error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());

            return redirect()
                ->route('students.index')
                ->with('error', 'Server error while deleting student.');
        }
    }
}
