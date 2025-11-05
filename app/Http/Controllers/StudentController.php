<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\Country;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\GradeScale;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    // ------------------------
    // CRUD: Students
    // ------------------------
    public function index()
    {
        $students = User::role('Student')->with('school')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $schools = School::all();
        $countries = Country::with('states')->get();
        return view('admin.students.create', compact('schools', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:10|min:2',
            'last_name'  => 'required|string|max:10|min:2',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string',
            'dob'        => 'nullable|date',
            'avatar'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'password'   => 'required|min:8',
        ]);

        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $data['password'] = Hash::make($request->password);
        $student = User::create($data);
        $student->assignRole('Student');

        return redirect()->route('students.index')->with('success', 'Student added!');
    }

    public function edit(User $student)
    {
        $schools = School::all();
        $countries = Country::with('states')->get();

        // Load related grades for summary
        $grades = $student->grades()->with('classModel', 'subject', 'gradeScale')->get();

        return view('admin.students.edit', compact('student', 'schools', 'countries', 'grades'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:10|min:2',
            'last_name'  => 'required|string|max:10|min:2',
            'email'      => 'required|email|unique:users,email,' . $student->id,
            'phone'      => 'nullable|string',
            'dob'        => 'nullable|date',
            'avatar'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'password'   => 'nullable|min:8',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated!');
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
            'schools.*.classes.*.subjects.*.min_percentage' => 'nullable|numeric',
            'schools.*.classes.*.subjects.*.max_percentage' => 'nullable|numeric',
        ]);

        $schools = $request->input('schools', []);

        foreach ($schools as $schoolData) {
            $school = School::firstOrCreate(['name' => $schoolData['school_name']]);

            foreach ($schoolData['classes'] as $classData) {
                $class = ClassModel::firstOrCreate([
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

    public function updateGradesInline(Request $request, User $student)
    {
        $request->validate([
            'grades' => 'required|array|min:1',
            'grades.*.id' => 'required|exists:student_grades,id',
            'grades.*.subject_id' => 'required|exists:subjects,id',
            'grades.*.grade_id' => 'required|exists:grade_scales,id',
            'grades.*.min_score' => 'nullable|numeric',
            'grades.*.max_score' => 'nullable|numeric',
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
        $request->validate([
            'school_id' => 'required|exists:schools,id',
        ]);

        $student->school_id = $request->school_id;
        $student->save();

        return response()->json(['success' => true]);
    }

    public function gradesSections(Request $request, $studentId, $schoolId)
    {
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

        // 🟢 Case 1: Only load data for "Add Class" dropdown
        if (!$request->has('load_existing')) {
            return response()->json([
                'classes'  => $school->classes,
                'subjects' => $school->subjects,
                'grades'   => $grades,
            ]);
        }

        // 🟢 Case 2: Load student's saved grades
        $studentGrades = \App\Models\StudentGrade::with(['classModel', 'subject', 'gradeScale'])
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('class_id');

        $savedClasses = [];

        foreach ($studentGrades as $classId => $gradesGroup) {
            $class = $gradesGroup->first()->classModel; // <-- use classModel
            $savedClasses[] = [
                'id' => $classId,
                'name' => $class?->name ?? 'Unknown Class', // fallback
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
    public function storeGrades($studentId, Request $request)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.class_id' => 'required|integer',
            'grades.*.subject_id' => 'required|integer',
            'grades.*.grade_id' => 'required|integer',
            'grades.*.min_score' => 'nullable|numeric',
            'grades.*.max_score' => 'nullable|numeric',
        ]);

        foreach ($validated['grades'] as $data) {
            StudentGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $data['class_id'],
                    'subject_id' => $data['subject_id'],
                ],
                [
                    'grade_id' => $data['grade_id'],
                    'min_score' => $data['min_score'],
                    'max_score' => $data['max_score'],
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    // ------------------------
    // Load saved grades for student (AJAX)
    // ------------------------
    public function loadGrades(User $student)
    {
        $grades = $student->grades()
            ->with('classModel:id,name', 'subject:id,name', 'gradeScale:id,grade,min_score,max_score')
            ->get()
            ->map(function ($g) {
                return [
                    'id' => $g->id,
                    'class_name' => $g->classModel->name ?? '',
                    'subject_name' => $g->subject->name ?? '',
                    'grade' => $g->gradeScale->grade ?? '',
                    'min_score' => $g->gradeScale->min_score ?? '',
                    'max_score' => $g->gradeScale->max_score ?? '',
                ];
            });

        return response()->json(['grades' => $grades]);
    }

    public function deleteSubject($studentId, Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);

        StudentGrade::where('student_id', $studentId)
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
}
