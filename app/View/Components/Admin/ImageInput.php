<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class ImageInput extends Component
{
    public function __construct(
        public string $name,
        public ?string $value = null,
        public string $label = 'Gambar',
        public ?string $hint = null,
        public string $shape = 'rect',
        public bool $required = false,
    ) {}

    public function currentUrl(): ?string
    {
        return $this->value ? Storage::disk('public')->url($this->value) : null;
    }

    public function previewClasses(): string
    {
        return $this->shape === 'circle'
            ? 'h-20 w-20 rounded-full object-cover'
            : ($this->shape === 'square' ? 'h-20 w-20 rounded object-contain p-1 bg-white' : 'h-20 w-28 rounded object-cover');
    }

    public function render(): View
    {
        return view('components.admin.image-input');
    }
}
