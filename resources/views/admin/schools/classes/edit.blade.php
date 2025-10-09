@extends('layouts.app')
@section('title', 'Edit Class')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit Class</h4>
                <form action="{{ route('schools.classes.update', [$school->id, $class->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_id">School</label>
                                <select name="school_id" class="form-control form-control-sm @error('school_id') is-invalid @enderror" required>
                                    @foreach ($school as $schools)
                                    <option value="{{ $school->id }}" {{ old('school_id', $class->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name', $class->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm-2">Update Class</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('schools.classes.destroy', [$school->id, $class->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm-2" onclick="return confirm('Are you sure?')">Delete Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection