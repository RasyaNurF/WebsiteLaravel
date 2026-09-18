<?php

namespace App\Http\Requests\Admin;

use App\Enums\PublishStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
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
            'position' => ['nullable', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:150'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'photo_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'photo_path_remove' => ['sometimes', 'boolean'],
            'quote' => ['required', 'string', 'max:2000'],
            'is_featured' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
        ];
    }
}
