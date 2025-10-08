@extends('layouts.app')
@section('title', 'Edit State')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit State</h4>
                <form action="{{ route('states.update', $state->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" required value="{{ $state->name }}">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" name="code" class="form-control form-control-sm" value="{{ $state->code }}">
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select name="country_id" class="form-control form-control-sm" required>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $state->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-dark btn-sm-2">Update State</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('states.destroy', $state->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm-2" onclick="return confirm('Are you sure?')">Delete State</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection