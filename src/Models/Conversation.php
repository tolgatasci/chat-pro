<?php

namespace TolgaTasci\Chat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = ['type', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(
            config('chat.user_model'),
            'conversation_user',
            'conversation_id',
            'user_id'
        )->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // Diğer metodlar...
}
