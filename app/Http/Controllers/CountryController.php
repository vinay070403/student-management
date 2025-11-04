<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * Cascade delete Country → States → Schools → Classes → Subjects
     * Handles both normal and AJAX requests
     */
    public function destroy(Country $country)
    {
        try {
            $country->load('states.school.classes', 'states.school.subjects');

            foreach ($country->states as $state) {
                foreach ($state->school as $school) {

                    if ($school->classes()->exists()) {
                        $school->classes()->delete();
                    }
                    if ($school->subjects()->exists()) {
                        $school->subjects()->delete();
                    }
                    $school->delete();
                }
                $state->delete();
            }
            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country and all related states, schools, classes, and subjects deleted successfully.'
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
