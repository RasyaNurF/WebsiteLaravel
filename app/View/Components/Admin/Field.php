<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Field extends Component
{
    public function __construct(
        public string $label,
        public string $name,
        public ?string $hint = null,
        public bool $required = false,
        public ?string $for = null,
    ) {}

    public function render(): View
    {
        return view('components.admin.field');
    }
}
