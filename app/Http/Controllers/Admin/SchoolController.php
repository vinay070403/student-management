<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\State;
use App\Models\GradeScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SchoolController extends Controller implements HasMiddleware
{
    /**
     * Permission middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:school-list', only: ['index', 'show']),
            new Middleware('permission:school-create', only: ['create', 'store']),
            new Middleware('permission:school-edit', only: ['edit', 'update']),
            new Middleware('permission:school-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $schools = School::select(
                'id',
                'ulid',
                'state_id',
                'name',
                'created_at'
            )
                ->with('state:id,name');

            // Custom search support
            $search = $request->input('custom_search');

            if (!empty($search)) {
                $schools->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }


            return datatables()->of($schools)
                ->addColumn('checkbox', function ($school) {
                    return '<input type="checkbox" class="select-school" data-id="' . $school->id . '">';
                })

                ->addColumn('school_name', function ($school) {
                    return '<span class="fw-semibold">' . e($school->name) . '</span>';
                })

                ->addColumn('state', function ($school) {
                    return $school->state ? e($school->state->name) : '-';
                })

                ->addColumn('created_at', function ($school) {
                    return $school->created_at
                        ? $school->created_at->format('d M Y, h:i A')
                        : '';
                })

                ->addColumn('actions', function ($school) {
                    return view('admin.schools.partials.actions', compact('school'))->render();
                })

                ->rawColumns(['checkbox', 'school_name', 'actions'])
                ->make(true);
        }

        return view('admin.schools.index');
    }
    public function create()
    {
        $states = State::all();
        return view('admin.schools.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            'state_id' => 'required|exists:states,id',

            // Grade validation with relation rules
            'grade.*' => 'nullable|string|max:3|min:1|required_with:min.*,max.*,point.*',
            'min.*'   => 'nullable|numeric|min:0|required_with:grade.*',
            'max.*'   => 'nullable|numeric|min:0|gt:min.*|required_with:grade.*',
            'point.*' => 'nullable|numeric|min:0|max:10|required_with:grade.*',
        ]);

        DB::beginTransaction();
        try {
            // ✅ Create the school
            $school = School::create([
                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);

            // ✅ Create grade scales if any exist
            if ($request->filled('grade')) {
                $ranges = [];
                foreach ($request->grade as $index => $grade) {
                    if (!empty($grade)) {
                        $min = $request->min[$index] ?? null;
                        $max = $request->max[$index] ?? null;

                        // ✅ Strict min-max validation
                        if (!is_null($min) && !is_null($max) && $min >= $max) {
                            return back()->with('error', "Row " . ($index + 1) . ": Min must be less than Max.")->withInput();
                        }

                        // ✅ Check overlap with previously added ranges
                        foreach ($ranges as $range) {
                            if ($min <= $range['max'] && $max >= $range['min']) {
                                return back()->with('error', "Overlap detected between {$min}-{$max} and {$range['min']}-{$range['max']}")->withInput();
                            }
                        }

                        $ranges[] = ['min' => $min, 'max' => $max];

                        GradeScale::create([
                            'school_id'   => $school->id,
                            'grade'       => $grade,
                            'min_score'   => $min,
                            'max_score'   => $max,
                            'grade_point' => $request->point[$index] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.schools.edit', $school->id)
                ->with('success', 'School added successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating school: ' . $e->getMessage());
            return back()->with('error', 'Failed to create school.')->withInput();
        }
    }
    public function edit(School $school)
    {
        $states = State::all();

        // Eager load relations with only needed fields
        $school->load([
            'classes:id,school_id,ulid,name',        // Classes with ULID
            'subjects:id,school_id,ulid,name',      // Subjects with ULID
            'gradeScales:id,school_id,grade,min_score,max_score,grade_point'
        ]);

        return view('admin.schools.edit', compact('school', 'states'));
    }
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            'state_id' => 'required|exists:states,id',

            // Same stricter grade validation rules
            'grade.*' => 'nullable|string|max:3|min:1|required_with:min.*,max.*,point.*',
            'min.*'   => 'nullable|numeric|min:0|required_with:grade.*',
            'max.*'   => 'nullable|numeric|min:0|gt:min.*|required_with:grade.*',
            'point.*' => 'nullable|numeric|min:0|max:10|required_with:grade.*',
        ]);

        DB::beginTransaction();
        try {
            // ✅ Update school info
            $school->update([
                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);

            // ✅ Replace grade scales
            $school->gradeScales()->delete();

            if ($request->filled('grade')) {
                $ranges = [];
                foreach ($request->grade as $index => $grade) {
                    if (!empty($grade)) {
                        $min = $request->min[$index] ?? null;
                        $max = $request->max[$index] ?? null;

                        if (!is_null($min) && !is_null($max) && $min >= $max) {
                            return back()->with('error', "Row " . ($index + 1) . ": Min must be less than Max.")->withInput();
                        }

                        foreach ($ranges as $range) {
                            if ($min <= $range['max'] && $max >= $range['min']) {
                                return back()->with('error', "Overlap detected between {$min}-{$max} and {$range['min']}-{$range['max']}")->withInput();
                            }
                        }

                        $ranges[] = ['min' => $min, 'max' => $max];

                        GradeScale::create([
                            'school_id'   => $school->id,
                            'grade'       => $grade,
                            'min_score'   => $min,
                            'max_score'   => $max,
                            'grade_point' => $request->point[$index] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.schools.edit', $school->id)
                ->with('success', 'School updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating school: ' . $e->getMessage());
            return back()->with('error', 'Failed to update school.')->withInput();
        }
    }
    public function destroy(School $school)
    {
        DB::beginTransaction();

        try {
            // Set school_id = NULL for users of this school
            DB::table('users')
                ->where('school_id', $school->id)
                ->update(['school_id' => null]);

            // Load relations
            $school->load('classes', 'subjects', 'gradeScales');

            // Delete related records
            if ($school->classes()->exists()) {
                $school->classes()->delete();
            }

            if ($school->subjects()->exists()) {
                $school->subjects()->delete();
            }

            if ($school->gradeScales()->exists()) {
                $school->gradeScales()->delete();
            }

            // 🔥 Step 2: Delete the school
            $school->delete();

            DB::commit();

            return redirect()
                ->route('schools.index')
                ->with('success', 'School and related data deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('School delete error: ' . $e->getMessage());

            return redirect()
                ->route('schools.index')
                ->with('error', 'Error deleting school.');
        }
    }
    public function getByState($stateUlid)
    {
        $state = State::where('ulid', $stateUlid)->first();

        if (!$state) {
            return response()->json(['schools' => []]);
        }

        $schools = $state->schools()->get(['ulid', 'name']); // use ULID for school
        return response()->json(['schools' => $schools]);
    }
}
