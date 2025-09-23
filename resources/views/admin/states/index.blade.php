@extends('layouts.app')
@section('title', 'States')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">State List</h4>
                <a href="{{ route('states.create') }}" class="btn btn-primary btn-sm mb-3">Add State</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                        <!-- <tr onclick="window.location.href='{{ route('states.edit', $state->id) }}'" style="cursor: pointer;"> -->
                        <tr @if($state->id) onclick="window.location.href='{{ route('states.edit', $state->id) }}'" @endif style="cursor: pointer;">
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->code ?? 'N/A' }}</td>
                            <td>{{ $state->country->name ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('states.destroy', $state->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
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