@extends('layouts.app')
@section('title', 'Classes')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Class List</h4>
                <a href="{{ route('schools.classes.create', $school->id) }}" class="btn btn-primary mb-3">Add Class</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>School</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                        <!-- <tr onclick="window.location.href='{{ route('schools.classes.edit', [$school->id, $class->id]) }}'" style="cursor: pointer;"> -->
                        <tr @if($class->id) onclick="window.location.href='{{ route('schools.classes.edit',[$school->id, $class->id]) }}'" @endif style="cursor: pointer;">
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->school->name ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('schools.classes.destroy', [$school->id, $class->id]) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm-2" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if ($classes->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No classes found for this school.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection