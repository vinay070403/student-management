<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    public function index(School $school, Request $request)
    {
        if ($request->ajax()) {
            $subjects = $school->subjects()->select(['id', 'name', 'ulid', 'created_at']);

            return DataTables::of($subjects)
                ->addIndexColumn() // Adds DT_RowIndex
                ->addColumn('action', function ($subject) use ($school) {
                    $editUrl = route('schools.subjects.edit', [$school, $subject]);
                    $deleteUrl = route('schools.subjects.destroy', [$school, $subject]);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.schools.subjects.index', compact('school'));
    }

    public function create(School $school)
    {
        return view('admin.schools.subjects.create', compact('school'));
    }

    public function store(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);

        $school->subjects()->create($request->all());

        return redirect()->route('schools.subjects.index', $school)->with('success', 'Subject added!');
    }

    public function edit(School $school, Subject $subject)
    {
        return view('admin.schools.subjects.edit', compact('school', 'subject'));
    }

    public function update(Request $request, School $school, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:25',
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
