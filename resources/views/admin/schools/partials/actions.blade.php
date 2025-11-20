<td class="text-end">
    <div class="d-flex justify-content-end ">
        <a href="{{ route('schools.edit', $school->ulid) }}" class="btn btn-sm custom-edit-btn" title="Edit">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <button type="button" class="btn btn-sm custom-delete-btn delete-school-btn" data-id="{{ $school->ulid }}"
            title="Delete">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>
</td>
