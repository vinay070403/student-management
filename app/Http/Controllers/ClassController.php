<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\StoreClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
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

    public function store(StoreClassRequest $request, School $school)
    {
        $school->classes()->create($request->validated());

        return redirect()
            ->route('schools.classes.index', $school)
            ->with('success', 'Class added!');
    }

    public function edit(School $school, ClassModel $class)
    {
        return view('admin.schools.classes.edit', compact('school', 'class'));
        // $schools = School::all();
        // return view('admin.schools.classes.edit', compact('school', 'class', 'schools'));
    }

    public function update(UpdateClassRequest $request, School $school, ClassModel $class)
    {
        $class->update($request->validated());

        return redirect()
            ->route('schools.classes.index', $school)
            ->with('success', 'Class updated!');
    }

    public function destroy(School $school, ClassModel $class)
    {
        $class->delete();
        return redirect()
            ->route('schools.classes.index', $school)
            ->with('success', 'Class deleted!');
    }
}
