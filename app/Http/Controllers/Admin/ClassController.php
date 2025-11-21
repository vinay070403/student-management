<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Class\StoreClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Models\SchoolClass;
use App\Models\School;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassController extends Controller
{

    // public function index(School $school)
    // {
    //     $classes = $school->classes()->get(); // Use relationship
    //     return view('admin.schools.classes.index', compact('school', 'classes'));
    // }


    public function index(Request $request, School $school)
    {
        if ($request->ajax()) {
            $classes = $school->classes()->select('id', 'ulid', 'name', 'created_at');

            return DataTables::of($classes)
                ->addColumn('actions', function ($class) use ($school) {
                    return '

                    <a href="' . route('schools.classes.edit', [$school->ulid, $class->ulid]) . '"
                    class="btn btn-sm btn-primary">
                    Edit
                    </a>

                    <button data-id="' . $class->ulid . '"
                            class="btn btn-sm btn-danger delete-class">
                        Delete
                    </button>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $classes = $school->classes()->get(); // fallback for non-AJAX
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

    public function edit(School $school, SchoolClass $class)
    {
        //dd($school, $class); // Make sure both are loaded
        return view('admin.schools.classes.edit', compact('school', 'class'));
        // $schools = School::all();
        // return view('admin.schools.classes.edit', compact('school', 'class', 'schools'));
    }

    public function update(UpdateClassRequest $request, School $school, SchoolClass $class)
    {
        $class->update($request->validated());

        return redirect()
            ->route('schools.classes.index', $school)
            ->with('success', 'Class updated!');
    }

    public function destroy(School $school, SchoolClass $class)
    {
        try {
            // 🟢 Delete all student grades associated with this class
            if ($class->studentGrades()->exists()) {
                $class->studentGrades()->delete();
            }

            // 🟢 Now delete the class itself
            $class->delete();

            return redirect()
                ->route('schools.classes.index', $school)
                ->with('success', 'Class and related student grades deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('Class delete error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());

            return redirect()
                ->route('schools.classes.index', $school)
                ->with('error', 'Error deleting class and related data.');
        }
    }
}
