<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyState extends Component
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public string $icon = 'search-empty',
    ) {}

    public function render(): View
    {
        return view('components.admin.empty-state');
    }
}
