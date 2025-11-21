<div class="d-inline-flex gap-2">

    <a href="{{ route('states.edit', $state->ulid) }}" class="btn btn-sm custom-edit-btn" title="Edit">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <button class="btn btn-sm custom-delete-btn delete-state-btn" data-id="{{ $state->ulid }}" title="Delete">
        <i class="fa-solid fa-trash-can"></i>
    </button>

</div>
