<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'company_name' => ['nullable', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'google_maps' => ['nullable', 'string', 'max:2000'],
            'google_maps_embed' => ['nullable', 'string', 'max:5000'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'favicon_path' => ['nullable', 'string', 'max:255'],
            'hero_image_path' => ['nullable', 'string', 'max:255'],
            'about_image_path' => ['nullable', 'string', 'max:255'],
            'stat_experience' => ['nullable', 'string', 'max:20'],
            'stat_projects' => ['nullable', 'string', 'max:20'],
            'stat_retention' => ['nullable', 'string', 'max:20'],
            'logo_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'logo_path_remove' => ['sometimes', 'boolean'],
            'favicon_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'favicon_path_remove' => ['sometimes', 'boolean'],
            'hero_image_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'hero_image_path_remove' => ['sometimes', 'boolean'],
            'about_image_path_file' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'about_image_path_remove' => ['sometimes', 'boolean'],
            'maintenance_mode' => ['sometimes', 'boolean'],
        ];
    }
}
