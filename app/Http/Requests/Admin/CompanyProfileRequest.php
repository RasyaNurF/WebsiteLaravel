<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'about' => ['nullable', 'string', 'max:10000'],
            'vision' => ['nullable', 'string', 'max:5000'],
            'mission' => ['nullable', 'string', 'max:5000'],
            'values' => ['nullable', 'string', 'max:10000'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'logo_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'logo_path_remove' => ['sometimes', 'boolean'],
            'cover_image_path' => ['nullable', 'string', 'max:255'],
            'cover_image_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'cover_image_path_remove' => ['sometimes', 'boolean'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:2000'],
            'founded_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
        ];
    }
}
