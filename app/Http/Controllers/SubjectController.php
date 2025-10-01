<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\School;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // public function index()
    // {
    //     $subjects = Subject::with('school')->get();
    //     return view('admin.subjects.index', compact('subjects'));
    // }

    // public function create()
    // {
    //     $schools = School::all();
    //     return view('admin.subjects.create', compact('schools'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'school_id' => 'required|exists:schools,id',
    //         'name' => 'required|string|max:255',
    //     ]);

    //     Subject::create($request->all());
    //     return redirect()->route('subjects.index')->with('success', 'Subject added!');
    // }

    // public function edit(Subject $subject)
    // {
    //     $schools = School::all();
    //     return view('admin.subjects.edit', compact('subject', 'schools'));
    // }

    // public function update(Request $request, Subject $subject)
    // {
    //     $request->validate([
    //         'school_id' => 'required|exists:schools,id',
    //         'name' => 'required|string|max:255',
    //     ]);

    //     $subject->update($request->all());
    //     return redirect()->route('subjects.index')->with('success', 'Subject updated!');
    // }

    // public function destroy(Subject $subject)
    // {
    //     $subject->delete();
    //     return redirect()->route('subjects.index')->with('success', 'Subject deleted!');
    // }

    public function index(School $school)
    {
        $subjects = $school->subjects()->get(); // Use relationship
        return view('admin.schools.subjects.index', compact('school', 'subjects'));
    }

    public function create(School $school)
    {
        // $schools = School::all();
        return view('admin.schools.subjects.create', compact('school'));
    }

    public function store(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school->subjects()->create($request->all());
        return redirect()->route('schools.subjects.index', $school)->with('success', 'Subject added!');
    }

    public function edit(School $school, Subject $subject)
    {
        //$schools = School::all();
        return view('admin.schools.subjects.edit', compact('school', 'subject',));
    }

    public function update(Request $request, School $school, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update($request->all());
        return redirect()->route('schools.subjects.index', $school)->with('success', 'Subject updated!');
    }

    public function destroy(School $school, Subject $subject)
    {
        $subject->delete();
        return redirect()->route('schools.subjects.index', $school)->with('success', 'Subject deleted!');
    }
}
