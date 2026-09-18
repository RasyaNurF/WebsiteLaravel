<?php

namespace App\Http\Requests\Admin;

use App\Enums\AdminRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user')?->id)],
            'role' => ['required', Rule::enum(AdminRole::class)],
            'job_title' => ['nullable', 'string', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'password' => $this->isMethod('post')
                ? ['required', 'string', Password::min(8)]
                : ['nullable', 'string', Password::min(8)],
        ];
    }
}
