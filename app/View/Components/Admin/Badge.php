<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(public string $tone = 'neutral') {}

    /**
     * @return array<string, string>
     */
    public function tones(): array
    {
        return [
            'neutral' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
            'brand' => 'bg-brand-50 text-brand-700 ring-brand-100',
            'sky' => 'bg-sky-50 text-sky-700 ring-sky-100',
            'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
            'amber' => 'bg-amber-50 text-amber-700 ring-amber-100',
            'violet' => 'bg-violet-50 text-violet-700 ring-violet-100',
            'red' => 'bg-red-50 text-red-700 ring-red-100',
        ];
    }

    public function classes(): string
    {
        return $this->tones()[$this->tone] ?? $this->tones()['neutral'];
    }

    public function render(): View
    {
        return view('components.admin.badge');
    }
}
