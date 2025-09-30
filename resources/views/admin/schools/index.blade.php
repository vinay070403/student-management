@extends('layouts.app')
@section('title', 'Schools')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">School List</h4>
                <a href="{{ route('schools.create') }}" class="btn btn-primary btn-sm mb-3">Add School</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>State</th>
                            <th>Address</th>
                            <th>Zipcode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        @foreach ($schools as $school)
                        <tr @if(isset($school->id)) onclick="window.location.href='{{ route('schools.edit', $school->id) }}'" @endif style="cursor: pointer;">
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->state->name ?? 'N/A' }}</td>
                            <td>{{ $school->address }}</td>
                            <td>{{ $school->zipcode }}</td>
                            <td>
                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> -->
                    <tbody>
                        @foreach ($schools as $school)
                        <!-- <tr onclick="window.location.href='{{ route('schools.edit', $school->id) }}'" style="cursor: pointer;"> -->
                        <tr @if(isset($school->id)) onclick="window.location.href='{{ route('schools.edit', $school->id) }}'" @endif style="cursor: pointer;">
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->state->name ?? 'N/A' }}</td>
                            <td>{{ $school->address }}</td>
                            <td>{{ $school->zipcode }}</td>
                            <td>
                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
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