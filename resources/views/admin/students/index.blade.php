@extends('layouts.app')
@section('title', 'Students')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Student List</h4>
                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm mb-3">Add Student</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <!-- <tr onclick="window.location.href='{{ route('students.edit', $student->id) }}'" style="cursor: pointer;"> -->
                        <tr @if($student->id) onclick="window.location.href='{{ route('students.edit', $student->id) }}'" @endif style="cursor: pointer;">
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection