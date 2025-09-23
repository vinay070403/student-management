@extends('layouts.app')
@section('title', 'Edit Country')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Edit Country</h4>
                <form action="{{ route('countries.update', $country->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" required value="{{ $country->name }}">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" name="code" class="form-control form-control-sm" value="{{ $country->code }}">
                            </div>
                        </div> -->
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Update Country</button>
                    </div>
                </form>
                <hr>
                <form action="{{ route('countries.destroy', $country->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection