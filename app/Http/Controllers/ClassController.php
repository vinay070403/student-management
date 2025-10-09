<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\School;
use Illuminate\Http\Request;

class ClassController extends Controller
{

    public function index(School $school)
    {
        $classes = $school->classes()->get(); // Use relationship
        return view('admin.schools.classes.index', compact('school', 'classes'));
    }

    public function create(School $school)
    {
        // $schools = School::all();
        return view('admin.schools.classes.create', compact('school'));
    }

    public function store(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school->classes()->create($request->all());
        return redirect()->route('schools.classes.index', $school)->with('success', 'Class added!');
    }

    public function edit(School $school, ClassModel $class)
    {
        return view('admin.schools.classes.edit', compact('school', 'class'));
        // $schools = School::all();
        // return view('admin.schools.classes.edit', compact('school', 'class', 'schools'));
    }

    public function update(Request $request, School $school, ClassModel $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class->update($request->all());
        return redirect()->route('schools.classes.index', $school)->with('success', 'Class updated!');
    }

    public function destroy(School $school, ClassModel $class)
    {
        $class->delete();
        return redirect()->route('schools.classes.index', $school)->with('success', 'Class deleted!');
    }
}
