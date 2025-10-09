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
     * Cascade delete Country → States → Schools
     * Handles both normal and AJAX requests
     */
    public function destroy(Country $country)
    {
        try {
            // load relations
            $country->load('states.school');

            // delete schools then states then country
            foreach ($country->states as $state) {
                $state->school()->delete();
            }
            $country->states()->delete();
            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country and related states & schools deleted successfully.'
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
