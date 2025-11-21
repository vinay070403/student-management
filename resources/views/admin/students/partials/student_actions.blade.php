<div class="d-inline-flex gap-2">

    <a href="{{ route('students.edit', $student->ulid) }}" class="btn btn-sm custom-edit-btn" title="Edit">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <button class="btn btn-sm custom-delete-btn delete-student" data-id="{{ $student->ulid }}"
        data-name="{{ $student->first_name }} {{ $student->last_name }}" title="Delete">
        <i class="fa-solid fa-trash-can"></i>
    </button>

</div>
