<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('state')->get();
        return view('admin.schools.index', compact('schools'));
    }

    // public function show(School $school)
    // {
    //     return view('admin.schools.show', compact('school'));
    // }

    public function create()
    {
        $states = State::all();
        return view('admin.schools.create', compact('states'));
    }

    public function store(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            'state_id' => 'required|exists:states,id',
            // 'address' => 'required|string|max:55',
            // 'zipcode' => 'required|string|max:7',
        ]);

        School::create($request->all());
        return redirect()->route('schools.index')->with('success', 'School added!');
    }

    public function edit(School $school)
    {
        $states = State::all();
        return view('admin.schools.edit', compact('school', 'states'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            'state_id' => 'required|exists:states,id',
            // 'address' => 'required|string|max:55',
            // 'zipcode' => 'required|string|max:7',
        ]);

        $school->update($request->all());
        return redirect()->route('schools.index')->with('success', 'School updated!');
    }

    /**
     * Cascade delete School → Classes → Subjects
     */
    public function destroy(School $school)
    {
        try {
            // Load related data
            $school->load('classes', 'subjects');

            // Delete all classes first
            if ($school->classes()->exists()) {
                $school->classes()->delete();
            }

            // Delete all subjects next
            if ($school->subjects()->exists()) {
                $school->subjects()->delete();
            }

            // Finally delete the school itself
            $school->delete();

            return redirect()
                ->route('schools.index')
                ->with('success', 'School and all related classes and subjects deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('School delete error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return redirect()
                ->route('schools.index')
                ->with('error', 'Error while deleting school and its related data.');
        }
    }
}
