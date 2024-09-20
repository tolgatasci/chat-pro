<?php

namespace TolgaTasci\Chat\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use TolgaTasci\Chat\Models\Conversation;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->participants->contains($user);
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        return $conversation->participants->contains($user);
    }
}
