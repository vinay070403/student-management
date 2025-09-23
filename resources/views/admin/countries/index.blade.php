@extends('layouts.app')
@section('title', 'Countries')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Country List</h4>
                <a href="{{ route('countries.create') }}" class="btn btn-primary btn-sm mb-3">Add Country</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <!-- <th>Code</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                        <!-- <tr onclick="window.location.href='{{ route('countries.edit', $country->id) }}'" style="cursor: pointer;"> -->
                        <tr @if($country->id) onclick="window.location.href='{{ route('countries.edit', $country->id) }}'" @endif style="cursor: pointer;">
                            <td>{{ $country->name }}</td>
                            <!-- <td>{{ $country->code ?? 'N/A' }}</td> -->
                            <td>
                                <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
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