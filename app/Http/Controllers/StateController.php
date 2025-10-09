<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:255',
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

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')->with('success', 'State deleted!');
    }
}
