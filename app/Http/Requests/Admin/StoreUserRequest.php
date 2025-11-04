<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Or add role-based logic if needed later
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50|min:2',
            'last_name'  => 'required|string|max:50|min:2',
            'email'      => 'required|string|email|unique:users,email',
            'phone'      => 'nullable|string',
            'dob'        => 'nullable|date',
            'avatar'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'address'    => 'nullable|string',
            'password'   => 'required|string|min:8|confirmed',
        ];
    }
}
