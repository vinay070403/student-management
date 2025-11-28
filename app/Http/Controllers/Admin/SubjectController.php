<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubjectController extends Controller implements HasMiddleware
{
    /**
     * Permission middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:subject-list', only: ['index', 'show']),
            new Middleware('permission:subject-create', only: ['create', 'store']),
            new Middleware('permission:subject-edit', only: ['edit', 'update']),
            new Middleware('permission:subject-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    public function index(School $school, Request $request)
    {
        if ($request->ajax()) {
            $subjects = $school->subjects()->select(['id', 'name', 'ulid', 'created_at']);

            return DataTables::of($subjects)
                ->addIndexColumn() // Adds DT_RowIndex
                ->addColumn('action', function ($subject) use ($school) {
                    // $editUrl = route('schools.subjects.edit', [$school, $subject]);
                    // $deleteUrl = route('schools.subjects.destroy', [$school, $subject]);
                    return '

                     <a href="' . route('schools.subjects.edit', [$school->ulid, $subject->ulid]) . '"
                    class="btn btn-sm btn-primary">
                    Edit
                    </a>

                    <button data-id="' . $subject->ulid . '"
                            class="btn btn-sm btn-danger delete-subject">
                        Delete
                    </button>

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

        return redirect()->route('schools.edit', $school)->with('success', 'Subject added!');
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

        return redirect()->route('schools.edit', $school)->with('success', 'Subject updated!');
    }

    public function destroy(School $school, Subject $subject)
    {
        $subject->delete();

        return redirect()->route('schools.edit', $school)->with('success', 'Subject deleted!');
    }
}
