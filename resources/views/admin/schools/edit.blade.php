@extends('layouts.app')
@section('title', 'Edit School')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit School</h4>
                <form action="{{ route('schools.update', $school->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" required value="{{ $school->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_id">State</label>
                                <select name="state_id" class="form-control form-control-sm" required>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ $school->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control form-control-sm" required value="{{ $school->address }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zipcode">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control form-control-sm" required value="{{ $school->zipcode }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Update School</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('schools.destroy', $school->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete School</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection