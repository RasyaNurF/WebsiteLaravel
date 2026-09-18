<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(public ?string $title = null, public ?string $description = null) {}

    public function render(): View
    {
        return view('components.admin.card');
    }
}
