<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatParticipant extends Model
{
    protected $fillable = [
        'guest_token',
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'status',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $q) => $q->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('subject', 'like', "%{$term}%");
        }));
    }

    #[Scope]
    protected function withStatus(Builder $query, ?string $status): void
    {
        $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }
}
