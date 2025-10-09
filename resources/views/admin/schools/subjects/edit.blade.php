@extends('layouts.app')
@section('title', 'Edit Subject')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit Subject</h4>
                <form action="{{ route('schools.subjects.update', [$school, $subject]) }}" method="POST">


                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_id">School</label>
                                <select name="school_id" class="form-control form-control-sm" required>
                                    @foreach ($school as $schools)
                                    <option value="{{ $school->id }}" {{ $subject->school_id == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" required value="{{ $subject->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm-2">Update Subject</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm-2" onclick="return confirm('Are you sure?')">Delete Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection