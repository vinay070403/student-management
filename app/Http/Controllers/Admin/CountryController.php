<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;   // 16,22,21,15,17,13
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $countries = Country::select(
                'id',
                'ulid',
                'name',
                'created_at'
            );

            return DataTables::of($countries)
                ->addColumn('actions', function ($country) {
                    return view('admin.countries.partials.country_actions', compact('country'))->render();
                })

                ->addColumn('created_at', function ($country) {
                    return $country->created_at ? $country->created_at->format('d M Y, h:i A') : '';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.countries.index');
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Country::create($request->only('name'));

        return redirect()->route('countries.index')->with('success', 'Country added!');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate(['name' => 'required|string|max:25']);
        $country->update($request->only('name'));

        return redirect()->route('countries.index')->with('success', 'Country updated!');
    }

    public function destroy(Country $country)
    {
        try {
            $country->load('states.school.classes', 'states.school.subjects', 'states.school.gradeScales');

            foreach ($country->states as $state) {
                foreach ($state->school as $school) {
                    $school->gradeScales()->delete();
                    $school->classes()->delete();
                    $school->subjects()->delete();
                    $school->delete();
                }
                $state->delete();
            }

            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country and all related data deleted successfully.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Country delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete.'], 500);
        }
    }

    /**
     * Bulk delete countries
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:countries,id'
        ]);

        try {
            $countries = Country::whereIn('id', $request->ids)->get();

            foreach ($countries as $country) {
                // Load related data
                $country->load('states.school.classes', 'states.school.subjects', 'states.school.gradeScales');

                foreach ($country->states as $state) {
                    foreach ($state->school as $school) {
                        $school->gradeScales()->delete();
                        $school->classes()->delete();
                        $school->subjects()->delete();
                        $school->delete();
                    }
                    $state->delete();
                }

                $country->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Selected countries and all related data deleted successfully.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Bulk country delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete selected countries.'], 500);
        }
    }
}
