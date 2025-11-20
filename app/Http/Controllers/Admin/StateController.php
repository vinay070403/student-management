<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $states = State::select(
                'id',
                'ulid',
                'country_id',
                'name',
                'created_at'
            )
                ->with('country:id,name');

            // Custom search support
            $search = $request->input('custom_search');

            if (!empty($search)) {
                $states->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            return DataTables::of($states)
                ->addColumn('checkbox', function ($state) {
                    return '<input type="checkbox" class="select-state" data-id="' . $state->id . '">';
                })
                ->addColumn('state_name', function ($state) {
                    return '<span class="fw-semibold">' . e($state->name) . '</span>';
                })
                ->addColumn('country', function ($state) {
                    return $state->country ? e($state->country->name) : '-';
                })
                ->addColumn('created_at', function ($state) {
                    return $state->created_at
                        ? $state->created_at->format('d M Y, h:i A')
                        : '';
                })
                ->addColumn('actions', function ($state) {
                    return view('admin.states.partials.actions', compact('state'))->render();
                })
                ->rawColumns(['checkbox', 'state_name', 'actions'])
                ->make(true);
        }

        return view('admin.states.index');
    }


    public function create()
    {
        $countries = Country::all();
        return view('admin.states.create', compact('countries'));
    }

    // public function schools($stateId)
    // {
    //     $state = State::with('schools')->findOrFail($stateId);
    //     return response()->json(['schools' => $state->schools]);
    // }

    public function schools($stateId)
    {
        $state = State::with(['schools' => function ($q) {
            $q->select('ulid', 'name', 'state_id');
        }])->findOrFail($stateId);

        return response()->json(['schools' => $state->schools]);
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

    // public function getByCountry($countryId)
    // {
    //     $states = \App\Models\State::where('country_id', $countryId)
    //         ->select('id', 'name')
    //         ->get();

    //     return response()->json(['states' => $states]);
    // }

    public function getByCountry($countryId)
    {
        $states = \App\Models\State::where('country_id', $countryId)
            ->select('id', 'ulid', 'name')   // ← ADD ulid HERE
            ->get();

        return response()->json(['states' => $states]);
    }




    /**
     * Cascade delete State → Schools → Classes → Subjects
     */
    public function destroy(State $state)
    {
        try {
            // Load correct relationships
            $state->load('schools.classes', 'schools.subjects');

            foreach ($state->schools as $school) {

                // Delete classes under this school
                $school->classes()->delete();

                // Delete subjects under this school
                $school->subjects()->delete();

                // Delete school
                $school->delete();
            }

            // Delete the state itself
            $state->delete();

            return redirect()->route('states.index')
                ->with('success', 'State and its related schools, classes, and subjects deleted successfully.');
        } catch (\Throwable $e) {
            Log::error("State delete error: {$e->getMessage()}");
            return redirect()->route('states.index')
                ->with('error', 'Error while deleting state.');
        }
    }
}
