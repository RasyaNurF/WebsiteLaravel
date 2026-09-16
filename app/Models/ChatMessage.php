<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'guest_token',
        'sender',
        'name',
        'email',
        'body',
        'is_auto',
    ];

    protected function casts(): array
    {
        return [
            'is_auto' => 'boolean',
        ];
    }

    public function isGuest(): bool
    {
        return $this->sender === 'guest';
    }
}
