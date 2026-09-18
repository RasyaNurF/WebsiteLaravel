<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'job_title' => ['nullable', 'string', 'max:100'],
            'avatar_path' => ['nullable', 'string', 'max:255'],
            'avatar_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'avatar_path_remove' => ['sometimes', 'boolean'],
        ];
    }
}
