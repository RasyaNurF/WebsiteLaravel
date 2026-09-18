<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * @param  list<array{label: string, url?: string|null}>  $items
     */
    public function __construct(public array $items = []) {}

    public function render(): View
    {
        return view('components.admin.breadcrumb');
    }
}
