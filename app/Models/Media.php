<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'alt_text',
        'title',
        'uploaded_by',
    ];

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function humanSize(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = (float) $this->size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, $unit === 0 ? 0 : 1).' '.$units[$unit];
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('original_name', 'like', "%{$term}%")
                ->orWhere('title', 'like', "%{$term}%")
                ->orWhere('alt_text', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function images(Builder $query): void
    {
        $query->where('mime_type', 'like', 'image/%');
    }
}
