 <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
     <!-- <h4 class="mb-0 fw-semibold text-dark"><i class="bi bi-book me-2"></i>Subjects</h4> -->
     <div class="d-flex gap-2">

         <div class="d-flex justify-content-end mb-2">
             <a href="{{ route('schools.subjects.create', $school) }}"
                 class="btn btn-dark px-4 py-3 d-flex align-items-center gap-2 rounded-3 btn-lg">
                 Add Subject
             </a>
         </div>

     </div>
 </div>
 <!-- <div class="table-responsive rounded-3 shadow-sm"> -->
 <table class="table table-hover align-middle mb-0">
     <thead class="table-light fw-bold">
         <tr>
             {{-- <th>#</th> --}}
             <th>Subject Name</th>
             <th class="text-end">Actions</th>
         </tr>
     </thead>
     <tbody>
         @forelse ($school->subjects as $subject)
             <tr class="fw-semibold">
                 {{-- <td>{{ $subject->id }}</td> --}}
                 <td>{{ $subject->name }}</td>
                 <td class="text-end">
                     <a href="{{ route('schools.subjects.edit', [$school->id, $subject->id]) }}"
                         class="btn btn-sm custom-edit-btn">
                         <i class="fa-solid fa-pen-to-square"></i>
                     </a>
                     <!-- Delete Button -->
                     <form action="{{ route('schools.subjects.destroy', [$school->id, $subject->id]) }}" method="POST"
                         class="d-inline delete-subject-form">
                         @csrf
                         @method('DELETE')
                         <button type="submit" class="btn btn-sm custom-delete-btn" title="Delete">
                             <i class="fa-solid fa-trash-can"></i>
                         </button>
                     </form>

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
