<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavSection extends Component
{
    /**
     * @param  list<string>  $routes
     */
    public function __construct(public string $label, public array $routes = []) {}

    public function render(): View
    {
        return view('components.admin.nav-section');
    }
}
