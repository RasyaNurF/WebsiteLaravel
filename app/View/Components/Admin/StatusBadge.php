<?php

namespace App\View\Components\Admin;

use BackedEnum;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public function __construct(public ?BackedEnum $status = null) {}

    public function label(): string
    {
        return $this->status && method_exists($this->status, 'label')
            ? $this->status->label()
            : (string) $this->status?->value;
    }

    public function tone(): string
    {
        return $this->status && method_exists($this->status, 'tone')
            ? $this->status->tone()
            : 'neutral';
    }

    public function render(): View
    {
        return view('components.admin.status-badge');
    }
}
