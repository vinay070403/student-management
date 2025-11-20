<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function states($countryId)
    {
        $country = Country::with('states')->findOrFail($countryId);
        return response()->json(['states' => $country->states]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Country::create($request->only('name'));
        return redirect()->route('countries.index')->with('success', 'Country added!');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country->update($request->only('name'));
        return redirect()->route('countries.index')->with('success', 'Country updated!');
    }
    /**
     * Cascade delete Country → States → Schools → Classes → Subjects → Grades
     * Handles both normal and AJAX requests
     */
    public function destroy(Country $country)
    {
        try {
            // Load all nested relationships
            $country->load('states.school.classes', 'states.school.subjects', 'states.school.grades');

            foreach ($country->states as $state) {
                foreach ($state->school as $school) {

                    // 🟢 Delete all related grades first
                    if ($school->grades()->exists()) {
                        $school->grades()->delete();
                    }

                    // 🟢 Delete classes and subjects
                    if ($school->classes()->exists()) {
                        $school->classes()->delete();
                    }
                    if ($school->subjects()->exists()) {
                        $school->subjects()->delete();
                    }

                    // 🟢 Finally delete the school
                    $school->delete();
                }

                // 🟢 Delete the state after its schools are gone
                $state->delete();
            }

            // 🟢 Finally delete the country
            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country and all related states, schools, classes, subjects, and grades deleted successfully.'
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Country destroy error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'Server error while deleting country.'
            ], 500);
        }
    }
}
