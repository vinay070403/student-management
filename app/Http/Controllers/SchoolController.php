<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\State;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('state')->get();
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        $states = State::all();
        return view('admin.schools.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
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
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
        ]);

        $school->update($request->all());
        return redirect()->route('schools.index')->with('success', 'School updated!');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('schools.index')->with('success', 'School deleted!');
    }
}
