<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller implements HasMiddleware
{
    /**
     * Permission middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:state-list', only: ['index', 'show']),
            new Middleware('permission:state-create', only: ['create', 'store']),
            new Middleware('permission:state-edit', only: ['edit', 'update']),
            new Middleware('permission:state-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of states (with DataTables AJAX support)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $states = State::select('ulid', 'name', 'country_id', 'created_at')
                ->with('country:id,name');


            return datatables()->of($states)
                ->addColumn('actions', function ($state) {
                    return view('admin.states.partials.actions', compact('state'))->render();
                })
                ->addColumn('name', function ($state) {
                    return '<span class="fw-semibold">' . e($state->name) . '</span>';
                })
                ->addColumn('country', function ($state) {
                    return $state->country ? e($state->country->name) : '-';
                })
                ->addColumn('created_at', function ($state) {
                    return $state->created_at ? $state->created_at->format('d M Y, h:i A') : '';
                })
                ->rawColumns(['actions', 'name'])
                ->make(true);
        }

        return view('admin.states.index');
    }

    /**
     * Show the form for creating a new state
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.states.create', compact('countries'));
    }

    /**
     * Store a newly created state in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        State::create($request->only('name', 'country_id'));

        return redirect()->route('states.index')->with('success', 'State added!');
    }

    /**
     * Show the form for editing a state
     */
    public function edit(State $state)
    {
        $countries = Country::all();
        return view('admin.states.edit', compact('state', 'countries'));
    }

    /**
     * Update the specified state
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $state->update($request->only('name', 'country_id'));

        return redirect()->route('states.index')->with('success', 'State updated!');
    }

    /**
     * Remove the specified state and related data
     */
    public function destroy(State $state)
    {
        try {
            $state->load('schools.classes', 'schools.subjects');

            foreach ($state->schools as $school) {
                $school->classes()->delete();
                $school->subjects()->delete();
                $school->delete();
            }

            $state->delete();

            return redirect()->route('states.index')->with('success', 'State deleted successfully!');
        } catch (\Throwable $e) {
            Log::error("State delete error: {$e->getMessage()}");
            return redirect()->route('states.index')->with('error', 'Failed to delete state.');
        }
    }

    /**
     * Bulk delete states and related data
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:states,id',
        ]);

        try {
            $states = State::whereIn('id', $request->ids)->get();

            foreach ($states as $state) {
                $state->load('schools.classes', 'schools.subjects');
                foreach ($state->schools as $school) {
                    $school->classes()->delete();
                    $school->subjects()->delete();
                    $school->delete();
                }
                $state->delete();
            }

            return redirect()->route('states.index')->with('success', 'Selected states deleted successfully!');
        } catch (\Throwable $e) {
            Log::error("Bulk delete error: {$e->getMessage()}");
            return redirect()->route('states.index')->with('error', 'Failed to delete selected states.');
        }
    }
    public function getByCountry($countryId)
    {
        $states = \App\Models\State::where('country_id', $countryId)
            ->select('id', 'ulid', 'name')   // ← ADD ulid HERE
            ->get();

        return response()->json(['states' => $states]);
    }
}
