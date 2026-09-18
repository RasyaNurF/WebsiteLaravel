<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $eyebrow = null,
    ) {}

    public function render(): View
    {
        return view('components.admin.page-header');
    }
}
