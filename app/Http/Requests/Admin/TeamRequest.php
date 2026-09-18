<?php

namespace App\Http\Requests\Admin;

use App\Enums\PublishStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120'],
            'position' => ['nullable', 'string', 'max:120'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'photo_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'photo_path_remove' => ['sometimes', 'boolean'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
        ];
    }
}
