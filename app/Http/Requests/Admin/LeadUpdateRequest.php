<?php

namespace App\Http\Requests\Admin;

use App\Enums\LeadStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadUpdateRequest extends FormRequest
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
            'status' => ['required', Rule::enum(LeadStatus::class)],
            'admin_note' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
