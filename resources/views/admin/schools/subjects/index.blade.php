@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-book me-2"></i>Subjects</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('schools.edit', $school->id) }}"
                            class="btn btn-dark px-5 py-3 rounded-3 fw-bold shadow-sm ">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <!-- <a href="{{ route('schools.subjects.create', $school) }}" class="btn btn-dark d-flex align-items-center gap-2 rounded-3 btn-lg">
                                <i class="bi bi-plus-lg"></i> Add Subject   btn btn-secondary d-flex align-items-center gap-2 rounded-3 btn-lg
                            </a> -->
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body p-4">
                        @include('admin.schools.subjects.partials.table')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Card polish */
        .card {
            border-radius: 12px;
        }

        /* Table look */
        .subjects-table thead th {
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 2px solid #dee2e6;
        }

        .subjects-table tbody tr {
            transition: all 0.2s ease-in-out;
        }

        .subjects-table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.001);
        }

        /* Buttons polish */
        .btn-outline-primary,
        .btn-outline-danger {
            border-radius: 6px !important;
            font-weight: 500;
            transition: all 0.15s;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
@endpush
@push('scripts')
    <script>
        // Put inside your scripts block
        $(document).on('submit', '.delete-subject-form', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the subject.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
