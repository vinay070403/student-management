 <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
     <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-book me-2"></i>Subjects</h4>
     <div class="d-flex gap-2">
         <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-secondary px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
             <i class="bi bi-arrow-left"></i> Back
         </a>
         <a href="{{ route('schools.subjects.create', $school) }}" class="btn btn-secondary px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
             <i class="bi bi-plus-lg"></i> Add Subject
         </a>
     </div>
 </div>
 <div class="table-responsive rounded-3 shadow-sm">
     <table class="table table-hover align-middle bg-white rounded-3">
         <thead class="table-light fw-bold">
             <tr>
                 <th>#</th>
                 <th>Subject Name</th>
                 <th class="text-end">Actions</th>
             </tr>
         </thead>
         <tbody>
             @forelse ($school->subjects as $subject)
             <tr class="fw-semibold">
                 <td>{{ $subject->id }}</td>
                 <td>{{ $subject->name }}</td>
                 <td class="text-end">
                     <a href="{{ route('schools.subjects.edit', [$school->id, $subject->id]) }}" class="btn btn-sm btn-outline-secondary me-2 fw-bold">Edit</a>
                     <button type="button" class="btn btn-sm btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}">
                         Delete
                     </button>
                 </td>
             </tr>
             @empty
             <tr>
                 <td colspan="3" class="text-center text-muted fw-semibold">No subjects yet.</td>
             </tr>
             @endforelse
         </tbody>
     </table>
 </div>