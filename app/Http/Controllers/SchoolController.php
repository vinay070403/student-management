<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\State;
use App\Models\GradeScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    
    public function index()
    {
        $schools = School::with('state')->get();
        return view('admin.schools.index', compact('schools'));
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
            'grade.*' => 'nullable|string|max:3|min:1',
            'min.*' => 'nullable|numeric|min:0',
            'max.*' => 'nullable|numeric|min:0',
            'point.*' => 'nullable|numeric|min:0|max:10',
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
                        $min = $request->min[$index] ?? 0;
                        $max = $request->max[$index] ?? 0;

                        // Validate range only if both provided
                        if ($min && $max && $min >= $max) {
                            return back()->with('error', "Row " . ($index + 1) . ": Min must be less than Max.")->withInput();
                        }

                        // Check overlap
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
            return redirect()->route('admin.schools.edit')->with('success', 'School added successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating school: ' . $e->getMessage());
            return back()->with('error', 'Failed to create school.')->withInput();
        }
    }

    public function edit(School $school)
    {
        $states = State::all();
        // Classes aur Subjects ko load kar lo
        $school->load(['classes', 'subjects']);
        $school->load('gradeScales');
        return view('admin.schools.edit', compact('school', 'states'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            'state_id' => 'required|exists:states,id',
            'grade.*' => 'nullable|string|max:3|min:1',
            'min.*' => 'nullable|numeric|min:0',
            'max.*' => 'nullable|numeric|min:0',
            'point.*' => 'nullable|numeric|min:0|max:10',
        ]);

        DB::beginTransaction();
        try {
            // ✅ Update school info
            $school->update([
                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);

            // ✅ Replace grade scales (optional)
            $school->gradeScales()->delete();

            if ($request->filled('grade')) {
                $ranges = [];
                foreach ($request->grade as $index => $grade) {
                    if (!empty($grade)) {
                        $min = $request->min[$index] ?? 0;
                        $max = $request->max[$index] ?? 0;

                        if ($min && $max && $min >= $max) {
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
            return redirect()->route('admin.schools.edit')->with('success', 'School updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating school: ' . $e->getMessage());
            return back()->with('error', 'Failed to update school.')->withInput();
        }
    }

    public function destroy(School $school)
    {
        try {
            $school->load('classes', 'subjects', 'gradeScales');

            if ($school->classes()->exists()) {
                $school->classes()->delete();
            }

            if ($school->subjects()->exists()) {
                $school->subjects()->delete();
            }

            if ($school->gradeScales()->exists()) {
                $school->gradeScales()->delete();
            }

            $school->delete();

            return redirect()
                ->route('schools.index')
                ->with('success', 'School and related data deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('School delete error: ' . $e->getMessage());
            return redirect()
                ->route('schools.index')
                ->with('error', 'Error deleting school.');
        }
    }

    public function getByState($stateId)
    {
        $schools = \App\Models\School::where('state_id', $stateId)->get(['id', 'name']);
        return response()->json(['schools' => $schools]);
    }
}
