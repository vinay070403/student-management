<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  $this->user()->can('country-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:countries,name,' . $this->country->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Country name is required.',
            'name.unique' => 'This country name is already taken.',

        ];
    }
}
