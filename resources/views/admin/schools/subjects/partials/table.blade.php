    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <!-- <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-book me-2"></i>Subjects</h4> -->
        {{--  --}}
    </div>
    <!-- <div class="table-responsive rounded-3 shadow-sm"> -->
    <table class="table table-hover align-middle mb-0">
        <div class="card-body p-4">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('schools.subjects.create', $school) }}"
                    class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                    + Add Subject
                </a>
            </div>

            <table id="subjects-table" class="table table-hover align-middle mb-0">
                <thead class="table-light fw-bold">
                    <tr>
                        <th>Subject Name</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </table>
    </div>
