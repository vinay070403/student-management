@extends('layouts.app')
@section('title', 'Add Country')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-3">
                <h4 class="card-title mb-3">Add New Country</h4>
                <form action="{{ route('countries.store') }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" name="code" class="form-control form-control-sm">
                            </div>
                        </div> -->
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Add Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection