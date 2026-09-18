<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_participant_id',
        'guest_token',
        'sender',
        'name',
        'email',
        'body',
        'is_auto',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_auto' => 'boolean',
            'is_read' => 'boolean',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(ChatParticipant::class, 'chat_participant_id');
    }

    public function isGuest(): bool
    {
        return $this->sender === 'guest';
    }
}
