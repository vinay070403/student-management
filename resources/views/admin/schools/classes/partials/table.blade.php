<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <!-- <h3 class="fw-semibold text-dark mb-0">
            <i class="bi bi-people me-2"></i> Classes List
        </h3> -->
        <div class="d-flex gap-2">
            <a href="{{ route('schools.edit', $school->ulid) }}"
                class="btn btn-secondary px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                ← Back
            </a>
            <a href="{{ route('schools.classes.create', $school->ulid) }}"
                class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                + Add Class
            </a>
        </div>
    </div>

    <table id="classes-table" class="table align-middle table-row-dashed fs-6 gy-3">
        <thead class="table-light text-nowrap">
            <tr>
                <th>Name</th>
                <th>Created At</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
    </table>

</div>
