@php
    $countryKey = $country->ulid ?: $country->id;
@endphp

<div class="d-inline-flex gap-2">
    <a href="{{ route('countries.edit', $countryKey) }}" class="btn btn-sm custom-edit-btn" title="Edit">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <button type="button" class="btn btn-sm custom-delete-btn delete-country-btn" data-id="{{ $countryKey }}"
        title="Delete">
        <i class="fa-solid fa-trash-can"></i>
    </button>
</div>
