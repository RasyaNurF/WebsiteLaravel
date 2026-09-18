<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
            'file' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
        ];
    }
}
