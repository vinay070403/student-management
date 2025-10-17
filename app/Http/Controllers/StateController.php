<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')->get();
        return view('admin.states.index', compact('states'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25|min:4',
            // 'code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
        ]);

        State::create($request->all());
        return redirect()->route('states.index')->with('success', 'State added!');
    }

    public function edit(State $state)
    {
        $countries = Country::all();
        return view('admin.states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
        ]);

        $state->update($request->all());
        return redirect()->route('states.index')->with('success', 'State updated!');
    }

    /**
     * Cascade delete State → Schools → Classes → Subjects
     */
    public function destroy(State $state)
    {
        try {
            // Load deep relations
            $state->load('school.classes', 'school.subjects');

            // Delete schools and their related data
            foreach ($state->school as $school) {

                // Delete all classes under this school
                if ($school->classes()->exists()) {
                    $school->classes()->delete();
                }

                // Delete all subjects under this school
                if ($school->subjects()->exists()) {
                    $school->subjects()->delete();
                }

                // Delete the school itself
                $school->delete();
            }

            // Finally delete the state
            $state->delete();

            // Redirect back with success message
            return redirect()->route('states.index')->with('success', 'State and all related schools, classes, and subjects deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('State delete error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('states.index')->with('error', 'Error while deleting state and its related data.');
        }
    }
}
