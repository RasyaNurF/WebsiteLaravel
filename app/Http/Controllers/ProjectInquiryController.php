<?php

namespace App\Http\Controllers;

use App\Models\ProjectInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectInquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:150'],
            'project_type' => ['required', 'string', Rule::in(ProjectInquiry::PROJECT_TYPES)],
            'budget_range' => ['nullable', 'string', Rule::in(ProjectInquiry::BUDGET_RANGES)],
            'project_detail' => ['required', 'string', 'max:5000'],
        ]);

        ProjectInquiry::create($validated);

        return redirect()
            ->to(route('kontak').'#proyek')
            ->with('success', 'Permintaan Anda terkirim. Tim kami akan menghubungi Anda maksimal 1×24 jam kerja.');
    }
}
