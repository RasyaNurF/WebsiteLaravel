<?php

namespace App\Http\Requests\Admin;

use App\Enums\ProjectStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:180'],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:10000'],
            'technologies' => ['nullable', 'string', 'max:500'],
            'started_at' => ['nullable', 'date'],
            'finished_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'image_path' => ['nullable', 'string', 'max:255'],
            'image_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'image_path_remove' => ['sometimes', 'boolean'],
            'url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
