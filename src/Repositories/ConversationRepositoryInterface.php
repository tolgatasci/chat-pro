<?php

namespace TolgaTasci\Chat\Repositories;

use TolgaTasci\Chat\Models\Conversation;

interface ConversationRepositoryInterface
{
    public function create(array $participants, string $type, array $data): Conversation;

    public function findById(int $id): ?Conversation;

    // Diğer metodlar...
}
