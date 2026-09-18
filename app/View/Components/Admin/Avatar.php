<?php

namespace App\View\Components\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(public ?User $user = null) {}

    public function render(): View
    {
        return view('components.admin.avatar');
    }
}
