<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CountryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                'permission:country-list|country-create|country-edit|country-delete',
                only: ['index', 'show']
            ),

            new Middleware(
                'permission:country-create',
                only: ['create', 'store']
            ),

            new Middleware(
                'permission:country-edit',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:country-delete',
                only: ['destroy', 'bulkDelete']
            ),
        ];
    }

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

                // ADD EDIT & DELETE BUTTONS DIRECTLY HERE
                ->addColumn('actions', function ($country) {

                    $key = $country->ulid ?: $country->id;

                    $editUrl = route('countries.edit', $key);

                    return '
                    <div class="d-inline-flex gap-2">

                        <a href="' . $editUrl . '"
                           class="btn btn-sm "
                           title="Edit">
                           <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm  delete-country-btn"
                                data-id="' . $key . '"
                                title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                        </button>

                    </div>
                ';
                })

                ->addColumn('created_at', function ($country) {
                    return $country->created_at
                        ? $country->created_at->format('d M Y, h:i A')
                        : '';
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

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country added!');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate(['name' => 'required|string|max:25']);

        $country->update($request->only('name'));

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country updated!');
    }

    public function show(Country $country)
    {
        return response()->json($country);
    }
    public function destroy(Country $country)
    {
        try {
            // Load only valid relationships!
            $country->load('states.schools.classes', 'states.schools.subjects', 'states.schools.gradeScales');

            foreach ($country->states as $state) {

                foreach ($state->schools as $school) {

                    // Delete grade scales
                    if ($school->gradeScales()->exists()) {
                        $school->gradeScales()->delete();
                    }

                    // Delete classes
                    if ($school->classes()->exists()) {
                        $school->classes()->delete();
                    }

                    // Delete subjects
                    if ($school->subjects()->exists()) {
                        $school->subjects()->delete();
                    }

                    // Delete school
                    $school->delete();
                }

                // Delete state
                $state->delete();
            }

            // Delete country
            $country->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country and all related data deleted successfully.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Country delete error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting country.'
            ], 500);
        }
    }
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:countries,id'
        ]);

        try {
            $countries = Country::whereIn('id', $request->ids)->get();

            foreach ($countries as $country) {
                $country->load('states.school.classes', 'states.school.subjects', 'states.school.gradeScales');

                foreach ($country->states as $state) {
                    foreach ($state->schools as $school) {
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

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete selected countries.'
            ], 500);
        }
    }
}
