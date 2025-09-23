<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\School;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::with('school')->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $schools = School::all();
        return view('admin.classes.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        ClassModel::create($request->all());
        return redirect()->route('classes.index')->with('success', 'Class added!');
    }

    public function edit(ClassModel $class)
    {
        $schools = School::all();
        return view('admin.classes.edit', compact('class', 'schools'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        $class->update($request->all());
        return redirect()->route('classes.index')->with('success', 'Class updated!');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted!');
    }
}
