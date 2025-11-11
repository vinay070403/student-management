<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // ✅ Base rules
        $rules = [
            'first_name' => 'required|string|max:50|min:2',
            'last_name'  => 'required|string|max:50|min:2',
            'email'      => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'phone'         => 'nullable|string|max:20',
            'dob'           => 'nullable|date',
            'address'       => 'nullable|string|max:55',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ];

        // ✅ Add password rules dynamically if user tries to change password
        if ($this->filled('password')) {
            $rules['current_password'] = ['required'];
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    /**
     * Extra logic to verify the current password belongs to the user being edited.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (! $this->filled('password')) {
                return;
            }

            $currentPassword = $this->input('current_password');
            $routeUser = $this->route('user');

            // Handle model binding or ID route param
            $user = $routeUser instanceof User ? $routeUser : User::find($routeUser);

            if (! $user) {
                $validator->errors()->add('current_password', 'User not found.');
                return;
            }

            if (! Hash::check($currentPassword, $user->password)) {
                $validator->errors()->add('current_password', 'The current password is incorrect.');
            }
        });
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'password.confirmed' => 'Password confirmation does not match.',
            'current_password.required' => 'Please enter the current password to change it.',
        ];
    }
}
