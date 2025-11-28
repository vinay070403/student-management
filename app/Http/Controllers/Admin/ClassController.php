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
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ClassController extends Controller implements HasMiddleware
{
    /**
     * Permission middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:class-list', only: ['index', 'show']),
            new Middleware('permission:class-create', only: ['create', 'store']),
            new Middleware('permission:class-edit', only: ['edit', 'update']),
            new Middleware('permission:class-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    public function index(Request $request, School $school)
    {
        if ($request->ajax()) {
            $classes = $school->classes()->select('id', 'ulid', 'name', 'created_at');

            return DataTables::of($classes)
                ->addColumn('actions', function ($class) use ($school) {

                    $editUrl = route('schools.classes.edit', [$school->ulid, $class->ulid]);
                    $deleteUrl = route('schools.classes.destroy', [$school->ulid, $class->ulid]);

                    return '
                    <div class="btn-group" role="group">
                        <a href="' . $editUrl . '"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <button
                            class="btn btn-sm btn-danger delete-class"
                            data-url="' . $deleteUrl . '"
                        >
                            Delete
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // fallback (non-AJAX)
        $classes = $school->classes()->get();
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
            ->route('schools.edit', $school)
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
            ->route('schools.edit', $school)
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
